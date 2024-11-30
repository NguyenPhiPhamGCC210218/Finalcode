<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if cart session exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Get POST data
    $name = $_POST['namepro'];
    $price = $_POST['price'];
    $picture = $_POST['picture'];
    $quantity = $_POST['quantity'];

    // Check if product already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] == $name) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = array(
            'name' => $name,
            'price' => $price,
            'picture' => $picture,
            'quantity' => $quantity
        );
    }

    header("Location:?page=cart");
    exit();
}
?>
