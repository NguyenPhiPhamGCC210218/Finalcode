<!-- Bootstrap -->
<link rel="stylesheet" type="text/css" href="css/updateproduct.css">

<link rel="stylesheet" href="css/bootstrap.min.css">
<script type="text/javascript" src="scripts/ckeditor/ckeditor.js"></script>
<?php
include_once("connection.php");
function bind_Category_List($conn, $selectedValue)
{
	$sqlstring = "select Cat_ID, Cat_Name from category";
	$result = mysqli_query($conn, $sqlstring);
	echo "<select name='CategoryList' class='form-control' style='width:500px;'>
			<option value='0'>Choose category</option>";
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if ($row['Cat_ID'] == $selectedValue) {
			echo "<option value='" . $row['Cat_ID'] . "' selected>" . $row['Cat_Name'] . "</option>";
		} else {
			echo "<option value='" . $row['Cat_ID'] . "'>" . $row['Cat_Name'] . "</option>";
		}
	}
	echo "</select>";
}

if (isset($_GET["id"])) {
	$id = $_GET["id"];
	$sqlstring = "Select Pro_Name, Pro_Price, SmallDesc, ProDate, Pro_qty,
		Pro_image,Cat_ID from product where Pro_ID='$id'";

	$result = mysqli_query($conn, $sqlstring);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	$proname = $row["Pro_Name"];
	$short = $row['SmallDesc'];
	$price = $row['Pro_Price'];	
	$qty = $row['Pro_qty'];
	$pic = $row['Pro_image'];
	$category = $row['Cat_ID'];

?>
	<div class="container">
	<div class="coverblock">
	<a class="backhome" href="index.php">back to shop</a>

		<h2 class="h2category">Updating Product</h2>

		<form id="frmProduct" name="frmProduct" method="post" enctype="multipart/form-data" action="" class="form-horizontal" role="form">
			<div class="form-group">
				<label for="txtTen" class="col-sm-4 control-label">Product ID(*): </label>
				<div class="col-sm-8">
					<input class="inputext" type="text" name="txtID" id="txtID" class="form-control" placeholder="Product ID" readonly value='<?php echo $id; ?>' />
				</div>
			</div>
			<div class="form-group">
				<label for="txtTen" class="col-sm-4 control-label">Product Name(*): </label>
				<div class="col-sm-8">
					<input class="inputext" type="text" name="txtName" id="txtName" class="form-control" placeholder="Product Name" value='<?php echo $proname; ?>' />
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Product category(*): </label>
				<div class="col-sm-8">
					<?php bind_Category_List($conn, $category); ?>
				</div>
			</div>

			<div class="form-group">
				<label for="lblGia" class="col-sm-4 control-label">Price(*): </label>
				<div class="col-sm-8">
					<input class="inputext" type="text" name="txtPrice" id="txtPrice" class="form-control" placeholder="Price" value='<?php echo $price ?>' />
				</div>
			</div>

			<div class="form-group">
				<label for="lblShort" class="col-sm-4 control-label">Short description(*): </label>
				<div class="col-sm-8">
					<input class="inputext" type="text" name="txtShort" id="txtShort" class="form-control" placeholder="Short description" value='<?php echo $short ?>' />
				</div>
			</div>

			<!-- <div class="form-group">
				<label for="lblDetail" class="col-sm-4 control-label">Detail description(*): </label>
				<div class="col-sm-8">
					<textarea name="txtDetail" rows="4" class="ckeditor"><?php echo $detail ?></textarea>
					<script language="javascript">
						CKEDITOR.replace('txtDetail', {
							skin: 'kama',
							extraPlugins: 'uicolor',
							uiColor: '#eeeeee',
							toolbar: [
								['Source', 'DocProps', '-', 'Save', 'NewPage', 'Preview', '-', 'Templates'],
								['Cut', 'Copy', 'Paste', 'PasteText', 'PasteWord', '-', 'Print', 'SpellCheck'],
								['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
								['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
								['Bold', 'Italic', 'Underline', 'StrikeThrough', '-', 'Subscript', 'Superscript'],
								['OrderedList', 'UnorderedList', '-', 'Outdent', 'Indent', 'Blockquote'],
								['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull'],
								['Link', 'Unlink', 'Anchor', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'],
								['Image', 'Flash', 'Table', 'Rule', 'Smiley', 'SpecialChar'],
								['Style', 'FontFormat', 'FontName', 'FontSize'],
								['TextColor', 'BGColor'],
								['UIColor']
							]
						});
					</script>

				</div>
			</div> -->

			<div class="form-group">
				<label for="lblSoLuong" class="col-sm-4 control-label">Quantity(*): </label>
				<div class="col-sm-8">
					<input class="inputext" type="number" name="txtQty" id="txtQty" class="form-control" placeholder="Quantity" value="<?php echo $qty ?>" style="width: 500px;height: 40px;border-radius: 10px"/>
				</div>
			</div>

			<div class="form-group">
				<label for="sphinhanh" class="col-sm-4 control-label">Image(*): </label>
				<div class="col-sm-8">
					<img src='./product-imgs/<?php echo $pic; ?>' border='0' width="50" height="50" />
					<input type="file" name="txtImage" id="txtImage" class="form-control" value="" />
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<input class="btnaddCat" type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" style=" background: #F7E4E0;color: #C51162;"  />
					<input class="btnaddCat" type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=manageProduct'" style="background: #F7E4E0;color: #C51162	;"/>

				</div>
			</div>
		</form>
	</div>

<?php
} else {
	echo '<meta http-equiv="refresh" content="0;URL=?page=manageProduct"/>';
}
?>
<?php
include_once("connection.php");
if (isset($_POST["btnUpdate"])) {
	$id = $_POST["txtID"];
	$proname = $_POST["txtName"];
	$short = $_POST["txtShort"];
	// $detail = $_POST["txtDetail"];
	$price = $_POST["txtPrice"];
	$qty = $_POST["txtQty"];
	$pic = $_FILES["txtImage"];
	$category = $_POST["CategoryList"];
	$err = "";

	if (trim($id) == "") {
		$err .= "<li>Enter product ID, please</li>";
	}
	if (trim($proname) == "") {
		$err .= "<li>Enter product name, please</li>";
	}
	if ($category == "0") {
		$err .= "<li>Choose product category, olease</li>";
	}
	if (!is_numeric($price) ||$price < 0) {
		$err .= "<li>Product price must be number</li>";
	}
	if (!is_numeric($qty) || $qty < 0 ) {
		$err .= "<li>Product price must be number</li>";
	}
	if ($err != "") {
		echo "<ul>$err</ul>";
	} else {
		if ($pic['name'] != "") {
			if (
				$pic['type'] == "image/jpg" || $pic['type'] == "image/jpeg" || $pic['type'] == "image/png"
				|| $pic['type'] == "image/gif"
			) {
				if ($pic['size'] <= 614400) {
					$sq = "Select * from product where Pro_ID != '$id' and Pro_Name='$proname'";
					$result = mysqli_query($conn, $sq);
					if (mysqli_num_rows($result) == 0) {
						copy($pic['tmp_name'], "product-imgs/" . $pic['name']);
						$filePic = $pic['name'];

						$sqlstring = "UPDATE product set Pro_Name = '$proname', Pro_Price=$price, SmallDesc='$short', Pro_qty=$qty,
						Pro_image='$filePic',Cat_ID='$category',
						ProDate='" . date('Y-m-d H:i:s') . "' WHERE Pro_ID='$id'";
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
		} else {
			$sq = "Select *from product where Pro_ID != '$id' and Pro_Name='$proname'";
			$result = mysqli_query($conn, $sq);
			if (mysqli_num_rows($result) == 0) {
				$sqlstring = "UPDATE product set Pro_Name = '$proname',
				Pro_Price=$price, SmallDesc='$short' ,
				Pro_qty=$qty, Cat_ID='$category',
				ProDate='" . date('Y-m-d H:i:s') . "' WHERE Pro_ID='$id'";

				mysqli_query($conn, $sqlstring);
				echo '<meta http-equiv="refresh" content="0;URL=?page=manageProduct"/>';
			} else {
				echo "<li>Duplicate product Name</li>";
			}
		}
	}
}
?>