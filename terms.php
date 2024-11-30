<?php
$title = "Terms and Services"; // Page title
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

        <p>Welcome to <strong>PP Shop</strong>. By using our website, you agree to comply with the following terms and conditions. Please read them carefully.</p>

        <h2>1. Acceptance of Terms</h2>
        <p>By accessing this website, you accept these terms and conditions in full. If you disagree with any part of these terms, you must not use our website.</p>

        <h2>2. Changes to Terms</h2>
        <p>We reserve the right to modify these terms at any time. Any changes will be effective immediately upon posting on the site. Your continued use of the site after any such changes constitutes your acceptance of the new terms.</p>

        <h2>3. Use of the Website</h2>
        <p>You may use our website only for lawful purposes and in accordance with these terms. You agree not to use the site:</p>
        <ul>
            <li>In any way that violates any applicable federal, state, local, or international law or regulation.</li>
            <li>To transmit, or procure the sending of, any advertising or promotional material, including any "junk mail," "chain letter," "spam," or any other similar solicitation.</li>
            <li>To impersonate or attempt to impersonate PP Shop, a PP Shop employee, another user, or any other person or entity.</li>
        </ul>

        <h2>4. Intellectual Property Rights</h2>
        <p>The content, layout, design, data, databases, and graphics on this website are protected by copyright, trademarks, and other intellectual property rights. You may not reproduce, distribute, or otherwise exploit such material without our express written permission.</p>

        <h2>5. Limitation of Liability</h2>
        <p>In no event shall PP Shop be liable for any direct, indirect, incidental, special, consequential, or punitive damages, including, without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from:</p>
        <ul>
            <li>Your access to or use of, or inability to access or use, the website;</li>
            <li>Any conduct or content of any third party on the website;</li>
            <li>Any content obtained from the website; and</li>
            <li>Unauthorized access, use or alteration of your transmissions or content.</li>
        </ul>

        <h2>6. Governing Law</h2>
        <p>These terms shall be governed by and construed in accordance with the laws of [Your Country]. Any disputes arising under or in connection with these terms shall be subject to the exclusive jurisdiction of the courts of [Your Country].</p>

        <h2>7. Contact Us</h2>
        <p>If you have any questions about these terms, please contact us at <strong>@gmail.com</strong>.</p>

        <p>Thank you for using <strong>PP Shop</strong>!</p>
        
        <div class="text-center">
            <a id="goToShopBtn" class="btn btn-primary" href="index.php">Go to Shop</a> <!-- Button to return to shop -->
        </div>    </div>
    <script>// Optional: Smooth scrolling when clicking the "Go to Shop" button
document.getElementById('goToShopBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default anchor click behavior
    const targetUrl = this.getAttribute('href'); // Get the target URL
    window.location.href = targetUrl; // Redirect to the target URL
});
</script>
</body>
</html>


<Style>
    /* Add this to your existing styles.css file */

/* General container styling */
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
            color: #000; /* Tomato color */
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

        /* Button styling */
        .btn {
            width: 20%;
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
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .text-center a:hover {
            color: #000; /* Darker shade on hover */
        }

/* Responsive design */
@media (max-width: 600px) {
    .container {
                padding: 10px;
            }

            .btn {
                padding: 10px; /* Adjust padding for smaller screens */
                font-size: 14px; /* Adjust font size for smaller screens */
            }

}

</Style>
