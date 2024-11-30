<?php
include_once("connection.php");

$id = $_GET['id'];
$type = $_GET['type'];

if ($type == 'customer') {
    $result = $conn->query("SELECT * FROM customer WHERE Cus_ID = $id");
} else {
    $result = $conn->query("SELECT * FROM employer WHERE Emp_ID = $id");
}

$account = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Account</title>
</head>
<body>
    <h1>Edit Account</h1>
    <form action="update_account.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="type" value="<?php echo $type; ?>">
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" id="full_name" value="<?php echo $account['Full_Name'] ?? $account['Emp_Name']; ?>" required>
        <br>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo $account['Username']; ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $account['Email']; ?>" required>
        <br>
        <button type="submit">Update Account</button>
    </form>
</body>
</html>
