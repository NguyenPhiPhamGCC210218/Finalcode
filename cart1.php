<?php
session_start(); 
include_once("connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="css/cart.css">
    <script src="js/cart.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="js/jquery.min.js"></script>
    <script src="js/Library.js"></script>
    

</head>

<body>
<div class="boxcart" id="boxcart">
    <img src="images/cart.png" class="carticon"> <span></span>
</div>
    <div class="boxcenter">
        <table>
            <tr>
                <th>Sản phẩm</th>
                <th>Hình</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Xóa</th>
            </tr>
            <tbody id="giohang">
                <tr>
                    <td>Sản phẩm 1</td>
                    <td><img src="images/1.jpg"></td>
                    <td>100</td>
                    <td><input type="number" min="1" max="10" value="1" class="num"></td>
                    <td>100</td>
                    <td><img src="images/removeicon.png" class="remo">x</td>
                </tr>
                <tr>
                    <td>Sản phẩm 2</td>
                    <td><img src="images/1.jpg"></td>
                    <td>200</td>
                    <td><input type="number" min="1" max="10" value="2" class="num"></td>
                    <td>400</td>
                    <td><img src="images/removeicon.png" class="remo">x</td>
                </tr>
                <tr>
                    <td>Sản phẩm 3</td>
                    <td><img src="images/1.jpg"></td>
                    <td>300</td>
                    <td><input type="number" min="1" max="10" value="3" class="num"></td>
                    <td>900</td>
                    <td><img src="images/removeicon.png" class="remo">x</td>
                </tr>
                </tbody>
            </tbody id="tongdonhang">
            <tr >
                <td colspan="4"> Tóng đơn hàng</td>
                <td><span></span></td>
                <td></td>
            </tr>
            </tbody>

        </table>

    </div>
</body>

</html>