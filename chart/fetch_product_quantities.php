<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = ""; // Update with your password
$dbname = "online_shopping";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the quantity of each product
$sql = "SELECT Pro_Name, Pro_qty FROM product";
$result = $conn->query($sql);

$data = array();

while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();

echo json_encode($data);
?>
