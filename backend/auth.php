<?php
// Avviamo la sessione (ci servirà per ricordare l'utente dopo il login)
session_start();

// Includiamo la connessione al database
require_once 'config.php';

// ==========================================
// 1. GESTIONE DELLA REGISTRAZIONE
// ==========================================
if (isset($_POST['registrazione'])) {
    
    $ruolo = $_POST['ruolo'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Criptiamo la password per massima sicurezza
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Iniziamo la transazione di sicurezza
        $pdo->beginTransaction();

        if ($ruolo === 'lavoratore') {
            $nome = trim($_POST['nome']);
            $cognome = trim($_POST['cognome']);

            // A. Creo le credenziali nella tabella utenti
            $stmt = $pdo->prepare("INSERT INTO utenti (email, password, ruolo) VALUES (?, ?, 'lavoratore')");
            $stmt->execute([$email, $password_hash]);
            $id_nuovo_utente = $pdo->lastInsertId(); // Prendo l'ID appena generato

            // B. Creo il profilo lavoratore collegato nelle nuove colonne separate
            $stmt_prof = $pdo->prepare("INSERT INTO profili_lavoratori (id_utente, nome, cognome) VALUES (?, ?, ?)");
            $stmt_prof->execute([$id_nuovo_utente, $nome, $cognome]);

        } elseif ($ruolo === 'azienda') {
            $ragione_sociale = trim($_POST['ragione_sociale']);
            $partita_iva = trim($_POST['partita_iva']);

            // A. Creo prima l'entità azienda globale
            $stmt_az = $pdo->prepare("INSERT INTO aziende (ragione_sociale, partita_iva) VALUES (?, ?)");
            $stmt_az->execute([$ragione_sociale, $partita_iva]);
            $id_nuova_azienda = $pdo->lastInsertId(); // Prendo l'ID dell'azienda creata

            // B. Creo l'utente recruiter collegandolo a quell'azienda
            $stmt = $pdo->prepare("INSERT INTO utenti (email, password, ruolo, id_azienda) VALUES (?, ?, 'azienda', ?)");
            $stmt->execute([$email, $password_hash, $id_nuova_azienda]);
        }

        // Se è andato tutto liscio, salviamo tutto definitivamente!
        $pdo->commit();

        // Riportiamo l'utente alla pagina di login con un messaggio di successo
        header("Location: ../index.php?msg=registrazione_ok");
        exit;

    } catch (PDOException $e) {
        // Se qualcosa va storto (es. email già usata), annulla le modifiche
        $pdo->rollBack();
        die("Errore durante la registrazione: Controlla che l'email non sia già in uso. Dettaglio tecnico: " . $e->getMessage());
    }
}

// ==========================================
// 2. GESTIONE DEL LOGIN
// ==========================================
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Cerchiamo l'utente nel database
    $stmt = $pdo->prepare("SELECT * FROM utenti WHERE email = ?");
    $stmt->execute([$email]);
    $utente = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se l'utente esiste e la password combacia con quella criptata
    if ($utente && password_verify($password, $utente['password'])) {
        
        // Salviamo il "pass" in sessione
        $_SESSION['id_utente'] = $utente['id_utente'];
        $_SESSION['ruolo'] = $utente['ruolo'];
        
        if ($utente['ruolo'] === 'azienda') {
            $_SESSION['id_azienda'] = $utente['id_azienda'];
        }
        
        // Lo mandiamo alla Bacheca
        header("Location: ../bacheca.php");
        exit;
    } else {
        // Se sbaglia, lo rimandiamo al form
        die("Credenziali errate! Torna indietro e riprova.");
    }
}
?>