<?php
session_start();
include_once "connection.php";

$error_messages = "";
$success_message = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid
    $stmt = $conn->prepare("SELECT user_id, expires_at FROM password_resets WHERE token = ? LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $userId = $row['user_id'];
        $expiry = $row['expires_at'];

        // Check if the token is expired
        if (new DateTime() > new DateTime($expiry)) {
            $error_messages = "This password reset link has expired.";
        }

        if (isset($_POST['btnReset'])) {
            $newPassword = $_POST['txtNewPass'];
            $confirmPassword = $_POST['txtConfirmPass'];

            if ($newPassword !== $confirmPassword) {
                $error_messages = "Passwords do not match.";
            } else {
                // Hash the new password and update it in the database
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE customer SET Password = ? WHERE Cus_ID = ?");
                $stmt->bind_param("si", $hashedPassword, $userId);
                $stmt->execute();

                // Delete the reset token
                $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                $stmt->bind_param("s", $token);
                $stmt->execute();

                $success_message = "Your password has been reset successfully. You can now log in.";
            }
        }
    } else {
        $error_messages = "Invalid password reset token.";
    }
} else {
    header("Location: forgot_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Your existing CSS */
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Reset Password</h1>
        <?php if ($error_messages) { echo "<div class='error-message'>$error_messages</div>"; } ?>
        <?php if ($success_message) { echo "<div class='success-message'>$success_message</div>"; } ?>
        <form method="post" action="">
            <input type="password" name="txtNewPass" placeholder="New Password" required>
            <input type="password" name="txtConfirmPass" placeholder="Confirm Password" required>
            <input type="submit" name="btnReset" value="Reset Password">
        </form>
    </div>
</body>
</html>
