
<?php
        if(isset($_SESSION['admin']) && $_SESSION["admin"]==1)
        {
    ?>
<?php
include_once('connection.php');

// Fetch customers
$customers = $conn->query("SELECT * FROM customer");

// Fetch employers
$employers = $conn->query("SELECT * FROM employer");




// Initialize search variables
$searchCustomerId = isset($_POST['search_customer_id']) ? $_POST['search_customer_id'] : '';
$searchCustomerUsername = isset($_POST['search_customer_username']) ? $_POST['search_customer_username'] : '';
$searchEmployerId = isset($_POST['search_employer_id']) ? $_POST['search_employer_id'] : '';
$searchEmployerUsername = isset($_POST['search_employer_username']) ? $_POST['search_employer_username'] : '';

// Fetch customers with search
$customerQuery = "SELECT * FROM customer WHERE 1=1";
if ($searchCustomerId) {
    $customerQuery .= " AND Cus_ID LIKE '%" . $conn->real_escape_string($searchCustomerId) . "%'";
}
if ($searchCustomerUsername) {
    $customerQuery .= " AND Username LIKE '%" . $conn->real_escape_string($searchCustomerUsername) . "%'";
}
$customers = $conn->query($customerQuery);

// Fetch employers with search
$employerQuery = "SELECT * FROM employer WHERE 1=1";
if ($searchEmployerId) {
    $employerQuery .= " AND Emp_ID LIKE '%" . $conn->real_escape_string($searchEmployerId) . "%'";
}
if ($searchEmployerUsername) {
    $employerQuery .= " AND Username LIKE '%" . $conn->real_escape_string($searchEmployerUsername) . "%'";
}
$employers = $conn->query($employerQuery);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Account Management</title>
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

h1, h2 {
    text-align: center;
    color: #333;
}

button {
    background-color: #000;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background-color: #572d2d;
}

table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #000;
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

.actions a {
    margin-right: 15px;
    text-decoration: none;
    color: #ff0000;
    font-weight: bold;
}

.actions a:hover {
    text-decoration: underline;
    font-weight: normal;
}

.form-container {
    display: none;
    position: fixed;
    top: 20%;
    left: 50%;
    transform: translate(-50%, 0);
    width: 40%;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    padding: 20px;
    z-index: 1000;
}

.form-container h2 {
    margin-top: 0;
}

.form-container .close {
    position: absolute;
    top: 15px;
    right: 15px;
    cursor: pointer;
    font-size: 24px;
    color: #aaa;
}

.form-container .close:hover {
    color: #000;
}

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 999;
}

label {
    display: block;
    margin-bottom: 8px;
}

input, select, button {
    width: calc(100% - 22px);
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

input:focus, select:focus, button:focus {
    border-color: #4CAF50;
    outline: none;
}

    </style>
</head>
<body>
    <h1>Admin Account Management</h1>

    <button id="showFormButton">Add Account</button>

    <div class="overlay" id="overlay"></div>

    <div class="form-container" id="formContainer">
        <span class="close" id="closeFormButton">&times;</span>
        <h2>Add Account</h2>
        <form action="add_account.php" method="post">
            <label for="account_type">Account Type:</label>
            <select name="account_type" id="account_type">
                <option value="customer">Customer</option>
                <option value="employer">Employer</option>
            </select>
            <br>
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" required>
            <br>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <br>
            <button type="submit">Add Account</button>
        </form>
    </div>

    <h2>Customers</h2>
    <h2>Search Customers</h2>
    <form action="" method="post">
        <label for="search_customer_id">ID:</label>
        <input type="text" name="search_customer_id" id="search_customer_id" value="<?php echo htmlspecialchars($searchCustomerId); ?>">
        <br>
        <label for="search_customer_username">Username:</label>
        <input type="text" name="search_customer_username" id="search_customer_username" value="<?php echo htmlspecialchars($searchCustomerUsername); ?>">
        <br>
        <button type="submit">Search</button>
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while($customer = $customers->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $customer['Cus_ID']; ?></td>
            <td><?php echo $customer['Full_Name']; ?></td>
            <td><?php echo $customer['Username']; ?></td>
            <td><?php echo $customer['Email']; ?></td>
            <td class="actions">
                <a href="delete_account.php?type=customer&id=<?php echo $customer['Cus_ID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h2>Employers</h2>
    <h2>Search Employers</h2>
    <form action="" method="post">
        <label for="search_employer_id">ID:</label>
        <input type="text" name="search_employer_id" id="search_employer_id" value="<?php echo htmlspecialchars($searchEmployerId); ?>">
        <br>
        <label for="search_employer_username">Username:</label>
        <input type="text" name="search_employer_username" id="search_employer_username" value="<?php echo htmlspecialchars($searchEmployerUsername); ?>">
        <br>
        <button type="submit">Search</button>
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while($employer = $employers->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $employer['Emp_ID']; ?></td>
            <td><?php echo $employer['Emp_Name']; ?></td>
            <td><?php echo $employer['Username']; ?></td>   
            <td><?php echo $employer['Email']; ?></td>
            <td class="actions">
                <a href="delete_account.php?type=employer&id=<?php echo $employer['Emp_ID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        
    </script>

    <script>
        document.getElementById('showFormButton').addEventListener('click', function() {
            document.getElementById('formContainer').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        });

        document.getElementById('closeFormButton').addEventListener('click', function() {
            document.getElementById('formContainer').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        });

        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('formContainer').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            if (password.length < 6) {
                alert('Password must be at least 6 characters long.');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
<?php
        }else{
            echo "<script>alert('You are not Adminitrator!')</script>";
            echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
        }
   ?>