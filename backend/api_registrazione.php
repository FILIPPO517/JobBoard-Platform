<?php
require_once 'config.php';

// Comunichiamo solo in formato JSON
header('Content-Type: application/json');

// Riceviamo i dati da Javascript
$inputJSON = file_get_contents('php://input');
$dati = json_decode($inputJSON, true);

if (!$dati) {
    echo json_encode(['success' => false, 'message' => 'Nessun dato ricevuto.']);
    exit;
}

$ruolo = $dati['ruolo'] ?? '';
$email = trim($dati['email'] ?? '');
$password = $dati['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email e Password sono obbligatori.']);
    exit;
}

try {
    // 1. Controlliamo se l'email esiste già
    $stmt = $pdo->prepare("SELECT id_utente FROM utenti WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Questa email è già registrata.']);
        exit;
    }

    // 2. Inseriamo l'utente generico
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmtUser = $pdo->prepare("INSERT INTO utenti (email, password, ruolo) VALUES (?, ?, ?)");
    $stmtUser->execute([$email, $password_hash, $ruolo]);
    $id_utente = $pdo->lastInsertId();

    // 3. Inseriamo i dati specifici in base al ruolo
    if ($ruolo === 'lavoratore') {
        $nome = $dati['nome'] ?? '';
        $cognome = $dati['cognome'] ?? '';
        
        $stmtLav = $pdo->prepare("INSERT INTO lavoratori (id_utente, nome, cognome) VALUES (?, ?, ?)");
        $stmtLav->execute([$id_utente, $nome, $cognome]);

    } elseif ($ruolo === 'azienda') {
        $ragione_sociale = $dati['ragione_sociale'] ?? '';
        $partita_iva = $dati['partita_iva'] ?? '';
        $codice_invito = $dati['codice_invito'] ?? ''; // Puoi gestire la logica dell'invito qui
        
        $stmtAz = $pdo->prepare("INSERT INTO aziende (id_utente, ragione_sociale, partita_iva) VALUES (?, ?, ?)");
        $stmtAz->execute([$id_utente, $ragione_sociale, $partita_iva]);
    }

    // Risposta di successo
    echo json_encode(['success' => true, 'redirect' => 'login.php']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Errore Server: ' . $e->getMessage()]);
}
?>