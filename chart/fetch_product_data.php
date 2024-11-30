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

// Query to fetch the count of products per category
$sql = "
    SELECT c.Cat_Name, COUNT(p.Pro_ID) as product_count
    FROM product p
    JOIN category c ON p.Cat_ID = c.Cat_ID
    GROUP BY c.Cat_Name
";

$result = $conn->query($sql);

$data = array();

while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();

echo json_encode($data);
?>
