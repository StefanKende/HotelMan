<?php 
session_start();
if (!isset($_SESSION['authenticated'])) {
    header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/login.php');
} 
?>