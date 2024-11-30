<?php
session_start();
include_once("connection.php");

// Check if the user is logged in as either customer or employer
if (!isset($_SESSION['cus_id']) && !isset($_SESSION['emp_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

// Determine user role and set the other party’s ID
$isCustomer = isset($_SESSION['cus_id']);
$user_id = $isCustomer ? $_SESSION['cus_id'] : $_SESSION['emp_id'];
$receiver_id = $isCustomer ? $_SESSION['emp_id'] : $_SESSION['cus_id'];

// Ensure receiver_id is defined
if (!$receiver_id) {
    echo json_encode(["status" => "error", "message" => "Receiver ID not set."]);
    exit();
}

// Retrieve messages between the customer and employer
$query = "SELECT * FROM chat WHERE (Cus_ID = ? AND Emp_ID = ?) OR (Cus_ID = ? AND Emp_ID = ?) ORDER BY ChatDate ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiii", $user_id, $receiver_id, $receiver_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'id' => $row['id'],
        'sender' => $row['Cus_ID'] == $user_id ? 'customer' : 'employer',
        'content' => $row['ContentChat'],
        'date' => $row['ChatDate']
    ];
}

echo json_encode(["status" => "success", "messages" => $messages]);
$stmt->close();
$conn->close();
?>
