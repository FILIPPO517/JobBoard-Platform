<?php
// Attiviamo il controllo degli errori visivi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// --- FILI DA INCIAMPO PER IL DEBUG ---
// Se uno di questi blocchi fallisce, la pagina si fermerà mostrandoti l'errore esatto

if (!isset($_SESSION['id_utente'])) {
    die("<h1>Tarpa di sicurezza: 'id_utente' non è presente nella sessione!</h1>");
}

if (!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] !== 'azienda') {
    $ruolo_attuale = $_SESSION['ruolo'] ?? 'Nessuno';
    die("<h1>Targa di sicurezza: Il tuo ruolo non è 'azienda'. Ruolo rilevato: Rilevato: '$ruolo_attuale'</h1>");
}

if (!isset($_SESSION['id_azienda']) || empty($_SESSION['id_azienda'])) {
    die("<h1>Targa di sicurezza: Manca l'id_azienda nella sessione! Il sistema non sa quali annunci mostrarti.</h1>");
}



// Se il codice arriva qui, la sessione è perfetta. Carichiamo il database.
require_once 'backend/config.php';

$id_azienda = $_SESSION['id_azienda'];
$ruolo = $_SESSION['ruolo'];

try {
    // 1. Recupero il nome dell'azienda per la navbar
    $stmt_az = $pdo->prepare("SELECT ragione_sociale FROM aziende WHERE id_azienda = ?");
    $stmt_az->execute([$id_azienda]);
    $azienda = $stmt_az->fetch(PDO::FETCH_ASSOC);
    $nome_utente = $azienda['ragione_sociale'] ?? 'Azienda';

    // 2. Recupero tutti gli annunci pubblicati usando i nomi delle colonne del tuo screenshot
    $stmt_annunci = $pdo->prepare("SELECT * FROM annunci_lavoro WHERE id_azienda = ? ORDER BY data_pubblicazione DESC");
    $stmt_annunci->execute([$id_azienda]);
    $annunci = $stmt_annunci->fetchAll(PDO::FETCH_ASSOC);

    // 3. Controllo finale sulla vista
    if (!file_exists('views/miei_annunci_view.php')) {
        die("<h1>Errore: Non trovo il file grafica 'views/miei_annunci_view.php'!</h1>");
    }
    
    // Tutto è pronto, carichiamo la pagina
    require 'views/miei_annunci_view.php';

} catch (PDOException $e) {
    die("<h1>Errore del Database SQL:</h1> " . $e->getMessage());
}
?>