<?php
// Avviamo la sessione
session_start();
require_once 'config.php';

// ==========================================
// 1. GESTIONE DELLA REGISTRAZIONE
// ==========================================
if (isset($_POST['registrazione'])) {
    
    $ruolo = $_POST['ruolo'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    try {
        $pdo->beginTransaction();

        if ($ruolo === 'lavoratore') {
            $nome = trim($_POST['nome']);
            $cognome = trim($_POST['cognome']);

            // 1. Creo l'utente
            $stmt = $pdo->prepare("INSERT INTO utenti (email, password, ruolo) VALUES (?, ?, 'lavoratore')");
            $stmt->execute([$email, $password_hash]);
            $id_nuovo_utente = $pdo->lastInsertId();

            // 2. Creo il profilo lavoratore
            $stmt_prof = $pdo->prepare("INSERT INTO profili_lavoratori (id_utente, nome, cognome) VALUES (?, ?, ?)");
            $stmt_prof->execute([$id_nuovo_utente, $nome, $cognome]);

        } elseif ($ruolo === 'azienda') {
            
            // 1. CREO PRIMA L'UTENTE (senza azienda per ora, la aggiorno dopo)
            $stmt_utente = $pdo->prepare("INSERT INTO utenti (email, password, ruolo) VALUES (?, ?, 'azienda')");
            $stmt_utente->execute([$email, $password_hash]);
            $id_nuovo_utente = $pdo->lastInsertId(); // ECCO L'ID CHE CI MANCAVA!

            $codice_invito = trim($_POST['codice_invito']);

            // 2. GESTISCO L'AZIENDA
            // SE L'UTENTE HA INSERITO UN CODICE INVITO (Si unisce a un'azienda esistente)
            if (!empty($codice_invito)) {
                $stmt_check = $pdo->prepare("SELECT id_azienda FROM aziende WHERE codice_invito = ?");
                $stmt_check->execute([$codice_invito]);
                $azienda_esistente = $stmt_check->fetch(PDO::FETCH_ASSOC);

                if ($azienda_esistente) {
                    $id_azienda_definitivo = $azienda_esistente['id_azienda'];
                } else {
                    throw new PDOException("Il codice invito inserito non è valido o non esiste.");
                }

            // SE CREA UNA NUOVA AZIENDA
            } else {
                $ragione_sociale = trim($_POST['ragione_sociale']);
                $partita_iva = trim($_POST['partita_iva']);
                
                // Genero solo il codice invito
                $nuovo_codice = 'AZ-' . strtoupper(substr(md5(uniqid()), 0, 6));
                
                // 3. INSERISCO L'AZIENDA USANDO L'ID_UTENTE APPENA CREATO
                $stmt_az = $pdo->prepare("INSERT INTO aziende (ragione_sociale, partita_iva, codice_invito, stato_verifica, id_utente) VALUES (?, ?, ?, 'approvata', ?)");
                $stmt_az->execute([$ragione_sociale, $partita_iva, $nuovo_codice, $id_nuovo_utente]);
                $id_azienda_definitivo = $pdo->lastInsertId(); 
            }

            // 4. AGGIORNO L'UTENTE COLLEGANDOLO ALLA SUA AZIENDA DEFINITIVA
            $stmt_update = $pdo->prepare("UPDATE utenti SET id_azienda = ? WHERE id_utente = ?");
            $stmt_update->execute([$id_azienda_definitivo, $id_nuovo_utente]);
        }

        $pdo->commit();
        // Redirect corretto alla pagina di login (prima era index.php)
        header("Location: ../login.php?msg=registrazione_ok");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Errore: " . $e->getMessage());
    }
}


?>