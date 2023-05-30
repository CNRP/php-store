<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["user"])) {
        header("Location: /auth/login.php");
        // echo '<script>window.location.href = "/auth/login.php";</script>';

        exit();
    }
?>