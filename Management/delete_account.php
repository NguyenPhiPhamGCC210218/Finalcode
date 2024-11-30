<?php
include_once("connection.php");
$id = $_GET['id'];
$type = $_GET['type'];

if ($type == 'customer') {
    $stmt = $conn->prepare("DELETE FROM customer WHERE Cus_ID = ?");
} else {
    $stmt = $conn->prepare("DELETE FROM employer WHERE Emp_ID = ?");
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Account deleted successfully";
    echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
