<!DOCTYPE html>
<?php include 'hmsession.php' ?>
<html>

<head>
    <link rel="stylesheet" href="<?php echo $_SESSION['cssfile']; ?>">
    <title>Hotelman</title>
</head>

<body style="background-image:url('../hotelman/backgroundimageindex.jpg');
                 background-size:cover;">
    <?php include 'menu.php' ?>

    <div class="main">
        <div class="main-content" style="text-align:center;
                                              color:white;
                                              position: fixed;
                                              top: 40%;
                                              left: 40%;">
            <p style="font-size:300%;
                            font-family: times new roman, sans-serif;">Üdvözöljük a Hotelman szállodában!</p>
            <p>A bal oldali menüből választhat a lehetőségek közül! </p>
        </div>
    </div>
</body>

</html>