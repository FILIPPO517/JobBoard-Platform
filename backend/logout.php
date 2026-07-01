<?php
// Avvia la sessione per poterla leggere
session_start();

// Rimuove tutte le variabili di sessione (distrugge i dati all'interno)
session_unset();

// Distrugge definitivamente la sessione dal server
session_destroy();

// Rimanda l'utente alla pagina di login (usiamo ../ per uscire dalla cartella backend)
header("Location: ../login.php");
exit;
?>