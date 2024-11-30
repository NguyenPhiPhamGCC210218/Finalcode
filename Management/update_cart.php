<?php
session_start();
include_once("connection.php"); // Ensure you include your database connection

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $key = $_POST['key'];

    if ($action === 'update') {
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        // Fetch the product ID from the session
        if (isset($_SESSION['cart'][$key]['id'])) {
            $productId = $_SESSION['cart'][$key]['id'];

            // Fetch the product's stock from the database
            $stmt = $pdo->prepare("SELECT stock_quantity FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $max_quantity = $result['stock_quantity'] ; // Default stock if not found

            // Validate and update quantity
            if ($quantity > $max_quantity) {
                $quantity = $max_quantity;
            }
            if ($quantity < 1) {
                $quantity = 1;
            }

            $_SESSION['cart'][$key]['quantity'] = $quantity;
        }
    } elseif ($action === 'remove') {
        if (isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
        }
    }
}
?>
