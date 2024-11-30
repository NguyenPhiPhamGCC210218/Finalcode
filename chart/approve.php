<?php

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

// SQL query to get approved products grouped by time and product
$sql_detail_approved = "
    SELECT 
        d.CreateTime AS Time,
        p.Pro_Name AS Product,
        SUM(d.Pro_qty) AS Quantity
    FROM 
        detailcart d
    JOIN 
        cart c ON d.Cart_ID = c.Cart_ID
    JOIN 
        product p ON d.Pro_ID = p.Pro_ID
    WHERE 
        c.Status = 'approved'
    GROUP BY 
        d.CreateTime, p.Pro_Name
    ORDER BY 
        d.CreateTime DESC;  /* Order by time in descending order */
";

$result_detail_approved = $conn->query($sql_detail_approved);
$data_detail_approved = [];

if ($result_detail_approved->num_rows > 0) {
    while($row = $result_detail_approved->fetch_assoc()) {
        $data_detail_approved[] = $row;
    }
} else {
    echo "No approved products found.";
}

// SQL query to get waiting products grouped by time and product
$sql_detail_waiting = "
    SELECT 
        d.CreateTime AS Time,
        p.Pro_Name AS Product,
        SUM(d.Pro_qty) AS Quantity
    FROM 
        detailcart d
    JOIN 
        cart c ON d.Cart_ID = c.Cart_ID
    JOIN 
        product p ON d.Pro_ID = p.Pro_ID
    WHERE 
        c.Status = 'waiting'
    GROUP BY 
        d.CreateTime, p.Pro_Name
    ORDER BY 
        d.CreateTime DESC;  /* Order by time in descending order */
";

$result_detail_waiting = $conn->query($sql_detail_waiting);
$data_detail_waiting = [];

if ($result_detail_waiting->num_rows > 0) {
    while($row = $result_detail_waiting->fetch_assoc()) {
        $data_detail_waiting[] = $row;
    }
} else {
    echo "No waiting products found.";
}

// SQL query to get total quantities of approved products regardless of time
$sql_total_approved = "
    SELECT 
        p.Pro_Name AS Product,
        SUM(d.Pro_qty) AS Quantity
    FROM 
        detailcart d
    JOIN 
        cart c ON d.Cart_ID = c.Cart_ID
    JOIN 
        product p ON d.Pro_ID = p.Pro_ID
    WHERE 
        c.Status = 'approved'
    GROUP BY 
        p.Pro_Name
    ORDER BY 
        p.Pro_Name ASC;
";

$result_total_approved = $conn->query($sql_total_approved);
$data_total_approved = [];

if ($result_total_approved->num_rows > 0) {
    while($row = $result_total_approved->fetch_assoc()) {
        $data_total_approved[] = $row;
    }
}

// SQL query to get total quantities of waiting products regardless of time
$sql_total_waiting = "
    SELECT 
        p.Pro_Name AS Product,
        SUM(d.Pro_qty) AS Quantity
    FROM 
        detailcart d
    JOIN 
        cart c ON d.Cart_ID = c.Cart_ID
    JOIN 
        product p ON d.Pro_ID = p.Pro_ID
    WHERE 
        c.Status = 'waiting'
    GROUP BY 
        p.Pro_Name
    ORDER BY 
        p.Pro_Name ASC;
";

$result_total_waiting = $conn->query($sql_total_waiting);
$data_total_waiting = [];

if ($result_total_waiting->num_rows > 0) {
    while($row = $result_total_waiting->fetch_assoc()) {
        $data_total_waiting[] = $row;
    }
}

$conn->close();

// Prepare data for the approved chart
$approved_products = [];
$approved_quantities = [];
foreach ($data_total_approved as $row) {
    $approved_products[] = $row['Product'];
    $approved_quantities[] = $row['Quantity'];
}

// Prepare data for the waiting chart
$waiting_products = [];
$waiting_quantities = [];
foreach ($data_total_waiting as $row) {
    $waiting_products[] = $row['Product'];
    $waiting_quantities[] = $row['Quantity'];
}

