<?php
// session_start(); // Ensure the session is started
include_once("connection.php");

// Ensure user is logged in
if (!isset($_SESSION['cus_id'])) {
    header("Location: login.php");
    exit();
}

$cus_id = $_SESSION['cus_id'];

// Fetch cart items for the user with status 'waiting'
$sql = "SELECT cd.Pro_ID, p.Pro_Name, p.Pro_image, p.Pro_price, SUM(cd.Pro_qty) AS Pro_qty
        FROM detailcart cd
        JOIN product p ON cd.Pro_ID = p.Pro_ID
        JOIN cart c ON cd.Cart_ID = c.Cart_ID
        WHERE c.cus_id = ? AND c.status = 'waiting'
        GROUP BY cd.Pro_ID, p.Pro_Name, p.Pro_image, p.Pro_price";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cus_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $total += $row['Pro_price'] * $row['Pro_qty'];
}

$stmt->close();

// Check if cart is empty
if (empty($cartItems)) {
    echo "<script>alert('Your cart is empty. Please add products to your cart before checking out.');</script>";
    echo "<script>window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <script src="js/cart.js" defer></script>
    <script>
        function confirmPayment(event) {
            event.preventDefault(); // Prevent form submission
            const confirmation = confirm("Do you really want to confirm the payment?");
            if (confirmation) {
                // If the user confirms, submit the form
                document.getElementById("paymentForm").submit();
            }
            // Otherwise, do nothing (stay on the page)
        }
    </script>
</head>

<body>
    <div class="payment-container">
        <h2>Review Your Order</h2>
        <form id="paymentForm" action="process_payment.php" method="post">
            <table>
                <tr>
                    <th>Product</th>
                    <th>Picture</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['Pro_Name']); ?></td>
                        <td><img src="./Management/product-imgs/<?= htmlspecialchars($item['Pro_image']); ?>" alt="<?= htmlspecialchars($item['Pro_Name']); ?>"></td>
                        <td><?= number_format($item['Pro_price'], 2); ?></td>
                        <td><?= htmlspecialchars($item['Pro_qty']); ?></td>
                        <td><?= number_format($item['Pro_price'] * $item['Pro_qty'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4">Total Order Amount</td>
                    <td class="total-amount"><?= number_format($total, 2); ?></td>
                </tr>
            </table>
            <label for="payment_method">Choose Payment Method:</label>
            <select id="payment_method" name="payment_method">
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <!-- Add more payment options if needed -->
            </select>
            <input type="hidden" name="order_total" value="<?= $total; ?>">
            <input type="hidden" name="order_date" value="<?= date('Y-m-d H:i:s'); ?>">
            <button type="submit" onclick="confirmPayment(event)">Confirm Payment</button>
        </form>
    </div>
</body>

</html>

<style>
   /* General Styles */
body {
    margin: 0;
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    /* Soft gray background */
}

.payment-container {
    max-width: 800px;
    /* Limit max width for larger screens */
    margin: 40px auto;
    /* Center the container */
    padding: 30px;
    /* Add padding */
    background-color: #ffffff;
    /* White background for the payment box */
    border-radius: 10px;
    /* Rounded corners */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    /* Soft shadow */
    border: 1px solid #ccc;
    /* Light gray border */
}

h2 {
    font-size: 2em;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
    text-transform: uppercase;
    border-bottom: 2px solid #000;
    padding-bottom: 10px;
    letter-spacing: 1px;
    font-family: 'Arial', sans-serif;
}

/* Table Styling */
table {
    width: 100%;
    /* Full width */
    border-collapse: collapse;
    /* Remove gaps between cells */
    margin-bottom: 30px;
    /* Space below the table */
}

th,
td {
    padding: 15px;
    /* Add padding */
    text-align: center; /* Center align text in both headers and cells */
    border-bottom: 1px solid #ddd;
    /* Light gray border for rows */
}

th {
    background-color: #010201;
    /* Green background for header */
    color: white;
    /* White text for header */
    font-weight: bold;
    /* Bold header */
}

td {
    border-right: 1px solid #ddd;
    /* Right border for better separation */
}

td:last-child {
    border-right: none;
    /* Remove right border from last column */
}

/* Image Styling */
img {
    max-width: 100px;
    /* Limit image width */
    height: auto;
    /* Keep aspect ratio */
    border-radius: 5px;
    /* Rounded corners for images */
}

/* Label Styling */
label {
    display: block;
    /* Make label block-level for spacing */
    margin-top: 20px;
    /* Space above the label */
    font-weight: bold;
    /* Bold text */
    color: #333;
    /* Dark color for labels */
}

/* Select Dropdown Styling */
select {
    padding: 12px;
    /* Add padding to the dropdown */
    width: 100%;
    /* Full width */
    max-width: 300px;
    /* Limit max width */
    margin-bottom: 20px;
    /* Space below the dropdown */
    border: 1px solid #ccc;
    /* Light gray border */
    border-radius: 4px;
    /* Rounded corners */
    font-size: 16px;
    /* Slightly larger font size */
}

/* Button Styling */
button {
    background-color: #ea5624;
    /* Green background */
    color: white;
    /* White text */
    padding: 15px 30px;
    /* Add padding */
    border: none;
    /* Remove border */
    border-radius: 4px;
    /* Rounded corners */
    font-size: 18px;
    /* Increase font size */
    cursor: pointer;
    /* Pointer cursor on hover */
    transition: background 0.3s ease, transform 0.2s ease;
    /* Smooth color and scale change */
    display: block;
    /* Center button block-level */
    margin: 0 auto;
    /* Center the button */
}

button:hover {
    background-color: #ee2121;
    /* Darker green on hover */
    transform: scale(1.05);
    /* Slightly enlarge button on hover */
}

/* Total Order Amount Styling */
.total-amount {
    font-size: 24px;
    /* Larger font size for total */
    font-weight: bold;
    /* Bold text for total */
    color: #333;
    /* Dark color for total */
    text-align: right;
    /* Align total to the right */
}

/* Responsive Styles */
@media (max-width: 600px) {
    .payment-container {
        padding: 20px;
        /* Reduce padding on small screens */
    }

    th,
    td {
        font-size: 14px;
        /* Smaller text size for better fit */
    }

    button {
        width: 100%;
        /* Full width button on small screens */
    }
}
</style>
