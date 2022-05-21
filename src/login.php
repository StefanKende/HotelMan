<!DOCTYPE html>

<?php include 'settings.php' ?>

<?php
session_start();
if (!isset($_SESSION['cssfile'])) $_SESSION['cssfile'] = 'hotelman.css';
$message = "";
$loginerror = false;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (!isset($_POST['uname']) || $_POST['uname'] == "") {
    $loginerror = true;
    $message = "Hibás felhasználónév vagy jelszó!";
  }

  if (!isset($_POST['pword']) || $_POST['pword'] == "") {
    $loginerror = true;
    $message = "Hibás felhasználónév vagy jelszó!";
  }

  $query = "select * from user where uname='" . $_POST['uname'] .
    "'AND pword='" . md5($_POST['pword']) . "'";
  $result = mysqli_query($link, $query) or die(mysqli_error($link));
  if (mysqli_num_rows($result)) {
    $_SESSION['authenticated'] = true;
    $row = mysqli_fetch_assoc($result);
    $userid = $row['ID'];
    $_SESSION['userid'] = $userid;
    $_SESSION['cssfile'] = $row['preference'];
    $query = "select role from userrole where userid=" . $userid;
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $row = mysqli_fetch_assoc($result) or die(mysqli_error($link));
    $_SESSION['role'] = $row['role'];
    header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/index.php');
  } else {
    $loginerror = true;
    $message = "Hibás felhasználónév vagy jelszó!";
  }
}
?>

<html>

<head>
  <link rel="stylesheet" href="<?php echo $_SESSION['cssfile']; ?>">
  <title>Bejelentkezés</title>
</head>

<body style="background-image:url('../hotelman/backgroundimage.jpg');
                 background-size:cover;">
  <div class="main-content">
    <div class="formcss">

      <div class=main-content style="position: fixed;
                                                  top: 15%;
                                                  left: 47%;
                                                  transform: translate(-50%, -50%);
                                                  font-size:170%">
        Hotelman
      </div>

      <form action="login.php" method="post" style="position: fixed;
                                                        top: 60%;
                                                        left: 50%;
                                                        transform: translate(-50%, -50%);">
        <input type="text" placeholder="Enter Username" name="uname" required> <br>
        <input type="password" placeholder="Enter Password" name="pword" required> <br>
        <button type="submit" style="color:black;
                                        background: linear-gradient(135deg,rgb(255, 238, 0), rgb(28, 155, 3));">Login</button>
      </form>
      <div class=main-content style="position: fixed;
                                                  top: 93%;
                                                  left: 50%;
                                                  transform: translate(-50%, -50%);">
        <?php echo $message; ?>
      </div>
    </div>
  </div>
</body>