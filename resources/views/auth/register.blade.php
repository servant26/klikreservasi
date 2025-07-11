<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <title>Dispursip Samarinda</title>
    <link rel="icon" href="{{ asset('dist/img/logorbg.png') }}" type="image/png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #ececec;
        }
        .box-area {
            width: 930px;
        }
        .right-box {
            padding: 40px 30px 40px 40px;
        }
        ::placeholder {
            font-size: 16px;
        }
        .rounded-4 {
            border-radius: 20px;
        }
        .rounded-5 {
            border-radius: 30px;
        }
        @media only screen and (max-width: 768px) {
            .box-area {
                margin: 0 10px;
            }
            .left-box {
                height: 100px;
                overflow: hidden;
            }
            .right-box {
                padding: 20px;
            }
        }
    </style>
</head>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: linear-gradient(135deg,rgb(26, 89, 161),rgb(128, 63, 111));">
                    <div class="featured-image mb-3">
                    <img src="{{ asset('dist/img/logres.png') }}" class="img-fluid" style="width: 250px;">
                    </div>
                    <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Register</p>
                    <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Buat akun untuk mengakses layanan</small>
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Buat Akun</h2>
                        <p>Silakan isi formulir di bawah ini</p>
                    </div>
                    @if ($errors->any())
                        <div class="mb-2">
                            @foreach ($errors->all() as $error)
                                <div class="bg-danger text-white px-3 py-3 rounded mb-2">
                                    {{ $error }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('register.post') }}" method="POST" autocomplete="off">
                        @csrf
                        <!-- Nama -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" id="name" name="name"
                                class="form-control form-control-lg bg-light fs-6"
                                placeholder="Masukkan Nama" required autofocus pattern="[A-Za-z\s]+"
                                value="{{ old('name') }}"
                                oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Nama hanya boleh huruf!')"
                                oninput="this.setCustomValidity('')" autocomplete="off">
                        </div>

                        <!-- Email -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" id="email" name="email"
                                class="form-control form-control-lg bg-light fs-6"
                                placeholder="Masukkan Email" required
                                value="{{ old('email') }}"
                                oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Masukkan alamat email yang valid!')"
                                oninput="this.setCustomValidity('')" autocomplete="off">
                        </div>

                        <!-- WhatsApp -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="number" id="whatsapp" name="whatsapp"
                                class="form-control form-control-lg bg-light fs-6"
                                placeholder="Masukkan Nomor WhatsApp" required
                                value="{{ old('whatsapp') }}"
                                oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Masukkan hanya angka!')"
                                oninput="this.setCustomValidity('')" autocomplete="off">
                        </div>

                        <!-- Asal -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <input type="text" id="asal" name="asal"
                                class="form-control form-control-lg bg-light fs-6"
                                placeholder="Masukkan Asal Instansi" required
                                value="{{ old('asal') }}"
                                oninvalid="this.setCustomValidity('Form ini wajib diisi!')"
                                oninput="this.setCustomValidity('')" autocomplete="off">
                        </div>

                        <!-- Password -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" id="password" name="password"
                                class="form-control form-control-lg bg-light fs-6"
                                placeholder="Masukkan Password" required minlength="8" autocomplete="new-password"
                                oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Password minimal 8 karakter!')"
                                oninput="this.setCustomValidity('')">
                        </div>

                        <!-- Tombol -->
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Daftar</button>
                        </div>
                    </form>

                    <div class="row">
                        <small>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
