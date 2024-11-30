<?php
    session_start();

    header('Content-Type: application/json; charset=utf-8');
    include_once "connection.php";

    $username = $_POST["username"];
    $pass = md5($_POST["pass"]);
    // User found, now check the password
    $query = "SELECT Cus_ID, Username, Email, Password, state, role FROM customer 
     WHERE (Username = '$username' OR Email = '$username') AND Password = '$pass'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_num_rows($res) == 1) {
        // Login successful
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $_SESSION["us"] = $row["Username"];
        $_SESSION["cus_id"] = $row["Cus_ID"];
        $_SESSION["admin"] = $row["state"];

        //payload
        $data["id"] =  $row["Cus_ID"];
        $data["username"] =  $row["Username"];
        $data["role"] =  $row["role"];
        $data["status_code"] =  200;
        echo json_encode($data);
    } else {
        $data["status_code"] =  400;
        echo  json_encode($data);
    }
?>