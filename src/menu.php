        <div id="mySidenav" class="sidenav">
            <a href="index.php">Főoldal</a>
            <a href="room.php?action=list">Szobák</a>
            <a href="guest.php?action=list">Vendégek</a>
            <a href="booking.php?action=list">Foglalások</a>
            <a href="booking.php?action=searchempty1">Üres szoba keresése </a>
            <a href="booking.php?action=bookingtable">Szobák foglaltági naptára</a>
            <?php 
            $_SESSION['switchurl'] = $_SERVER['REQUEST_URI'];
            if ($_SESSION['cssfile'] == 'hotelman.css') { ?>
              <a href="switchcss.php">Sötét mód </a>
            <?php } else { ?>
              <a href="switchcss.php">Világos mód </a>
            <?php }?>
            <a href="logout.php">Kijelentkezés</a>
        </div>