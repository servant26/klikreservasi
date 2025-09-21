<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dispursip Samarinda</title>
  <link rel="icon" href="{{ asset('dist/img/logorbg.png') }}" type="image/png">
  <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
  <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background: #ececec;
    }

    .box-area {
      width: 950px;
      max-width: 100%;
    }

    .left-box {
      min-height: 500px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 20px;
      background: linear-gradient(135deg,rgb(26, 89, 161),rgb(128, 63, 111));
    }

    .right-box {
      display: flex;
      align-items: center;
      min-height: 500px;
      padding: 40px 30px;
    }

    .zoom-hover {
      transition: transform 0.4s ease;
    }

    .zoom-hover:hover {
      transform: scale(1.05);
      filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
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

    /* Tablet (iPad Mini dll) → jadi stack (1 kolom) */
    @media (max-width: 991.98px) {
      .box-area {
        margin: 10px;
      }
      .left-box {
        border-radius: 20px 20px 0 0;
        min-height: 300px;
      }
      .right-box {
        border-radius: 0 0 20px 20px;
        padding: 30px 20px;
      }
    }

    /* HP */
    @media (max-width: 768px) {
      .featured-image img {
        width: 180px !important;
      }
      .header-text h2 {
        font-size: 22px;
      }
      .header-text p {
        font-size: 14px;
      }
      .form-control {
        font-size: 14px;
      }
      .btn {
        font-size: 14px !important;
        padding: 10px;
      }
    }

    /* HP kecil banget */
    @media (max-width: 480px) {
      .featured-image img {
        width: 140px !important;
      }
      .left-box p {
        font-size: 20px;
      }
      .left-box small {
        font-size: 12px;
      }
    }
    /* HP (jadi 1 kolom, gambar dipendekin) */
    @media (max-width: 768px) {
      .box-area {
        margin: 10px;
        flex-direction: column;
      }
      .left-box {
        height: 180px;          /* lebih pendek */
        min-height: auto;
        padding: 10px;
      }
      .left-box img {
        width: 120px !important; /* kecilin logo */
      }
      .left-box p {
        font-size: 18px;         /* kecilin teks Login */
        margin-bottom: 4px;
      }
      .left-box small {
        font-size: 12px;         /* kecilin deskripsi */
      }
      .right-box {
        min-height: auto;
        padding: 15px;
      }
      .header-text h2 {
        font-size: 20px;
      }
      .header-text p {
        font-size: 14px;
      }
      .form-control {
        font-size: 14px;
      }
      .btn {
        font-size: 14px !important;
        padding: 10px;
      }
    }

    /* HP kecil banget */
    @media (max-width: 480px) {
      .left-box {
        height: 180px;          /* makin pendek lagi */
      }
      .left-box img {
        width: 100px !important;
      }
      .left-box p {
        font-size: 16px;
      }
      .left-box small {
        font-size: 11px;
      }
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
      <!-- LEFT -->
      <div class="col-lg-6 col-12 rounded-4 left-box">
        <div class="featured-image mb-3">
          <img src="{{ asset('dist/img/logres.png') }}" class="img-fluid" style="width: 250px;">
        </div>
        <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Register</p>
        <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Buat akun untuk mengakses layanan</small>
      </div>

      <!-- RIGHT -->
      <div class="col-lg-6 col-12 right-box">
        <div class="w-100">
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
                oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Nama hanya boleh huruf!')"
                oninput="this.setCustomValidity('')" autocomplete="off">
            </div>

            <!-- Email -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              <input type="email" id="email" name="email"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Masukkan Email" required
                oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Masukkan alamat email yang valid!')"
                oninput="this.setCustomValidity('')" autocomplete="off">
            </div>

            <!-- WhatsApp -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fas fa-phone"></i></span>
              <input type="number" id="whatsapp" name="whatsapp"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Masukkan Nomor WhatsApp" required
                oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Form ini wajib diisi!' : 'Masukkan hanya angka!')"
                oninput="this.setCustomValidity('')" autocomplete="off">
            </div>

            <!-- Asal -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fas fa-building"></i></span>
              <input type="text" id="asal" name="asal"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Masukkan Asal Instansi" required
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

          <div class="text-center">
            <small>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Preview Gambar -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content bg-dark">
        <div class="modal-body text-center">
          <img id="previewImage" src="" class="img-fluid" style="max-height: 80vh;" alt="Preview">
        </div>
      </div>
    </div>
  </div>

  <script>
    function showPreview(src) {
      document.getElementById('previewImage').src = src;
    }
  </script>
</body>
</html>
