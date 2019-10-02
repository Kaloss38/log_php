<?php 
    session_start();
    session_unset();
    session_destroy();
    setcookie('auth', '', time()-1, '/', null, false, true); //Detroy cookie

    header('location: index.php');
    exit();
?>