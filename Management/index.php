<?php
session_start();
include_once "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PP ShoP</title>


  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon"> -->
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<style>
  a.logout-link {
    color: #333;
    /* Màu chữ chính */
    text-decoration: none;
    /* Loại bỏ gạch chân */
    margin-left: 211px;
    /* Khoảng cách từ trái như yêu cầu */
    position: relative;
    /* Giữ nguyên vị trí */
    font-size: 30px;
    /* Kích thước chữ */
    font-family: 'Poppins', sans-serif;
    /* Đổi font chữ hiện đại */
    font-weight: bold;
    /* Tô đậm chữ */
    transition: all 0.3s ease;
    /* Hiệu ứng chuyển mượt */
    border-radius: 8px;
    /* Bo góc */
    padding: 10px 20px;
    /* Khoảng cách bên trong giúp dễ bấm */
    background-color: #fff;
    /* Nền sáng nhẹ */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* Đổ bóng nhẹ */
  }

  a.logout-link:hover {
    color: #fff;
    /* Màu chữ khi hover */
    /* background-color: #ff6347; Đổi màu nền khi hover */
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    /* Đổ bóng mạnh hơn khi hover */
    transform: translateY(-3px);
    /* Hiệu ứng nổi lên */
    font-size: 32px;
    /* Kích thước chữ */

  }

  a.logout-link i {
    margin-right: 8px;
    /* Khoảng cách giữa biểu tượng và văn bản */
    font-size: 24px;
    /* Kích thước biểu tượng */
    vertical-align: middle;
    /* Đảm bảo biểu tượng căn giữa với văn bản */
  }
