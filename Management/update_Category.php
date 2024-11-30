     <!-- Bootstrap -->
     <link rel="stylesheet" type="text/css" href="style.css" />
     <meta charset="utf-8" />
     <link rel="stylesheet" href="css/bootstrap.min.css">
	 <link rel="stylesheet" type="text/css" href="css/updateCategoryy.css">
    <!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="style.css" />
	 <link rel="stylesheet" type="text/css" href="css/addCategory.css">
     <meta charset="utf-8" />
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <?php
		include_once("connection.php");
		if (isset($_GET["id"])) {
			$id = $_GET["id"];
			$result = mysqli_query($conn, "SELECT * FROM category WHERE Cat_ID ='$id'");
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$cat_id = $row['Cat_ID'];
			$cat_name = $row['Cat_Name'];
			$cat_des = $row['Cat_Des'];

		?>
     	<div class="container">
		 <div class="coverblock">
		 <a class="backhome" href="index1.php">←back to shop</a>

     		<h2 class="h2category">Updating Product Category</h2>

     		<form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
     			<div class="form-group">
     				<label for="txtTen" class="col-sm-4 control-label">Category ID(*): </label>
     				<div class="col-sm-8">
     					<input class="inputext" type="text" name="txtID" id="txtID" class="form-control" placeholder="Catepgy ID" readonly value='<?php echo $cat_id; ?>'>
     				</div>
     			</div>
     			<div class="form-group">
     				<label for="txtTen" class="col-sm-4 control-label">Category Name(*): </label>
     				<div class="col-sm-8">
     					<input class="inputext" type="text" name="txtName" id="txtName" class="form-control" placeholder="Catepgy Name" value='<?php echo $cat_name; ?>'>
     				</div>
     			</div>

     			<div class="form-group">
     				<label for="txtMoTa" class="col-sm-4 control-label">Description(*): </label>
     				<div class="col-sm-8">
     					<input class="inputext" type="text" name="txtDes" id="txtDes" class="form-control" placeholder="Description" value='<?php echo $cat_des; ?>'>
     				</div>
     			</div>

     			<div class="form-group">
     				<div class="col-sm-offset-2 col-sm-10">
     					<input class="btnupdateCat" type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" style="background: #F7E4E0;color: #C51162;" />
     					<input class="btnupdateCat" type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnoer" value="Ignore" onclick="window.location='?page=category_management'"  style="background: #F7E4E0;color: #C51162; margin-left: 50px;"/>

     				</div>
     			</div>
     		</form>
			</div>
     	</div>
     	<?php
			if (isset($_POST["btnUpdate"])) {
				$id = $_POST["txtID"];
				$name = $_POST["txtName"];
				$des = $_POST["txtDes"];
				$err = "";
				if ($name == "") {
					$err .= "<li>Enter Category Name,PLease</li>";
				}
				if ($err != "") {
					echo "<ul>$err</ul>";
				} else {
					$sq = "Select * from category where Cat_ID != '$id' and Cat_Name='$name'";
					$result = mysqli_query($conn, $sq);
					if (mysqli_num_rows($result) == 0) {
						mysqli_query($conn, "UPDATE category SET Cat_Name = '$name', Cat_Des='$des' WHERE Cat_ID ='$id'");
						echo '<meta http-equiv="refresh" content="0;URL=?page=category_management"/>';
					} else {
						echo "<li>Duplicate categogy Name</li>";
					}
				}
			}
			?>


     <?php
		} else {
			echo '<meta http-equiv="refresh" content="0;URL=Category_Management.php"/>';
		}
		?>  