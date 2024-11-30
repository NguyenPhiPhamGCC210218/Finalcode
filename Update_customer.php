<?php
// Start session

// Include database connection
include_once "connection.php";

// Get customer information
$query = "SELECT Full_Name, Address, Email, Telephone FROM customer WHERE Username ='" . $_SESSION["us"] . "'";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($result->num_rows > 0) {
	$us = $_SESSION["us"];
	$email = $row["Email"];
	$fullname = $row["Full_Name"];
	$address = $row["Address"];
	$telephone = $row["Telephone"];
} else {
	echo "No user found with the given username.";
}

// Update information when the user presses the "Update" button
if (isset($_POST['btnUpdate'])) {
	$fullname = $_POST['txtFullname'];
	$address = $_POST['txtAddress'];
	$tel = $_POST['txtTel'];

	$test = check();
	if ($test == "") {
		// Customer changes Password
		if ($_POST['txtPass1'] != "") {
			$pass = md5($_POST['txtPass1']);
			$sq = "UPDATE customer SET Full_Name='$fullname', Address='$address', Telephone='$tel', Password='$pass' WHERE Username ='" . $_SESSION['us'] . "'";
			mysqli_query($conn, $sq) or die(mysqli_error($conn));
		} else {
			$sq = "UPDATE customer SET Full_Name='$fullname', Address='$address', Telephone='$tel' WHERE Username ='" . $_SESSION['us'] . "'";
			mysqli_query($conn, $sq) or die(mysqli_error($conn));
		}
		echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
	} else {
		echo '<div class="alert alert-danger">' . $test . '</div>'; // Show error messages
	}
}

// Function to check information
function check()
{
	$errors = [];
	if (empty($_POST['txtFullname'])) {
		$errors[] = "Full name is required.";
	} elseif (preg_match('/[0-9]/', $_POST['txtFullname'])) {
		$errors[] = "Full name must not contain numbers.";
	}

	if (empty($_POST['txtAddress'])) {
		$errors[] = "Address is required.";
	}

	if (empty($_POST['txtTel'])) {
		$errors[] = "Telephone is required.";
	} elseif (!preg_match('/^0[0-9]+$/', $_POST['txtTel'])) {
		$errors[] = "Telephone must be numeric and start with 0.";
	}

	if (empty($_POST['txtPass1'])) {
		$errors[] = "Password is required.";
	}

	if (empty($_POST['txtPass2'])) {
		$errors[] = "Password confirmation is required.";
	}

	if (strlen($_POST['txtPass1']) > 0 && strlen($_POST['txtPass1']) <= 5) {
		$errors[] = "Password must be greater than 5 characters.";
	}

	if ($_POST['txtPass1'] != $_POST['txtPass2']) {
		$errors[] = "Password and Confirm Password do not match.";
	}

	return implode("<br>", $errors);
}
?>

<!-- HTML Structure -->

<div class="container">
	<div class="coverblock">
		<h2 class="h2UpdatCust">Update Profile</h2>

		<form id="form1" method="post" action="" class="form-horizontal" role="form">
			<div class="form-group">
				<label for="lblTenDangNhap" class="col-sm-4 control-label">Username(*):</label>
				<div class="col-sm-8">
					<label class="form-control inputCust" style="font-weight:400;font-size: 20px"><?php echo $us; ?></label>
				</div>
			</div>

			<div class="form-group">
				<label for="lblEmail" class="col-sm-4 control-label">Email(*):</label>
				<div class="col-sm-8">
					<label class="form-control inputCust" style="font-weight:400;font-size: 20px"><?php echo $email; ?></label>
				</div>
			</div>

			<div class="form-group">
				<label for="lblMatKhau1" class="col-sm-4 control-label">Password(*):</label>
				<div class="col-sm-8">
					<input type="password" name="txtPass1" id="txtPass1" class="form-control inputCust" />
				</div>
			</div>

			<div class="form-group">
				<label for="lblMatKhau2" class="col-sm-4 control-label">Confirm Password(*):</label>
				<div class="col-sm-8">
					<input type="password" name="txtPass2" id="txtPass2" class="form-control inputCust" />
				</div>
			</div>

			<div class="form-group">
				<label for="lblHoten" class="col-sm-4 control-label">Full name(*):</label>
				<div class="col-sm-8">
					<input type="text" name="txtFullname" id="txtFullname" value="<?php echo $fullname; ?>"
						class="form-control inputCust" placeholder="Enter Fullname, please" />
				</div>
			</div>

			<div class="form-group">
				<label for="lblDiaChi" class="col-sm-4 control-label">Address(*):</label>
				<div class="col-sm-8">
					<input type="text" name="txtAddress" id="txtAddress" value="<?php echo $address; ?>"
						class="form-control inputCust" placeholder="Enter Address, please" />
				</div>
			</div>

			<div class="form-group">
				<label for="lblDienThoai" class="col-sm-4 control-label">Telephone(*):</label>
				<div class="col-sm-8">
					<input type="text" name="txtTel" id="txtTel" value="<?php echo $telephone; ?>"
						class="form-control inputCust" placeholder="Enter Telephone, please" />
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8 btn-group"> <!-- Updated to include btn-group -->
					<input type="submit" class="btn btn-primary btnupdatCus" name="btnUpdate" id="btnUpdate" value="Update" />
					<a href="index.php" class="btn btn-secondary btnCancel">Cancel</a>
				</div>
			</div>

		</form>
	</div>
