<?php
$title = "About Us"; // Page title
include_once("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1><?php echo $title; ?></h1>
        <p>Welcome to <strong>PP SHOP</strong>!</p>
        <p>At <strong>PP SHOP</strong>, we don’t just sell products; we offer you a wonderful and memorable online shopping experience. Established in <strong>2024</strong>, we have gradually established ourselves as one of the leading online fashion stores in Vietnam.</p>

        <h2>Our Mission</h2>
        <p>We are committed to providing high-quality fashion products with a diverse range of styles that meet the modern trends and needs of consumers. Our mission is to bring you items that are not only beautiful but also express your unique style and personality.</p>

        <h2>Why Choose Us?</h2>
        <ul>
            <li><strong>Diverse Product Range</strong>: We constantly update our latest collections to meet all customer needs, from office wear to party outfits, and from casual to elegant styles.</li>
            <li><strong>Quality Assurance</strong>: Every product is carefully selected and inspected for quality before it reaches our customers, ensuring maximum satisfaction.</li>
            <li><strong>Dedicated Customer Service</strong>: Our team is always ready to assist you, from product consultation to delivery.</li>
            <li><strong>Fast Delivery</strong>: We guarantee fast, safe, and timely delivery so you can receive your favorite products in the shortest time possible.</li>
        </ul>

        <h2>Contact Us</h2>
        <p>If you have any questions, feel free to reach out to us via <strong>@mail</strong> or call us at <strong>@phone</strong>. We look forward to serving you!</p>

        <p>Thank you for trusting and choosing <strong>PP SHOP</strong>. We hope you will have a fantastic shopping experience with us!</p>

        <a id="goToShopBtn" class="btn btn-primary" href="index.php">Go to Shop</a> <!-- Button to return to shop -->
        </div>

    <script src="script.js"></script> <!-- Link to your JS file -->
</body>
</html>

<script>
    // Smooth scrolling to top when the button is clicked
document.addEventListener("DOMContentLoaded", function() {
    const scrollToTopButton = document.getElementById("scrollToTopBtn");

    // Show button when scrolling down
    window.addEventListener("scroll", function() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            scrollToTopButton.style.display = "block";
        } else {
            scrollToTopButton.style.display = "none";
        }
    });

    scrollToTopButton.addEventListener("click", function() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});

</script>

<style>
    /* Add this to your existing styles.css file */

/* Button styling */
.container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Heading styles */
        h1 {
            color: #040101; /* Tomato color */
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        /* Paragraph and list styling */
        p, ul {
            margin-bottom: 15px;
        }

        /* Button styles */
        .btn {
            width: 200px;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .btn-primary {
            background: #c51162; /* Primary button color */
            color: #fff;
        }

        .btn-primary:hover {
            background: #9e0e52; /* Darker shade on hover */
        }

        .btn-secondary {
            background: #f3f3f3; /* Secondary button color */
            color: #333;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background: #ddd; /* Darker shade on hover */
        }

        .text-center {
            text-align: center;
            margin-top: 20px;
        }

        .text-center a {
            color: #c51162;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .text-center a:hover {
            color: #9e0e52; /* Darker shade on hover */
        }

/* Responsive design */
@media (max-width: 600px) {
    .container {
                padding: 10px;
            }
    h1 {
        font-size: 2em;
    }

    h2 {
        font-size: 1.5em;
    }

    p, ul {
        font-size: 0.9em;
    }
}

</style>