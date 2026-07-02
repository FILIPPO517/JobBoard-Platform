<?php
session_start();

// Se l'utente ha già una sessione attiva, lo rimandiamo in bacheca
if (isset($_SESSION['id_utente'])) {
    header("Location: bacheca.php");
    exit;
}

// Carica la grafica
require 'views/login_view.php';
?>