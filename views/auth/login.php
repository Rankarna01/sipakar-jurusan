<?php require VIEW_PATH . 'layout/header.php'; ?>
<section class="section-padding" style="min-height:75vh; display:flex; align-items:center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5" data-aos="fade-up">
                <div class="glass-card p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle" style="font-size:56px; color: var(--sky-blue);"></i>
                        <h3 class="fw-bold mt-2">Masuk Akun Siswa</h3>
                        <p class="text-muted small">Masuk untuk mulai konsultasi & melihat riwayat</p>
                    </div>

                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-auto-dismiss"><?= clean($_SESSION['error']); unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>auth/loginProses" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">NIS</label>
                            <input type="text" name="nisn" class="form-control form-control-lg" required placeholder="Masukkan NIS Anda">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" required placeholder="Masukkan Password (NPSN Sekolah)">
                        </div>
                        <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill">Masuk</button>
                    </form>
                    <p class="text-center mt-4 mb-0 small">Belum punya akun? <a href="<?= BASE_URL ?>auth/register" class="fw-bold">Daftar sekarang</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require VIEW_PATH . 'layout/footer.php'; ?>
