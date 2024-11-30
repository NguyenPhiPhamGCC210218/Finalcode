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
			$result = mysqli_query($conn, "SELECT * FROM supplier WHERE Sup_ID ='$id'");
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$sup_id = $row['Sup_ID'];
			$sup_name = $row['Sup_Name'];
			$sup_des = $row['Sup_Des'];

		?>
     	<div class="container">
		 <div class="coverblock">
		 <a class="backhome" href="index1.php">←back to shop</a>

     		<h2 class="h2category">Updating Product Supplier</h2>

     		<form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
     			<div class="form-group">
     				<label for="txtTen" class="col-sm-4 control-label">Supplier ID(*): </label>
     				<div class="col-sm-8">
     					<input class="inputext" type="text" name="txtID" id="txtID" class="form-control" placeholder="Supplier ID" readonly value='<?php echo $sup_id; ?>'>
     				</div>
     			</div>
     			<div class="form-group">
     				<label for="txtTen" class="col-sm-4 control-label">Supplier Name(*): </label>
     				<div class="col-sm-8">
     					<input class="inputext" type="text" name="txtName" id="txtName" class="form-control" placeholder="Supplier Name" value='<?php echo $sup_name; ?>'>
     				</div>
     			</div>

     			<div class="form-group">
     				<label for="txtMoTa" class="col-sm-4 control-label">Description(*): </label>
     				<div class="col-sm-8">
     					<input class="inputext" type="text" name="txtDes" id="txtDes" class="form-control" placeholder="Description" value='<?php echo $sup_des; ?>'>
     				</div>
     			</div>

     			<div class="form-group">
     				<div class="col-sm-offset-2 col-sm-10">
     					<input class="btnupdateCat" type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" style="background: #F7E4E0;color: #C51162;" />
     					<input class="btnupdateCat" type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnoer" value="Ignore" onclick="window.location='?page=supplier_management'"  style="background: #F7E4E0;color: #C51162; margin-left: 50px;"/>

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
					$err .= "<li>Enter Supplier Name,PLease</li>";
				}
				if ($err != "") {
					echo "<ul>$err</ul>";
				} else {
					$sq = "Select * from supplier where Sup_ID != '$id' and Sup_Name='$name'";
					$result = mysqli_query($conn, $sq);
					if (mysqli_num_rows($result) == 0) {
						mysqli_query($conn, "UPDATE supplier SET Sup_Name = '$name', Sup_Des='$des' WHERE Sup_ID ='$id'");
						echo '<meta http-equiv="refresh" content="0;URL=?page=supplier_management"/>';
					} else {
						echo "<li>Duplicate Suplier Name</li>";
					}
				}
			}
			?>


     <?php
		} else {
			echo '<meta http-equiv="refresh" content="0;URL=Supplier_Management.php"/>';
		}
		?>  