<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if(!isset($_SESSION['radnik_id'])) {
    echo json_encode(['success' => false, 'message' => 'Niste ulogovani']);
    exit();
}

require_once __DIR__ . '/../../autoload.php';
require_once __DIR__ . '/../../connections/pdo.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $db = getDBConnection();
    $repo = new Repository($db);
    
    $id = intval($_POST['id']);
    
    try {
        $novaKolicina = $repo->dodajKolicinu($id);
        
        echo json_encode([
            'success' => true,
            'nova_kolicina' => $novaKolicina
        ]);
    } catch(Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nevažeći zahtev']);
}
?>