<?php
session_start();

// Se l'utente è già loggato, non ha senso che si registri di nuovo
if (isset($_SESSION['id_utente'])) {
    header("Location: bacheca.php");
    exit;
}

// Carica la grafica
require 'views/registrazione_view.php';
?>