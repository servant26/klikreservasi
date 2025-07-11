<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispursip Samarinda</title>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="icon" href="{{ asset('dist/img/logoo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <style type="text/css">
    .cover {
        height: 95vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        position: relative;
        padding: 0 20px;
    }
    .navbar.fixed-top {
        z-index: 1030; /* Agar navbar tetap di atas */
        width: 100%;
    }

    /* Mengatur posisi logo dan teks */
    .navbar-brand {
        display: flex;
        align-items: center;
        margin-left: -70px; /* Jarak sedikit ke kiri untuk laptop */
    }

    /* Responsif untuk tablet & HP */
    @media (max-width: 992px) { /* Tablet */
        .navbar-brand {
            margin-left: -20px; /* Kurangi jarak agar pas */
        }
    }

    @media (max-width: 576px) { /* HP */
        .navbar-brand {
            margin-left: 0; /* Reset ke posisi normal di HP */
            font-size: 16px; /* Perkecil ukuran teks */
        }
        .navbar-brand img {
            width: 30px; /* Perkecil logo di HP */
            height: 30px;
        }
        .navbar-toggler {
            margin-right: 10px; /* Jarak tombol menu biar rapi */
        }
    }

    nav a {
        color: rgba(255, 255, 255, 0.7); /* Warna default agak redup */
        transition: color 0.7s ease-in-out; /* Transisi warna yang smooth */
    }

    nav a.active {
        color: rgba(255, 255, 255, 1); /* Warna putih terang penuh */
    }

    .navbar-nav .nav-item {
        margin-right: 50px;
    }

    .navbar-nav .nav-item:last-child {
        margin-right: -40px;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .cover-content h1 {
        font-size: 2.5rem !important;
    }

    .cover-content p {
        font-size: 1.2rem !important;
    }

    @media (max-width: 992px) { /* Tablet */
        .cover-content h1 {
            font-size: 2rem !important;
        }
        .cover-content p {
            font-size: 1rem !important;
        }
    }

    @media (max-width: 768px) { /* HP besar */
        .cover-content h1 {
            font-size: 1.8rem !important;
        }
        .cover-content p {
            font-size: 0.9rem !important;
        }
    }

    @media (max-width: 576px) { /* HP kecil */
        .cover-content h1 {
            font-size: 1.5rem !important;
        }
        .cover-content p {
            font-size: 0.82rem !important;
        }
    }

    .cover-content {
        position: relative;
        z-index: 1;
        max-width: 900px;
        text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.8);
    }

    .btn-container {
        margin-top: 10px;
    }

    .map-container {
        width: 100%;
        height: 400px;
        margin-top: 20px;
    }

    .footer {
        background-color: #24262b;
        padding: 70px 0;
    }

    .footer-col {
        width: 35%;
        padding: 0 15px;
    }

    .footer-col h4 {
        font-size: 18px;
        color: #ffffff;
        text-transform: capitalize;
        margin-bottom: 15px;
        font-weight: 500;
        position: relative;
        display: inline-block;
        padding-bottom: 5px;
    }

    .footer-col h4::after {
        content: '';
        position: absolute;
        width: 0;
        height: 3px;
        display: block;
        margin-top: 5px;
        left: 0;
        background: #e91e63;
        transition: width 0.3s ease;
    }

    .footer-col h4:hover::after {
        width: 100%;
    }

    .footer-col ul li:not(:last-child) {
        margin-bottom: 10px;
    }

    .footer-col ul li a {
        font-size: 16px;
        text-transform: capitalize;
        color: #ffffff;
        text-decoration: none;
        font-weight: 300;
        color: #bbbbbb;
        display: block;
        transition: all 0.3s ease;
    }

    .footer-col ul li a:hover {
        color: #ffffff;
        padding-left: 8px;
    }

    .footer-col .social-links a {
        display: inline-block;
        height: 40px;
        width: 40px;
        background-color: rgba(255,255,255,0.2);
        margin:0 10px 10px 0;
        text-align: center;
        line-height: 40px;
        border-radius: 50%;
        color: #ffffff;
        transition: all 0.5s ease;
    }

    .footer-col .social-links a:hover {
        color: #24262b;
        background-color: #ffffff;
    }

    @media(max-width: 767px) {
        .footer-col {
            width: 50%;
            margin-bottom: 30px;
        }
    }

    @media(max-width: 574px) {
        .footer-col {
            width: 100%;
        }
    }
    @media (max-width: 768px) { /* Untuk HP */
        .container {
            max-width: 95% !important; /* Biar nggak terlalu lebar */
        }

        .col-md-6 {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        p {
            font-size: 0.95rem; /* Biar lebih pas di layar kecil */
        }
    }
    @media (min-width: 768px) { /* Untuk Tablet dan ke atas */
        .row {
            display: flex;
            align-items: center; /* Supaya teks dan gambar sejajar */
        }

        .col-md-6 {
            min-height: 100%; /* Pastikan tinggi elemen seragam */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        img {
            height: 100%; /* Supaya gambar mengisi tinggi yang sama dengan teks */
            object-fit: cover; /* Biar gambar tetap proporsional */
        }
    }

    @media (max-width: 767px) { /* Untuk HP */
        .col-md-6 {
            text-align: center; /* Biar teks di tengah di HP */
            padding: 10px; /* Mengurangi ruang kosong */
        }

        img {
            width: 100%;
            height: auto; /* Biar gambar nggak terlalu pendek di HP */
        }
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('dist/img/logoo.png') }}" alt="Logo" width="40" height="40" class="me-2">
                Dispursip Samarinda
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" id="nav-home" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" id="nav-layanan" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" id="nav-alamat" href="#alamat">Lokasi Dinas</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Masuk</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div style="background: url('{{ asset('dist/img/cover.png') }}') no-repeat center 80% / cover;" class="cover" id="home">
        <div class="overlay"></div>
        <div class="cover-content">
            <h1>Selamat Datang di Layanan Reservasi Aula dan Kunjungan Perpustakaan</h1>
            <p style="font-size:17px">Reservasi aula dan kunjungan perpustakaan kini lebih mudah dan cepat. <br> Daftar sekarang untuk menikmati layanan kami.</p>
        </div>
    </div>

    <div id="layanan" class="container-fluid bg-dark text-white p-5">
        <div class="container vm-content col-lg-6">
            <div class="text-center">
                <p class="fs-3">Layanan</p>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <div>
                        <h2>Reservasi Aula</h2><br>
                        <p style="text-align:justify;">Layanan ini memungkinkan Anda untuk memesan aula sebagai tempat penyelenggaraan berbagai kegiatan, seperti diskusi komunitas, acara keorganisasian, kegiatan edukatif, atau aktivitas sosial lainnya yang membutuhkan ruang luas dan nyaman. Dengan fasilitas yang memadai, lingkungan yang kondusif, serta tata ruang yang fleksibel, aula ini dapat disesuaikan dengan berbagai kebutuhan acara. Kami berkomitmen untuk menyediakan tempat yang mendukung kreativitas, kolaborasi, dan interaksi yang bermanfaat bagi setiap peserta kegiatan.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-5">
                    <img src="{{ asset('dist/img/reservasi.jpg') }}" alt="Gambar" class="img-fluid">
                </div>

                <div class="col-md-6 mt-5">
                    <img src="{{ asset('dist/img/kunjungan.jpg') }}" alt="Gambar" class="img-fluid">
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <div>
                        <h2>Kunjungan Perpustakaan</h2><br>
                        <p style="text-align:justify;">Nikmati pengalaman membaca dan belajar yang lebih menyenangkan dengan layanan kunjungan perpustakaan. Temukan berbagai koleksi buku, referensi, dan materi edukatif yang dapat memperluas wawasan serta mendukung minat dan kebutuhan Anda di berbagai bidang. Dengan suasana yang tenang dan fasilitas yang nyaman, perpustakaan ini menjadi tempat ideal untuk membaca buku, melakukan riset, atau mengembangkan keterampilan literasi. Selain itu, perpustakaan ini juga dapat menjadi ruang interaktif untuk kegiatan seperti membaca bersama, bedah buku, diskusi literasi, hingga berbagi wawasan dengan komunitas yang memiliki minat serupa.</p>
                    </div>
                </div>
            </div>
        </div>  
    </div>

    <br><br><br><br>

    <div id="alamat" class="container-fluid bg-dark text-white p-5">
        <div class="container vm-content col-lg-6">
            <div class="text-center">
                <p class="fs-3">Lokasi Dinas</p>
            </div>
        </div>
    </div>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d997.3541071670327!2d117.1451101!3d-0.4904076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f1269e28361%3A0xaa136682cc338c7d!2sDinas%20Perpustakaan%20dan%20Kearsipan%20Kota%20Samarinda!5e0!3m2!1sen!2sid!4v1710769023518!5m2!1sen!2sid" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

<br><br><br><br><br><br><br>

<footer class="footer">
     <div class="container">
        <div class="row">
            <div class="footer-col">
                <h4><a class="nav-link active" href="#">Alamat Lengkap</a></h4>
                <ul>
                    <li><a href="#">Jl. Kesuma Bangsa No.5, Dadi Mulya, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur 75242</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4><a class="nav-link active" href="#">Sosial Media</a></h4>
                <div class="social-links">
                    <a href="https://www.facebook.com/dinas.perpustakaan.501?locale=id_ID" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/perpustakaankearsipan_smr/" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
     </div>
</footer>  

</body>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let sections = document.querySelectorAll("div[id]");
    let navLinks = document.querySelectorAll(".nav-link");

    function activateNav() {
        let scrollPosition = window.scrollY;

        sections.forEach(section => {
            let sectionTop = section.offsetTop - 100; // Offset biar lebih akurat
            let sectionHeight = section.offsetHeight;

            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                navLinks.forEach(link => link.classList.remove("active"));
                let activeLink = document.querySelector(`.nav-link[href="#${section.id}"]`);
                if (activeLink) {
                    activeLink.classList.add("active");
                }
            }
        });
    }

window.addEventListener("scroll", activateNav);
    activateNav(); // Panggil langsung untuk halaman yang dimuat pertama kali
});  
</script>
</html>
