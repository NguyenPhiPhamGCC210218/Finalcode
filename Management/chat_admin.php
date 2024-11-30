<?php
    include_once("connection.php");
    $customer = "SELECT * FROM customer";
    $result = mysqli_query($conn, $customer);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- <link href="assets/img/favicon.png" rel="icon"> -->
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <title>Chat</title>
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link href="/management/assets/css/chat/bootstrap.min.css" rel="stylesheet">
    <link href="/management/assets/css/chat/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/management/assets/css/chat/chat.css">

</head>
<body>
<div class="container-fluid position-relative d-flex p-0">
    <div class="sidebar pe-4 pb-3  shadow p-3 mb-5 bg-body-tertiary" style="z-index: 99998; background-color:white">
        <nav class="navbar navbar-dark">
            <a href="#" class="navbar-brand mx-4 mb-3">
                <h3 style="color: #012970">
                <i class="bi bi-chat-dots me-2"></i>Chat
                </h3>

            </a>
            <div class="navbar-nav w-100">
                <?php
                   while($_row = mysqli_fetch_assoc($result)){
                    include('item_user.php');
                   }
                ?>
            </div>
        </nav>
    </div>
    <div class="content" style="background-color:#f5f5f5">
        <!-- Navbar Start -->
        <nav style="background-color:white;padding-left: 1rem!important; padding-right: 1rem!important; padding-bottom:1rem!important;z-index: 99999;padding-top: 3rem;"
             class="shadow navbar navbar-expand navbar-dark sticky-top px-4 py-0">
        
            <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="fa fa-bars" style="    color: white;"></i>
            </a>
            <div class="navbar-nav align-items-center ms-auto">

            </div>

            <div class="navbar-nav align-items-center ms-auto">
                <a href="/management/index.php">
                <button type="button" class="btn btn-primary" style="min-width: 7rem;background-color:black;border-color:black;    margin-top: 1rem;">
                          
                          Back to Dashboard
                      </button>
                </a>

            </div>
        </nav>
        <!-- Navbar End -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="shadow rounded p-4 mt-3 visually-hidden" id="chat_container">
                    <div class="selected-user users " style="background: white">
                        <div class="" data-user-id="person5">
                            <div class="user" style="padding: 1rem;    text-align: center;">
                                <span class="name" id="name_current_user" style="font-size: 1.5rem;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="chat-container" style="background: white">
                        <ul class="chat-box">
                        </ul>
                    </div>
                    <form id="content_form" style="padding: 1rem;background-color:white">
                        <div class="d-flex justify-content-between  form-group mt-3 mb-0">
                            <input type="text" class="form-control me-3" id="content_message">
                            <button type="submit" class="btn btn-primary" style="min-width: 7rem;background-color:black;border-color:black">
                                <i class="fa-solid fa-paper-plane me-2"></i>
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"
        integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/socket.io.min.js"></script>
<script src="/management/assets/js/chat_admin_controller.js"></script>
<script>
    //logout
    $('#btn_logout').click(function () {
        $.removeCookie('user_token', {path: '/'});
        location.href = '/security/sign-in'
    })

    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });
</script>
</html>



