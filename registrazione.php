<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione - JobBoard Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Crea un nuovo account</h2>

                    <form action="backend/auth.php" method="POST">
                        
                        <div class="mb-4 text-center">
                            <label class="form-label fw-bold d-block">Seleziona il tuo ruolo:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ruolo" id="ruolo_lavoratore" value="lavoratore" checked onchange="toggleCampi()">
                                <label class="form-check-label" for="ruolo_lavoratore">Candidato (Lavoratore)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ruolo" id="ruolo_azienda" value="azienda" onchange="toggleCampi()">
                                <label class="form-check-label" for="ruolo_azienda">Recruiter (Azienda)</label>
                            </div>
                        </div>

                        <h5 class="mb-3 border-bottom pb-2">Credenziali di Accesso</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Indirizzo Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>

                        <div id="campi_lavoratore">
                            <h5 class="mb-3 border-bottom pb-2 mt-3">Dati Personali</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cognome" class="form-label">Cognome</label>
                                    <input type="text" class="form-control" id="cognome" name="cognome">
                                </div>
                            </div>
                        </div>

                        <div id="campi_azienda" style="display: none;">
                            <h5 class="mb-3 border-bottom pb-2 mt-3">Dati Aziendali</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ragione_sociale" class="form-label">Ragione Sociale</label>
                                    <input type="text" class="form-control" id="ragione_sociale" name="ragione_sociale">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="partita_iva" class="form-label">Partita IVA</label>
                                    <input type="text" class="form-control" id="partita_iva" name="partita_iva">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" name="registrazione" class="btn btn-success btn-lg">Registrati</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="index.php" class="text-decoration-none">Hai già un account? Accedi qui</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleCampi() {
        var isLavoratore = document.getElementById('ruolo_lavoratore').checked;
        var campiLavoratore = document.getElementById('campi_lavoratore');
        var campiAzienda = document.getElementById('campi_azienda');

        if (isLavoratore) {
            campiLavoratore.style.display = 'block';
            campiAzienda.style.display = 'none';
        } else {
            campiLavoratore.style.display = 'none';
            campiAzienda.style.display = 'block';
        }
    }
</script>

</body>
</html>