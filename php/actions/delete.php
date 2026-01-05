<?php
session_start();

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
        $uspesno = $repo->obrisiProizvod($id);
        
        if($uspesno) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Proizvod nije pronađen']);
        }
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