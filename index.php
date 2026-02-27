<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: pages/dashboard.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}
?>