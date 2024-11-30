<?php
    include_once("connection.php");
    header('Content-Type: application/json; charset=utf-8');
    $cust_id = $_GET["cust_id"];
    $chat_query = "SELECT * FROM chat WHERE sender = $cust_id OR receiver = $cust_id";
    $result = mysqli_query($conn, $chat_query);
    $chat_list = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $chat_list[] = $row;
    }
    echo json_encode([
        'status_code' => 200,
        'chat_list' => $chat_list
    ]);
?>
