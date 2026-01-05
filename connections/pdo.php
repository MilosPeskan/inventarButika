<?php

function getDBConnection() {
    try {
        $db = new PDO('mysql:host=localhost;dbname=butik;charset=utf8','root','',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        return $db;
    } catch (PDOException $e) {
        die("Greška pri konekciji na bazu: " . $e->getMessage());
    }
}

?>