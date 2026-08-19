<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 - Halaman Tidak Ditemukan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>body{font-family:sans-serif; min-height:100vh; display:flex; align-items:center; background:#0f172a; color:white;}</style>
</head>
<body>
<div class="container text-center">
    <i class="bi bi-emoji-frown" style="font-size:80px; color:#38bdf8;"></i>
    <h1 class="fw-bold mt-3">404</h1>
    <p class="opacity-75">Halaman yang Anda cari tidak ditemukan.</p>
    <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>" class="btn btn-outline-light rounded-pill px-4 mt-3">Kembali ke Beranda</a>
</div>
</body>
</html>
