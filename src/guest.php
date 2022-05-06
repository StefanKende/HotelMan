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
            <h1> Vendégek </h1>
            <div class="main-content">
            <table> 
                <tr>
                    <th>id</th>
                    <th>Vendég neve </th>
                    <th>Vendég telefonszáma</th>
                    <th>Vendég e-mail címe</th>
                    <th>Műveletek</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Anna</td>
                    <td>123456787</td>
                    <td>anna@citromail.com</td>
                    <td><a href="guest.php">Szerkesztés</a> <a href="guest.php">Törlés </a></td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Béla</td>
                    <td>123456788</td>
                    <td>béla@citromail.com</td>
                    <td><a href="guest.php">Szerkesztés</a> <a href="guest.php">Törlés </a></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Cili</td>
                    <td>123456789</td>
                    <td>cili@citromail.com</td>
                    <td><a href="guest.php">Szerkesztés</a> <a href="guest.php">Törlés </a></td>
                </tr>
            </table>

            <h1>Új vendég felvétele</h1>
            
            <form> 
                <label for="guestname">Vendég neve:</label><br>
                <input type="text" id="guestname" name="guestname"> <br>
                <label for="guestphonenumber">Vendég telefonszáma:</label><br>
                <input type="text" id="guestphn" name="guestphn"><br>
                <label for="">Vendég e-mail címe</label><br>
                <input type="text" id="guestmail" name="guestmail"><br>
            </form>
            <button type=button>Új vendég felvétele</button>
        </div>
        </div>
    </body>    
</html>        