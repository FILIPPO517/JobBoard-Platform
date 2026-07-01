<?php
session_start();
require_once 'backend/config.php';

// Se sei già loggato, vai in bacheca
if (isset($_SESSION['id_utente'])) {
    header("Location: bacheca.php");
    exit;
}

// Se l'utente ha premuto "Accedi"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM utenti WHERE email = ?");
        $stmt->execute([$email]);
        $utente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utente && password_verify($password, $utente['password'])) {
            $_SESSION['id_utente'] = $utente['id_utente'];
            $_SESSION['ruolo'] = $utente['ruolo'];
            
            if ($utente['ruolo'] === 'azienda') {
                $stmtA = $pdo->prepare("SELECT id_azienda FROM aziende WHERE id_utente = ?");
                $stmtA->execute([$utente['id_utente']]);
                $_SESSION['id_azienda'] = $stmtA->fetchColumn();
            }
            
            header("Location: bacheca.php");
            exit;
        } else {
            $errore_login = "Email o password errati!";
        }
    } catch (PDOException $e) {
        die("Errore Database: " . $e->getMessage());
    }
}

// Alla fine, carica la grafica del login
include 'views/login_view.php';
?>