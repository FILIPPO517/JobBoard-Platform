<?php
session_start();
require_once 'config.php';

// Diciamo al browser che risponderemo SOLO in formato JSON
header('Content-Type: application/json');

// 1. Catturiamo il JSON inviato da Javascript tramite Fetch
$inputJSON = file_get_contents('php://input');
$dati = json_decode($inputJSON, true);

// Se non ci sono dati, blocchiamo tutto
if (!$dati) {
    echo json_encode(['success' => false, 'message' => 'Nessun dato ricevuto.']);
    exit;
}

$email = trim($dati['email'] ?? '');
$password = $dati['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Compila tutti i campi.']);
    exit;
}

try {
    // 2. Controllo le credenziali nel database
    $stmt = $pdo->prepare("SELECT * FROM utenti WHERE email = ?");
    $stmt->execute([$email]);
    $utente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utente && password_verify($password, $utente['password'])) {
        // Login effettuato: salvo la sessione
        $_SESSION['id_utente'] = $utente['id_utente'];
        $_SESSION['ruolo'] = $utente['ruolo'];
        
        if ($utente['ruolo'] === 'azienda') {
            $stmtA = $pdo->prepare("SELECT id_azienda FROM aziende WHERE id_utente = ?");
            $stmtA->execute([$utente['id_utente']]);
            $_SESSION['id_azienda'] = $stmtA->fetchColumn();
        }
        
        // 3. Rispondo con un JSON di successo e dico a JS dove andare
        echo json_encode(['success' => true, 'redirect' => 'bacheca.php']);
    } else {
        // 4. Rispondo con un JSON di errore
        echo json_encode(['success' => false, 'message' => 'Email o password errati!']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Errore Server: ' . $e->getMessage()]);
}
?>