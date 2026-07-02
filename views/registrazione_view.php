<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione - JobBoard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
        .card-custom { border-radius: 1.5rem; border: none; }
        .form-control { border: 1px solid #ced4da; padding: 0.75rem 1rem; }
        .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15); }
        .btn-group .btn { border-radius: 0.5rem !important; margin: 0 0.25rem; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            
            <div class="text-center mb-4 text-white">
                <i class="bi bi-rocket-takeoff-fill" style="font-size: 3rem;"></i>
                <h2 class="fw-bold mt-2 text-dark">Unisciti a JobBoard</h2>
                <p class="text-dark opacity-75">Crea il tuo account in pochi secondi</p>
            </div>

            <div class="card card-custom shadow-lg">
                <div class="card-body p-5">

                    <div id="statusAlert" class="alert d-flex align-items-center rounded-3 mb-4 d-none" role="alert">
                        <i id="statusIcon" class="bi me-2"></i>
                        <div id="statusMessage"></div>
                    </div>

                    <form id="registerForm">
                        
                        <div class="mb-4 text-center">
                            <label class="form-label fw-bold text-secondary small text-uppercase mb-3">Scegli il tuo ruolo</label>
                            <div class="btn-group w-100 d-flex" role="group">
                                <input type="radio" class="btn-check" name="ruolo" id="ruolo_lavoratore" value="lavoratore" checked onchange="toggleCampi()">
                                <label class="btn btn-outline-primary py-2 fw-bold flex-fill" for="ruolo_lavoratore">
                                    <i class="bi bi-person-badge me-2"></i>Candidato
                                </label>

                                <input type="radio" class="btn-check" name="ruolo" id="ruolo_azienda" value="azienda" onchange="toggleCampi()">
                                <label class="btn btn-outline-primary py-2 fw-bold flex-fill" for="ruolo_azienda">
                                    <i class="bi bi-building me-2"></i>Azienda
                                </label>
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        <h5 class="mb-3 fw-bold text-dark"><i class="bi bi-shield-lock me-2 text-primary"></i>Dati di Accesso</h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label text-muted small fw-bold">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div id="campi_lavoratore">
                            <h5 class="mb-3 fw-bold text-dark"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Dati Personali</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small fw-bold">Nome</label>
                                    <input type="text" class="form-control" name="nome">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small fw-bold">Cognome</label>
                                    <input type="text" class="form-control" name="cognome">
                                </div>
                            </div>
                        </div>

                        <div id="campi_azienda" style="display: none;">
                            <h5 class="mb-3 fw-bold text-dark"><i class="bi bi-shop-window me-2 text-primary"></i>Dati Aziendali</h5>
                            <div class="mb-4">
                                <label class="form-label text-primary fw-bold small">Codice Invito (Opzionale)</label>
                                <input type="text" class="form-control border-primary" name="codice_invito">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small fw-bold">Ragione Sociale</label>
                                    <input type="text" class="form-control" name="ragione_sociale">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small fw-bold">Partita IVA</label>
                                    <input type="text" class="form-control" name="partita_iva">
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="btnSubmit" class="btn btn-primary w-100 btn-lg fw-bold rounded-3 shadow-sm mt-4">
                            <span id="btnText">Crea Account</span> <i class="bi bi-arrow-right ms-2" id="btnIcon"></i>
                        </button>
                    </form>

                </div>
                <div class="card-footer bg-white border-0 text-center py-4 rounded-bottom-4">
                    <span class="text-muted">Hai già un account?</span> 
                    <a href="login.php" class="text-primary fw-bold text-decoration-none ms-1">Accedi qui</a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Mostra/Nascondi i campi
    function toggleCampi() {
        var isLavoratore = document.getElementById('ruolo_lavoratore').checked;
        document.getElementById('campi_lavoratore').style.display = isLavoratore ? 'block' : 'none';
        document.getElementById('campi_azienda').style.display = isLavoratore ? 'none' : 'block';
    }

    // Gestione della form tramite Fetch API (AJAX)
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault(); 
        
        const btnSubmit = document.getElementById('btnSubmit');
        const btnText = document.getElementById('btnText');
        const statusAlert = document.getElementById('statusAlert');
        const statusMessage = document.getElementById('statusMessage');
        const statusIcon = document.getElementById('statusIcon');

        // Raccogliamo i dati dinamicamente
        const formData = new FormData(this);
        const dataJson = Object.fromEntries(formData.entries());

        // UI Loading
        statusAlert.classList.add('d-none');
        btnSubmit.disabled = true;
        btnText.innerText = "Creazione in corso...";

        fetch('backend/api_registrazione.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dataJson)
        })
        .then(response => response.json())
        .then(data => {
            statusAlert.classList.remove('d-none');
            if (data.success) {
                // Successo: lo facciamo diventare verde
                statusAlert.className = "alert alert-success d-flex align-items-center rounded-3 mb-4";
                statusIcon.className = "bi bi-check-circle-fill me-2";
                statusMessage.innerText = "Registrazione completata! Reindirizzamento al login...";
                
                // Redirezione automatica dopo 2 secondi
                setTimeout(() => window.location.href = data.redirect, 2000);
            } else {
                // Errore: torna rosso e riabilita il bottone
                statusAlert.className = "alert alert-danger d-flex align-items-center rounded-3 mb-4";
                statusIcon.className = "bi bi-exclamation-triangle-fill me-2";
                statusMessage.innerText = data.message;
                
                btnSubmit.disabled = false;
                btnText.innerText = "Crea Account";
            }
        })
        .catch(error => {
            console.error('Errore:', error);
            statusAlert.className = "alert alert-danger d-flex align-items-center rounded-3 mb-4";
            statusMessage.innerText = "Errore di connessione al server.";
            statusAlert.classList.remove('d-none');
            btnSubmit.disabled = false;
            btnText.innerText = "Crea Account";
        });
    });
</script>

</body>
</html>