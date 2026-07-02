<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['id_azienda'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorizzato.']);
    exit;
}

$dati = json_decode(file_get_contents('php://input'), true);
$id_annuncio = $dati['id_annuncio'] ?? null;

try {
    $stmt = $pdo->prepare("DELETE FROM annunci_lavoro WHERE id_annuncio = ? AND id_azienda = ?");
    $stmt->execute([$id_annuncio, $_SESSION['id_azienda']]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Errore: ' . $e->getMessage()]);
}
?>