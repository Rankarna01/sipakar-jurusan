<?php require VIEW_PATH . 'layout/header.php'; ?>
<section class="section-padding" style="min-height:75vh; display:flex; align-items:center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6" data-aos="fade-up">
                <div class="glass-card p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill" style="font-size:56px; color: var(--sky-blue);"></i>
                        <h3 class="fw-bold mt-2">Daftar Akun Siswa</h3>
                    </div>

                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-auto-dismiss"><?= clean($_SESSION['error']); unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>auth/registerProses" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">NISN</label>
                                <input type="text" name="nisn" class="form-control" maxlength="10" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kelas</label>
                                <input type="text" name="kelas" class="form-control" placeholder="XII IPA 1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. WhatsApp</label>
                                <input type="text" name="no_wa" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">Pilih...</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" minlength="6" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Konfirmasi Password</label>
                                <input type="password" name="konfirmasi_password" class="form-control" minlength="6" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill mt-4">Daftar</button>
                    </form>
                    <p class="text-center mt-4 mb-0 small">Sudah punya akun? <a href="<?= BASE_URL ?>auth/login" class="fw-bold">Masuk di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require VIEW_PATH . 'layout/footer.php'; ?>
