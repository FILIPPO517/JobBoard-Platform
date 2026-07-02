<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['id_azienda'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorizzato.']);
    exit;
}

$dati = json_decode(file_get_contents('php://input'), true);

try {
    $stmt = $pdo->prepare("INSERT INTO annunci_lavoro (id_azienda, titolo_annuncio, descrizione_ruolo, tipo_contratto, ral_offerta, data_pubblicazione) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([
        $_SESSION['id_azienda'],
        $dati['titolo'],
        $dati['descrizione'],
        $dati['contratto'],
        $dati['ral']
    ]);
    
    echo json_encode(['success' => true, 'message' => 'Annuncio pubblicato con successo!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Errore: ' . $e->getMessage()]);
}
?>