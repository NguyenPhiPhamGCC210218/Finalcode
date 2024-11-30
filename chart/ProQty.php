<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Count by Category</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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

        h1 {
            text-align: center;
            color: #333;
        }

        .chart-container {
            margin: 20px auto;
            max-width: 800px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        canvas {
            display: block;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
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
            body {
                padding: 10px;
            }

            h1 {
                font-size: 20px;
            }

            .chart-container {
                padding: 15px;
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

<h1>Product Quantities</h1>
<div class="chart-container">
    <canvas id="productQuantityChart" width="600" height="400"></canvas>
</div>

<!-- Statistics Table -->
<div class="chart-container">
    <h2 style="text-align:center; margin-top: 0;">Statistics Table</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody id="statisticsTableBody">
            <!-- Data will be populated here -->
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('fetch_product_quantities.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.Pro_Name);
                const quantities = data.map(item => item.Pro_qty);

                // Populate the chart
                const ctx = document.getElementById('productQuantityChart').getContext('2d');
                const productQuantityChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Quantity of Each Product',
                            data: quantities,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Populate the statistics table
                const statisticsTableBody = document.getElementById('statisticsTableBody');
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.Pro_Name}</td>
                        <td>${item.Pro_qty}</td>
                    `;
                    statisticsTableBody.appendChild(row);
                });
            });
    });
</script>

</body>
</html>
