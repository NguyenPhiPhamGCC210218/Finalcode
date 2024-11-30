<?php
session_start();
include_once("connection.php");

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION["cus_id"])) {
    header("location: login.php");
    exit();
}

// Lấy ID sản phẩm từ tham số URL
if (isset($_GET['id'])) {
    $pro_id = intval($_GET['id']); // Chuyển đổi ID thành số nguyên
    $cus_id = $_SESSION['cus_id'];

    // Kiểm tra xem sản phẩm có trong giỏ hàng không
    $check_query = "SELECT COUNT(*) FROM detailcart cd
                    JOIN cart c ON cd.Cart_ID = c.Cart_ID
                    WHERE c.Cus_ID = ? AND cd.Pro_ID = ?";
    
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $cus_id, $pro_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Nếu sản phẩm tồn tại, thực hiện xóa
    if ($count > 0) {
        // Xóa sản phẩm khỏi giỏ hàng
        $delete_query = "DELETE cd FROM detailcart cd
                         JOIN cart c ON cd.Cart_ID = c.Cart_ID
                         WHERE c.Cus_ID = ? AND cd.Pro_ID = ?";
        
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("ii", $cus_id, $pro_id);

        if ($stmt->execute()) {
            // Xóa thành công, có thể thêm thông báo
            echo "<script>alert('Product removed successfully.');</script>";
        } else {
            // Nếu có lỗi xảy ra
            echo "<script>alert('Error removing product: " . mysqli_error($conn) . "');</script>";
        }

        // Đóng statement
        $stmt->close();
    } else {
        echo "<script>alert('Product not found in cart.');</script>";
    }
} else {
    echo "<script>alert('Invalid product ID.');</script>";
}

// Chuyển hướng người dùng trở lại trang giỏ hàng
echo '<meta http-equiv="refresh" content="0;URL=?page=cart"/>';
exit();
?>
