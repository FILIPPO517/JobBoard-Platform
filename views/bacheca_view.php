<?php
/** @var string $ruolo */
/** @var string $nome_utente */
/** @var string|null $codice_invito */
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bacheca - JobBoard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#"><i class="bi bi-briefcase-fill me-2"></i>JobBoard</a>
        <div class="d-flex align-items-center">
            <span class="navbar-text me-3 text-white">
                <i class="bi bi-person-circle me-1"></i> <?php echo htmlspecialchars($nome_utente); ?> 
                <span class="badge bg-secondary ms-1"><?php echo ucfirst($ruolo); ?></span>
            </span>
            <a href="backend/logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Esci</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <?php if ($ruolo === 'azienda'): ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0">Pannello di Controllo</h2>
                <p class="text-muted mb-0">Gestisci i tuoi annunci di lavoro.</p>
            </div>
            <a href="#" class="btn btn-primary btn-lg"><i class="bi bi-plus-circle me-2"></i>Pubblica Annuncio</a>
        </div>
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card bg-white border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3 fw-bold fs-5"><i class="bi bi-list-task me-2 text-primary"></i>I tuoi annunci</div>
                    <div class="card-body p-0 text-center p-5"><h5 class="text-muted">Nessun annuncio ancora pubblicato</h5></div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-white border-0 shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold py-3"><i class="bi bi-share me-2"></i>Team e Dipendenti</div>
                    <div class="card-body text-center p-4">
                        <p class="small text-muted mb-3">Condividi questo codice segreto:</p>
                        <div class="bg-light p-3 border rounded border-dashed mb-3 position-relative">
                            <span id="testo-codice" class="fs-2 font-monospace fw-bold text-dark"><?php echo htmlspecialchars($codice_invito); ?></span>
                            <button onclick="copiaCodice()" class="btn btn-sm btn-outline-primary position-absolute top-50 end-0 translate-middle-y me-3"><i class="bi bi-files"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($ruolo === 'lavoratore'): ?>
        <div class="card bg-white border-0 shadow-sm p-5 text-center mt-5">
            <div class="py-4">
                <i class="bi bi-rocket-takeoff-fill text-success" style="font-size: 4rem;"></i>
                <h3 class="mt-4 fw-bold">Bentornato, <?php echo htmlspecialchars($nome_utente); ?>!</h3>
                <p class="lead text-muted mx-auto">Il tuo profilo candidato è attivo. Presto potrai sfogliare gli annunci.</p>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
    function copiaCodice() {
        var testo = document.getElementById("testo-codice").innerText;
        navigator.clipboard.writeText(testo).then(() => alert("Codice copiato!"));
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>