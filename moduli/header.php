
<header id="header">
    <h1>Butik Inventar</h1>
    <div id="navigacija">
        <a href="main.php">Profil</a> | 
        <a href="articles.php">Inventar</a> | 
        <a href="order.php">Trebovanje</a>
    </div>
    <div id="profil">
        <p>Ulogovan: <?php echo $_SESSION['ime'] . " " . $_SESSION['prezime'] ?></p>
        <a href="../php/logout.php">Odjavi se</a>
    </div>
</header>