<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "shopping_online";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for error and success messages
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $re_id = $_POST['re_id'];
    $emp_id = $_POST['emp_id'];
    $sup_id = $_POST['sup_id'];
    
    // Validate input
    if (empty($re_id) || empty($emp_id) || empty($sup_id)) {
        $error = "Please fill all the fields.";
    } else {
        // Check if the Re_ID already exists
        $stmt = $conn->prepare("SELECT * FROM receivenote WHERE Re_ID = ?");
        $stmt->bind_param("i", $re_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "This Receivenote ID already exists.";
        } else {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO receivenote (Re_ID, Emp_ID, Sup_ID) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $re_id, $emp_id, $sup_id);
            
            // Execute the query
            if ($stmt->execute()) {
                $success = "New receivenote added successfully!";
                // Optionally redirect to another page after success
                header("Location:?page=receivenote");
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
            
            $stmt->close();
        }
    }
}

// Fetch employers
$employers = [];
$result = $conn->query("SELECT Emp_ID, Emp_Name FROM employer");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employers[] = $row;
    }
}

// Fetch suppliers
$suppliers = [];
$result = $conn->query("SELECT Sup_ID, Sup_Name FROM supplier");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Receivenote</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
/* Add your CSS styles here */
h1 {
    text-align: center;
    padding: 20px;
    background-color: #333;
    color: #fff;
    margin: 0;
}

.container {
    width: 80%;
    margin: auto;
    padding: 20px;
}

section {
    margin-bottom: 40px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    max-width: 600px;
    margin: auto;
}

label {
    display: block;
    margin-bottom: 8px;
}

select, input[type="text"], input[type="submit"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

p.error {
    color: red;
    text-align: center;
}

p.success {
    color: green;
    text-align: center;
}
</style>
<body>
    <h1>Add Receivenote</h1>

    <div class="container">
        <section>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <p class="success"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            
            <form action="add_receivenote.php" method="post">
                <label for="re_id">Receivenote ID:</label>
                <input type="text" id="re_id" name="re_id">
                
                <label for="emp_id">Select Employee:</label>
                <select id="emp_id" name="emp_id">
                    <option value="">Choose Employee</option>
                    <?php foreach ($employers as $employer): ?>
                        <option value="<?php echo htmlspecialchars($employer['Emp_ID']); ?>"><?php echo htmlspecialchars($employer['Emp_Name']); ?></option>
                    <?php endforeach; ?>
                </select>
                
                <label for="sup_id">Select Supplier:</label>
                <select id="sup_id" name="sup_id">
                    <option value="">Choose Supplier</option>
                    <?php foreach ($suppliers as $supplier): ?>
                        <option value="<?php echo htmlspecialchars($supplier['Sup_ID']); ?>"><?php echo htmlspecialchars($supplier['Sup_Name']); ?></option>
                    <?php endforeach; ?>
                </select>
                
                <input type="submit" value="Add Receivenote">
            </form>
        </section>
    </div>
</body>
</html>
