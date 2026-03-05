<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Selamat Datang - BKSDA Jateng</title>
    <link rel="icon" type="image/png" href="img/logo2.png" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .landing-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('img/gunung.jpg') no-repeat center center;
            background-size: cover;
            text-align: center;
        }
        .landing-content {
            background: rgba(255, 255, 255, 0.85);
            padding: 50px;
            border-radius: 10px;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <div class="landing-content">
            <img src="img/logo2.png" alt="Logo BKSDA Jawa Tengah" style="width: 100px; height: auto;" class="mb-4">
            <h1 class="h3 fw-bold text-primary">Selamat Datang di Website BKSDA Jawa Tengah</h1>
            <p class="mt-4">Silakan pilih cara Anda masuk:</p>
            <div class="d-grid gap-2 col-8 mx-auto mt-4">
                <a href="login.php" class="btn btn-primary btn-lg">Login Admin</a>
                <a href="index.php" class="btn btn-light btn-lg">Masuk sebagai Tamu</a>
            </div>
        </div>
    </div>
</body>
</html>