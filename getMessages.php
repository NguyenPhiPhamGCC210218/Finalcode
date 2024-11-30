<?php
session_start();
include_once("connection.php");

if (!isset($_SESSION['Cus_ID']) && !isset($_SESSION['Employer_ID'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

$user_id = isset($_SESSION['Cus_ID']) ? $_SESSION['Cus_ID'] : $_SESSION['Employer_ID'];

$query = "SELECT * FROM chat WHERE sender_id = ? OR receiver_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode(["status" => "success", "messages" => $messages]);
$stmt->close();
$conn->close();
?>
    