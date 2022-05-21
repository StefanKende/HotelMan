<?php
function checkIsAValidDate($myDateString)
{
    return (bool)strtotime($myDateString);
}
?>

<!DOCTYPE html>
<?php include 'hmsession.php' ?>
<html>

<head>
    <link rel="stylesheet" href=" <?php echo $_SESSION['cssfile']; ?> ">
    <title>Foglalások</title>
</head>

<body style="background-image:url('../hotelman/backgroundimagebooking.jpg');
                  background-size:cover;">
    <?php include 'menu.php' ?>
    <?php include 'settings.php' ?>
    <div class="main">
        <?php $hasaccess = ($_SESSION['role'] == 'superuser') || ($_SESSION['role'] == 'receptionist') ?>
        <?php if (isset($_GET['action']) && $_GET['action'] == 'list') {
        ?>
            <h1> Foglalások </h1>
            <div class="main-content">
                <?php if ($hasaccess) { ?>
                    <p>
                    <form action="booking.php" method="post">
                        <input type="hidden" name="action" value="new">
                        <button type="submit" value="submit">Új foglalás felvétele</button>
                    </form>
                    </p>
                <?php } ?>

                <table>
                    <tr>
                        <th>id</th>
                        <th>Ár </th>
                        <th>Foglalás kezdete</th>
                        <th>Foglalás vége</th>
                        <th>Vendég neve</th>
                        <th>Vendég telefonszáma</th>
                        <th>Szobaszám</th>
                        <?php if ($hasaccess) echo "<th>Műveletek</th>"; ?>
                    </tr>
                    <?php $query = "select booking.id, booking.price, booking.beginning, 
                booking.end, guest.name, guest.phone_number,room.roomnr
                from booking inner join guest inner join room 
                where guest.id=booking.guest_id AND room.id=booking.room_id";
                    $result = mysqli_query($link, $query) or die(mysqli_error($link));


                    for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["price"] .
                            "</td><td>" . $row["beginning"] . "</td><td>" . $row["end"] .
                            "</td><td>" . $row["name"] . "</td><td>" . $row["phone_number"] . "</td>" .
                            "<td>" . $row["roomnr"] . "</td>";
                        if ($hasaccess) {
                            echo "<td><a href=\"booking.php?action=edit&id=" . $row["id"] . "\">Szerkesztés</a>" .
                                "<a href=\"booking.php?action=delete&id=" . $row["id"] . "\"> Törlés </a>" .
                                "<a href=\"booking.php?action=checkout&id=" . $row["id"] .
                                "\">Kijelentkezés</a></td>";
                        }
                        echo "</tr>";
                    } ?>
                </table>

            <?php
            //===================================================================
            // Új foglalás időpontjának beállítása
            //=================================================================== 
        } else if (isset($_POST['action']) && $_POST['action'] == 'new') { ?>
                <h1>Új foglalás felvétele</h1>
                <div class="main-content">
                    <p> </p>
                    <div class="formcss2">
                        <form action="booking.php" method="post">
                            <label>Kérem adja meg a foglalás kezdeti és végpontját!</label><br>
                            <label for="beginning">A foglalás kezdete</label><br>
                            <input type="text" name="beginning"> <br>
                            <label for="end"></label>A foglalás vége<br>
                            <input type="text" name="end"><br>
                            <input type=hidden name="action" value="new2">
                            <button type="submit" value="submit">Tovább</button>
                        </form>
                    </div>
                </div>
            <?php
            //===================================================================
            // Új foglalás, Fogadott időpontok validálása, foglalás űrlap megjelenítése
            //===================================================================
        } else if (isset($_POST['action']) && $_POST['action'] == 'new2') { ?>
                <h1>Új foglalás felvétele</h1>
                <div class="main-content">
                    <div class="formcss2">
                        <?php
                        $formerror = 0;
                        $message = "";
                        if (!checkIsAValidDate($_POST['beginning'])) {
                            $formerror = 1;
                            $message = "A kezdő dátumnak érvényesnek kell lennie! " . "<br>";
                        }
                        if (!checkIsAValidDate($_POST['end'])) {
                            $formerror = 1;
                            $message = $message . "A vég dátumnak érvényesnek kell lennie!";
                        }
                        if ($formerror) { ?>
                            <form action="booking.php" method="post">
                                <div class="warning">
                                    <?php echo "<label>" . $message . "</label><br> "; ?>
                                </div>
                                <label>Kérem adja meg a foglalás kezdeti és végpontját!</label><br>
                                <label for="beginning">A foglalás kezdete</label><br>
                                <input type="text" name="beginning" value="<?php echo $_POST['beginning']; ?>"> <br>
                                <label for="end"></label>A foglalás vége<br>
                                <input type="text" name="end" value="<?php echo $_POST['end']; ?>"><br>
                                <input type=hidden name="action" value="new2">
                                <button type="submit" value="submit">Tovább</button>
                            </form>
                    </div>
                </div>
            <?php
                        } else { ?>
                <div class="formcss2">
                    <p> A foglalás időpontja:
                        <?php
                            echo $_POST['beginning'] . "-tól " . $_POST['end'] . "-ig";     ?> </p>
                    <form action="booking.php" method="post">
                        <label for="guests">Válassza ki a vendéget:</label>
                        <select name="guests">
                            <?php
                            $query = "select * from guest";
                            $result = mysqli_query($link, $query) or die(mysqli_error($link));
                            for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
                                echo "<option value=\"" . $row['id'] . "\">" . $row['name'] .  "</option> \n";
                            }
                            ?>
                        </select>
                        <br>
                        <label for="rooms"> Válassza ki a szobát </label>
                        <select name="rooms">
                            <?php
                            $query = "select id, roomnr from room where id not in (select room_id from booking where ('" . $_POST['beginning'] . "' >= beginning 
        AND '" . $_POST['beginning'] . "'< end ) OR ('" . $_POST['end'] . "' > beginning
        AND '" . $_POST['end'] . "'<=end))";
                            $result = mysqli_query($link, $query) or die(mysqli_error($link));
                            for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
                                echo "<option value=\"" . $row['id'] . "\">" . $row['roomnr'] . "</option> \n";
                            }
                            ?>
                        </select> <br>
                        <input type="hidden" name="action" value="create">
                        <input type="hidden" name="beginning" value="<?php echo $_POST['beginning'] ?>">
                        <input type="hidden" name="end" value="<?php echo $_POST['end'] ?>">
                        <button type="submit" value="create">Megerősítés</button>
                    </form>
                </div>
            </div>
        <?php }
                    }
                    //===================================================================
                    // Új foglalás letárolása az adatbázisba
                    //===================================================================
                    else if (isset($_POST['action']) && $_POST['action'] == 'create') { ?>

        <?php
                        $datetime1 = date_create($_POST['beginning']);
                        $datetime2 = date_create($_POST['end']);
                        $interval = date_diff($datetime1, $datetime2);
                        echo $interval->format('%a days');
                        $roomid = $_POST['rooms'];
                        $guestid = $_POST['guests'];
                        $query = "select price from room where id =$roomid";
                        $result = mysqli_query($link, $query) or die(mysqli_error($link));
                        $row = mysqli_fetch_assoc($result);
                        $price = $row['price'] * $interval->format('%a');;
                        $query = "insert into booking values(0," . $guestid . "," . $roomid . ","
                            . $price . ", '" . $_POST['beginning'] . "','" . $_POST['end'] . "')";
                        $result = mysqli_query($link, $query) or die(mysqli_error($link));
                        header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/booking.php?action=list');
        ?>

    <?php }
                    //===================================================================
                    // Foglalás módosítása
                    //=================================================================== 
                    else if (isset($_GET['action']) && $_GET['action'] == 'edit') { ?>

        <h1>Foglalás módosítása</h1>
        <div class="main-content">
            <div class="formcss2">
                <?php if (!isset($_GET["id"])) {
                            echo "A foglalás azonosítóját kötelező megadni!";
                            exit;
                        }
                        $bookingid = $_GET["id"];
                        $query = "select * from booking where id =" . $bookingid;

                        $result = mysqli_query($link, $query);
                        $nrrec = mysqli_num_rows($result);

                        if ($nrrec == 0) {
                            echo $bookingid . " azonosítóval nem létezik foglalás az adatbázisban.";
                            exit;
                        }

                        $row = mysqli_fetch_assoc($result);
                        $guestid = $row["guest_id"];
                        $beginning = $row["beginning"];
                        $end = $row["end"];
                        $roomid = $row["room_id"];

                ?>

                <form action="booking.php" method="post">
                    <label for="beginning">A foglalás kezdete</label><br>
                    <input type="text" name="beginning" value="<?php echo $beginning; ?>"> <br>
                    <label for="end"></label>A foglalás vége<br>
                    <input type="text" name="end" value="<?php echo $end; ?>"><br>
                    <input type=hidden name="action" value="edit2">
                    <input type=hidden name="guestid" value=<?php echo $guestid; ?>>
                    <input type=hidden name="bookingid" value=<?php echo $bookingid; ?>>
                    <input type=hidden name="room_id" value=<?php echo $roomid; ?>>
                    <button type="submit" value="submit">Tovább</button>
                </form>
            </div>
        </div>

    <?php
                        //===================================================================
                        // Foglalás módosítása2
                        //===================================================================

                    } else if (isset($_POST['action']) && $_POST['action'] == 'edit2') { ?>

        <h1>Foglalás módosítása</h1>
        <div class="main-content">
            <div class="formcss2">
                <?php
                        $formerror = 0;
                        $message = "";
                        $guestid = $_POST["guestid"];
                        $bookingid = $_POST["bookingid"];
                        if (!checkIsAValidDate($_POST['beginning'])) {
                            $formerror = 1;
                            $message = "A kezdő dátumnak érvényesnek kell lennie! " . "<br>";
                        }
                        if (!checkIsAValidDate($_POST['end'])) {
                            $formerror = 1;
                            $message = $message . "A vég dátumnak érvényesnek kell lennie!";
                        }
                        if ($formerror) { ?>
                    <div class="warning">
                        <?php echo $message; ?>
                    </div>
                    <p> Kérem adja meg a foglalás kezdeti és végpontját!</p>
                    <form action="booking.php" method="post">
                        <label for="beginning">A foglalás kezdete</label><br>
                        <input type="text" name="beginning" value="<?php echo $_POST['beginning']; ?>"> <br>
                        <label for="end"></label>A foglalás vége<br>
                        <input type="text" name="end" value="<?php echo $_POST['end']; ?>"><br>
                        <input type=hidden name="action" value="edit2">
                        <input type=hidden name="guestid" value=<?php echo $guestid ?>>
                        <input type=hidden name="bookingid" value=<?php echo $bookingid; ?>>
                        <input type=hidden name="bookingid" value=<?php echo $_POST['room_id']; ?>>
                        <button type="submit" value="submit">Tovább</button>
                    </form>
                <?php
                        } else { ?>
                    <p> A foglalás időpontja:
                        <?php
                            echo $_POST['beginning'] . "-tól " . $_POST['end'] . "-ig";
                        ?> </p>
                    <p> A vendég: <?php

                                    $guestid = $_POST["guestid"];
                                    $bookingid = $_POST["bookingid"];
                                    $query = "select * from guest where id=" . $guestid;
                                    $result = mysqli_query($link, $query) or die(mysqli_error($link));
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['name'];

                                    ?> </p>
                    <form action="booking.php" method="post">
                        <label for="rooms"> Válassza ki a szobát </label>
                        <select name="rooms">
                            <?php
                            $query = "select id, roomnr from room where id not in (select room_id from booking where (('" . $_POST['beginning'] . "' >= beginning 
            AND '" . $_POST['beginning'] . "'< end ) OR ('" . $_POST['end'] . "' > beginning
            AND '" . $_POST['end'] . "'<=end)) AND id !=" . $bookingid . ")";
                            $result = mysqli_query($link, $query) or die(mysqli_error($link));
                            for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
                                if ($row['id'] == $_POST['room_id']) {
                                    echo "<option value=\"" . $row['id'] . "\"selected>" . $row['roomnr'] . "</option>";
                                } else {
                                    echo "<option value=\"" . $row['id'] . "\">" . $row['roomnr'] . "</option>";
                                }
                            }
                            ?>
                        </select> <br>
                        <input type="hidden" name="action" value="modify">
                        <input type="hidden" name="beginning" value="<?php echo $_POST['beginning'] ?>">
                        <input type="hidden" name="end" value="<?php echo $_POST['end'] ?>">
                        <input type=hidden name="bookingid" value=<?php echo $_POST['bookingid']; ?>>
                        <button type="submit" value="submit">Megerősítés</button>
                    </form>
            </div>
        </div>
    <?php
                            //===================================================================
                            // Foglalás módosításának véglegesítése
                            //===================================================================

                        }
                    } else if (isset($_POST['action']) && $_POST['action'] == 'modify') { ?>
    <?php
                        $query = "update booking set beginning='" . $_POST['beginning'] . "',end='" . $_POST['end'] . "',room_id=" . $_POST['rooms'] . " where id=" . $_POST['bookingid'];
                        $result = mysqli_query($link, $query) or die(mysqli_error($link));
                        header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/booking.php?action=list');
    ?>
<?php
                        //===================================================================
                        // Foglalás törlése
                        //===================================================================

                    } else if (isset($_GET['action']) && $_GET['action'] == 'delete') { ?>

    <h1>Foglalás törlése</h1>
    <div class="main-content">
        <div class="formcss2">
            <?php $bookingid = $_GET["id"] ?>
            <p><?php echo "A " . $bookingid . " azonosítójú foglalás törölve lesz!" ?></p>
            <form action="booking.php" method="POST">
                <input type="hidden" name="bookingid" value=<?php echo $bookingid; ?>>
                <input type="hidden" name="action" value="delete">
                <button type="submit" value="submit">Foglalás törlése</button>
            </form>
            <a href="booking.php?action=list"> Mégsem </a>

        <?php } else if (isset($_POST['action']) && $_POST['action'] == 'delete') {

                        $bookingid = $_POST['bookingid'];
                        $query = "DELETE from booking WHERE id=" . $bookingid;
                        $result = mysqli_query($link, $query) or die(mysqli_error($link));
                        header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/booking.php?action=list');
                    } else if (isset($_GET['action']) && $_GET['action'] == 'checkout') {
                        $query = "select * from booking where id =" . $_GET['id'];
                        $result = mysqli_query($link, $query) or die(mysqli_error($link)); ?>

            <h1>Kijelentkezés</h1>
            <div class="main-content">
                <div class="formcss2">
                    <p> A vendég: <?php
                                    $bookingid = $_GET["id"];
                                    $query = "select * from booking where id=" . $bookingid;
                                    $result = mysqli_query($link, $query) or die(mysqli_error($link));
                                    $row = mysqli_fetch_assoc($result);
                                    $query2 = "select * from guest where id =" . $row['guest_id'];
                                    $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
                                    $row2 = mysqli_fetch_assoc($result2);
                                    echo $row2['name'];

                                    ?> </p>

                    <p> A foglalás időpontja:
                        <?php
                        echo $row['beginning'] . "-tól " . $row['end'] . "-ig"; ?> </p>

                    <p> A fizetendő összeg: <?php echo $row['price']; ?> </p>

                    <form action="booking.php" method="get">
                        <input type=hidden name="action" value="list">
                        <button type="submit" value="submit">Kijelentkezés</button>
                    </form>
                </div>
            </div>
        <?php

                    } else if (isset($_GET['action']) && $_GET['action'] == 'searchempty1') { ?>

            <h1>Üres szoba keresése</h1>
            <div class="main-content">
                <div class="formcss2">
                    <p> Kérem adja meg a foglalás kezdeti és végpontját!</p>
                    <form action="booking.php" method="post">
                        <label for="beginning">A foglalás kezdete</label><br>
                        <input type="text" name="beginning"> <br>
                        <label for="end"></label>A foglalás vége<br>
                        <input type="text" name="end"><br>
                        <input type=hidden name="action" value="searchempty2">
                        <button type="submit" value="submit">Tovább</button>
                    </form>
                    </p>
                </div>
            </div>
        <?php } else if (isset($_POST['action']) && $_POST['action'] == 'searchempty2') { ?>
            <h1>Üres szoba keresése</h1>
            <div class="main-content">
                <div class="formcss2">
                    <?php
                        $formerror = 0;
                        $message = "";
                        if (!checkIsAValidDate($_POST['beginning'])) {
                            $formerror = 1;
                            $message = "A kezdő dátumnak érvényesnek kell lennie! " . "<br>";
                        }
                        if (!checkIsAValidDate($_POST['end'])) {
                            $formerror = 1;
                            $message = $message . "A vég dátumnak érvényesnek kell lennie!";
                        }
                        if ($formerror) { ?>
                        <div class="warning">
                            <?php echo $message; ?>
                        </div>
                        <p> Kérem adja meg a foglalás kezdeti és végpontját!</p>
                        <form action="booking.php" method="post">
                            <label for="beginning">A foglalás kezdete</label><br>
                            <input type="text" name="beginning" value="<?php echo $_POST['beginning']; ?>"> <br>
                            <label for="end"></label>A foglalás vége<br>
                            <input type="text" name="end" value="<?php echo $_POST['end']; ?>"><br>
                            <input type=hidden name="action" value="searchempty2">
                            <button type="submit" value="submit">Tovább</button>
                        </form>
                </div>
            <?php } else { ?>
                <p> A következő szobák érhetőek el <?php echo $_POST['beginning']; ?> és <?php echo $_POST['end']; ?> között: </p>
            </div>
            <?php $query = "select * from room where id not in (select room_id from booking where ('" . $_POST['beginning'] . "' >= beginning 
            AND '" . $_POST['beginning'] . "'< end ) OR ('" . $_POST['end'] . "' > beginning
            AND '" . $_POST['end'] . "'<=end))";
                            $result = mysqli_query($link, $query) or die(mysqli_error($link)); ?>

            <table>
                <tr>
                    <th>Szobaszám </th>
                    <th>Ár/Nap</th>
                    <th>Férőhely</th>
                    <th>Extra</th>
                    <th>Kategória</th>
                </tr>
                <?php for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
                                echo "<tr><td>" . $row["roomnr"] .
                                    "</td><td>" . $row["price"] . "</td><td>" . $row["nr_guests"] .
                                    "</td><td>" . $row["extra"] . "</td><td>" . $row["category"] . "</td>";
                            } ?>
            </table>
        <?php
                        } ?>
        </div>
    <?php } else if (isset($_GET['action']) && $_GET['action'] == 'bookingtable') { ?>

        <h1>Szobák foglaltsági táblázata</h1>
        <div class="main-content">
            <?php

                        $query = "select roomnr, id from room";
                        $result = mysqli_query($link, $query) or die(mysqli_error($link));
                        for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
                            $query2 = "select beginning, end from booking where room_id =" . $row['id'];
                            $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
                            $nrrec = mysqli_num_rows($result2);
                            if ($nrrec) { ?> <div class="formcss2">
                        <?php echo "<p>A " . $row['roomnr'] . " Számú szobának ezek a foglalásai vannak:</p>"; ?>
                    </div>
                    <table>
                        <tr>
                            <th>Foglalás kezdete</th>
                            <th>Foglalás vége</th>
                        </tr>

                    <?php for ($j = 0; $row2 = mysqli_fetch_assoc($result2); $j++) {

                                    echo "<tr><td>" . $row2['beginning'] . "</td><td>" . $row2['end'] . "</td></tr>";
                                }
                            } ?>
                    </table>
            <?php }
                    }
            ?>
        </div>
    </div>
    </div>
</body>

</html>