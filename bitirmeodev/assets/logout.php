<?php 
    session_start();
    if (isset($_SESSION['email'])) {
        $_SESSION['isLoggedIn'] = true;
    } else {
        $_SESSION['isLoggedIn'] = false;
    }   
    if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
        header('Location: ../index.php');
        exit;
    }
    session_destroy();
    header('Location: ../index.php');
    exit;
 
?>