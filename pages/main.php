<?php
    session_start();

    if(!isset($_SESSION['radnik_id'])) {
        header("Location: ../index.php");
        exit();
    }

    $greska = '';
    if(isset($_GET['greska'])) {
        $greska = $_GET['greska'];
    }
    if(isset($_GET['uspeh'])) {
        $uspeh = $_GET['uspeh'];
    }
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Butik</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../moduli/header.php'; ?>
    
    <main style="padding: 20px;">
        <h2>Dobrodošao/la, <?php echo $_SESSION['ime']; ?>!</h2>
        <p>Ovo je tvoj radni panel.</p>
        <?php if($_SESSION['uloga'] === 'admin'): ?> 
            <?php if(!empty($greska)): ?>
                <p class="greska"><?php echo $greska; ?></p>
            <?php endif; ?>
            <?php if(!empty($uspeh)): ?>
                <p class="uspeh"><?php echo $uspeh; ?></p>
            <?php endif; ?>
            <form action="../php/add_worker.php" method="post" class="form-group">
                <label for="ime">Ime:</label>
                <input type="text" name="ime" id="ime"required><br>
                <label for="prezime">Prezime:</label>
                <input type="text" name="prezime" id="prezime"required><br>
                <label for="kredencijali">Dodelite kredencijale:</label>
                <input type="password" id="kredencijali" name="kredencijali" minlength="6" maxlength="6" required><br>
                <br><br>
                <label for="uloga">Izaberite ulogu:</label>
                <div id="check">
                    <input type="radio" name="uloga" id="radnik" value="radnik" class="radio" checked>
                    <label for="radnik" class="radio-label">Radnik</label>
                    <input type="radio" name="uloga" id="admin" value="admin" class="radio">
                    <label for="admin" class="radio-label">Administrator</label>
                </div>
                <br><br>
                <button type="submit" name="submit_button">Dodaj</button>
            </form> 
        <?php endif; ?>
    </main>
</body>
</html>