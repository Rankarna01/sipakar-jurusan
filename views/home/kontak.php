<?php require VIEW_PATH . 'layout/header.php'; ?>
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">📞 Hubungi Kami</span>
            <h2 class="section-title">Kontak</h2>
        </div>
        <div class="row g-4 justify-content-center mb-5">
            <div class="col-md-4" data-aos="fade-up">
                <div class="glass-card p-4 text-center h-100">
                    <i class="bi bi-geo-alt-fill fs-1 mb-2" style="color:var(--sky-blue-dark);"></i>
                    <h6 class="fw-bold">Alamat</h6>
                    <p class="text-muted small mb-0">Jalan Medan Krio, Sunggal, Sumatera Utara</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card p-4 text-center h-100">
                    <i class="bi bi-envelope-fill fs-1 mb-2" style="color:var(--orange);"></i>
                    <h6 class="fw-bold">Email</h6>
                    <p class="text-muted small mb-0">info@smamuh18sunggal.sch.id</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card p-4 text-center h-100">
                    <i class="bi bi-whatsapp fs-1 mb-2" style="color:var(--green);"></i>
                    <h6 class="fw-bold">WhatsApp</h6>
                    <p class="text-muted small mb-0">(061) 000-0000</p>
                </div>
            </div>
        </div>

        <!-- ===== BIODATA PEMBUAT SISTEM (multi, maks 5) ===== -->
        <div class="text-center mb-4" data-aos="fade-up">
            <span class="section-badge">👨‍💻 Tentang Pembuat</span>
            <h2 class="section-title">Tim Pengembang Sistem</h2>
            <p class="section-subtitle mx-auto">Sistem ini dirancang dan dikembangkan sebagai bagian dari penelitian terapan Program Studi Manajemen Informatika</p>
        </div>
        <div class="row justify-content-center g-4">
            <?php foreach ($daftarPengembang as $i => $dev): ?>
            <div class="col-lg-<?= count($daftarPengembang) === 1 ? '8' : '6' ?>" data-aos="zoom-in" data-aos-delay="<?= $i * 100 ?>">
                <div class="glass-card p-4 h-100">
                    <div class="row g-3 align-items-center">
                        <div class="col-4 col-md-3 text-center">
                            <?php if (!empty($dev['foto']) && file_exists(UPLOAD_PATH . $dev['foto'])): ?>
                                <img src="<?= UPLOAD_URL . clean($dev['foto']) ?>" class="rounded-circle mx-auto d-block" style="width:90px;height:90px;object-fit:cover;" alt="<?= clean($dev['nama']) ?>">
                            <?php else: ?>
                                <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle" style="width:90px;height:90px;background:var(--gradient-main);color:white;font-size:2rem;font-weight:800;">
                                    <?= strtoupper(substr($dev['nama'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-8 col-md-9">
                            <h5 class="fw-bold mb-1"><?= clean($dev['nama']) ?></h5>
                            <p class="text-muted small mb-2"><?= nl2br(clean($dev['jabatan'] ?? '')) ?></p>
                            <?php if (!empty($dev['bio'])): ?>
                                <p class="text-muted small mb-2"><?= clean($dev['bio']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($dev['keahlian'])): ?>
                            <div class="d-flex gap-2 flex-wrap">
                                <?php foreach (explode('|', $dev['keahlian']) as $k): if (trim($k) === '') continue; ?>
                                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size:0.72rem;"><?= clean(trim($k)) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (empty($daftarPengembang)): ?>
                <p class="text-center text-muted">Data pengembang belum diisi.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require VIEW_PATH . 'layout/footer.php'; ?>
