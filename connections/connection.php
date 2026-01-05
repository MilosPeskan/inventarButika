<?php 
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "butik";

    $conn = new mysqli($hostname, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Greška u konekciji");
    }
?>