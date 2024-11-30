     <!-- Bootstrap -->
     <link rel="stylesheet" type="text/css" href="style.css" />
	 <link rel="stylesheet" type="text/css" href="css/addCategory.css">
     <meta charset="utf-8" />
     <link rel="stylesheet" href="css/bootstrap.min.css">
	 

	 


     <?php
		include_once("connection.php");
		if (isset($_POST["btnAdd"])) {
			$id = $_POST["txtID"];
			$name = $_POST["txtName"];
			$des = $_POST["txtDes"];
			$err = "";
			if ($id == "") {
				$err .= "<li>Enter category ID,please</li>";
			}
			if ($name == "") {
				$err .= "<li>Enter category Name,please</li>";
			}
			if ($err != "") {
				echo "<ul>$err</ul>";
			} else {
				$id = htmlspecialchars(mysqli_real_escape_string($conn,$id));
				$name = htmlspecialchars(mysqli_real_escape_string($conn,$name));
				$des = htmlspecialchars(mysqli_real_escape_string($conn,$des));

				$sq = "Select * from category where Cat_ID='$id' or Cat_Name='$name'";
				$result = mysqli_query($conn, $sq);
				if (mysqli_num_rows($result) == 0) {
					mysqli_query($conn, "INSERT INTO category (Cat_ID, Cat_Name, Cat_Des) VALUES ('$id', '$name', '$des')");
					echo '<meta http-equiv="refresh" content="0;URL=?page=category_management"/>';
				} else {
					echo "<li>Duplicate category ID or Name</li>";
				}
			}
		}
		?>


	<div class="container">
     	<div class="coverblock">
		 <a class="backhome" href="index.php">←Back to shop</a>
     		<h2 class="h2category">Adding Category</h2>
			
     		<form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
     			<div class="form-group">
     				<label for="txtTen" class="col-sm-4 control-label">Category ID(*): </label>
     				<div class="col-sm-8">
     					<input class="inputext" type="text" name="txtID" id="txtID" class="form-control" placeholder="Catepgy ID" value='<?php echo isset($_POST["txtID"]) ? ($_POST["txtID"]) : ""; ?>'>
     				</div>
     			</div>
     			<div class="form-group">
     				<label for="txtTen" class="col-sm-4 control-label">Category Name(*): </label>
     				<div class="col-sm-8">
     					<input class="inputext" type="text" name="txtName" id="txtName" class="form-control " placeholder="Catepgy Name" value='<?php echo isset($_POST["txtName"]) ? ($_POST["txtName"]) : ""; ?>'>
     				</div>
     			</div>

     			<div class="form-group">
     				<label for="txtMoTa" class="col-sm-4 control-label">Description(*): </label>
     				<div class="col-sm-8">
     					<input class="inputext" type="text" name="txtDes" id="txtDes" class="form-control" placeholder="Description" value='<?php echo isset($_POST["txtDes"]) ? ($_POST["txtDes"]) : ""; ?>'>
     				</div>
     			</div>

     			<div class="form-group">
     				<div class="col-sm-offset-4 col-sm-8">
     					<input class="btnaddCat"  type="submit"  class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new"  style=" background: #F7E4E0;color: #C51162;" />
     					<input class="btnaddCat"  type="button"  class=" btn btn-primary " name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=category_management'" style="background: #F7E4E0;color: #C51162	;"/>

     				</div>
     			</div>
     		</form>
     	</div>
     </div>