<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="hotelman.css"> 
        <title>Bejelentkezés</title>
    </head>
    <body>
    <div class="main_content">

        <h1 text-align:center>Bejelentkezés</h1>

        <form action="login.php" method="post">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>
</form>
    </div>
    </body>