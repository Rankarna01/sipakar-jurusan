<?php require VIEW_PATH . 'layout/header.php'; ?>

<section class="section-padding">
    <div class="container">
        <div class="glass-card p-4 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3" data-aos="fade-up">
            <div>
                <h4 class="fw-bold mb-1">Halo, <?= clean($siswa['nama']) ?> 👋</h4>
                <p class="text-muted mb-0"><?= clean($siswa['kelas']) ?> &bull; <?= clean($siswa['email']) ?></p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>siswa/profil" class="btn btn-outline-navy rounded-pill px-3"><i class="bi bi-person-gear me-1"></i> Profil</a>
                <a href="<?= BASE_URL ?>konsultasi" class="btn btn-gradient rounded-pill px-3"><i class="bi bi-plus-lg me-1"></i> Konsultasi Baru</a>
            </div>
        </div>

        <h5 class="fw-bold mb-3" data-aos="fade-up">Riwayat Konsultasi (<?= count($riwayat) ?>)</h5>
        <div class="row g-4">
            <?php foreach ($riwayat as $i => $r): ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <div class="card-modern p-4 h-100">
                    <span class="badge bg-light text-dark border mb-2"><?= clean($r['kode_konsultasi']) ?></span>
                    <h6 class="fw-bold"><?= clean($r['nama_jurusan_terbaik'] ?? '-') ?></h6>
                    <p class="text-muted small mb-2"><?= format_tanggal($r['created_at'], true) ?></p>
                    <h5 class="fw-bold" style="color: var(--sky-blue-dark);"><?= number_format($r['persentase_akhir'], 2) ?>%</h5>
                    <a href="<?= BASE_URL ?>hasil/detail/<?= $r['kode_konsultasi'] ?>" class="btn btn-sm btn-outline-navy rounded-pill w-100 mt-2">Lihat Detail</a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (empty($riwayat)): ?>
                <div class="col-12 text-center text-muted py-5">
                    <i class="bi bi-clipboard-x fs-1 d-block mb-2"></i>
                    Belum ada riwayat konsultasi. <a href="<?= BASE_URL ?>konsultasi">Mulai konsultasi pertamamu</a>.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require VIEW_PATH . 'layout/footer.php'; ?>
