<?php 
session_start();
include_once("connection.php");

// Ensure user is logged in
if (!isset($_SESSION['cus_id'])) {
    header("Location: login.php");
    exit();
}

$cus_id = $_SESSION['cus_id'];
$payment_method = $_POST['payment_method'];
$order_total = $_POST['order_total'];
$order_date = $_POST['order_date'];

// Begin transaction
$conn->begin_transaction();

try {
    // Fetch all cart IDs with status 'waiting' for the user
    $sql = "SELECT Cart_ID FROM cart WHERE cus_id = ? AND status = 'waiting'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cus_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("No waiting cart found.");
    }

    // Create an array to hold all cart IDs
    $cart_ids = [];
    while ($cart = $result->fetch_assoc()) {
        $cart_ids[] = $cart['Cart_ID'];
    }
    $stmt->close();

    // Fetch product names and quantities from the detailcart associated with the cart IDs
    $placeholders = implode(',', array_fill(0, count($cart_ids), '?')); // Create placeholders for prepared statement
    $sql = "SELECT p.Pro_Name, cd.Pro_qty FROM detailcart cd 
            JOIN product p ON cd.Pro_ID = p.Pro_ID 
            WHERE cd.Cart_ID IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    
    // Bind the cart IDs to the statement
    $stmt->bind_param(str_repeat('i', count($cart_ids)), ...$cart_ids); 
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row; // Store product names and quantities
    }
    $stmt->close();

    // Update the status of all carts with the specified IDs to 'approved'
    $sql = "UPDATE cart SET status = 'approved' WHERE Cart_ID IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('i', count($cart_ids)), ...$cart_ids); // Bind the cart IDs to the statement
    $stmt->execute();
    $stmt->close();

    // Deduct quantities from the product table based on the confirmed cart items
    $out_of_stock_products = []; // To keep track of products that go out of stock
    foreach ($products as $product) {
        // Check current quantity before deduction
        $current_quantity = $product['Pro_qty'];
        $sql = "SELECT Pro_qty FROM product WHERE Pro_Name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $product['Pro_Name']);
        $stmt->execute();
        $stmt->bind_result($available_qty);
        $stmt->fetch();
        $stmt->close();

        // Check if there's enough quantity available
        if ($available_qty < $current_quantity) {
            $out_of_stock_products[] = $product['Pro_Name']; // Track out-of-stock product
        } else {
            // Deduct the quantity from the product table
            $sql = "UPDATE product SET Pro_qty = Pro_qty - ? WHERE Pro_Name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $current_quantity, $product['Pro_Name']);
            if (!$stmt->execute()) {
                throw new Exception("Error updating quantity for Product Name " . $product['Pro_Name'] . ": " . $stmt->error);
            }
            $stmt->close();
        }
    }

    // If any products went out of stock, prompt user to replace them
    if (!empty($out_of_stock_products)) {
        $error_message = "The following products are out of stock: " . implode(", ", $out_of_stock_products) . ". Please choose replacements for these products.";
        // Store error message in session or redirect to a page where they can select replacements
        $_SESSION['error'] = $error_message;
        header("Location: http://localhost/onlineshop/index1.php?page=choose_replacements");
        exit();
    }

    // Commit transaction
    $conn->commit();

    // Redirect to a confirmation page
    header("Location: http://localhost:1000/?page=confirm");
    exit();
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    // Log error for admin review, show user-friendly message
    error_log($e->getMessage()); // Log to server error log
    echo "Error processing payment. Please try again later.";
} finally {
    $conn->close(); // Ensure connection is closed
}
