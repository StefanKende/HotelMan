<!DOCTYPE html>
<?php include 'hmsession.php' ?>
<html>

<head>

    <link rel="stylesheet" href="<?php echo $_SESSION['cssfile']; ?>">
    <title>Vendégek</title>
</head>

<body style="background-image:url('../hotelman/backgroundimageguests.jpg');
                background-size:cover;">
    <?php include 'menu.php' ?>
    <?php include 'settings.php' ?>
    <div class="main">
        <?php $hasaccess = ($_SESSION['role'] == 'superuser') || ($_SESSION['role'] == 'receptionist') ?>
        <?php
        //===================================================================
        // Összes vendég listázása
        //=================================================================== 
        if (isset($_GET["action"]) && $_GET['action'] == 'list') { ?>
            <h1> Vendégek </h1>
            <div class="main-content">
                <?php if ($hasaccess) { ?>
                    <p>
                    <form action="guest.php" method="post">
                        <input type="hidden" name="action" value="new">
                        <button type="submit" value="submit">Új vendég felvétele</button>
                    </form>
                    </p>
                <?php } ?>

                <table>
                    <tr>
                        <th>id</th>
                        <th>Vendég neve </th>
                        <th>Vendég telefonszáma</th>
                        <th>Vendég e-mail címe</th>
                        <?php if ($hasaccess) echo "<th>Műveletek</th>"; ?>
                    </tr>

                    <?php
                    $query = "select * from guest";
                    $result = mysqli_query($link, $query) or die(mysqli_error($link));


                    for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] .
                            "</td><td>" . $row["phone_number"] . "</td><td>" . $row["email"] . "</td>";
                        if ($hasaccess) {
                            echo "<td><a href=\"guest.php?action=edit&id=" . $row["id"] . "\">Szerkesztés</a> 
                         <a href=\"guest.php?action=delete&id=" . $row["id"] . "\">Törlés </a></td>";
                        }
                        echo "</tr>";
                    }
                    ?>

                </table>
            </div>
        <?php }
        //===================================================================
        // új vendég felvétele
        //=================================================================== 
        else if (isset($_POST['action']) && $_POST['action'] == 'new') { ?>

            <h1>Új vendég felvétele</h1>
            <div class="main-content">
                <div class="formcss2">
                    <form action='guest.php' method='post'>
                        <label for="name">Vendég neve:</label><br>
                        <input type="text" name="name"> <br>
                        <label for="phone_number">Vendég telefonszáma:</label><br>
                        <input type="text" name="phone_number"><br>
                        <label for="email">Vendég e-mail címe</label><br>
                        <input type="text" name="email"><br>
                        <input type="hidden" name="action" value="create">
                        <button type=submit value=submit>Új vendég felvétele</button>
                    </form>
                </div>
                <?php } else if (isset($_POST['action']) && $_POST['action'] == 'create') {
                $guestname = '';
                $guestphn = '';
                $guestmail = '';
                $formerror = 0;
                $message = "";


                $guestname = $_POST['name'];
                $guestphn = $_POST['phone_number'];
                $guestmail = $_POST['email'];

                if ($guestphn == '') {
                    $formerror = 1;
                    $message = $message . "Kötelező megadni a vendég telefonszámát! <br>";
                }
                if (!is_numeric($guestphn)) {
                    $formerror = 1;
                    $message = $message . "Érvényes telefonszámot kell megadni! <br>";
                }
                if ($guestname == '') {
                    $formerror = 1;
                    $message = $message . "Kötelező megadni a vendeg nevét <br>";
                }

                if ($guestmail == '') {
                    $formerror = 1;
                    $message = $message . "Kötelező megadni a vendég e-mail címét!";
                }

                if ($formerror) {
                ?>

                    <h1>Új vendég felvétele</h1>
                    <div class="main-content">
                        <div class="formcss2">
                            <?php echo "<p class=\"warning\">" . $message . "</p>";  ?>
                            <form action="guest.php" method="post">
                                <label for="name">Vendég neve:</label><br>
                                <input type="text" name="name" value="<?php echo $guestname; ?>"> <br>
                                <label for="phone_number">Vendég telefonszáma:</label><br>
                                <input type="text" name="phone_number" value="<?php echo $guestphn; ?>"><br>
                                <label for="email">Vendég e-mail címe</label><br>
                                <input type="text" name="email" value="<?php echo $guestmail; ?>"><br>
                                <input type="hidden" name="guestid" value="<?php echo $guestid; ?>">
                                <input type="hidden" name="action" value="create">
                                <button type=submit value=submit>Új vendég felvétele</button>
                            </form>
                        </div>

                    <?php } else {
                    echo $guestmail;
                    $query = "insert into guest values(0, '" . $guestname . "','" . $guestphn . "','" . $guestmail . "')";
                    $result = mysqli_query($link, $query) or die(mysqli_error($link));
                    header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/guest.php?action=list');
                }
            }
            //===================================================================
            // Display edit guest form
            //=================================================================== 
            else if (isset($_GET['action']) && $_GET['action'] == 'edit') { ?>

                    <h1>Vendég adatainak módosítása</h1>
                    <div class="main-content">
                        <div class="formcss2">
                            <?php if (!isset($_GET["id"])) {
                                echo "A vendég azonosítóját kötelező megadni!";
                                exit;
                            }
                            $guestid = $_GET["id"];
                            $query = "select * from guest where id =" . $guestid;

                            $result = mysqli_query($link, $query);
                            $nrrec = mysqli_num_rows($result);

                            if ($nrrec == 0) {
                                echo $guestid . " azonosítóval nem létezik vendég az adatbázisban.";
                                exit;
                            }

                            $row = mysqli_fetch_assoc($result);
                            $guestname = $row["name"];
                            $guestphn = $row["phone_number"];
                            $guestmail = $row["email"];
                            ?>

                            <form action="guest.php" method="post">
                                <label for="guestname">Vendég neve:</label><br>
                                <input type="text" name="name" value="<?php echo $guestname; ?>"> <br>
                                <label for="guestphn">Vendég telefonszáma:</label><br>
                                <input type="text" name="phone_number" value="<?php echo $guestphn; ?>"><br>
                                <label for="">Vendég e-mail címe</label><br>
                                <input type="text" name="email" value="<?php echo $guestmail; ?>"><br>
                                <input type="hidden" name="guestid" value="<?php echo $guestid; ?>">
                                <input type="hidden" name="action" value="modify">
                                <button type=submit value=submit>Vendég adatainak módosítása</button>
                            </form>
                        </div>
                        <?php
                    }
                    //===================================================================
                    // Validate edit form data and update DB record
                    //=================================================================== 
                    else if (isset($_POST['action']) && $_POST['action'] == 'modify') {
                        $message = "";
                        $formerror = 0;
                        $guestname = "";
                        $guestphn = "";
                        $guestmail = "";
                        $guestid = $_POST['guestid'];
                        $guestname = $_POST['name'];
                        $guestphn = $_POST["phone_number"];
                        $guestmail = $_POST["email"];

                        if ($guestname == "") {
                            $formerror = 1;
                            $message = "A vendég nevét kötelező megadni! <br>";
                        }

                        if ($guestphn == "") {
                            $formerror = 1;
                            $message = $message . "a vendég telefonszámát kötelező megadni! <br>";
                        }

                        if (!is_numeric($guestphn)) {
                            $formerror = 1;
                            $message = $message . "Érvényes telefonszámot kell megadni! <br>";
                        }

                        if ($guestmail == "") {
                            $formerror = 1;
                            $message = $message . "a vendég e-mail címét kötelező megadni! <br>";
                        }

                        if ($formerror) { ?>

                            <h1>Vendég adatainak módosítása</h1>
                            <div class="main-content">
                                <div class="formcss2">
                                    <?php echo "<p class=\"warning\">" . $message . "</p>";  ?>
                                    <form action="guest.php" method="post">
                                        <label for="guestname">Vendég neve:</label><br>
                                        <input type="text" name="name" value="<?php echo $guestname; ?>"> <br>
                                        <label for="guestphn">Vendég telefonszáma:</label><br>
                                        <input type="text" name="phone_number" value="<?php echo $guestphn; ?>"><br>
                                        <label for="">Vendég e-mail címe</label><br>
                                        <input type="text" name="email" value="<?php echo $guestmail; ?>"><br>
                                        <input type="hidden" name="action" value="modify">
                                        <input type="hidden" name="guestid" value="<?php echo $guestid; ?>">
                                        <button type=submit value=submit>Vendég adatainak módosítása</button>
                                    </form>
                                </div>
                            <?php
                        } else {
                            $query = "update guest set name='" . $guestname . "',phone_number='" . $guestphn . "',email='" . $guestmail . "' where id=" . $guestid;
                            echo $query;
                            $result = mysqli_query($link, $query) or die(mysqli_error($link));
                            header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/guest.php?action=list');
                        }
                    } else if (isset($_GET['action']) && $_GET['action'] == 'delete') { ?>

                            <h1>Vendég törlése</h1>
                            <div class="main-content">
                                <?php $guestid = $_GET["id"] ?>
                                <div class="formcss2">
                                    <p><?php echo "A " . $guestid . " azonosítójú vendég törölve lesz!" ?></p>
                                    <form action="guest.php" method="POST">
                                        <input type="hidden" name="guestid" value=<?php echo $guestid; ?>>
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" value="submit">Vendég törlése</button>
                                    </form>
                                    <a href="guest.php?action=list"> Mégsem </a>
                                </div>

                            <?php } else if (isset($_POST['action']) && $_POST['action'] == 'delete') {
                            $guestid = $_POST["guestid"];
                            $query = "DELETE from guest WHERE id=" . $guestid;
                            $result = mysqli_query($link, $query) or die(mysqli_error($link));
                            header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/guest.php?action=list');
                        } ?>

                            </div>
</body>

</html>