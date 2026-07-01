<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accedi a JobBoard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h3 class="card-title text-center fw-bold text-primary mb-4">Login</h3>
                
                <?php if (isset($errore_login)): ?>
                    <div class="alert alert-danger text-center"><?php echo $errore_login; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Accedi</button>
                </form>

                <div class="mt-4 text-center">
                    <p class="mb-0">Non hai ancora un account?</p>
                    <a href="registrazione.php" class="text-primary fw-bold text-decoration-none">Registrati ora</a>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>