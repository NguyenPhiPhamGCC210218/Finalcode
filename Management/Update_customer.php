
<?php
//Get custmer information
	$query = "SELECT Emp_Name, Address, Email, Phone FROM employer WHERE UserName ='" . $_SESSION["us"]."'";
	$result = mysqli_query($conn,$query) or die (mysqli_error($conn));
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	$us = $_SESSION["us"];
	$email = $row["Email"];
	$fullname = $row["Emp_Name"];
	$address = $row["Address"];
	$telephone = $row["Phone"];

//Update information when the user presses the "Update" button
	
	if(isset($_POST['btnUpdate'])){
		$fullname = $_POST['txtFullname'];
		$address =$_POST['txtAddress'];
		$tel =$_POST['txtTel'];

		$test = check();
		if($test==""){
			//Customer changes Password
			if($_POST['txtPass1']!=""){
				$pass = md5($_POST['txtPass1']);

				$sq ="UPDATE employer SET Emp_Name='$fullname',Address='$address', Phone='$tel',Password='$pass' WHERE Username ='" . $_SESSION['us'] ."'";

				mysqli_query($conn,$sq) or die(mysqli_error($conn));
			}
		else{
			$sq ="UPDATE employer SET Emp_Name='$fullname',Address='$address',Phone='$tel' WHERE Username ='" . $_SESSION['us'] ."'";
			mysqli_query($conn, $sq) or die(mysqli_error($conn));
		}
		echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
		}
		else {
			echo $test;
		}
	}

//Write check() function to check information
	function check(){
		if($_POST['txtFullname']==""|| $_POST['txtAddress']==""){
			return "<li>Enter Fullname or address</li>";
		}
		elseif(strlen($_POST['txtPass1'])>0 && strlen($_POST['txtPass1'])<=5){
			return "<li>Password is greater than 5 characters</li>";
			
		}
		elseif($_POST['txtPass1']!=$_POST['txtPass2']){
			return "<li>Password and Confirm Pass do not match</li>";
		}
		else{
			return "";
		}

	}
?>
<link rel="stylesheet" type="text/css" href="css/updateCustomer.css">

<a class="backhome" href="index.php">←Back to shop</a>

<div class="container">
<div class="coverblock">

	
<h2 class="h2UpdatCust">Update Profile</h2>

			 	<form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
					<div class="form-group">
						    
                            <label for="lblTenDangNhap" class="col-sm-4 control-label">Username(*):  </label>
							<div class="col-sm-8">
							      <label  class="form-control inputCust" style="font-weight:400"><?php echo $us; ?></label>
							</div>
                     </div>
                           
                         <div class="form-group">   
                            <label for="lblEmail" class="col-sm-4 control-label">Email(*):  </label>
							<div class="col-sm-8">
							       <label class="form-control inputCust" style="font-weight:400"><?php  echo $email; ?></label>
							</div>
                          </div>  
                          
                           <div class="form-group"> 
                            <label for="lblMatKhau1" class="col-sm-4 control-label">Password(*):  </label>
							<div class="col-sm-8">
							      <input type="password" name="txtPass1" id="txtPass1" class="form-control inputCust"/>
							</div>
                            </div>
                            
                             <div class="form-group"> 
                            <label for="lblMatKhau2" class="col-sm-4 control-label">Confirm Password(*):  </label>
							<div class="col-sm-8">
							      <input type="password" name="txtPass2" id="txtPass2" class="form-control inputCust"/>
							</div>
                            </div>
                            
                            <div class="form-group">                         
                            	<label for="lblHoten" class="col-sm-4 control-label">Full name(*):  </label>
								<div class="col-sm-8">
							      <input type="text" name="txtFullname" id="txtFullname" value="<?php echo $fullname; ?>" 
								  class="form-control inputCust" placeholder="Enter Fullname, please"/>
								</div>
                            </div>
                           
                             <div class="form-group"> 
                             <label for="lblDiaChi" class="col-sm-4 control-label">Address(*):  </label>
							<div class="col-sm-8">
							      <input type="text" name="txtAddress" id="txtAddress" value="<?php echo $address;  ?>" class="form-control inputCust" placeholder="Enter Address, please"/>
							</div>
                            </div>
                            
                            <div class="form-group"> 
                            <label for="lblDienThoai" class="col-sm-4 control-label">Telephone(*):  </label>
							<div class="col-sm-8">
							      <input type="text" name="txtTel" id="txtTel" value="<?php echo $telephone; ?>" class="form-control inputCust" placeholder="Enter Telephone, please" />
							</div>
                            </div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
						      <input type="submit"  class="btn btn-primary btnupdatCus" name="btnUpdate" id="btnUpdate" value="Update" style=" background: #F7E4E0;color: #C51162;border-radius: 10px;" />
							  <input type="submit" name="btnCancel" class="btn btn-primary btnupdatCus" id="btnCancel" value="Cancel"style="background: #F7E4E0;color: #C51162	;border-radius: 10px;" />

						</div>
					</div>
				</form>
		</div>
</div>






