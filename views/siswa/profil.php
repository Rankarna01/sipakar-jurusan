<?php require VIEW_PATH . 'layout/header.php'; ?>

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6" data-aos="fade-up">
                <div class="glass-card p-5">
                    <h4 class="fw-bold mb-4"><i class="bi bi-person-gear me-2"></i>Profil Saya</h4>

                    <?php require VIEW_PATH . 'partials/alert.php'; ?>

                    <form action="<?= BASE_URL ?>siswa/updateProfil" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= clean($siswa['nama']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">NISN</label>
                            <input type="text" class="form-control" value="<?= clean($siswa['nisn']) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kelas</label>
                            <input type="text" name="kelas" class="form-control" value="<?= clean($siswa['kelas']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" value="<?= clean($siswa['email']) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control" value="<?= clean($siswa['no_wa'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Profil</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password Baru (opsional)</label>
                            <input type="password" name="password" class="form-control" minlength="6" placeholder="Kosongkan jika tidak ingin mengganti">
                        </div>
                        <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require VIEW_PATH . 'layout/footer.php'; ?>
