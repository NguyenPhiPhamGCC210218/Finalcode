<?php
include_once('connection.php');

// Fetch customers
$customers = $conn->query("SELECT * FROM customer");

// Fetch employers
$employers = $conn->query("SELECT * FROM employer");
?>
<?php
include_once('connection.php');


$account_type = $_POST['account_type'];
$full_name = $_POST['full_name'];
$username = $_POST['username'];
$password = md5($_POST['password']); // Assuming MD5 for now
$email = $_POST['email'];

if ($account_type == 'customer') {
    $stmt = $conn->prepare("INSERT INTO customer (Full_Name, Username, Password, Email) VALUES (?, ?, ?, ?)");
} else {
    $stmt = $conn->prepare("INSERT INTO employer (Emp_Name, Username, Password, Email) VALUES (?, ?, ?, ?)");
}

$stmt->bind_param("ssss", $full_name, $username, $password, $email);

if ($stmt->execute()) {
    echo "New account added successfully";
    echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';

} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

