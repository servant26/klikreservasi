<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan link Font Awesome untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Menyesuaikan ukuran card dan form */
        .login-card {
            width: 100%;
            max-width: 550px;  /* Lebar maksimum */
            padding: 40px;     /* Padding lebih besar */
        }
        .form-control {
            padding: 10px;     /* Padding input lebih besar */
            font-size: 1.0rem; /* Ukuran font lebih besar */
        }
        .btn {
            font-size: 1.0rem; /* Ukuran font tombol lebih besar */
        }
        /* Media query untuk smartphone */
        @media (max-width: 576px) {
            .login-card {
                padding: 30px;  /* Padding lebih kecil untuk smartphone */
            }
        }
    </style>
    <title>Login</title>
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card login-card shadow">
            <h3 class="text-center mb-4">Login</h3>
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Your Email" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Your Password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="text-center mt-3">
                <p>Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Daftar disini!</a></p>
            </div>
        </div>
    </div>
</body>
</html>
