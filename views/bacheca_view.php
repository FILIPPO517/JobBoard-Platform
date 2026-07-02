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
    <title>Dashboard - JobBoard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .navbar { border-bottom: 1px solid #eaeaea; }
        .card-custom {
            border-radius: 1.2rem;
            border: none;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05);
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .btn-custom { border-radius: 0.5rem; padding: 0.75rem 1.5rem; }
        .badge-ruolo { font-size: 0.75rem; letter-spacing: 0.5px; }
        .invite-box {
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            border: 2px dashed #baccde;
            border-radius: 1rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4 d-flex align-items-center" href="bacheca.php">
            <i class="bi bi-rocket-takeoff-fill me-2"></i>JobBoard
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-5 me-auto">
                <?php if ($ruolo === 'azienda'): ?>
                    <li class="nav-item me-2">
                        <a class="nav-link active text-primary fw-bold" href="bacheca.php">
                            <i class="bi bi-plus-circle me-1"></i> Pubblica
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary fw-semibold" href="miei_annunci.php">
                            <i class="bi bi-list-task me-1"></i> I Miei Annunci
                        </a>
                    </li>
                <?php elseif ($ruolo === 'lavoratore'): ?>
                    <li class="nav-item">
                        <a class="nav-link active text-primary fw-bold" href="bacheca.php">
                            <i class="bi bi-house me-1"></i> Home
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            
            <div class="d-flex align-items-center mt-3 mt-lg-0">
                <div class="me-4 text-end d-none d-lg-block">
                    <div class="fw-bold text-dark lh-1"><?php echo htmlspecialchars($nome_utente); ?></div>
                    <span class="badge bg-primary bg-opacity-10 text-primary text-uppercase badge-ruolo mt-1">
                        <?php echo htmlspecialchars($ruolo); ?>
                    </span>
                </div>
                <a href="backend/logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold">
                    <i class="bi bi-box-arrow-right me-1"></i> Esci
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <?php if ($ruolo === 'azienda'): ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0">Dashboard Aziendale</h2>
                <p class="text-muted mb-0">Pubblica nuove offerte e fai crescere il tuo team.</p>
            </div>
        </div>
        
        <div id="apiAlert" class="alert d-none rounded-4 border-0 shadow-sm mb-4" role="alert"></div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card card-custom h-100">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Crea un nuovo Annuncio</h5>
                    </div>
                    <div class="card-body p-4">
                        <form id="formPubblica">
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Titolo della posizione</label>
                                <input type="text" class="form-control" name="titolo" placeholder="Es. Sviluppatore Web, HR Specialist..." required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Descrizione completa</label>
                                <textarea class="form-control" name="descrizione" rows="5" placeholder="Descrivi il ruolo..." required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Contratto</label>
                                    <select class="form-select" name="contratto">
                                        <option value="Indeterminato">Tempo Indeterminato</option>
                                        <option value="Determinato">Tempo Determinato</option>
                                        <option value="Stage">Stage / Tirocinio</option>
                                        <option value="Partita IVA">Partita IVA / Freelance</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-muted small fw-bold text-uppercase">RAL (Opzionale)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-currency-euro"></i></span>
                                        <input type="text" class="form-control border-start-0" name="ral" placeholder="Es. 25.000 - 30.000">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" id="btnPubblica" class="btn btn-primary btn-custom w-100 fw-bold fs-5 mt-2 shadow-sm">
                                <i class="bi bi-send-fill me-2"></i>Pubblica Annuncio
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card card-custom bg-white border-0">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 60px; height: 60px;">
                                <i class="bi bi-people-fill fs-2"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Il tuo Team</h5>
                        <p class="text-muted small mb-4">Condividi questo codice segreto con i tuoi colleghi recruiter per farli unire alla tua azienda.</p>
                        
                        <div class="invite-box p-4 position-relative">
                            <span class="d-block text-secondary small fw-bold text-uppercase mb-2">Codice Azienda</span>
                            <span id="testo-codice" class="fs-3 font-monospace fw-bold text-primary"><?php echo htmlspecialchars($codice_invito ?? ''); ?></span>
                            
                            <button onclick="copiaCodice()" class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 m-3 shadow" style="width: 35px; height: 35px;" title="Copia codice">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($ruolo === 'lavoratore'): ?>
        <div class="card card-custom p-5 text-center mt-4">
            <div class="py-5">
                <i class="bi bi-rocket-takeoff text-primary opacity-75" style="font-size: 5rem;"></i>
                <h2 class="mt-4 fw-bold text-dark">Bentornato, <?php echo htmlspecialchars($nome_utente); ?>!</h2>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">Il tuo profilo candidato è attivo e pronto.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Copia Codice Appunti
function copiaCodice() {
    var testo = document.getElementById("testo-codice").innerText;
    navigator.clipboard.writeText(testo).then(() => alert("Codice copiato!"));
}

// Chiamata FETCH per la pubblicazione
document.getElementById('formPubblica')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnPubblica');
    const alertBox = document.getElementById('apiAlert');
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Pubblicazione...';

    const dati = Object.fromEntries(new FormData(this).entries());

    fetch('backend/api_pubblica.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dati)
    })
    .then(res => res.json())
    .then(data => {
        alertBox.classList.remove('d-none', 'alert-danger', 'alert-success');
        if(data.success) {
            alertBox.classList.add('alert-success');
            alertBox.innerHTML = '<i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i> <strong>Successo!</strong> ' + data.message;
            this.reset();
        } else {
            alertBox.classList.add('alert-danger');
            alertBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i> <strong>Errore:</strong> ' + data.message;
        }
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-send-fill me-2"></i>Pubblica Annuncio';
    })
    .catch(error => {
        alertBox.classList.remove('d-none', 'alert-success');
        alertBox.classList.add('alert-danger');
        alertBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i> Errore di connessione.';
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-send-fill me-2"></i>Pubblica Annuncio';
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>