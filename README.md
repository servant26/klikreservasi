<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Setup - klikreservasi (README)</title>
  <style>
    body{font-family:system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;line-height:1.6;color:#111;padding:24px;max-width:900px;margin:auto}
    a{color:#0366d6}
    h3{margin-top:1.2rem;border-left:4px solid #e1e4e8;padding-left:10px}
    h4{margin-top:1rem;color:#333}
    ul, ol{margin-left:1.2rem}
    pre{background:#f6f8fa;padding:12px;border-radius:6px;overflow:auto}
    code{font-family:SFMono-Regular, Menlo, Monaco, 'Courier New', monospace;font-size:0.95em}
    .links small{display:block;margin-top:4px;color:#555}
  </style>
</head>
<body>
  <h3>Requirements (Software yang dibutuhkan)</h3>
  <ul>
    <li>Git — <a href="https://git-scm.com/downloads" target="_blank">https://git-scm.com/downloads</a></li>
    <li>PHP (pastikan sesuai <code>composer.json</code>, disarankan PHP &gt;= 8.1) — <a href="https://www.php.net/downloads.php" target="_blank">https://www.php.net/downloads.php</a></li>
    <li>Composer (PHP dependency manager) — <a href="https://getcomposer.org/download/" target="_blank">https://getcomposer.org/download/</a></li>
    <li>Node.js + npm (gunakan versi LTS, contoh Node 18) — <a href="https://nodejs.org/en/download" target="_blank">https://nodejs.org/en/download</a></li>
    <li>Database (MySQL atau MariaDB):
      <ul>
        <li>MySQL — <a href="https://dev.mysql.com/downloads/" target="_blank">https://dev.mysql.com/downloads/</a></li>
        <li>MariaDB — <a href="https://mariadb.org/download/" target="_blank">https://mariadb.org/download/</a></li>
      </ul>
    </li>
    <li>Editor (opsional): VS Code — <a href="https://code.visualstudio.com/download" target="_blank">https://code.visualstudio.com/download</a></li>
    <li>Web server (opsional): XAMPP — <a href="https://www.apachefriends.org/download.html" target="_blank">https://www.apachefriends.org/download.html</a> atau Laragon — <a href="https://laragon.org/download/index.html" target="_blank">https://laragon.org/download/index.html</a></li>
  </ul>

  <h3>Step-by-step Setup</h3>
  <ol>
    <li>
      <h4>Clone repository</h4>
      <pre><code>git clone https://github.com/servant26/klikreservasi.git
cd klikreservasi</code></pre>
    </li>

    <li>
      <h4>Install dependency PHP</h4>
      <pre><code>composer install</code></pre>
    </li>

    <li>
      <h4>Copy file environment & generate app key</h4>
      <pre><code>cp .env.example .env   # Windows: copy .env.example .env
php artisan key:generate</code></pre>
      <p>Setelah itu edit <code>.env</code> untuk mengatur koneksi database dan variabel lain (APP_URL, MAIL_*, dsb).</p>
    </li>

    <li>
      <h4>Setup database</h4>
      <p>Buat database (contoh nama: <code>klikreservasi</code>) lalu ubah konfigurasi DB di <code>.env</code>:</p>
      <pre><code>DB_DATABASE=klikreservasi
DB_USERNAME=root
DB_PASSWORD=yourpassword</code></pre>
    </li>

    <li>
      <h4>Run migrations & seed (jika ada)</h4>
      <pre><code>php artisan migrate --seed</code></pre>
    </li>

    <li>
      <h4>Install frontend dependencies & build assets</h4>
      <pre><code>npm install
npm run dev   # atau npm run production untuk build produksi</code></pre>
    </li>

    <li>
      <h4>Buat symlink storage (jika perlu)</h4>
      <pre><code>php artisan storage:link</code></pre>
    </li>

    <li>
      <h4>Set permission (Linux/Mac)</h4>
      <pre><code>chmod -R 775 storage bootstrap/cache
# atau
chown -R $USER:www-data storage bootstrap/cache</code></pre>
    </li>

    <li>
      <h4>Jalankan aplikasi</h4>
      <pre><code>php artisan serve
# lalu buka http://127.0.0.1:8000</code></pre>
    </li>
  </ol>

  <h3>Quick Checklist (copy-paste)</h3>
  <pre><code>git clone https://github.com/servant26/klikreservasi.git
cd klikreservasi
composer install
cp .env.example .env
php artisan key:generate
# edit .env -> isi DB
php artisan migrate --seed
npm install
npm run dev
php artisan storage:link
php artisan serve</code></pre>

  <h3>Troubleshooting singkat</h3>
  <ul>
    <li><strong>Composer memory error</strong> — jalankan: <code>COMPOSER_MEMORY_LIMIT=-1 composer install</code></li>
    <li><strong>Versi PHP tidak kompatibel</strong> — periksa <code>composer.json</code> & install versi PHP yang sesuai</li>
    <li><strong>npm build error</strong> — gunakan Node.js versi LTS (mis. 18) atau periksa <code>package.json</code></li>
    <li><strong>Gagal migrasi</strong> — periksa kredensial DB, hak akses, dan versi database</li>
  </ul>

  <p class="links">Butuh README.md versi Markdown juga? Saya bisa konversi HTML ini langsung ke Markdown atau buatkan file <code>README.md</code> siap pakai. Beri tahu saya pilihannya.</p>
</body>
</html>
