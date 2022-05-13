<?php 
function checkIsAValidDate($myDateString){
    return (bool)strtotime($myDateString);
}
?>

<!DOCTYPE htlm>
<html>
    <head>
        <link rel="stylesheet" href="hotelman.css"> 
        <title>Foglalások</title>
    </head>
    <body>
        <?php include 'menu.html' ?>
        <?php include 'settings.php' ?>
        <div class="main">

        <?php if (isset($_GET['action']) && $_GET['action'] == 'list') {
        ?>
        <h1> Foglalások </h1>
        <div class="main-content">
        
        <p>
            <form action="booking.php" method="post">
                <input type="hidden" name="action" value="new">
                <button type="submit" value="submit">Új foglalás felvétele</button>
            </form>
        </p>

        <table> 
                <tr>
                    <th>id</th>
                    <th>Ár </th>
                    <th>Foglalás kezdete</th>
                    <th>Foglalás vége</th>
                    <th>Vendég neve</th>
                    <th>Vendég telefonszáma</th>
                    <th>Szobaszám</th>
                    <th>Műveletek</th>
                </tr>
                <?php $query = "select booking.id, booking.price, booking.beginning, 
                booking.end, guest.name, guest.phone_number,room.roomnr
                from booking inner join guest inner join room 
                where guest.id=booking.guest_id AND room.id=booking.room_id"; 
            $result = mysqli_query($link,$query) or die(mysqli_error(link) );

            
            for ($i=0; $row=mysqli_fetch_assoc($result); $i++) { 
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["price"] . 
                "</td><td>" . $row["beginning"] . "</td><td>" . $row["end"] . 
                "</td><td>" . $row["name"] . "</td><td>" . $row["phone_number"] . "</td>" .
                "<td>" . $row["roomnr"] . "</td>" .
                "<td><a href=\"booking.php?action=edit&id=" . $row["id"] . "\">Szerkesztés</a>" . 
                "<a href=\"booking.php?action=delete&id=". $row["id"] . "\"> Törlés </a></td></tr>";
            } ?>
            </table>


        <?php 
        //===================================================================
        // Új foglalás időpontjának beállítása
        //=================================================================== 
        } else if (isset($_POST['action']) && $_POST['action'] == 'new') { ?>
            <h1>Új foglalás felvétele</h1>
            <div class="main-content">
            <p> Kérem adja meg a foglalás kezdeti és végpontját!</p>
            <form action="booking.php" method="post"> 
                <label for="beginning">A foglalás kezdete</label><br> 
                <input type="text" name="beginning"> <br>
                <label for="end"></label>A foglalás vége<br>
                <input type="text" name="end"><br>
                <input type=hidden name="action" value="new2">
                <button type="submit" value="submit">Tovább</button>
            </form>
        </div>
        <?php 
        //===================================================================
        // Új foglalás, Fogadott időpontok validálása, foglalás űrlap megjelenítése
        //===================================================================
        } else if (isset($_POST['action']) && $_POST['action'] == 'new2') {?>
        <h1>Új foglalás felvétele</h1>
        <div class="main-content">
        <?php
        $formerror = 0;
        $message="";
        if (!checkIsAValidDate($_POST['beginning'])) {
            $formerror=1;
            $message="A kezdő dátumnak érvényesnek kell lennie! " . "<br>";
        }
        if (!checkIsAValidDate($_POST['end'])) {
            $formerror=1;
            $message=$message."A vég dátumnak érvényesnek kell lennie!";
        }
        if($formerror) {
            echo $message; ?>
            <p> Kérem adja meg a foglalás kezdeti és végpontját!</p>
            <form action="booking.php" method="post"> 
                <label for="beginning">A foglalás kezdete</label><br> 
                <input type="text" name="beginning" value="<?php echo $_POST['beginning']; ?>"> <br>
                <label for="end"></label>A foglalás vége<br>
                <input type="text" name="end" value="<?php echo $_POST['end']; ?>"><br>
                <input type=hidden name="action" value="new2">
                <button type="submit" value="submit">Tovább</button>
            </form> 
        <?php
        } else { ?>
        <p> A foglalás időpontja:
        <?php
        echo $_POST['beginning'] . "-tól " . $_POST['end'] . "-ig";     ?> </p>
        <form action="booking.php" method="post">
        <label for="guests">Válassza ki a vendéget:</label>
        <select name="guests">
        <?php 
        $query = "select * from guest"; 
        $result = mysqli_query($link,$query) or die(mysqli_error(link));
        for ($i=0; $row=mysqli_fetch_assoc($result); $i++) {
                echo "<option value=\"" . $row['id'] . "\">" . $row['name'] .  "</option> \n";
            }
            ?>
        </select>
        <br>
        <label for="rooms"> Válassza ki a szobát </label>
        <select name="rooms">
        <?php 
        $query = "select id, roomnr from room where id not in (select room_id from booking where (beginning<='". $_POST['beginning'] .
        "' AND end>" . $_POST['beginning'] . ") OR (beginning>'". $_POST['end'] . 
        "' AND end<='". $_POST['end'] . "'))";
        $result = mysqli_query($link,$query) or die(mysqli_error(link));
        for ($i=0; $row=mysqli_fetch_assoc($result); $i++) {
            echo"<option value=\"". $row['id'] . "\">". $row['roomnr'] . "</option>";
            }
            ?>
        </select> <br>
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="beginning" value="<?php echo $_POST['beginning']?>">
        <input type="hidden" name="end" value="<?php echo $_POST['end']?>">
        <button type="submit" value="create">Megerősítés</button>
        </form>
        </div>
        <?php }}
        //===================================================================
        // Új foglalás letárolása az adatbázisba
        //===================================================================
        else if (isset($_POST['action']) && $_POST['action'] == 'create') {?>

        <?php
        $datetime1 = date_create($_POST['beginning']);
        $datetime2 = date_create($_POST['end']);
        $interval = date_diff($datetime1, $datetime2);
        echo $interval->format('%a days');
        $roomid=$_POST['rooms'];
        $guestid=$_POST['guests'];
        $query = "select price from room where id =$roomid"; 
        $result = mysqli_query($link,$query) or die(mysqli_error(link) );
        $row=mysqli_fetch_assoc($result);
        $price=$row['price'] * $interval->format('%a');;
            $query="insert into booking values(0,". $guestid .",". $roomid . "," 
            . $price . ", '" . $_POST['beginning'] . "','" . $_POST['end'] . "')";
            $result = mysqli_query($link, $query) or die(mysqli_error($link));
            header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/booking.php?action=list');
            ?>
            
        <?php } else if (isset($_GET['action']) && $_GET['action'] == 'edit') {?>
        <?php } else if (isset($_GET['action']) && $_GET['action'] == 'edit2') {?>
        <?php } else if (isset($_GET['action']) && $_GET['action'] == 'modify') {?>
        <?php } else if (isset($_GET['action']) && $_GET['action'] == 'delete') ?>
        </div>
        </div>
    </body>    
</html>        