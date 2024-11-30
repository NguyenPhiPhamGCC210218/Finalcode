<?php
include_once 'connection.php';

// Lấy danh sách Re_ID từ bảng receivenote
$sql = "SELECT Re_ID FROM receivenote";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Re_qty = $_POST['Re_qty'];
    $Re_Price = $_POST['Re_Price'];
    $Re_Datetime = $_POST['Re_Datetime'];
    $Re_ID = $_POST['Re_ID'];

    // Kiểm tra Re_ID có giá trị hợp lệ không
    if (empty($Re_ID)) {
        echo "Vui lòng chọn Re_ID.";
        exit();
    }

    // Sử dụng prepared statements để thêm dữ liệu vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO detailreceivenote (Re_qty, Re_Price, Re_Datetime, Re_ID) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idii", $Re_qty, $Re_Price, $Re_Datetime, $Re_ID);

    if ($stmt->execute()) {
        echo "Thêm thành công";
        header('Location:?page=detailreceivenote');
        exit();
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm Chi Tiết Biên Nhận Hàng</title>
</head>
<body>
    <h1>Thêm Chi Tiết Biên Nhận Hàng</h1>
    <form method="post" action="">
        <label for="Re_qty">Số lượng:</label>
        <input type="number" id="Re_qty" name="Re_qty" required><br>
        <label for="Re_Price">Giá:</label>
        <input type="number" id="Re_Price" name="Re_Price" required><br>
        <label for="Re_Datetime">Ngày:</label>
        <input type="datetime-local" id="Re_Datetime" name="Re_Datetime" required><br>
        <label for="Re_ID">Re_ID:</label>
        <select id="Re_ID" name="Re_ID" required>
            <option value="">Chọn Re_ID</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['Re_ID']}'>{$row['Re_ID']}</option>";
                }
            } else {
                echo "<option value=''>Không có dữ liệu</option>";
            }
            ?>
        </select><br>
        <input type="submit" value="Thêm">
    </form>
</body>
</html>
<?php
$conn->close();
?>
