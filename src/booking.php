<!DOCTYPE htlm>
<html>
    <head>
        <link rel="stylesheet" href="hotelman.css"> 
        <title>Foglalások</title>
    </head>
    <body>
        <?php include 'menu.html' ?>
        <?php include 'settings.php ' ?>

        <div class="main">
            <h1> Foglalások </h1>
            <div class="main-content">
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
                <tr>
                    <td>1</td>
                    <td>30 000 FT</td>
                    <td>2022 03 10</td>
                    <td>2022 03 12</td>
                    <td>Anna</td>
                    <td>123456787</td>
                    <td>101</td>
                    <td><a href="booking.php">Szerkesztés</a> <a href="booking.php">Törlés </a><a href="booking.php">Kijelentkezés </a></td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>45 000 FT</td>
                    <td>2022 04 12</td>
                    <td>2022 04 29</td>
                    <td>Béla</td>
                    <td>123456788</td>
                    <td>115</td>
                    <td><a href="booking.php">Szerkesztés</a> <a href="booking.php">Törlés </a><a href="booking.php">Kijelentkezés </a></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>10 000 FT</td>
                    <td>2022 03 10</td>
                    <td>2022 03 24</td>
                    <td>Béla</td>
                    <td>123456788</td>
                    <td>115</td>
                    <td><a href="booking.php">Szerkesztés</a> <a href="booking.php">Törlés </a><a href="booking.php">Kijelentkezés </a></td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>100 000 FT</td>
                    <td>2022 03 14</td>
                    <td>2022 03 19</td>
                    <td>Cili</td>
                    <td>123456789</td>
                    <td>101</td>
                    <td><a href="booking.php">Szerkesztés  </a> <a href="booking.php">Törlés  </a><a href="booking.php">Kijelentkezés  </a></td>
                </tr>
            </table>
        </div>
        </div>
    </body>    
</html>        