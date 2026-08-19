<?php require VIEW_PATH . 'layout/header.php'; ?>
<section class="section-padding section-tint-blue">
    <span class="bg-blob bg-blob-1"></span>
    <span class="bg-blob bg-blob-3"></span>
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Jelajahi</span>
            <h2 class="section-title">Daftar Fakultas</h2>
            <p class="section-subtitle mx-auto">Pilih fakultas untuk melihat program studi yang tersedia</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($fakultas as $i => $f): ?>
            <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="<?= ($i % 4) * 80 ?>">
                <a href="<?= BASE_URL ?>fakultas/detail/<?= $f['slug'] ?>" class="text-decoration-none">
                    <div class="glass-card h-100 p-4 text-center">
                        <div class="fakultas-icon mx-auto mb-3"><i class="bi <?= clean($f['icon'] ?: 'bi-mortarboard') ?>"></i></div>
                        <div class="mb-1" style="font-size:1.4rem;"><?= get_fakultas_emoji($f['nama_fakultas']) ?></div>
                        <h6 class="fw-bold text-dark mb-1"><?= clean($f['nama_fakultas']) ?></h6>
                        <small class="text-muted"><?= (int)$f['jumlah_jurusan'] ?> Jurusan</small>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require VIEW_PATH . 'layout/footer.php'; ?>
