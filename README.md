<h3>Requirements (Software yang dibutuhkan)</h3>
  <ul>
    <li>Git — <a href="https://git-scm.com/downloads" target="_blank">https://git-scm.com/downloads</a></li>
    <li>PHP (pastikan sesuai <code>composer.json</code>, disarankan PHP &gt;= 8.1) — <a href="https://www.php.net/downloads.php" target="_blank">https://www.php.net/downloads.php</a></li>
    <li>Composer (PHP dependency manager) — <a href="https://getcomposer.org/download/" target="_blank">https://getcomposer.org/download/</a></li>
    <li>Node.js + npm (gunakan versi LTS, contoh Node 18) — <a href="https://nodejs.org/en/download" target="_blank">https://nodejs.org/en/download</a></li>
    <li>Database : MySQL — <a href="https://dev.mysql.com/downloads/" target="_blank">https://dev.mysql.com/downloads/</a>
    </li>
    <li>Editor : VS Code — <a href="https://code.visualstudio.com/download" target="_blank">https://code.visualstudio.com/download</a></li>
    <li>Web server : XAMPP — <a href="https://www.apachefriends.org/download.html" target="_blank">https://www.apachefriends.org/download.html</a></li>
  </ul>

  <h3>Step-by-step Setup</h3>
  <ol>
      <li>Clone repository (pastikan sudah install GIT)</li>
      <ul>PENTING!!
          <li>Pastikan posisi folder berada di main project laravel tepatnya di folder XAMPP -> htdocs -> klikreservasi -> </li>
          <li>Setelah berada di folder klikreservasi, klik kanan pada mouse, lalu pilih opsi Git Bash (pastikan Git telah terinstall)</li>
          <li>Ketikkan perintah berikut secara berurutan :</li>
          <li>git clone https://github.com/servant26/klikreservasi.git</li>
          <li>cd klikreservasi</li>
      </ul>
      <li>Install dependency PHP (masih di GIT)</li>
      <p>composer install</p>
      <li>Copy file environment</li>
      <p>cp .env.example .env <br>php artisan key:generate</p>
      <li>Siapkan Database</li>
      <p>Buat Database bernama dispursip di mysql, kemudian export file sql bernama dispursip yang terdapat pada folder bernama database<br>Ubah file env. sesuaikan dengan struktur database, <b> DB_DATABASE=dispursip<br>
DB_USERNAME=root<br>
DB_PASSWORD=</p>
      <li>Install dependency frontend</li>
          <p>npm install<br>npm run dev<br>php artisan storage:link</p>
        <li>Jalankan server laravel</li>
          <p>Buka XAMPP, klik start pada apache dan mysql, setelah statusnya nyala/start, buka folder klikreservasi, ketikkan cmd pada form folder, lalu setelah cmd terbuka, ketik php artisan serve, buka browser dan ketikkan localhost:8000 </p>
  </ol>
