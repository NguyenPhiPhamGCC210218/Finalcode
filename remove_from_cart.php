<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("connection.php");

// Check if product ID is provided in the query string
if (isset($_GET['pro_id'])) {
    $cart_id = $_GET['cart_id'];
    $pro_id = $_GET['pro_id'];

    // Assume cus_id is stored in session
    $cus_id = $_SESSION['cus_id'];

    // Begin a transaction to ensure atomicity
    $conn->begin_transaction();

    try {
        // Find the Cart ID for the current customer and "waiting" status
        // $sql = "SELECT Cart_ID FROM cart WHERE cus_id = ? AND status = 'waiting' AND Pro_ID = ?";
        // $stmt = $conn->prepare($sql);
        // $stmt->bind_param("ii", $cus_id, $product_id);
        // $stmt->execute();
        // $stmt->bind_result($cart_id);
        // $stmt->fetch();
        // $stmt->close();

        // if ($cart_id) {

            // Delete the product from the detailcart table
            $sql = "DELETE FROM detailcart WHERE Cart_ID = ? AND Pro_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $cart_id, $pro_id);
            $stmt->execute();
            $stmt->close();

            // Check if there are any other products left in the detailcart for the same Cart_ID
            // $sql = "SELECT COUNT(*) FROM detailcart WHERE Cart_ID = ?";
            // $stmt = $conn->prepare($sql);
            // $stmt->bind_param("i", $cart_id);
            // $stmt->execute();
            // $stmt->bind_result($count);
            // $stmt->fetch();
            // $stmt->close();

            // If no other products are left, delete the cart itself
            // if ($count == 0) {
               
                $sql = "DELETE FROM cart WHERE Cart_ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $cart_id);
                $stmt->execute();
                $stmt->close();
            // }
       

            // Commit the transaction
            $conn->commit();
        // }

        // Redirect back to the cart page
        echo '<meta http-equiv="refresh" content="0;URL=?page=cart"/>';
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect back to the cart page if no product ID is provided
    echo '<meta http-equiv="refresh" content="0;URL=?page=cart"/>';
    exit();
}
?>
