<?php
// Registration PHP Logic
include_once "connection.php";
if (isset($_POST['btnRegister'])) {
    $us = $_POST['txtUsername'];
    $pass1 = $_POST['txtPass1'];
    $fullname = $_POST['txtFullname'];
    $email = $_POST['txtEmail'];
    $address = $_POST['txtAddress'];
    $tel = $_POST['txtTel'];
    
    // Gender check
    if (isset($_POST['grpRender'])) {
        $sex = $_POST['grpRender'];
    }

    // Prepare error message
    $err = [];
    if ($us == "" || $pass1 == "" || $fullname == "" || $email == "" || $address == "" || !isset($sex)) {
        $err[] = "Enter fields with mark (*), please";
    }

    if (strlen($pass1) <= 5) {
        $err[] = "Password must be greater than 5 chars";
    }

    // If no errors, proceed with registration
    if (empty($err)) {
        // Using prepared statements for better security
        $pass = password_hash($pass1, PASSWORD_DEFAULT); // Secure password hash

        // Check if username or email already exists
        $sq = "SELECT * FROM customer WHERE Username = ? OR email = ?";
        $stmt = mysqli_prepare($conn, $sq);
        mysqli_stmt_bind_param($stmt, "ss", $us, $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($res) == 0) {
            // Insert the new user
            $role = 'cust'; // Set the default role
            $insertQuery = "INSERT INTO customer (Username, Password, Full_Name, Gender, Address, Email, Telephone, role) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsert = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmtInsert, "ssssssss", $us, $pass, $fullname, $sex, $address, $email, $tel, $role);

            if (mysqli_stmt_execute($stmtInsert)) {
                echo "<script>alert('You have registered successfully');</script>";
            } else {
                echo "<script>alert('Registration failed. Please try again later.');</script>";
            }
        } else {
            $err[] = "Username or email already exists";
        }
    }

    // Display errors (if any)
    if (!empty($err)) {
        foreach ($err as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Registration</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/register.css">

    <!-- JavaScript Files -->
    <script src="js/jquery-3.2.0.min.js"></script>
</head>
<body>

<a class="backhome" href="index.php">← Back to shop</a>

<div class="container">
    <div class="row align-items-center">
        <div class="col-md-6 d-none d-md-block">
            <img src="./Management/product-imgs/register.jpg" alt="Registration Image" class="img-fluid">   
        </div>
        <div class="col-md-6">
            <div class="coverblock">
                <h2 class="h2Register">Registration</h2>

                <div id="errorBox" class="alert alert-danger d-none" role="alert"></div>

                <form id="form1" name="form1" method="post" action="" class="form-horizontal" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="txtUsername" class="control-label">Username(*):</label>
                        <input type="text" name="txtUsername" id="txtUsername" class="form-control" placeholder="Username" 
                            value="<?php if (isset($us)) echo htmlspecialchars($us); ?>" />
                    </div>
                    <div class="form-group">      
                        <label for="txtEmail" class="control-label">Email(*):</label>
                        <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Email" 
                            value="<?php if (isset($email)) echo htmlspecialchars($email); ?>" />
                    </div>
                    <div class="form-group">   
                        <label for="txtPass1" class="control-label">Password(*):</label>
                        <input type="password" name="txtPass1" id="txtPass1" class="form-control" placeholder="Password" />
                    </div>     
                    <div class="form-group">                               
                        <label for="txtFullname" class="control-label">Full name(*):</label>
                        <input type="text" name="txtFullname" id="txtFullname" class="form-control" placeholder="Enter Fullname" 
                            value="<?php if (isset($fullname)) echo htmlspecialchars($fullname); ?>" />
                    </div>
                    <div class="form-group">   
                        <label for="txtAddress" class="control-label">Address(*):</label>
                        <input type="text" name="txtAddress" id="txtAddress" class="form-control" placeholder="Address" 
                            value="<?php if (isset($address)) echo htmlspecialchars($address); ?>" />
                    </div>  
                    <div class="form-group">  
                        <label for="txtTel" class="control-label">Telephone(*):</label>
                        <input type="text" name="txtTel" id="txtTel" class="form-control" placeholder="Telephone" 
                            value="<?php if (isset($tel)) echo htmlspecialchars($tel); ?>" />
                    </div> 
                    <div class="form-group">  
                        <label class="control-label">Gender(*):</label>
                        <div class="form-check">
                            <input type="radio" name="grpRender" value="0" id="male" class="form-check-input"
                                <?php if (isset($sex) && $sex == "0") echo "checked"; ?> />
                            <label for="male" class="form-check-label">Male</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="grpRender" value="1" id="female" class="form-check-input"
                                <?php if (isset($sex) && $sex == "1") echo "checked"; ?> />
                            <label for="female" class="form-check-label">Female</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <input type="submit" class="btn btn-primary canLogin" name="btnRegister" id="btnRegister" value="Register" />
                            <input type="button" name="btnCancel" class="btn btn-secondary" id="btnCancel" value="Cancel" onclick="window.location='index.php';">
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* General Styles */
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 20px;
    }

    .coverblock {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto;
    }

    .h2Register {
        color: #14042d;
    margin-bottom: 20px;
    font-weight: bold;
    text-align: center;
    }

    .backhome {
        display: inline-block;
        margin: 10px 0;
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .backhome:hover {
        text-decoration: underline;
    }

    .form-control {
        width: 100%;
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px;
        box-sizing: border-box;
    }

    .form-group {
        margin-bottom: 20px;
        color: #000;
    }

    .control-label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-check {
        margin-bottom: 10px;
    }

    .form-check-input {
        margin-right: 10px;
    }

    .btn-primary {
        background-color: #C51162;
        border-color: #C51162;
        color: #fff;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: bold;
        width: 48%;
    }

    .btn-primary:hover {
        background-color: #A5004A;
        border-color: #A5004A;
    }

    .btn-secondary {
        background-color: #F7E4E0;
        border-color: #F7E4E0;
        color: #C51162;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: bold;
        width: 48%;
    }

    .btn-secondary:hover {
        background-color: #C51162;
        border-color: #C51162;
        color: #fff;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .coverblock {
            padding: 20px;
        }
        .btn-primary, .btn-secondary {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    /* Image Styles */
    img.img-fluid {
        width: 100%;
        height: auto;
        border-radius: 12px 0 0 12px; /* Round left corners of the image */
    }

    /* Error Box Style */
    #errorBox {
        margin-bottom: 20px;
        border-radius: 8px;
    }
</style>

<script>
    function validateForm() {
        const errorBox = document.getElementById("errorBox");
        const errors = [];
        const username = document.getElementById("txtUsername").value.trim();
        const email = document.getElementById("txtEmail").value.trim();
        const password = document.getElementById("txtPass1").value.trim();
        const fullname = document.getElementById("txtFullname").value.trim();
        const address = document.getElementById("txtAddress").value.trim();
        const tel = document.getElementById("txtTel").value.trim();
        const sex = document.querySelector('input[name="grpRender"]:checked');

        if (username === "" || email === "" || password === "" || fullname === "" || address === "" || !sex) {
            errors.push("Enter fields with mark (*), please");
        }

        if (password.length <= 5) {
            errors.push("Password must be greater than 5 chars");
        }
        // Validate email for special characters and accents
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            errors.push("Email cannot contain special characters or accents.");
        }

        // Validate telephone number for special characters and accents
        const telPattern = /^[0-9]+$/;
        if (!telPattern.test(tel)) {
            errors.push("Telephone can only contain numbers.");
        }
        if (errors.length > 0) {
            errorBox.innerHTML = errors.join("<br>");
            errorBox.classList.remove("d-none");
            return false; // Prevent form submission
        }

        
        errorBox.classList.add("d-none"); // Hide error box
        return true; // Allow form submission
    }
</script>

</body>
</html>
