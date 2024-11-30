<?php
include_once("connection.php");

function bind_Category_List($conn){
    $sqlstring = "SELECT Cat_ID, Cat_Name FROM category";
    $result = mysqli_query($conn, $sqlstring);
    echo "<select name='CategoryList' class='form-control' style='width:500px;'>
    <option value='0'>Choose category</option>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        echo "<option value='".$row['Cat_ID']."'>".$row['Cat_Name']."</option>";
    }
    echo "</select>";
}

if (isset($_POST["btnAdd"])){
    $id = mysqli_real_escape_string($conn, $_POST["txtID"]);
    $proname = mysqli_real_escape_string($conn, $_POST["txtName"]);
    $short = mysqli_real_escape_string($conn, $_POST['txtShort']);
    $price = mysqli_real_escape_string($conn, $_POST['txtPrice']);
    $qty = mysqli_real_escape_string($conn, $_POST['txtQty']);
    $pic = $_FILES['txtImage'];
    $category = mysqli_real_escape_string($conn, $_POST['CategoryList']);
    $err = "";

    if (trim($id) == "") {
        $err .= "<li>Enter product ID, Please!</li>";
    }
    if (trim($proname) == "") {
        $err .= "<li>Enter product Name, Please!</li>";
    }
    if ($category == "0") {
        $err .= "<li>Choose product category, Please!</li>";
    }
    if (!is_numeric($price) || $price < 0) {
        $err .= "<li>Product price must be number</li>";
    }
    if (!is_numeric($qty) || $qty < 0) {
        $err .= "<li>Product quantity must be number</li>";
    }

    if ($err != "") {
        echo "<ul>$err</ul>";
    } else {
        if ($pic['type'] == "image/jpg" || $pic['type'] == "image/jpeg" || $pic['type'] == "image/png" || $pic['type'] == "image/gif") {
            if ($pic['size'] <= 614400) {
                $sq = "SELECT * FROM product WHERE Pro_ID='$id' OR Pro_Name='$proname'";
                $result = mysqli_query($conn, $sq);
                if (mysqli_num_rows($result) == 0) {
                    copy($pic['tmp_name'], "./product-imgs/" . $pic['name']);
                    $filePic = $pic['name'];
                    $sqlstring = "INSERT INTO product (
                        Pro_ID, Pro_Name, Pro_Price, SmallDesc, ProDate, Pro_qty, Pro_image, Cat_ID
                    ) VALUES (
                        '$id', '$proname', '$price', '$short', '".date('Y-m-d H:i:s')."', '$qty', '$filePic', '$category'
                    )";

                    mysqli_query($conn, $sqlstring);
                    echo '<meta http-equiv="refresh" content="0;URL=?page=manageProduct"/>';

                } else {
                    echo "<li>Duplicate product ID or Name</li>";
                }
            } else {
                echo "Size of image too big";
            }
        } else {
            echo "Image format is not correct";
        }
    }
}
?>

<div class="container">
<div class="coverblock">
<a class="backhome" href="index.php">←back to shop</a>

    <h2 class="h2category">Adding new Product</h2>

    <form id="frmProduct" name="frmProduct" method="post" enctype="multipart/form-data" action="" class="form-horizontal" role="form">
        <div class="form-group">
            <label for="txtTen" class="col-sm-4 control-label">Product ID(*):  </label>
            <div class="col-sm-8">
                <input class="inputext" type="text" name="txtID" id="txtID" class="form-control" placeholder="Product ID" value=''/>
            </div>
        </div> 
        <div class="form-group"> 
            <label for="txtTen" class="col-sm-4 control-label">Product Name(*):  </label>
            <div class="col-sm-8">
                <input class="inputext" type="text" name="txtName" id="txtName" class="form-control" placeholder="Product Name" value=''/>
            </div>
        </div>   
        <div class="form-group">   
            <label for="" class="col-sm-4 control-label">Product category(*):  </label>
            <div class="col-sm-8">
                <?php bind_Category_List($conn); ?>
            </div>
        </div>  
                      
        <div class="form-group">  
            <label for="lblGia" class="col-sm-4 control-label">Price(*):  </label>
            <div class="col-sm-8">
                <input class="inputext"  type="text" name="txtPrice" id="txtPrice" class="form-control" placeholder="Price" value=''/>
            </div>
        </div>   
                        
        <div class="form-group">   
            <label for="lblShort" class="col-sm-4 control-label">Short description(*):  </label>
            <div class="col-sm-8">
                <input class="inputext" type="text" name="txtShort" id="txtShort" class="form-control" placeholder="Short description" value=''/>
            </div>
        </div>

                        
        <div class="form-group">  
            <label for="lblSoLuong" class="col-sm-4 control-label">Quantity(*):  </label>
            <div class="col-sm-8">
                <input type="number" name="txtQty" id="txtQty" class="form-control" placeholder="Quantity" value="" style="width: 500px;  height: 40px;  border-radius: 10px"/>
            </div>
        </div>

        <div class="form-group">  
            <label for="sphinhanh" class="col-sm-4 control-label">Image(*):  </label>
            <div class="col-sm-8">
                <input type="file" name="txtImage" id="txtImage" class="form-control" value="" style="width: 500px;height: 40px;border-radius: 10px"/>
            </div>
        </div>
                    
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <input class="btnupdatePro" type="submit" class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new" style="font-size: 20px;margin-top: 5px;border-radius: 10px;margin-left: 50px;background: #F7E4E0;color: #C51162;font-family: fangsong; font-weight: bold;"/>
                <input class="btnupdatePro" type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=manageProduct'" style="font-size: 20px;margin-top: 5px;border-radius: 10px;margin-left: 50px;background: #F7E4E0;color: #C51162;font-family: fangsong; font-weight: bold;"/>
            </div>
        </div>
    </form>
</div>
</div>
