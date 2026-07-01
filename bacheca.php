<?php
session_start();
require_once 'backend/config.php';

// Sicurezza
if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit;
}

$ruolo = $_SESSION['ruolo'];
$nome_utente = "Utente"; 
$codice_invito = null;

try {
    if ($ruolo === 'azienda') {
        $stmt = $pdo->prepare("SELECT ragione_sociale, codice_invito FROM aziende WHERE id_azienda = ?");
        $stmt->execute([$_SESSION['id_azienda']]);
        $azienda = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($azienda) {
            $nome_utente = $azienda['ragione_sociale'];
            $codice_invito = $azienda['codice_invito'];
        }
    } elseif ($ruolo === 'lavoratore') {
        $stmt = $pdo->prepare("SELECT nome, cognome FROM profili_lavoratori WHERE id_utente = ?");
        $stmt->execute([$_SESSION['id_utente']]);
        $lavoratore = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($lavoratore) {
            $nome_utente = $lavoratore['nome'] . " " . $lavoratore['cognome'];
        }
    }
} catch (PDOException $e) {
    die("Errore Database: " . $e->getMessage());
}

// Alla fine, carica la grafica passando i dati puliti
include 'views/bacheca_view.php';
?>