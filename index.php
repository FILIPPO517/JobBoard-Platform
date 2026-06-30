<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobBoard Platform - Accedi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Benvenuto su JobBoard</h2>
                    
                    <form action="backend/auth.php" method="POST">
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Indirizzo Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" name="login" class="btn btn-primary">Accedi</button>
                        </div>
                        
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p>Non hai ancora un account?</p>
                        <a href="registrazione.php" class="btn btn-outline-secondary">Registrati ora</a>
                    </div>
                    
                </div>
            </div>
            </div>
    </div>
</div>

</body>
</html>