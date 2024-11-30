<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Receivenote</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Sửa lại đường dẫn CSS nếu cần -->
</head>
<style>
    /* CSS đã được giữ nguyên từ trước */
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

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 10px;
        text-align: left;
        color: #000;
    }

    th {
        background-color: #4CAF50;
        color: #000;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    p {
        text-align: center;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        margin: 4px 2px;
        background-color: #4CAF50;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 4px;
    }

    .btn:hover {
        background-color: #45a049;
    }
</style>
<body>
    <h1>Management Receivenote</h1>

    <div class="container">
        <section>
            <?php
            include_once("connection.php");

            // Xử lý yêu cầu xóa tất cả dữ liệu
            if (isset($_POST['delete_all'])) {
                // Bắt đầu giao dịch
                $conn->begin_transaction();
                
                try {
                    // Xóa dữ liệu từ bảng detailreceivenote trước
                    $sql_delete_detail = "DELETE FROM detailreceivenote";
                    $conn->query($sql_delete_detail);

                    // Xóa dữ liệu từ bảng receivenote
                    $sql_delete_receivenote = "DELETE FROM receivenote";
                    $conn->query($sql_delete_receivenote);

                    // Cam kết giao dịch
                    $conn->commit();
                    echo "<p>All records deleted successfully.</p>";
                } catch (Exception $e) {
                    // Rollback giao dịch nếu có lỗi
                    $conn->rollback();
                    echo "<p>Error deleting records: " . $e->getMessage() . "</p>";
                }
            }

            // Truy vấn để lấy tất cả các receivenote
            $sql = "SELECT rn.Re_ID, e.Emp_Name, s.Sup_Name
                    FROM receivenote rn
                    JOIN employer e ON rn.Emp_ID = e.Emp_ID
                    JOIN supplier s ON rn.Sup_ID = s.Sup_ID";
            $result = $conn->query($sql);
            ?>
        </section>

        <section>
            <h2>List Receivenotes</h2>
            <a href="?page=addreceivenote" class="btn">Add Receivenote</a>
            <!-- Nút xóa tất cả dữ liệu -->
            <form method="post" action="">
                <input type="submit" name="delete_all" value="Delete All Receivenotes" class="btn" onclick="return confirm('Are you sure you want to delete all records?');">
            </form>
            <?php
            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            
                            <th>Employee Name</th>
                            <th>Supplier Name</th>
                        </tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            
                            <td>" . $row["Emp_Name"] . "</td>
                            <td>" . $row["Sup_Name"] . "</td>
                          </tr>";
                }
                echo "</table>";    
            } else {
                echo "<p>No data.</p>";
            }

            $conn->close();
            ?>
        </section>
    </div>
</body>
</html>
