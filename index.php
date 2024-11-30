<!DOCTYPE html>
<html lang="en">

<head>
  <title>PPshop</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <!-- <link rel="stylesheet" href="css/cart.css"> -->
  <!-- <link rel="stylesheet" href="css/search.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="js/shop.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/css/chat_box.css">
</head>
<style>
  body {
    background: #fff;
  }

  .logo {
    display: inline-block;
    /* Make it an inline block for padding and margin */
    font-size: 26px;
    /* Size of the text */
    font-weight: bold;
    /* Make the text bold */
    color: #fff;
    /* Text color */
    background-color: #000000;
    /* Background color for the logo */
    padding: 10px 20px;
    /* Padding around the text */
    border-radius: 25px;
    /* Rounded corners */
    text-decoration: none;
    /* Remove underline from the link */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    /* Shadow for a 3D effect */
    transition: background-color 0.3s, transform 0.3s;
    /* Smooth transition effects */
  }

  .logo:hover {
    background-color: #A50040;
    /* Darker shade on hover */
    transform: scale(1.05);
    /* Slightly grow the logo on hover */
  }

  @media (max-width: 768px) {
    .logo {
      font-size: 24px;
      /* Slightly smaller font for smaller screens */
      padding: 8px 16px;
      /* Adjust padding */
    }
  }
</style>

<body>
  <?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  include_once("connection.php");

  ?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light py-4 ">
    <div class="container-fluid mx-md-5 row">
      <div class="col-2">
        <!-- <a href="index1.php"><img src="Image/lg.png" class="logo" alt="Logo">PP shop
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </a> -->
        <a href="index.php" class="logo">PP shop

        </a>
      </div>

      <div class="collapse navbar-collapse col-auto justify-content-center" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=terms">Terms&Service</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="?page=chat">chat</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="?page=about">About Us</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="?page=history">History</a>
            </li>
          <!-- <li class="nav-item">
              <a class="nav-link" href="?page=search&&gender=Women">Women</a>
            </li> -->
          <!-- <li class="nav-item">
              <a class="nav-link" href="?page=management">Management</a>
            </li> -->

          <?php
          if (isset($_SESSION['us']) && $_SESSION['us'] != "") {
          ?>
            <li class="nav-item">
              <a href="?page=cart" class="nav-link bi bi-bag">Cart
                <!-- <span class="cart-count">
                <?php
                // $total_order = 0;

                // // Prepare and execute the SQL query
                // $query = "SELECT SUM(total_quantity) AS total_quantity FROM total_quantity";
                // $result = mysqli_query($conn, $query); // Make sure $conn is your connection variable

                // if ($result) {
                //   $row = mysqli_fetch_assoc($result);
                //   $total_order = $row['total_quantity']; // This could be null
                // }

                // // Check if $total_order is null or not a number, set to 0 if so
                // if (is_null($total_order) || !is_numeric($total_order)) {
                //   $total_order = 0;
                // }

                // // Format total_order to ensure it's two digits
                // echo $total_order;
                ?>
              </span> -->
              </a>

            </li>

            <li class="nav-item">
              <a class="nav-link" href="?page=update_customer" id="btnUser"><i class="glyphicon glyphicon-user" style="margin-left:50px"></i> Welcome, <?php echo $_SESSION['us'] ?></a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="?page=logout" id="btnlogout" class="glyphicon glyphicon-log-out">Logout <i class="bi bi-box-arrow-right"></i></a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="?page=logout" id="btnlogout" class="glyphicon glyphicon-log-out" onclick="return confirmLogout();">Logout
                <i class="bi bi-box-arrow-right"></i>
              </a>
            </li>
          <?php
          } else {
          ?>

            <li class="nav-item">
              <a class="nav-link" href="?page=login" id="btnLogin">Login&nbsp;<i class="bi bi-box-arrow-in-right"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?page=loginadmin" id="btnLogin">Login With Admin&nbsp;<i class="bi bi-box-arrow-in-right"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?page=register" id="btnRegister" style="margin-left:25px">Register&nbsp;<i class="bi bi-person-plus"></i></a>
            </li>
          <?php
          }
          ?>
        </ul>
      </div>
  </nav>


  <script>
