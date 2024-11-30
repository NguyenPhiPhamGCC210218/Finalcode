
<?php
include_once 'connection.php';


// Lấy dữ liệu từ bảng detailreceivenote
$sql = "SELECT * FROM detailreceivenote";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Chi Tiết Biên Nhận Hàng</title>
</head>
<body>
    <h1>Danh Sách Chi Tiết Biên Nhận Hàng</h1>
    <a href="?page=add_detailreceivenote">Thêm Chi Tiết Mới</a>
    <table border="1">
        <tr>
            <th>DeR_ID</th>
            <th>Re_qty</th>
            <th>Re_Price</th>
            <th>Re_Datetime</th>
            <th>Re_ID</th>
            <th>Hành Động</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['DeR_ID']}</td>
                    <td>{$row['Re_qty']}</td>
                    <td>{$row['Re_Price']}</td>
                    <td>{$row['Re_Datetime']}</td>
                    <td>{$row['Re_ID']}</td>
                    <td>
                        <a href='edit_detailreceivenote.php?id={$row['DeR_ID']}'>Sửa</a> |
                        <a href='delete_detailreceivenote.php?id={$row['DeR_ID']}'>Xóa</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>
