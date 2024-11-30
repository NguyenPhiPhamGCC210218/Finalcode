<?php
// Kết nối cơ sở dữ liệu
include_once 'connection.php';

// Kiểm tra kết nối
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Xử lý xóa sản phẩm
if (isset($_GET['function']) && $_GET['function'] == 'del' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_query = "DELETE FROM product WHERE Pro_ID = '$id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Product deleted successfully');</script>";
        echo "<script>window.location.href='?page=manageProduct';</script>";
    } else {
        echo "<script>alert('Error deleting product: " . mysqli_error($conn) . "');</script>";
    }
}

// Truy vấn dữ liệu sản phẩm
$sql = "SELECT p.Pro_ID, p.Pro_Name, p.Pro_Price, p.Pro_qty, p.Pro_image, p.ProDate, p.SmallDesc, p.Cat_ID, c.Cat_Name
        FROM product p
        JOIN category c ON p.Cat_ID = c.Cat_ID
        ORDER BY p.ProDate DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
    <script>
        function deleteConfirm() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>
   
</head>
<body>
    <div class="container">
        <div class="coverblock">
            <form name="frm" method="post" action="">
                <a class="backhome" href="index.php">Back to Shop</a>
                <h1 class="h1manaCat">Product Management</h1>
                <p>
                    
                    <a href="?page=add_Product" class="ManaAddCat"><img src="./product-imgs/addicon.png" alt="Add new" width="16" height="16" border="0" />Add New Product</a>
                </p>
                <table id="tableproduct" class="table table-striped table-bordered" cellspacing="0" width="100%" style="text-align: center; color:#000;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Quantity Product</th>
                            <!-- <th>Product Date</th> -->
                            <th>Short Description</th>
                            <th>Image</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        
                        $No = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $No; ?></td>
                                <td><?php echo $row["Pro_ID"]; ?></td>
                                <td><?php echo $row["Pro_Name"]; ?></td>
                                <td><?php echo $row["Pro_Price"]; ?></td>
                                <td><?php echo $row["Cat_Name"]; ?></td>
                                <td><?php echo $row["Pro_qty"]; ?></td>

                                <!-- <td><?php echo $row["ProDate"]; ?></td> -->
                                <td><?php echo $row["SmallDesc"]; ?></td>
                                <td >
                                    <img src='product-imgs/<?php echo $row['Pro_image']; ?>'style="width:50px height:50px" />
                                </td>
                                <td><a href="?page=update_Product&&id=<?php echo $row["Pro_ID"]; ?>"><img src='./product-imgs/editicon.png' border='0' /></a></td>
                                <td><a href="?page=manageProduct&&function=del&&id=<?php echo $row["Pro_ID"]; ?>" onclick="return deleteConfirm()"><img src='./product-imgs/deleteicon.png' border='0' /></a></td>
                            </tr>
                        <?php
                            $No++;
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>
 <style>
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
        img {
    height: 50px;
    width: 50px;

}
a{
    color: #000;
    text-decoration: none;
    font-weight: bold;
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