function confirmLogout() {
  if(confirm("Are you sure you want to log out?")){
      $.removeCookie('user_token', { path: '/' });
      $.removeCookie('user_id', { path: '/' });
      location.href = 'index.php'
      return true
  }
  return false
}
</script>




  <?php

  if(!isset($_GET['page'])  || isset($_GET['page']) && $_GET['page'] != "login" && 
  $_GET['page'] != "loginadmin" &&  $_GET['page'] != "forgot"){
    include_once('./chat/client/chat_box.php');
  }

  if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == "search") {
      include_once("Search.php");
    }
    if ($page == "login") {
      include_once("login.php");
    }
    if ($page == "logout") {
      include_once("logout.php");
    }
    if ($page == "loginadmin") {
      include_once("./Management/LoginAdmin.php");
    }
    if ($page == "register") {
      include_once("register.php");
    }


    
    // if ($page == "chat") {
    // 	include_once("chat.php");
    // } 
    // if ($page == "send") {
    // 	include_once("sendMessage.php");
    // } 
 



    if ($page == "detail") {
      include_once("detail.php");
    }
    if ($page == "cart") {
      include_once("Cart.php");
    }
    if ($page == "addcart") {
      include_once("addcart.php");
    }
    if ($page == "update_customer") {
      include_once("Update_customer.php");
    }
    if ($page == "removecart") {
      include_once("remove_from_cart.php");
    }
    if ($page == "updatecart") {
      include_once("update_cart.php");
    }
    if ($page == "payment") {
      include_once("payment.php");
    }
    if ($page == "process") {
      include_once("process_payment.php");
    }

    if ($page == "confirm") {
      include_once("confirmation.php");
    }
    if ($page == "forgot") {
      include_once("forgot_password.php");
    }
    if ($page == "about") {
      include_once("about.php");
    }
    if ($page == "terms") {
      include_once("terms.php");
    }

    if ($page == "history") {
      include_once("history.php");
    }
  } else {
    include("Content1.php");
  }
  ?>

  <!-- <footer>
		<div class="other-footer-infos-container">
			<span class="footer-info"><i class="bx bx-map"></i> Address, CAN THO</span>
			<span class="footer-info"><i class="bx bx-phone"></i> 22 (923) 3424 4156</span>
			<span class="footer-info"><i class="bx bx-mail-send"></i> admin@gmail.com</span>
			<div class="footer-social-links">
				<ul>
					<li><i class='bx bxl-instagram-alt nav-icon clr-transition'></i></li>
					<li><i class='bx bxl-twitter nav-icon clr-transition'></i></li>
					<li><i class='bx bxl-facebook-square nav-icon clr-transition'></i></li>
				</ul>
			</div>
		</div>
		<div class="lower-footer">
			<span class="lower-footer-elt copy">copyright © 2024</span>
			<span class="lower-footer-elt developer">Developed by <a href="#" class="developerportfoliolink" title="developer portfolio link">P</a></span>
			<span class="lower-footer-elt policy"><a href="#" class="policy-link">Privacy • Policy</a></span>
		</div>
	</footer> -->

  <!-- Footer -->
  <footer class="text-center text-lg-start bg-body-tertiary text-muted">
    <!-- Section: Social media -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
      <!-- Left -->

      <!-- Left -->

      <!-- Right -->
      <div>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-google"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-github"></i>
        </a>
      </div>
      <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            <h6 class="text-uppercase fw-bold mb-4">
              <i class="fas fa-gem me-3"></i>PP shop
            </h6>
            <p>
            Our e-commerce website provides a convenient and secure online shopping platform, 
            specializing in providing a wide range of high-quality fashion products.
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Products
            </h6>
            <p>
              <a href="#!" class="text-reset">Hoodie</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Jacket</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Coat</a>
            </p>
            <p>
              <a href="#!" class="text-reset">T-shirt</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Useful links
            </h6>
            <p>
              <a href="#!" class="text-reset">Facebook</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Zalo</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Instagram</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Help</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
            <p><i class="fas fa-home me-3"></i>An Khanh, Ninh Kieu, Can Tho</p>
            <p>
              <i class="fas fa-envelope me-3"></i>
              ShopPP@gmail.com
            </p>
            <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
            <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
      © 2021 Copyright
      <a class="text-reset fw-bold" href="https://mdbootstrap.com/"></a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->

</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/js/login_api.js"></script>
<script src="/js/login_admin.js"></script>
<script src="/js/socket.io.min.js"></script>
  <script src="/js/chat_controller.js"></script>
</html>