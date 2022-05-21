<?php 
include 'settings.php';
include 'hmsession.php';
if ($_SESSION['cssfile'] == "hotelman.css") {
    $_SESSION['cssfile'] = "hotelmandark.css";
} else {
    $_SESSION['cssfile'] = "hotelman.css";
}
$query = "update user 
         set preference ='". $_SESSION['cssfile'] ."' where id =". $_SESSION['userid'];
$result = mysqli_query($link,$query); 
header('Location: http://' . $_SERVER['SERVER_NAME'] . $_SESSION['switchurl']);
 ?>