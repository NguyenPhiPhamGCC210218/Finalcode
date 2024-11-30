<?php
session_start();
include_once("connection.php");

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['cus_id'])) {
    echo json_encode(array("status" => "error", "message" => "Người dùng chưa đăng nhập."));
    exit();
}

$cus_id = $_SESSION['cus_id'];
$employer_id = 1; // Thay thế bằng ID của nhà tuyển dụng thực tế cho cuộc trò chuyện

if (isset($_POST['message'])) {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Chuẩn bị câu lệnh SQL
    $query = "INSERT INTO chat (Cus_ID, Emp_ID, ContentChat, ChatDate) VALUES ('$cus_id', '$employer_id', '$message', NOW())";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Gửi tin nhắn không thành công."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Không có tin nhắn được cung cấp."));
}

// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>
