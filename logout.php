<?php
    include("path.php");

    unset($_SESSION['id']);
    unset($_SESSION['role']);
    unset($_SESSION['name']);
    unset($_SESSION['image']);
    unset($_SESSION['message']);

    session_destroy();
    header('Location: ' . BASE_URL . '/index.php');
?>
