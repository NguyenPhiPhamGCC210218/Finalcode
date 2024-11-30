<?php
function generateInvoice($pay_id) {
    // Database connection
    $conn = new mysqli('localhost', 'username', 'password', 'online_shopping');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve payment details
    $stmt = $conn->prepare("SELECT * FROM payment WHERE Pay_ID = ?");
    $stmt->bind_param("i", $pay_id);
    $stmt->execute();
    $payment_result = $stmt->get_result();
    $payment = $payment_result->fetch_assoc();
    $stmt->close();

    // Retrieve cart details
    $cart_id = $payment['Cart_ID'];
    $stmt = $conn->prepare("SELECT * FROM cart WHERE Cart_ID = ?");
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();
    $cart = $cart_result->fetch_assoc();
    $stmt->close();

    // Retrieve cart items
    $stmt = $conn->prepare("SELECT * FROM detailcart WHERE Cart_ID = ?");
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $items_result = $stmt->get_result();
    $items = $items_result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Retrieve product details
    $products = [];
    foreach ($items as $item) {
        $pro_id = $item['Pro_ID'];
        $stmt = $conn->prepare("SELECT * FROM product WHERE Pro_ID = ?");
        $stmt->bind_param("s", $pro_id);
        $stmt->execute();
        $product_result = $stmt->get_result();
        $products[] = $product_result->fetch_assoc();
        $stmt->close();
    }

    // Close connection
    $conn->close();

    // Display invoice
    echo "<h1>Invoice</h1>";
    echo "<p>Payment ID: " . $payment['Pay_ID'] . "</p>";
    echo "<p>Order Date: " . $payment['OrderDate'] . "</p>";
    echo "<p>Payment Method: " . $payment['Pay_method'] . "</p>";
    echo "<p>Payment Price: $" . $payment['Pay_Price'] . "</p>";
    echo "<h2>Cart Details</h2>";
    echo "<p>Cart ID: " . $cart['Cart_ID'] . "</p>";
    echo "<p>Customer ID: " . $cart['Cus_ID'] . "</p>";
    echo "<p>Status: " . $cart['Status'] . "</p>";
    echo "<h2>Items</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Product Name</th><th>Quantity</th><th>Price</th></tr>";
    foreach ($items as $index => $item) {
        echo "<tr>";
        echo "<td>" . $products[$index]['Pro_Name'] . "</td>";
        echo "<td>" . $item['Pro_qty'] . "</td>";
        echo "<td>$" . $item['Cart_Price'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
