<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: login.php");
    exit;
}
if(isset($_SESSION['user'])) {
   header("Location: home.php");
}
if(isset($_SESSION[ 'adm'])) {
   header("Location: dashboard.php");
}

if(isset($_GET['logout'])) {
unset($_SESSION['user']);
unset($_SESSION['adm']);
session_unset();
session_destroy();
header("Location: login.php");
exit;
}