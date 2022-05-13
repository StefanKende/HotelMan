<!DOCTYPE htlm>
<html>
    <head>
        <link rel="stylesheet" href="hotelman.css"> 
        <title>Vendégek</title>
    </head>
    <body>
         <?php include 'menu.html' ?>
         <?php include 'settings.php'?>
         
        <div class="main">

            <?php 
            //===================================================================
            // Összes vendég listázása
            //=================================================================== 
            if ( isset($_GET["action"]) && $_GET['action'] == 'list') { ?>
            <h1> Vendégek </h1>
            <div class="main-content">

            <form action="guest.php" method="post">
                <input type="hidden" name="action" value="new">
                <button type="submit" value="submit">Új vendég felvétele</button>
            </form>

            <table> 
                <tr>
                    <th>id</th>
                    <th>Vendég neve </th>
                    <th>Vendég telefonszáma</th>
                    <th>Vendég e-mail címe</th>
                    <th>Műveletek</th>
                </tr>

                <?php
                $query = "select * from guest"; 
                 $result = mysqli_query($link,$query) or die(mysqli_error(link) );

            
            for ($i=0; $row=mysqli_fetch_assoc($result); $i++) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . 
                "</td><td>" . $row["phone_number"] . "</td><td>" . $row["e-mail"] . "</td>
                <td><a href=\"guest.php?action=edit&id=" . $row["id"] . "\">Szerkesztés</a> 
                <a href=\"guest.php?action=delete&id="
                . $row["id"] . "\">Törlés </a></td></tr>";
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
            <form action='guest.php' method='post'> 
                <label for="guestname">Vendég neve:</label><br>
                <input type="text" id="guestname" name="guestname"> <br>
                <label for="guestphonenumber">Vendég telefonszáma:</label><br>
                <input type="text" id="guestphn" name="guestphn"><br>
                <label for="">Vendég e-mail címe</label><br>
                <input type="text" id="guestmail" name="guestmail"><br>
                <input type="hidden" name="action" value="create">
                <button type=submit value=submit >Új vendég felvétele</button>
            </form>
        <?php }
        else if (isset($_POST['action']) && $_POST['action'] == 'create') {
        $id = 0;
        $guestname = '';
        $guestphn = '';
        $guestmail = '';
        $formerror=0;
        $message = "";

        $guestname = $_POST['guestname'];
        $guestphn = $_POST['guestphn'];
        $guestmail = $_POST['guestmail'];

        if ($guestphn == '') {
            $formerror=1;
            $message = $message . "Kötelező megadni a vendég telefonszámát! <br>";
        }
        if (!is_numeric($guestphn)) {
            $formerror=1;
            $message = $message . "Érvényes telefonszámot kell megadni! <br>";
        }
        $guestphn='+'.$guestphn;

        if ($guestname == '') {
            $formerror=1;
            $message = "Kötelező megadni a vendeg nevét <br>";
        }

        if ($guestmail == '') {
            $formerror=1;
            $message = $message . "Kötelező megadni a vendég e-mail címét!";
        }

        if($formerror) {
        ?>

            <h1>Új vendég felvétele</h1>
            <div class="main-content"> 
            
            <?php echo "<p class=\"warning\">" . $message . "</p>";  ?>
            <form> 
                <label for="guestname">Vendég neve:</label><br>
                <input type="text" name="guestname" value=<?php echo $guestname; ?>> <br>
                <label for="guestphonenumber">Vendég telefonszáma:</label><br>
                <input type="text" name="guestphn" value=<?php echo $guestphn; ?>><br>
                <label for="">Vendég e-mail címe</label><br>
                <input type="text" name="guestmail" value=<?php echo $guestmail; ?>><br>
                <input type="hidden" name="action" value="create">
            </form>
            <button type=submit value=submit >Új vendég felvétele</button>

        <?php }
        ?>


        <?php
        }
        ?>

        </div>
    </body>    
</html>        