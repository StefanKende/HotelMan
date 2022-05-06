<?php
    $host = "localhost";
    $user = "hotelman";
    $password = "h0telm4n";
    $database = "hotelman";

    $link = mysqli_connect($host,$user,$password,$database)
    or die("Kapcsolódási hiba: " . mysqli_error() );
?>