</div>

<style>
	/* General Styles */

	/* General Styles */
	body {
		font-family: 'Arial', sans-serif;
		background-color: #f5f5f5;
		color: #333;
		margin: 0;
	}

	.container {
		display: flex;
		justify-content: center;
		align-items: center;
		min-height: 100vh;
	}

	.coverblock {
		background-color: #fff;
		padding: 30px;
		border-radius: 15px;
		box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
		width: 90%;
		max-width: 600px;
		position: relative;
	}

	.h2UpdatCust {
		text-align: center;
		color: #C51162;
		margin-bottom: 30px;
		font-weight: bold;
	}

	.backhome {
		display: block;
		margin-bottom: 20px;
		color: #C51162;
		text-decoration: none;
		font-weight: bold;
		transition: color 0.3s;
	}

	.backhome:hover {
		color: #A50040;
		/* Darker shade on hover */
	}

	/* Form Styles */
	.form-horizontal .form-group {
		margin-bottom: 20px;
		display: flex;
		/* Use flexbox for alignment */
		justify-content: center;
		/* Center the items */
	}

	.control-label {
		font-weight: bold;
		color: #333;
		flex: 0 0 40%;
		/* Set fixed width for label */
		text-align: right;
		/* Align label to the right */
		margin-right: 10px;
		/* Add some space between label and input */
	}

	.inputCust {
		border-radius: 5px;
		border: 1px solid #ccc;
		padding: 10px;
		font-size: 14px;
		width: 100%;
		max-width: 300px;
		/* Set a max-width for inputs */
		transition: border-color 0.3s, box-shadow 0.3s;
	}

	.inputCust:focus {
		border-color: #C51162;
		box-shadow: 0 0 8px rgba(197, 17, 98, 0.2);
	}

	.btn-group {
		display: flex;
		/* Use flexbox to align buttons */
		justify-content: space-between;
		/* Space between buttons */
		margin-top: 20px;
		/* Add space above the button group */
	}

	.btnupdatCus {
		flex: 1;
		/* Allow button to grow */
		padding: 10px;
		font-size: 16px;
		font-weight: bold;
		border: none;
		border-radius: 5px;
		background: #C51162;
		color: #fff;
		cursor: pointer;
		transition: background-color 0.3s ease, transform 0.3s;
		margin-right: 10px;
		/* Add space between buttons */
	}

	.btnupdatCus:hover {
		background-color: #A50040;
		/* Darker shade on hover */
		transform: translateY(-2px);
	}

	.btnCancel {
		flex: 1;
		/* Allow button to grow */
		padding: 10px;
		font-size: 16px;
		font-weight: bold;
		border: none;
		border-radius: 5px;
		background: #f5f5f5;
		/* Original color */
		color: #C51162;
		/* Text color matching the update button */
		cursor: pointer;
		transition: background-color 0.3s ease, transform 0.3s;
	}

	.btnCancel:hover {
		background-color: #e0e0e0;
		/* Slightly darker shade on hover */
	}

	.alert {
		padding: 5px 10px;
		/* Adjust padding */
		margin-bottom: 20px;
		border: 1px solid #f44336;
		color: #ef1000;
		background-color: #fff;
		border-radius: 5px;
		text-align: center;
		/* Centered text for alerts */
		font-size: 14px;
		/* Adjust font size */
		max-width: 80%;
		/* Limit the width of alert */
		margin-left: auto;
		/* Center the alert */
		margin-right: auto;
		/* Center the alert */
		font-weight: bold;
	}

	/* Media Queries */
	@media (max-width: 768px) {
		.control-label {
			flex: 0 0 30%;
			/* Reduce width for smaller screens */
			text-align: left;
			/* Align labels to the left */
		}

		.inputCust {
			max-width: 100%;
			/* Allow inputs to take full width */
		}

		.btn-group {
			flex-direction: column;
			/* Stack buttons vertically on small screens */
		}

		.btnupdatCus,
		.btnCancel {
			margin-right: 0;
			/* Remove right margin */
			margin-bottom: 10px;
			/* Space between buttons when stacked */
			width: 100%;
			/* Full width for buttons */
		}

		.btnCancel {
			margin-bottom: 0;
			/* Remove bottom margin on last button */
		}
	}

	@media (max-width: 480px) {
		.h2UpdatCust {
			font-size: 24px;
			/* Adjust heading size for mobile */
		}

		.inputCust {
			font-size: 12px;
			/* Smaller font size for inputs */
		}

		.alert {
			font-size: 12px;
			/* Smaller font size for alerts */
		}
	}
</style>
<script>
	document.getElementById('form1').addEventListener('submit', function(e) {
		var fullname = document.getElementById('txtFullname').value;
		var telephone = document.getElementById('txtTel').value;

		if (/\d/.test(fullname)) {
			e.preventDefault();
			alert('Full name must not contain numbers.');
			return;
		}

		if (!/^0[0-9]+$/.test(telephone)) {
			e.preventDefault();
			alert('Telephone must be numeric and start with 0.');
			return;
		}
	});
</script>