<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your external CSS file -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1500px   ;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #0c0c0d;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            table th {
                display: none; /* Hide headers in mobile view */
            }
            table tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
            }
            table td {
                text-align: right;
                padding-left: 50%; /* Leave space for pseudo element */
                position: relative;
            }
            table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: calc(50% - 20px);
                text-align: left;
                font-weight: bold;
                color: #007bff;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Purchase History</h1>
        <table>
            <thead>
                <tr>
                    <th>Name Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Purchase Date</th>
                    <th>Picture</th>
                    <th>Your Name</th>
                    <th>Your Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Kết nối tới cơ sở dữ liệu
                include_once "connection.php";
                // session_start(); // Khởi động session để sử dụng biến phiên

                // Kiểm tra xem ID người dùng có tồn tại trong session không
                if (!isset($_SESSION['cus_id'])) {
                    echo "<script>alert('You must be logged in to see your purchase history.')</script>";
                    echo '<meta http-equiv="refresh" content="0;URL=?page=login"/>';
                    exit();
                }

                // Lấy ID người dùng từ session
                $cus_id = $_SESSION['cus_id']; 

                // Thực hiện truy vấn để lấy lịch sử mua hàng
                $sql = "SELECT c.Cart_ID, c.Create AS Cart_Create, c.Total, c.Status, 
                               dc.Pro_qty, p.Pro_Name, p.Pro_Price, p.Pro_image, 
                               u.Full_Name AS Cus_Name, u.Email AS Cus_Email
                        FROM cart c
                        JOIN detailcart dc ON c.Cart_ID = dc.Cart_ID
                        JOIN product p ON dc.Pro_ID = p.Pro_ID
                        JOIN customer u ON c.Cus_ID = u.Cus_ID
                        WHERE c.Status = 'approved' AND c.Cus_ID = ?
                        ORDER BY c.Create DESC";

                // Chuẩn bị và thực hiện truy vấn
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $cus_id); // Ràng buộc biến
                $stmt->execute();
                $result = $stmt->get_result();

                // Hiển thị dữ liệu
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td data-label='Name Product'>" . $row['Pro_Name'] . "</td>
                                <td data-label='Quantity'>" . $row['Pro_qty'] . "</td>
                                <td data-label='Price'>$" . number_format($row['Pro_Price'], 2) . "</td>
                                <td data-label='Total Price'>$" . number_format($row['Total'], 2) . "</td>
                                <td data-label='Purchase Date'>" . date("d/m/Y", strtotime($row['Cart_Create'])) . "</td>
                                <td data-label='Picture'><img src='./Management/product-imgs/" . $row['Pro_image'] . "' alt='" . $row['Pro_Name'] . "'></td>
                                <td data-label='Your Name'>" . $row['Cus_Name'] . "</td>
                                <td data-label='Your Email'>" . $row['Cus_Email'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>You have no purchase history.</td></tr>";
                }

                // Đóng kết nối
                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
