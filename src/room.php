<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="hotelman.css"> 
        <title>Szobák</title>
    </head>
    <body>
        <?php include 'menu.html' ?>
        <?php include 'settings.php'?>

        <div class="main">
            <?php 
              //===================================================================
              // Main action list all rooms
              //=================================================================== 
              if (isset($_GET['action']) && $_GET['action'] == 'list') { 
            ?>
            <h1> Szobák </h1>
            <div class="main-content">

            <p>
            <form action="room.php" method="post">
                <input type="hidden" name="action" value="new">
                <button type="submit" value="submit">Új szoba felvétele</button>
            </form>
            </p>
            
            <table> 
                <tr>
                    <th>id</th>
                    <th>Szobaszám </th>
                    <th>Ár/Nap</th>
                    <th>Férőhely</th>
                    <th>Extra</th>
                    <th>Kategória</th>
                    <th>Műveletek</th>
                </tr>

            <?php
            $query = "select * from room"; 
            $result = mysqli_query($link,$query) or die(mysqli_error(link) );

            
            for ($i=0; $row=mysqli_fetch_assoc($result); $i++) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["roomnr"] . 
                "</td><td>" . $row["price"] . "</td><td>" . $row["nr_guests"] . 
                "</td><td>" . $row["category"] . "</td><td>" . $row["extra"] . "</td>
                <td><a href=\"room.php?action=edit&id=" . $row["id"] . "\">Szerkesztés</a> <a href=\"room.php?action=delete&id=". $row["id"] . "\">Törlés </a></td></tr>";
            }
            ?>
            </table>
               <?php
                //===================================================================
                // Display create new room form 
                //=================================================================== 
                } else if (isset($_POST['action']) && $_POST['action'] == 'new') {
               ?>
            <h1>Új szoba felvétele</h1>
            <div class="main-content">                
          
            <form action="room.php" method="post"> 
                <label for="roomnumber">Szobaszám:</label><br> 
                <input type="text" name="roomnr"> <br>
                <label for="price">Ár:</label><br>
                <input type="text" name="price">Ft/nap<br>
                <label for="">Férőhely</label><br>
                <input type="text" name="nr_guests"><br>
                <p>Extra:</p>
                <input type="checkbox" name="seaview" value="seaview"><label for="seaview">Tengerre néző</label><br>
                <input type="checkbox" name="balcony" value="balcony"><label for="balcony">Erkélyes</label><br>
                <p>Kategória:</p>
                <input type="radio" value="standard" name="category"><label for="standard">Standard</label><br>
                <input type="radio" value="deluxe" name="category"><label for="deluxe">Deluxe</label><br>
                <input type="radio" value="premium" name="category"><label for="premium">Prémium</label><br>
                <input type="hidden" name="action" value="create">
                <button type="submit" value="submit">Szoba létrehozása</button>
            </form>
        </div>
        <?php
            //===================================================================
            // Form validation and create new DB record
            //===================================================================  
            } else if ( isset($_POST['action']) && $_POST['action'] == 'create') {
            $formerror = 0;
            $roomnr = "";
            $price = "";
            $nr_guests = "";
            $seaview = false;
            $balcony = false;
            $category = "";
            $extra = "";
            $seaview = isset($_POST['seaview']);
            $balcony = isset($_POST['balcony']);
            if ($seaview) $extra = "seaview";
            if ($balcony) $extra = $extra . " balcony";
            if (isset($_POST['roomnr'])) $roomnr = $_POST['roomnr'];
            $price = $_POST['price'];
            $nr_guests = $_POST["nr_guests"];
           
            $category = $_POST['category'];

            if ($roomnr == "") {
                $formerror = 1;
                $message = "Szombaszámot kötelező megadni! <br>";
            }

            if (!is_numeric($roomnr)) {
                $formerror = 1;
                $message = $message . "A szobaszámnak egy számnak kell lennie! <br>";
            }

            if ($price == "") {
                $formerror = 1;
                $message = $message . "Árat kötelező megadni! <br>";
            }

            if (!is_numeric($price)) {
                $formerror = 1;
                $message = $message . "Az árnak egy számnak kell lennie! <br>";
            }

            if ($nr_guests == "") {
                $formerror = 1;
                $message = $message . "Férőhelyet kötelező megadni! <br>";
            }

            if (!is_numeric($nr_guests)) {
                $formerror = 1;
                $message = $message . "A férőhelynek egy számnak kell lennie! <br>";
            }

            if ($category == "") {
                $formerror = 1;
                $message = $message . "Kategóriát kötelező megadni! <br>";
            }

            $message = $message . "<br>";

            if ($formerror) {
               
                ?>
                <h1>Új szoba felvétele</h1>
                <div class="main-content">
                    
                <?php echo "<p class=\"warning\">" . $message . "</p>";  ?>

                <form action="room.php" method="post"> 
                <label for="roomnumber">Szobaszám:</label><br> 
                <input type="text" name="roomnr" value="<?php echo $roomnr; ?>"> <br>
                <label for="price">Ár:</label><br>
                <input type="text" name="price" value="<?php echo $price;?>">Ft/nap<br>
                <label for="">Férőhely</label><br>
                <input type="text" name="nr_guests" value="<?php echo $nr_guests; ?>"><br>
                <p>Extra:</p>
                <input type="checkbox" name="seaview" value="seaview" <?php if ($seaview) echo "checked"?> ><label for="seaview">Tengerre néző</label><br>
                <input type="checkbox" name="balcony" value="balcony" <?php if ($balcony) echo "checked"?> ><label for="balcony">Erkélyes</label><br>
                <p>Kategória:</p>
                <input type="radio" value="standard" name="category" <?php if ($category == "standard" ) echo "checked" ?> ><label for="standard">Standard</label><br>
                <input type="radio" value="deluxe" name="category" <?php if ($category == "deluxe" ) echo "checked" ?> ><label for="deluxe">Deluxe</label><br>
                <input type="radio" value="premium" name="category" <?php if ($category == "premium" ) echo "checked" ?> ><label for="premium">Prémium</label><br>
                <input type="hidden" name="action" value="create">
                <button type="submit" value="submit">Szoba létrehozása</button>
            </form>

            <?php
            } //formerror 
            else {
                $query="insert into room values(0,". $roomnr .",". $price . "," . $nr_guests . ", '" . $category . "','" . $extra . "')";
                $result = mysqli_query($link, $query) or die(mysqli_error($link));
                header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/room.php?action=list');
            }
        } 
        //===================================================================
        // Display edit room form
        //=================================================================== 
        else if (isset($_GET['action']) && $_GET['action'] == 'edit') { ?>
            <h1>Szoba szerkesztése</h1>
            <div class="main-content">  
            <?php if (!isset($_GET["id"])) {
                echo "A szobaazonosítót kötelező megadni!";
                exit;
            }
            $roomid = $_GET["id"];
            $query = "select * from room where id =" . $roomid;

            $result = mysqli_query($link,$query);
            $nrrec = mysqli_num_rows($result);

            if ($nrrec == 0) {
                echo $roomid . "azonosítóval nem létezik szoba az adatbázisban.";
                exit;
            } 
            $row = mysqli_fetch_assoc($result);
            $roomnr = $row["roomnr"];
            $price = $row["price"];
            $nr_guests = $row["nr_guests"];
            $category = $row["category"];
            $seaview = false;
            $balcony = false;
            $pattern = "/seaview/i";
            if (preg_match($pattern, $row["extra"])) {
                $seaview = true;
            }
            $pattern = "/balcony/i";
            if (preg_match($pattern, $row["extra"])) {
                $balcony = true;
            }
            ?>
            
            <form action="room.php" method="post"> 
            <label for="roomnumber">Szobaszám:</label><br> 
            <input type="text" name="roomnr" value="<?php echo $roomnr; ?>"> <br>
            <label for="price">Ár:</label><br>
            <input type="text" name="price" value="<?php echo $price;?>">Ft/nap<br>
            <label for="">Férőhely</label><br>
            <input type="text" name="nr_guests" value="<?php echo $nr_guests; ?>"><br>
            <p>Extra:</p>
            <input type="checkbox" name="seaview" value="seaview" <?php if ($seaview) echo "checked"?> ><label for="seaview">Tengerre néző</label><br>
            <input type="checkbox" name="balcony" value="balcony" <?php if ($balcony) echo "checked"?> ><label for="balcony">Erkélyes</label><br>
            <p>Kategória:</p>
            <input type="radio" value="standard" name="category" <?php if ($category == "standard" ) echo "checked" ?> ><label for="standard">Standard</label><br>
            <input type="radio" value="deluxe" name="category" <?php if ($category == "deluxe" ) echo "checked" ?> ><label for="deluxe">Deluxe</label><br>
            <input type="radio" value="premium" name="category" <?php if ($category == "premium" ) echo "checked" ?> ><label for="premium">Prémium</label><br>
            <input type="hidden" name="action" value="modify">
            <input type="hidden" name="roomid" value="<?php echo $roomid; ?>">
            <button type="submit" value="submit">Szoba módosítása</button>
        </form>
        
        <?php
        //===================================================================
        // Validate edit form data and update DB record
        //=================================================================== 
        } else if (isset($_POST['action']) && $_POST['action'] == 'modify') {
            $message = "";
            $formerror = 0;
            $roomnr = "";
            $price = "";
            $nr_guests = "";
            $seaview = false;
            $balcony = false;
            $category = "";
            $extra = "";
            $seaview = isset($_POST['seaview']);
            $balcony = isset($_POST['balcony']);
            if ($seaview) $extra = "seaview";
            if ($balcony) $extra = $extra . " balcony";
            if (isset($_POST['roomnr'])) $roomnr = $_POST['roomnr'];
            $price = $_POST['price'];
            $nr_guests = $_POST["nr_guests"];
            $roomid = $_POST["roomid"];
           
            $category = $_POST['category'];

            if ($roomnr == "") {
                $formerror = 1;
                $message = "Szombaszámot kötelező megadni! <br>";
            }

            if (!is_numeric($roomnr)) {
                $formerror = 1;
                $message = $message . "A szobaszámnak egy számnak kell lennie! <br>";
            }

            if ($price == "") {
                $formerror = 1;
                $message = $message . "Árat kötelező megadni! <br>";
            }

            if (!is_numeric($price)) {
                $formerror = 1;
                $message = $message . "Az árnak egy számnak kell lennie! <br>";
            }

            if ($nr_guests == "") {
                $formerror = 1;
                $message = $message . "Férőhelyet kötelező megadni! <br>";
            }

            if (!is_numeric($nr_guests)) {
                $formerror = 1;
                $message = $message . "A férőhelynek egy számnak kell lennie! <br>";
            }

            if ($category == "") {
                $formerror = 1;
                $message = $message . "Kategóriát kötelező megadni! <br>";
            }
            $message = $message . "<br>";

            if ($formerror) {
               
                ?>
                <h1>Szoba szerkesztés</h1>
                <div class="main-content">
                    
                <?php echo "<p class=\"warning\">" . $message . "</p>";  ?>

                <form action="room.php" method="post"> 
                <label for="roomnumber">Szobaszám:</label><br> 
                <input type="text" name="roomnr" value="<?php echo $roomnr; ?>"> <br>
                <label for="price">Ár:</label><br>
                <input type="text" name="price" value="<?php echo $price;?>">Ft/nap<br>
                <label for="">Férőhely</label><br>
                <input type="text" name="nr_guests" value="<?php echo $nr_guests; ?>"><br>
                <p>Extra:</p>
                <input type="checkbox" name="seaview" value="seaview" <?php if ($seaview) echo "checked"?> ><label for="seaview">Tengerre néző</label><br>
                <input type="checkbox" name="balcony" value="balcony" <?php if ($balcony) echo "checked"?> ><label for="balcony">Erkélyes</label><br>
                <p>Kategória:</p>
                <input type="radio" value="standard" name="category" <?php if ($category == "standard" ) echo "checked" ?> ><label for="standard">Standard</label><br>
                <input type="radio" value="deluxe" name="category" <?php if ($category == "deluxe" ) echo "checked" ?> ><label for="deluxe">Deluxe</label><br>
                <input type="radio" value="premium" name="category" <?php if ($category == "premium" ) echo "checked" ?> ><label for="premium">Prémium</label><br>
                <input type="hidden" name="action" value="modify">
                <button type="submit" value="submit">Szoba módosítása</button>
            </form>

            <?php
            } //formerror 
            else {

                $query="update room set roomnr=". $roomnr .",price=". $price . ",nr_guests=" . $nr_guests . ",category= '" . $category . "',extra='" . $extra . "' where id=" . $roomid;
                $result = mysqli_query($link, $query) or die(mysqli_error($link));
                header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/room.php?action=list');
            }
        } else if (isset($_GET['action']) && $_GET['action'] == 'delete') { ?>
            <h1>Szoba törlése</h1>
            <div class="main-content">
            <?php $roomid=$_GET["id"]?>    
            <p><?php echo "A " . $roomid . " azonosítójú szoba törölve lesz!" ?></p>
            <form action="room.php" method="POST"> 
                <input type="hidden" name="roomid" value=<?php echo $roomid;?>>
                <input type="hidden" name="action" value="delete">
                <button type="submit" value="submit">Szoba törlése</button>
            </form>
            <a href="room.php?action=list"> Mégsem </a>

        <?php
        //===================================================================
        // Delete room from DB
        //=================================================================== 
         } else if (isset($_POST['action']) && $_POST['action'] == 'delete') { 
        $roomid=$_POST["roomid"];
        $query="DELETE from room WHERE id=" . $roomid;
        $result=mysqli_query($link,$query) or die(mysqli_error($link));
        header('Location: http://' . $_SERVER['SERVER_NAME'] . '/hotelman/room.php?action=list');
        } ?>
        </div>
    </body>    
</html>