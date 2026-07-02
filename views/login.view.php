<?php
session_start();
// Se l'utente ha già una sessione attiva, lo rimandiamo direttamente in bacheca
if (isset($_SESSION['id_utente'])) {
    header("Location: bacheca.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accedi a JobBoard</title>
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
        .card-custom {
            border-radius: 1.5rem;
            border: none;
        }
        .form-control, .input-group-text {
            border: 1px solid #ced4da; 
            padding: 0.75rem 1rem;
        }
        .input-group-text {
            background-color: transparent;
            border-right: none;
        }
        .form-control.border-start-0 {
            border-left: none;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="text-center mb-4 text-white">
                <i class="bi bi-rocket-takeoff-fill" style="font-size: 3rem;"></i>
                <h2 class="fw-bold mt-2 text-dark">Bentornato su JobBoard</h2>
                <p class="text-dark opacity-75">Accedi al tuo pannello di controllo</p>
            </div>

            <div class="card card-custom shadow-lg">
                <div class="card-body p-5">
                    
                    <div id="errorAlert" class="alert alert-danger d-flex align-items-center rounded-3 mb-4 d-none" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div id="errorMessage"></div>
                    </div>

                    <form id="loginForm">
                        
                        <h5 class="mb-4 fw-bold text-dark"><i class="bi bi-shield-lock me-2 text-primary"></i>Dati di Accesso</h5>

                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="es. mario@email.com" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Inserisci password" required>
                            </div>
                        </div>

                        <button type="submit" id="btnSubmit" class="btn btn-primary w-100 btn-lg fw-bold rounded-3 shadow-sm mt-3">
                            <span id="btnText">Accedi</span> <i class="bi bi-box-arrow-in-right ms-2" id="btnIcon"></i>
                        </button>
                    </form>
                </div>
                <div class="card-footer bg-white border-0 text-center py-4 rounded-bottom-4">
                    <span class="text-muted">Non hai ancora un account?</span> 
                    <a href="registrazione.php" class="text-primary fw-bold text-decoration-none ms-1">Registrati qui</a>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Blocca il ricaricamento della pagina
    
    const emailValue = document.querySelector('input[name="email"]').value;
    const passwordValue = document.querySelector('input[name="password"]').value;
    
    const errorAlert = document.getElementById('errorAlert');
    const errorMessage = document.getElementById('errorMessage');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = document.getElementById('btnText');
    const btnIcon = document.getElementById('btnIcon');

    // UI in caricamento
    errorAlert.classList.add('d-none');
    btnSubmit.disabled = true;
    btnText.innerText = "Accesso in corso...";
    btnIcon.className = "spinner-border spinner-border-sm ms-2";

    // Chiamata all'API backend
    fetch('backend/api_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: emailValue, password: passwordValue })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            btnSubmit.disabled = false;
            btnText.innerText = "Accedi";
            btnIcon.className = "bi bi-box-arrow-in-right ms-2";
            
            errorMessage.innerText = data.message;
            errorAlert.classList.remove('d-none');
        }
    })
    .catch(error => {
        console.error('Errore Fetch:', error);
        btnSubmit.disabled = false;
        btnText.innerText = "Accedi";
        btnIcon.className = "bi bi-box-arrow-in-right ms-2";
        
        errorMessage.innerText = "Si è verificato un errore di connessione.";
        errorAlert.classList.remove('d-none');
    });
});
</script>

</body>
</html>