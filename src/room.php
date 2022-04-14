<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="hotelman.css"> 
        <title>Szobák</title>
    </head>
    <body>
        <?php include 'menu.html' ?>

        <div class="main">

            <?php
                if ($_GET['action'] == 'list') {
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
                <tr>
                    <td>1</td>
                    <td>101</td>
                    <td>15000 Ft</td>
                    <td>3</td>
                    <td>-</td>
                    <td>Standard</td>
                    <td><a href="room.php">Szerkesztés</a> <a href="room.php">Törlés </a></td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>102</td>
                    <td>20000 Ft</td>
                    <td>2</td>
                    <td>Padlófűtés</td>
                    <td>Deluxe</td>
                    <td><a href="room.php">Szerkesztés</a> <a href="room.php">Törlés </a></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>103</td>
                    <td>10000 Ft</td>
                    <td>2</td>
                    <td>-</td>
                    <td>Standard</td>
                    <td><a href="room.php">Szerkesztés</a> <a href="room.php">Törlés </a></td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>113</td>
                    <td>22000 Ft</td>
                    <td>4</td>
                    <td>-</td>
                    <td>Deluxe</td>
                    <td><a href="room.php">Szerkesztés</a> <a href="room.php">Törlés </a></td>
                </tr>

                <tr>
                    <td>5</td>
                    <td>115</td>
                    <td>50000 Ft</td>
                    <td>2</td>
                    <td>Erkély</td>
                    <td>Prémium</td>
                    <td><a href="room.php">Szerkesztés</a> <a href="room.php">Törlés </a></td>
                </tr>
            </table>

               <?php } else if ($_POST['action'] == 'new') { ?>
            <h1>Új szoba felvétele</h1>
            <div class="main-content">                
          
            <form> 
                <label for="roomnumber">Szobaszám:</label><br>
                <input type="text" id="roomnr" name="roomnr"> <br>
                <label for="price">Ár:</label><br>
                <input type="text" id="price" name="price">Ft/nap<br>
                <label for="">Férőhely</label><br>
                <input type="text" id="nr_guests" name="nr_guests"><br>
                <p>Extra:</p>
                <input type="checkbox" id="seaview" name="seaview" value="seaview"><label for="seaview">Tengerre néző</label><br>
                <input type="checkbox" id="balcony" name="balcony" value="balcony"><label for="balcony">Erkélyes</label><br>
                <p>Kategória:</p>
                <input type="radio" id="standard" name="category"><label for="standard">Standard</label><br>
                <input type="radio" id="deluxe" name="category"><label for="deluxe">Deluxe</label><br>
                <input type="radio" id="premium" name="category"><label for="premium">Prémium</label><br>
                <button type="button">Szoba létrehozása</button>
            </form>
        </div>
        <?php } ?>
        </div>
    </body>    
</html>        