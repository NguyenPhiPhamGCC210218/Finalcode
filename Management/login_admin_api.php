<?php
        session_start();
        header('Content-Type: application/json; charset=utf-8');
        include_once "connection.php";
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $pass = md5($pass); // Ensure you use a secure hashing algorithm

        $query = "SELECT Emp_ID, Username, Password, state, role FROM employer WHERE Username = ? AND Password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $pass);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            $_SESSION["us"] = $username;
            $_SESSION["admin"] = $row["state"];
            $_SESSION["role"] = $row["role"];
           //payload
            $data["id"] =  -1;
            $data["username"] =  $row["Username"];
            $data["role"] =  $row["role"];
            $data["status_code"] =  200;
            echo json_encode($data);
        } else {
            $data["status_code"] =  400;
            echo  json_encode($data);
        }

?>
