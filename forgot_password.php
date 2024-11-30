<?php
include_once "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // Ensure this path is correct
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

$error_messages = "";
$success_message = "";

if (isset($_POST['btnSendCode'])) {
    $email = $_POST['txtEmail'];

    if ($email == "") {
        $error_messages .= "Please enter your email.<br/>";
    } else {
        $email = mysqli_real_escape_string($conn, $email);

        // Check if the email exists
        $query = "SELECT * FROM customer WHERE Email = '$email'";
        $res = mysqli_query($conn, $query);

        if (mysqli_num_rows($res) == 0) {
            $error_messages .= "Email does not exist.<br/>";
        } else {
            // Generate a confirmation code
            $code = rand(100000, 999999);
            // Store the code in the session or a temporary table in the database
            $_SESSION['reset_code'] = $code;
            $_SESSION['reset_email'] = $email;

            // PHPMailer setup
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'phamnpgcc210218@fpt.edu.vn'; // SMTP username
                $mail->Password = 'oscw xjuc prgn ooym
'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                $mail->Port = 587; // TCP port to connect to

                // Recipients
                $mail->setFrom('phamnpgcc210218@fpt.edu.vn', 'OnlineWeb'); // Sender's email and name
                $mail->addAddress($email); // Recipient's email

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Code';
                $mail->Body = "Your password reset code is: " . $code;

                $mail->send();
                $success_message .= "A confirmation code has been sent to your email.<br/>";
            } catch (Exception $e) {
                $error_messages .= "Failed to send email. Mailer Error: {$mail->ErrorInfo}<br/>";
            }
        }
    }
}

// Rest of your code remains unchanged
if (isset($_POST['btnResetPassword'])) {
    $input_code = $_POST['txtCode'];
    $new_password = $_POST['txtNewPassword'];
    $confirm_password = $_POST['txtConfirmPassword'];

    if ($input_code != $_SESSION['reset_code']) {
        $error_messages .= "Invalid confirmation code.<br/>";
    }

    if ($new_password != $confirm_password) {
        $error_messages .= "Passwords do not match.<br/>";
    }

    if ($error_messages == "") {
        // Hash the new password
        $hashed_password = md5($new_password);
        // Update the password in the database
        $query_update = "UPDATE customer SET Password = '$hashed_password' WHERE Email = '" . $_SESSION['reset_email'] . "'";
        if (mysqli_query($conn, $query_update)) {
            $success_message .= "Your password has been reset successfully. You can now log in.";
            // Clear the session variables
            unset($_SESSION['reset_code']);
            unset($_SESSION['reset_email']);
        } else {
            $error_messages .= "Error updating password. Please try again.<br/>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
       /* Global styles */
body {
    font-family: Arial, sans-serif;
    /* background: linear-gradient(135deg, #6a11cb, #2575fc); */
    margin: 0;
    padding: 0;
    /* display: flex;   */
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Container for the form */
.login-container {
    max-width: 400px;
    width: 90%;
    padding: 40px 30px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    text-align: center;
    animation: fadeIn 0.8s ease-in-out;
}

/* Heading styles */
h1 {
    color: #333;
    font-size: 28px;
    margin-bottom: 25px;
    font-weight: 600;
}

/* Form group container for better spacing */
.form-group {
    margin-bottom: 20px;
}

/* Input field styles */
.form-style {
    width: 100%;
    padding: 14px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: 16px;
    box-sizing: border-box;
    transition: all 0.3s;
}

.form-style:focus {
    border-color: #6a11cb;
    box-shadow: 0 0 10px rgba(106, 17, 203, 0.2);
    outline: none;
}

/* Button styling */
.btn {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #020f14, #020f14);
    color: white;
    font-size: 18px;
    font-weight: bold;  
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.btn:hover {
    background: linear-gradient(135deg, #5b0acb, #9246f5);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

.btn:active {
    transform: translateY(2px);
    box-shadow: none;
}

/* Error and success message styles */
.error-message {
    color: #e74c3c;
    font-weight: bold;
    margin-bottom: 15px;
    font-size: 14px;
}

.success-message {
    color: #2ecc71;
    font-weight: bold;
    margin-bottom: 15px;
    font-size: 14px;
}

/* Smooth entry animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .login-container {
        padding: 30px 20px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    h1 {
        font-size: 24px;
    }

    .form-style, .btn {
        padding: 12px;
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .login-container {
        padding: 25px 15px;
    }

    h1 {
        font-size: 22px;
    }

    .form-style, .btn {
        padding: 10px;
        font-size: 15px;
    }
}

    </style>
</head>

<body>
<div class="row justify-content-center align-items-center min-vh-100">
<div class="col-md-6 col-lg-4">

    <div class="login-container">
        
        <div id="error-message" class="error-message"><?php echo $error_messages; ?></div>
        <div id="success-message" class="success-message"><?php echo $success_message; ?></div>
        <form method="post" action="">
            <h1>Reset Password</h1>
            <div class="form-group">
                <input class="form-style" type="email" name="txtEmail" placeholder="Enter your Email" required>
            </div>
            <input type="submit" name="btnSendCode" class="btn btn-primary" value="Send Code">
        </form>
<br>
        <form method="post" action="">
            <div class="form-group">
                <input class="form-style" type="text" name="txtCode" placeholder="Enter Confirmation Code" required>
            </div>
            <div class="form-group">
                <input class="form-style" type="password" name="txtNewPassword" placeholder="Enter New Password" required>
            </div>
            <div class="form-group">
                <input class="form-style" type="password" name="txtConfirmPassword" placeholder="Confirm New Password" required>
            </div>
            <input type="submit" name="btnResetPassword" class="btn btn-primary" value="Reset Password">
        </form>
    </div>
    </div>
    </div>
    <script>
        function validateEmail() {
            const email = document.getElementById('txtEmail').value;
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(email)) {
                alert('Please enter a valid email address.');
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</body>

</html>