<?php
// session_start();
// include_once "connection.php";

// $errorMessage = ""; // Initialize error message

// if (isset($_POST['btnLogin'])) {
//     $us = $_POST['txtUsername'];
//     $pa = $_POST['txtPass'];

 
//     if ($us == "") {
//         $errorMessage .= "Enter Username, please<br/>";
//     }
//     if ($pa == "") {
//         $errorMessage .= "Enter Password, please<br/>";
//     }

//     if ($errorMessage != "") {
//         $errorMessage = "Please fix the following errors:<br/>" . $err;
//     } else {
//         $pass = md5($pa); // Ensure you use a secure hashing algorithm
//         $query_customer = "SELECT Cus_ID, Username, Password, state FROM customer WHERE Username = ? AND Password = ?";
//         $stmt_customer = $conn->prepare($query_customer);
//         $stmt_customer->bind_param("ss", $us, $pass);
//         $stmt_customer->execute();
//         $result_customer = $stmt_customer->get_result();

//         if ($result_customer->num_rows > 0) {
//             // Login successful for customer
//             $customer = $result_customer->fetch_assoc();
//             $_SESSION['Cus_ID'] = $customer['Cus_ID'];
//             $_SESSION['user_type'] = 'customer';    
//             echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
//             exit();
//         } else {
//             $query = "SELECT Username, Password, state FROM employer WHERE Username = ? AND Password = ?";
//             $stmt = $conn->prepare($query);
//             $stmt->bind_param("ss", $us, $pass);
//             $stmt->execute();
//             $res = $stmt->get_result();

//             if ($res->num_rows == 1) {
//                 $row = $res->fetch_assoc();
//                 $_SESSION["us"] = $us;
//                 $_SESSION["admin"] = $row["state"];
//                 echo '<meta http-equiv="refresh" content="0;URL=Management/index.php"/>';
//                 exit();
//             } else {
//                 // Determine which error message to display
//                 if (empty($us)) {
//                     $errorMessage = "Incorrect ";
//                 } else {
//                     $errorMessage = "Incorrect username or password. Please enter again!";
//                 }
//             }
//         }
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>PPshop Login</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <script>
        window.onload = function() {
            // Check if there's an error message and display it
            var errorMessage = "<?php echo addslashes($errorMessage); ?>";
            var errorMessageDiv = document.getElementById('error-message');

            if (errorMessage) {
                errorMessageDiv.innerHTML = errorMessage; // Set the error message
                errorMessageDiv.style.display = 'block'; // Show the error message
            }
        };
    </script> -->
</head>

<body>
    <div class="login-container">
    <div class="error-message" id="error-message" style="display:none;"></div> <!-- Error message display area -->

        <div class="login-image">
            <img src="https://e7.pngegg.com/pngimages/1011/702/png-clipart-computer-icons-graphics-iconfinder-administrator-icon-monochrome-black.png" alt="Admin Image">
        </div>
        <div class="login-form">
            <h1>Login as Admin</h1>
            <form method="post" action="" id="login_admin_form">
                <div class="form-group">
                    <input class="form-style" type="text" name="txtUsername" id="txtUsername" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input class="form-style" type="password" name="txtPass" id="txtPass" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnLogin" class="btn btn-primary" id="btnLogin" value="Login">
                    <input type="button" name="btnCancel" class="btn btn-secondary" id="btnCancel" value="Cancel" onclick="window.location='index.php';">
                </div>
                <!-- <p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p> -->
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
            display: none; /* Hide by default */
        }

        .login-image {
            width: 50%;
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