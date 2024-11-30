<?php
include_once "connection.php";

$page = isset($_GET['page']) ? $_GET['page'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css"> <!-- Link to your CSS file -->
    <title>Order Confirmation</title>
</head>
<body>
    <div class="container">
        <div class="confirmation-form">
            <?php
            if ($page === 'products') {
                if (isset($_GET['message'])) {
                    echo "<div class='alert'>" . htmlspecialchars($_GET['message']) . "</div>";
                }
                // Display products here...
            } elseif ($page === 'confirm') {
                echo "<h2>Payment Successful!</h2>";
                echo "<p>Your order has been placed successfully. Thank you for your purchase!</p>";
                echo '<a href="http://localhost:1000/" class="button">Continue Shopping</a>'; // Link to your product page
            } else {
                // Handle other pages or default content
                echo "<p>Welcome! Please select a page.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
<style>body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Full viewport height */
}



.confirmation-form {
    background-color: #fff;
    border: 1px solid #ddd; /* Light border for the form */
    border-radius: 8px; /* Rounded corners */
    padding: 20px; /* Padding inside the form */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Shadow for depth */
    text-align: center; /* Center text inside the form */
}

h2 {
    color: #000;
    margin-bottom: 10px;
    font-weight: bold;
}


p {
    color: #333; /* Dark gray for text */
    margin-bottom: 20px;
}

.alert {
    background-color: #f44336; /* Red color for alerts */
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.button {
    display: inline-block;
    background-color: #FF5733; /* A vibrant red-orange color */
    color: white;
    padding: 12px 24px; /* Increased padding for a larger button */
    text-decoration: none;
    border-radius: 8px; /* Rounded corners */
    font-size: 18px; /* Larger font size for better readability */
    font-weight: bold; /* Bold text for emphasis */
    transition: all 0.3s ease; /* Smooth transition for all properties */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
}

.button:hover {
    background-color: #C70039; /* Darker red on hover */
    transform: scale(1.05); /* Slightly enlarges the button */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3); /* Darker shadow on hover */
    cursor: pointer; /* Changes cursor to pointer */
}

.button:active {
    transform: scale(0.95); /* Slightly shrink when clicked */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Reduces shadow on click */
}


@media (max-width: 600px) {
    h2 {
        font-size: 24px; /* Smaller font size on small screens */
    }

    p {
        font-size: 16px; /* Smaller font size on small screens */
    }
}
</style>