</style>
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
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">PP ShoP</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" style="
    position: absolute;
    margin-left: -30px;">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->


          <div class="header-nav ms-auto" style="margin-right: 300px;">
            <div class="shop-menu pull-right">
              <ul class="nav navbar-nav">
                <?php
                if (isset($_SESSION['us']) && $_SESSION['us'] != "") {
                ?>
                  <li class="nav-item"><a href="?page=update_customer" class="nav-link clr-transition" style="font-size: 20px;position: absolute;font-style: oblique;">
                      <i class="fa fa-lock"></i>Welcome, <?php echo $_SESSION['us']; ?></a></li>
                  <!-- <li><a href="?page=logout"  class="logout-link" style="color: #ff0000;text-decoration: none;margin-left: 211px;position: relative;font-size: 30px;font-family: 'boxicons';">
										<i class="bx bx-log-out"></i>Logout</a></li> -->
                  <li>
                    <a href="?page=logout" class="logout-link" style="color: #ff0000; text-decoration: none; margin-left: 211px; position: relative; font-size: 30px; font-family: 'boxicons';" onclick="return confirmLogout();">
                      <i class="bx bx-log-out"></i> Logout
                    </a>
                  </li>
                <?php
                } else {
                ?>
                  <form class="form-inline mr-auto" target="_self">
                  </form><span class="navbar-text"> <a href="?page=login" class="login">Log In</a>
                    <a href="?page=loginadmin" class="login">Log In Admin</a></span>
                  <a class="btn btn-light action-button" role="button" href="?page=register">Register</a>
                <?php
                }
                ?>
              </ul>
            </div>
          </div>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>


          </ul><!-- End Notification Dropdown Items -->

          <!-- </li>End Notification Nav -->





      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <!-- <li class="nav-item">
        <a class="nav-link " href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="?page=category_management">
              <i class="bi bi-circle"></i><span>Category</span>
            </a>
          </li>
          <li>
            <a href="?page=supplier_management">
              <i class="bi bi-circle"></i><span>Supplier</span>
            </a>
          </li>
          <!-- <li>
            <a href="?page=category_management">
              <i class="bi bi-circle"></i><span>Category</span>
            </a>
          </li> -->
          <li>
            <a href="?page=manageProduct">
              <i class="bi bi-circle"></i><span>Product</span>
            </a>
          </li>

        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Manage</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="?page=account_management">
              <i class="bi bi-circle"></i><span>Management Account</span>
            </a>
          </li>
          <!-- <li>
            <a href="forms-layouts.html">
              <i class="bi bi-circle"></i><span>Form Layouts</span>
            </a>
          </li>
          <li>
            <a href="forms-editors.html">
              <i class="bi bi-circle"></i><span>Form Editors</span>
            </a>
          </li>
          <li>
            <a href="forms-validation.html">
              <i class="bi bi-circle"></i><span>Form Validation</span>
            </a>
          </li> -->
        </ul>
      </li><!-- End Forms Nav -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="?page=chat">
            <i class="bi bi-chat-dots"></i><span>chat</span>
            </a>
          </li>
          <li>
            <a href="tables-data.html">
              <i class="bi bi-circle"></i><span>Data Tables</span>
            </a>
          </li>
        </ul> -->
      </li>
      <!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../chart/ProbyC.php">
              <i class="bi bi-circle"></i><span>Product Count by Category</span>
            </a>
          </li>
          <li>
            <a href="../chart/ProQty.php">
              <i class="bi bi-circle"></i><span>Product Quantities</span>
            </a>
          </li>
          <li>
            <a href="../chart/approve.php">
              <i class="bi bi-circle"></i><span>Quantity of Products ordered</span>
            </a>
          </li>

          <!-- <li>
            <a href="../chart/report.php">
              <i class="bi bi-circle"></i><span>report</span>
            </a>
          </li> -->
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="icons-bootstrap.html">
              <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
            </a>
          </li>
          <li>
            <a href="icons-remix.html">
              <i class="bi bi-circle"></i><span>Remix Icons</span>
            </a>
          </li>
          <li>
            <a href="icons-boxicons.html">
              <i class="bi bi-circle"></i><span>Boxicons</span>
            </a>
          </li>
        </ul>
      </li><!-- End Icons Nav -->

      <?php
        if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }
      if($_SESSION["role"] == "customer_care"){
        ?>
         <li class="nav-item">
        <a class="nav-link collapsed" href="chat_admin.php">
        <i class="bi bi-chat-dots"></i><span>Chat</span>
        </a>
      </li>
        <?php
      }
    ?>
      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="?page=update_customer">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li><!-- End Error 404 Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
          <i class="bi bi-file-earmark"></i>
          <span>Blank</span>
        </a>
      </li><!-- End Blank Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <!-- <h1>Dashboard</h1> -->
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <?php
    if (isset($_GET['page'])) {
      $page = $_GET['page'];

      if ($page == "logout") {
        include_once("logout.php");
      }
      if ($page == "category_management") {
        include_once("Category_Management.php");
      }
      if ($page == "supplier_management") {
        include_once("Supplier_Management.php");
      }
      if ($page == "add_category") {
        include_once("add_Category.php");
      }
      if ($page == "add_supplier") {
        include_once("add_Supplier.php");
      }
      if ($page == "update_category") {
        include_once("update_Category.php");
      }
      if ($page == "update_supplier") {
        include_once("update_Supplier.php");
      }
      if ($page == "receivenote") {
        include_once("receivenote.php");
      }
      if ($page == "addreceivenote") {
        include_once("add_receivenote.php");
      }
      if ($page == "detailreceivenote") {
        include_once("detailreceivenote.php");
      }
      if ($page == "add_detailreceivenote") {
        include_once("add_detailreceivenote.php");
      }
      if ($page == "manageProduct") {
        include_once("Product_Management.php");
      }
      if ($page == "add_Product") {
        include_once("add_Product.php");
      }
      if ($page == "update_Product") {
        include_once("update_Product.php");
      }
      if ($page == "update_customer") {
        include_once("Update_customer.php");
      }
      if ($page == "account_management") {
        include_once("admin_account_management.php");
      }
      if ($page == "edit_account") {
        include_once("vedit_account.php");
      }
      if ($page == "chart") {
        include_once("../chart/index.php");
      }
      if ($page == "approvechart") {
        include_once("../chart/report.php");
      }
      if ($page == "chat") {
        include_once("../chat.php");
      }
    } else {
      include("ContentAd.php");
    }
    ?>





























    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
      <div class="copyright">
        &copy; Copyright <strong><span>@2024</span></strong>
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
      </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>