<?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        echo '<meta http-equiv="refresh" content="0; URL=../index.php"/>';
    ?>