<?php
session_start();

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "butik";

$greska = ""; 

if(isset($_POST['submit_button'])){
    try {
        $unesena_lozinka = $_POST['kredencijali'] ?? '';
        
        if(empty($unesena_lozinka)) {
            throw new Exception("Molimo unesite kredencijale!");
        }

        if(strlen($unesena_lozinka) != 6){
            throw new Exception("Kredencijali moraju imati 6 karaktera!");
        }

        if(!ctype_alnum($unesena_lozinka)) {
            throw new Exception("Kredencijali mogu sadržati samo slova i brojeve!");
        }
        
        $conn = new mysqli($hostname, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Greška u konekciji");
        }
        
        $result = $conn->query("SELECT * FROM radnici");
        
        $pronadjen = false;
        
        while($row = $result->fetch_assoc()) {
            if(password_verify($unesena_lozinka, $row['kredencijali'])) {
                $pronadjen = true;
                
                $_SESSION['prezime'] = $row['prezime'];
                $_SESSION['ime'] = $row['ime'];
                $_SESSION['radnik_id'] = $row['id'];
                $_SESSION['uloga'] = $row['uloga'];
                
                header("Location: pages/main.php");
                exit();
            }
        }
        
        if(!$pronadjen) {
            $greska = "Pogrešni kredencijali!";
        }
        
        $conn->close();
        
    } catch (Exception $e) {
        $greska = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="sr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Butik inventar</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header>
            <h1>Butik Inventar</h1>
            <h2></h2>
        </header>
        <main>
            <h1>Prijavljivanje</h1>
            <br><br>
            <?php if(!empty($greska)): ?>
                <p class="greska"><?php echo $greska; ?></p>
            <?php endif; ?>
            
            <form action="" method="post" class="form-group">
                <label for="kredencijali">Unesite svoje kredencijale:</label>
                <input type="password" id="kredencijali" name="kredencijali" minlength="6" maxlength="6" required>
                <br><br>
                <button type="submit" name="submit_button">Uloguj se</button>
            </form>
        <main>
    </body>
</html>