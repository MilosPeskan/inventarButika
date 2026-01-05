<?php
session_start();

if(!isset($_SESSION['radnik_id'])) {
    header("Location: ../index.php");
    exit();
}

if(isset($_POST['submit_button'])){
    $lozinka = $_POST['kredencijali'];
    $ime = ucfirst($_POST['ime']);
    $prezime = ucfirst($_POST['prezime']);
    $uloga = $_POST['uloga'];
        
    include '../connections/connection.php';

    $result = $conn->query("SELECT * FROM radnici");
    $pronadjen = false;
        
    while($row = $result->fetch_assoc()) {
        if(password_verify($lozinka, $row['kredencijali'])) {
            $pronadjen = true;
            break; 
        }
    }
        
    if($pronadjen) {
        header("Location: ../pages/main.php?greska=" . urlencode("Ovi kredencijalu su već u upotrebi!"));
        exit();
    }
    $hash = password_hash($lozinka, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO radnici (ime, prezime, kredencijali, uloga) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $ime, $prezime, $hash, $uloga);
    $stmt->execute();

    header("Location: ../pages/main.php?uspeh=" . urlencode("Uspešno dodat novi radnik!"));
    exit();
}
?>