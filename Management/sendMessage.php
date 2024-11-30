<?php
session_start();
include_once("connection.php");

// Check if the user is logged in as either customer or employer
if (!isset($_SESSION['cus_id']) && !isset($_SESSION['emp_id'])) {
    echo json_encode(array("status" => "error", "message" => "User not logged in."));
    exit();
}

$cus_id = $_SESSION['cus_id'] ?? null;
$emp_id = $_SESSION['emp_id'] ?? null;
$message = $_POST['message'] ?? '';
$receiver_id = $_POST['receiver_id'] ?? null;

// Validate message and receiver ID
if (!$message || !$receiver_id) {
    echo json_encode(array("status" => "error", "message" => "Invalid message or receiver ID."));
    exit();
}

// Set sender and receiver based on session roles
if ($cus_id) {
    $query = "INSERT INTO chat (Cus_ID, Emp_ID, ContentChat, ChatDate) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $cus_id, $receiver_id, $message);
} else {
    $query = "INSERT INTO chat (Cus_ID, Emp_ID, ContentChat, ChatDate) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $receiver_id, $emp_id, $message);
}

// Execute the query and return response
if ($stmt->execute()) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error", "message" => "Failed to send message."));
}

$stmt->close();
$conn->close();
?>
