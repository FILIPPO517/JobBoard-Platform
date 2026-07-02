<?php
/** @var string $ruolo */
/** @var string $nome_utente */
/** @var array $annunci */
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I Miei Annunci - JobBoard</title>
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
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-custom.card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
        }
        .btn-custom { border-radius: 0.5rem; padding: 0.5rem 1.25rem; }
        .badge-ruolo { font-size: 0.75rem; letter-spacing: 0.5px; }
        .badge-tag { font-weight: 600; padding: 0.5em 0.8em; border-radius: 0.4rem; }
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
                <li class="nav-item me-2">
                    <a class="nav-link text-secondary fw-semibold hover-primary" href="bacheca.php">
                        <i class="bi bi-plus-circle me-1"></i> Pubblica
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-primary fw-bold" href="miei_annunci.php">
                        <i class="bi bi-list-task me-1"></i> I Miei Annunci
                    </a>
                </li>
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
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark m-0">Storico Annunci</h2>
            <p class="text-muted mb-0">Gestisci le posizioni attualmente aperte dalla tua azienda.</p>
        </div>
        <a href="bacheca.php" class="btn btn-primary btn-custom fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Nuovo Annuncio
        </a>
    </div>

    <div class="row" id="grigliaAnnunci">
        <?php if (empty($annunci)): ?>
            <div class="col-12" id="messaggioVuoto">
                <div class="card card-custom bg-white text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-inbox text-muted opacity-50 d-block mb-3" style="font-size: 4rem;"></i>
                        <h4 class="fw-bold text-dark">Nessun annuncio pubblicato</h4>
                        <p class="text-muted mb-4">Non hai ancora inserito nessuna offerta di lavoro nel database.</p>
                        <a href="bacheca.php" class="btn btn-outline-primary btn-custom fw-bold">Pubblica il tuo primo annuncio</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            
            <?php foreach ($annunci as $annuncio): ?>
                <div class="col-md-6 mb-4" id="card-<?php echo $annuncio['id_annuncio']; ?>">
                    <div class="card card-custom card-hover h-100 d-flex flex-column">
                        <div class="card-body p-4">
                            <h4 class="card-title fw-bold text-dark mb-3"><?php echo htmlspecialchars($annuncio['titolo_annuncio']); ?></h4>
                            
                            <div class="mb-3 d-flex flex-wrap gap-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary badge-tag">
                                    <i class="bi bi-briefcase me-1"></i> <?php echo htmlspecialchars($annuncio['tipo_contratto']); ?>
                                </span>
                                <?php if (!empty($annuncio['ral_offerta'])): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success badge-tag">
                                        <i class="bi bi-cash-stack me-1"></i> RAL: <?php echo htmlspecialchars($annuncio['ral_offerta']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="card-text text-muted mb-0" style="font-size: 0.95rem;">
                                <?php echo nl2br(htmlspecialchars(substr($annuncio['descrizione_ruolo'], 0, 160))) . '...'; ?>
                            </p>
                        </div>
                        
                        <div class="card-footer bg-transparent border-top mt-auto p-4 d-flex justify-content-between align-items-center">
                            <span class="text-muted small fw-semibold">
                                <i class="bi bi-calendar3 me-1"></i> Pubblicato il <?php echo date('d/m/Y', strtotime($annuncio['data_pubblicazione'])); ?>
                            </span>
                            <button onclick="eliminaAnnuncio(<?php echo $annuncio['id_annuncio']; ?>)" class="btn btn-outline-danger btn-sm fw-bold rounded-pill px-3">
                                <i class="bi bi-trash3 me-1"></i> Elimina
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>

<script>
// Logica FETCH API per Eliminare
function eliminaAnnuncio(id) {
    if(!confirm('Sei sicuro di voler eliminare definitivamente questo annuncio?')) return;

    fetch('backend/api_elimina.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_annuncio: id })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            // Effetto magia: rimuoviamo la card con un'animazione
            const card = document.getElementById('card-' + id);
            card.style.transition = "opacity 0.3s ease";
            card.style.opacity = "0";
            setTimeout(() => card.remove(), 300);
        } else {
            alert('Errore: ' + data.message);
        }
    })
    .catch(err => alert("Errore di connessione al server."));
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>