// Prepare data for the approved detail table
$approved_times = [];
$approved_products_detail = [];
$approved_quantities_detail = [];
foreach ($data_detail_approved as $row) {
    $approved_times[] = $row['Time'];
    $approved_products_detail[] = $row['Product'];
    $approved_quantities_detail[] = $row['Quantity'];
}

// Prepare data for the waiting detail table
$waiting_times = [];
$waiting_products_detail = [];
$waiting_quantities_detail = [];
foreach ($data_detail_waiting as $row) {
    $waiting_times[] = $row['Time'];
    $waiting_products_detail[] = $row['Product'];
    $waiting_quantities_detail[] = $row['Quantity'];
}

// Encode data into JSON format for use in JavaScript
$approved_products = json_encode($approved_products);
$approved_quantities = json_encode($approved_quantities);
$waiting_products = json_encode($waiting_products);
$waiting_quantities = json_encode($waiting_quantities);
$approved_times = json_encode($approved_times);
$approved_products_detail = json_encode($approved_products_detail);
$approved_quantities_detail = json_encode($approved_quantities_detail);
$waiting_times = json_encode($waiting_times);
$waiting_products_detail = json_encode($waiting_products_detail);
$waiting_quantities_detail = json_encode($waiting_quantities_detail);

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved and Waiting Products Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .chart-container {
            margin: 20px auto;
            max-width: 900px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .chart-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
            font-size: 16px;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e2f0ff;
        }
        @media (max-width: 600px) {
            .chart-container {
                margin: 10px;
                padding: 15px;
            }
            .chart-title {
                font-size: 20px;
            }
            th, td {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<a href="../Management/index.php">Back to index</a>

<!-- Approved Products Chart -->
<div class="chart-container">
    <div class="chart-title">Total Quantity of Ordered Products in Shopping Cart</div>
    <canvas id="totalApprovedProductsChart"></canvas>
</div>

<!-- Waiting Products Chart -->
<div class="chart-container">
    <div class="chart-title">Total Quantity of Waiting Products Ordered in Shopping Cart</div>
    <canvas id="totalWaitingProductsChart"></canvas>
</div>

<script>
    // Approved Products Chart
    const approvedProducts = <?php echo $approved_products; ?>;
    const approvedQuantities = <?php echo $approved_quantities; ?>;

    const ctxApproved = document.getElementById('totalApprovedProductsChart').getContext('2d');
    const chartApproved = new Chart(ctxApproved, {
        type: 'bar', // Change this to 'line', 'pie', etc. if desired
        data: {
            labels: approvedProducts, // Labels are the product names
            datasets: [{
                label: 'Total Quantity of Ordered Products ',
                data: approvedQuantities, // Data points are the total quantities
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Waiting Products Chart
    const waitingProducts = <?php echo $waiting_products; ?>;
    const waitingQuantities = <?php echo $waiting_quantities; ?>;

    const ctxWaiting = document.getElementById('totalWaitingProductsChart').getContext('2d');
    const chartWaiting = new Chart(ctxWaiting, {
        type: 'bar', // Change this to 'line', 'pie', etc. if desired
        data: {
            labels: waitingProducts, // Labels are the product names
            datasets: [{
                label: 'Total Quantity of Waiting Products Ordered',
                data: waitingQuantities, // Data points are the total quantities
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Approved Products Detail Table -->
<div class="chart-container">
    <div class="chart-title">Quantity of Ordered Products  by Time</div>
    <table>
        <thead>
            <tr>
                <th>Time</th>
                <th>Product</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data_detail_approved as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Time']); ?></td>
                    <td><?php echo htmlspecialchars($row['Product']); ?></td>
                    <td><?php echo htmlspecialchars($row['Quantity']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Waiting Products Detail Table -->
<div class="chart-container">
    <div class="chart-title">Quantity of Waiting Products Ordered by Time</div>
    <table>
        <thead>
            <tr>
                <th>Time</th>
                <th>Product</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data_detail_waiting as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Time']); ?></td>
                    <td><?php echo htmlspecialchars($row['Product']); ?></td>
                    <td><?php echo htmlspecialchars($row['Quantity']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
