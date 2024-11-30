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

        @media (max-width: 600px) {
            h1 {
                font-size: 24px;
            }

            .chart-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <a href="../Management/index.php">Back to index</a>
    <h1>Product Count by Category</h1>
    <div class="chart-container">
        <canvas id="productChart" width="400" height="200"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('fetch_product_data.php')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.Cat_Name);
                    const counts = data.map(item => item.product_count);

                    const ctx = document.getElementById('productChart').getContext('2d');
                    const productChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Number of Products by Category',
                                data: counts,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false, // Maintain aspect ratio for better responsiveness
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script>
</body>
</html>
