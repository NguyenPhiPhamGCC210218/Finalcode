<?php
// session_start(); // Uncommented this line to start the session
// include_once "connection.php";

// $error_messages = "";

// if (isset($_POST['btnLogin'])) {
//     $us = $_POST['txtUsername'];
//     $pa = $_POST['txtPass'];

//     // Check if terms and conditions checkbox is checked
//     if (!isset($_POST['terms'])) {
//         $error_messages .= "You must agree to the terms and services before logging in.<br/>";
//     }

//     if ($us == "") {
//         $error_messages .= "Enter Email, please<br/>";
//     }
//     if ($pa == "") {
//         $error_messages .= "Enter Password, please<br/>";
//     }

//     if ($error_messages == "") {
//         $us = mysqli_real_escape_string($conn, $us);
//         $pass = md5($pa);

//         // Check if the username or email exists
//         $query_email_check = "SELECT * FROM customer WHERE Username = '$us' OR Email = '$us'";
//         $res_email_check = mysqli_query($conn, $query_email_check);

//         if (mysqli_num_rows($res_email_check) == 0) {
//             // No user found with this email or username
//             $error_messages .= "Wrong your email. Please enter again!<br/>";
//         } else {
//             // User found, now check the password
//             $query = "SELECT Cus_ID, Username, Email, Password, state FROM customer 
//                       WHERE (Username = '$us' OR Email = '$us') AND Password = '$pass'";
//             $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

//             if (mysqli_num_rows($res) == 1) {
//                 // Login successful
//                 $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
//                 $_SESSION["us"] = $row["Username"];
//                 $_SESSION["cus_id"] = $row["Cus_ID"];
//                 $_SESSION["admin"] = $row["state"];
//                 echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
//                 exit();
//             } else {
//                 // Password is incorrect
//                 $error_messages .= "Wrong password. Please enter again<br/>";
//             }
//         }
//     }
// }
// ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>PPshop</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- <script>
        // Display error messages dynamically
        function displayErrors() {
            const errorMessages = "<?php echo $error_messages; ?>";
            if (errorMessages) {
                const errorDiv = document.getElementById('error-message');
                errorDiv.innerHTML = errorMessages;
                errorDiv.style.display = 'block';
            }
        }

        window.onload = displayErrors;
    </script> -->
</head>

<body>
    <div class="login-container">
        <!-- Error message container -->
        <div id="error-message" class="error-message"></div>

        <div class="login-image"><img src="./Management/product-imgs/bìa.webp" alt="Login Image"></div>
        <div class="login-form">
            <h1>Login</h1>
            <form id="login_form">
                <div class="form-group">
                    <input class="form-style" type="text" name="txtUsername" id="txtUsername" placeholder="Enter Email ">
                    <i class="input-icon uil uil-at"></i>
                </div>
                <div class="form-group mt-2">
                    <input class="form-style" type="password" name="txtPass" id="txtPass" placeholder="Enter Password">
                    <i class="input-icon uil uil-lock-alt"></i>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="terms" id="terms">
                    <label for="terms">I agree to the <a href="?page=terms" target="_blank">terms and services</a></label>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnLogin" class="btn btn-primary" id="btnLogin" value="Login">
                    <input type="button" name="btnCancel" class="btn btn-secondary" id="btnCancel" value="Cancel" onclick="window.location='index.php';">
                </div>
                <p class="text-center"><a href="?page=forgot" class="link">Forgot your password?</a></p>
            </form>
        </div>
    </div>
</body>
</html>

<style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            padding: 30px;
            width: 90%;
            max-width: 450px;
            margin: 20px auto;
            position: relative;
        }

        .error-message {
            background-color: #ffdddd;
            color: #d8000c;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            width: 100%;
            display: none;
        }

        .login-image {
            width: 100%;
            border-radius: 10px 10px 0 0;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .login-image img {
            width: 100%;
            height: auto;
            border-radius: 10px 10px 0 0;
        }

        .login-form {
            width: 100%;
        }

        .login-form h1 {
            font-size: 2em;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-style {
            width: 100%;
            padding: 12px;
            padding-left: 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
            background-color: #f9fafb;
            transition: all 0.3s ease;
        }

        .form-style:focus {
            border-color: #c51162;
            outline: none;
            background-color: #fff;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #aaa;
            font-size: 1.2em;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .btn-primary {
            background: #c51162;
            color: #fff;
        }

        .btn-primary:hover {
            background: #9e0e52;
        }

        .btn-secondary {
            background: #f3f3f3;
            color: #333;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background: #ddd;
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
            color: #9e0e52;
        }
    </style>
