<?php
session_start();
include_once('connection.php');

// Check if the customer is logged in
if (isset($_SESSION['Cus_ID'])) {
    $cus_id = $_SESSION['Cus_ID'];
    $emp_id = $_POST['Emp_ID'];
    $message = $_POST['message'];

    // Prepare statement to insert message with matching field names
    $stmt = $conn->prepare("INSERT INTO chat (Cus_ID, Emp_ID, ContentChat, ChatDate) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $cus_id, $emp_id, $message);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => $message]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
}

$conn->close();
?>
