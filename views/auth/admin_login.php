<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
</head>
<body style="background: var(--gradient-navy); min-height:100vh; display:flex; align-items:center;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="glass-card p-5" style="background: rgba(255,255,255,0.95);">
                <div class="text-center mb-4">
                    <div class="brand-icon mx-auto mb-3" style="width:64px;height:64px;font-size:1.8rem;"><i class="bi bi-shield-lock-fill"></i></div>
                    <h4 class="fw-bold">Admin Panel</h4>
                    <p class="text-muted small">Sistem Pakar Rekomendasi Jurusan PTN</p>
                </div>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= clean($_SESSION['error']); unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>auth/adminLoginProses" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control form-control-lg" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg" required>
                    </div>
                    <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill">Masuk ke Dashboard</button>
                </form>
                <p class="text-center mt-4 mb-0"><a href="<?= BASE_URL ?>" class="text-muted small"><i class="bi bi-arrow-left"></i> Kembali ke Website</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
