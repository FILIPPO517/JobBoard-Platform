<?php
require_once 'backend/config.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Conferma Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="text-center p-5 bg-white shadow-sm rounded">
        <?php
        if (isset($_GET['token'])) {
            $token = $_GET['token'];

            // 1. Cerco se esiste un'azienda in attesa con questo token
            $stmt = $pdo->prepare("SELECT id_azienda FROM aziende WHERE token_verifica = ? AND stato_verifica = 'in_attesa'");
            $stmt->execute([$token]);
            $azienda = $stmt->fetch();

            if ($azienda) {
                // 2. Se la trovo, l'approvo e cancello il token (per non farlo usare 2 volte)
                $stmt_update = $pdo->prepare("UPDATE aziende SET stato_verifica = 'approvata', token_verifica = NULL WHERE id_azienda = ?");
                $stmt_update->execute([$azienda['id_azienda']]);

                echo "<h1 class='text-success mb-3'>Email confermata! 🎉</h1>";
                echo "<p class='lead'>L'account aziendale è stato verificato ed è ora attivo.</p>";
                echo "<a href='index.php' class='btn btn-primary mt-3'>Vai al Login / Bacheca</a>";
            } else {
                echo "<h1 class='text-danger mb-3'>Errore</h1>";
                echo "<p>Il link non è valido, è scaduto oppure l'azienda è già stata verificata.</p>";
                echo "<a href='index.php' class='btn btn-secondary mt-3'>Torna alla Home</a>";
            }
        } else {
            echo "<h1>Nessun codice fornito.</h1>";
        }
        ?>
    </div>
</body>
</html>