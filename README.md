# SiJurusan - Sistem Pakar Rekomendasi Jurusan PTN
### Metode Dempster-Shafer | SMA Muhammadiyah 18 Sunggal

Sistem pakar berbasis web (PHP Native MVC) untuk membantu siswa menentukan
jurusan Perguruan Tinggi Negeri yang sesuai menggunakan penalaran
ketidakpastian Metode Dempster-Shafer.

---

## 📋 Kebutuhan Sistem

- XAMPP (PHP >= 8.0, MySQL/MariaDB, Apache) — [Unduh di sini](https://www.apachefriends.org/)
- Composer (opsional, untuk fitur export PDF) — [Unduh di sini](https://getcomposer.org/)
- Browser modern (Chrome, Firefox, Edge)

---

## 🚀 Langkah Instalasi

### 1. Salin Proyek ke Folder htdocs

Salin seluruh folder `sipakar-jurusan` ke dalam:
```
C:\xampp\htdocs\sipakar-jurusan
```

### 2. Aktifkan Apache & MySQL

Buka **XAMPP Control Panel**, lalu klik **Start** pada modul `Apache` dan `MySQL`.

### 3. Buat Database

1. Buka `http://localhost/phpmyadmin`
2. Klik **New**, tidak perlu membuat database manual — cukup import file SQL berikut,
   karena file sudah berisi perintah `CREATE DATABASE IF NOT EXISTS`.
3. Klik tab **Import**, pilih file:
   ```
   database/install_full.sql
   ```
   File ini sudah berisi struktur tabel **dan** seed data (13 fakultas, 50 jurusan,
   250 evidence, 250 pertanyaan, 250 aturan basis pengetahuan).
4. Klik **Go** dan tunggu hingga proses import selesai.

> Jika ingin men-generate ulang seed data (misalnya setelah mengubah
> `database/generate_seed.php`), jalankan dari terminal:
> ```
> php database/generate_seed.php
> ```
> lalu import ulang `database/sipakar_jurusan.sql` + `database/seed_data.sql`.

### 4. Sesuaikan Konfigurasi

Buka `config/database.php` dan sesuaikan jika kredensial database Anda berbeda
dari default XAMPP (`root` tanpa password):

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'sipakar_jurusan');
define('DB_USER', 'root');
define('DB_PASS', '');
```

Buka `config/config.php` dan sesuaikan `BASE_URL` jika nama folder proyek Anda
berbeda dari `sipakar-jurusan`:

```php
define('BASE_URL', 'http://localhost/sipakar-jurusan/');
```

### 5. (Opsional) Instal Dependency untuk Export PDF & Email

Fitur export PDF menggunakan **DomPDF**, dan notifikasi email menggunakan
**PHPMailer**. Jika Composer sudah terpasang, jalankan di root proyek:

```bash
composer install
```

Jika Composer belum terpasang, sistem tetap berjalan normal:
- Fitur "Unduh PDF" otomatis menampilkan versi HTML siap cetak (fallback).
- Fitur notifikasi email otomatis dilewati tanpa error (dicatat ke error log).

#### Mengaktifkan Notifikasi Email (Opsional)

1. Login sebagai admin, buka menu **Pengaturan**.
2. Isi kredensial SMTP (contoh untuk Gmail: host `smtp.gmail.com`, port `587`,
   enkripsi `TLS`, username = email Anda, password = **App Password** Gmail
   — bukan password akun biasa).
3. Aktifkan toggle **"Aktifkan Notifikasi Email"**.
4. Setelah aktif, sistem otomatis mengirim:
   - Email selamat datang saat siswa berhasil mendaftar.
   - Email ringkasan hasil saat konsultasi selesai (jika siswa login, atau
     tamu mengisi kolom email opsional saat konsultasi).

### 6. Akses Aplikasi

- **Website Utama**: `http://localhost/sipakar-jurusan/`
- **Login Admin**: `http://localhost/sipakar-jurusan/auth/adminLogin`
  - Username: `admin`
  - Password: `admin123`

  ⚠️ **Segera ganti password default ini setelah login pertama kali**
  melalui menu Master Admin.

---

## 🗂️ Struktur Folder

```
sipakar-jurusan/
├── admin/                  (reserved - dashboard admin lewat routing MVC)
├── assets/
│   ├── css/                 style.css, admin.css
│   ├── js/                  main.js
│   ├── img/                 logo, favicon
│   └── uploads/              file upload (fakultas, jurusan, siswa, dst)
├── config/                  config.php, database.php
├── controllers/              seluruh Controller (Home, Admin*, Auth, dst)
├── core/                    Router, Database, Controller, Model, DempsterShafer
├── database/
│   ├── sipakar_jurusan.sql   struktur database
│   ├── seed_data.sql         data awal (fakultas, jurusan, dst)
│   ├── install_full.sql      gabungan struktur + seed (untuk import cepat)
│   └── generate_seed.php     generator seed data
├── helpers/                 functions.php, PdfExporter.php
├── models/                  seluruh Model
├── views/                   seluruh tampilan (home, admin, auth, dst)
├── vendor/                  dependency composer (setelah composer install)
├── .htaccess
├── composer.json
└── index.php                 front controller
```

---

## 🧠 Cara Kerja Metode Dempster-Shafer di Sistem Ini

1. Setiap **pertanyaan** terhubung ke satu **evidence** (bukti).
2. Setiap **evidence** dapat mendukung beberapa **jurusan** sekaligus,
   masing-masing dengan **nilai belief** (0–1) yang dapat diatur admin
   melalui menu **Basis Pengetahuan**.
3. Saat siswa menjawab "Ya" pada suatu pertanyaan, evidence terkait dianggap aktif.
4. Sistem mengombinasikan seluruh evidence aktif secara berurutan menggunakan
   **Dempster's Rule of Combination**:

   ```
   m3(Z) = [ Σ m1(X)·m2(Y) untuk X∩Y=Z ] / (1 - K)
   K (konflik) = Σ m1(X)·m2(Y) untuk X∩Y=∅
   ```

5. Seluruh langkah kombinasi (m1, m2, kombinasi, konflik, normalisasi) dicatat
   ke tabel `langkah_perhitungan` dan ditampilkan transparan di halaman hasil.
6. Jurusan dengan nilai **belief** akhir tertinggi menjadi rekomendasi utama.

---

## 🔐 Catatan Keamanan

- Seluruh query menggunakan **PDO Prepared Statement** (anti SQL Injection).
- Password disimpan dengan **bcrypt hash**.
- Seluruh form dilindungi **CSRF Token**.
- Input pengguna disaring lewat fungsi `clean()` (anti XSS).
- File `.sql`, `.log`, `.env` diblokir aksesnya lewat `.htaccess`.

---

## ⚠️ Catatan Penting: Akurasi Data Seed

Data seed awal (fakultas, jurusan, mata kuliah, top kampus, universitas) disusun
berdasarkan pengetahuan umum yang telah tervalidasi secara struktural (nama resmi
kampus, kota, tahun berdiri, struktur fakultas riil di PTN Indonesia). Namun,
beberapa nilai berikut adalah **estimasi/placeholder** yang perlu diverifikasi
dan diperbarui secara berkala oleh admin:

- **Nilai akreditasi kampus & program studi** — berubah dari waktu ke waktu,
  cek data resmi terkini di [banpt.or.id](https://www.banpt.or.id) atau
  [pddikti.kemdikbud.go.id](https://pddikti.kemdikbud.go.id)
- **Estimasi range gaji lulusan** — bersifat indikatif berdasarkan pengetahuan
  umum, bukan hasil survei resmi BPS/Kemnaker
- **Jumlah mahasiswa per kampus** — estimasi kasar, bukan data BPS/PDDikti resmi

Seluruh data ini dapat diubah kapan saja melalui menu **Master Universitas** dan
**Master Jurusan** di Dashboard Admin tanpa perlu mengubah source code.

---

## 🛠️ Troubleshooting

| Masalah | Solusi |
|---|---|
| Halaman blank / 500 error | Set `APP_DEBUG` ke `true` di `config/config.php` untuk melihat pesan error detail |
| CSS/JS tidak muncul | Pastikan `BASE_URL` di `config/config.php` sesuai dengan nama folder di htdocs |
| Import SQL gagal | Pastikan versi MySQL/MariaDB mendukung `CHECK constraint` (MySQL 8.0.16+ / MariaDB 10.2+) |
| Export PDF gagal / kosong | Jalankan `composer install` untuk memasang DomPDF, atau gunakan fallback cetak HTML |
| Upload gambar gagal | Pastikan folder `assets/uploads/` memiliki izin tulis (chmod 755) |

---

© SMA Muhammadiyah 18 Sunggal — Sistem Pakar Rekomendasi Jurusan PTN
