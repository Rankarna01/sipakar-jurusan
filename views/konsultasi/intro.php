<?php require VIEW_PATH . 'layout/header.php'; ?>
<?php $banner = get_setting('konsultasi_banner', ''); ?>

<section class="section-padding" style="min-height:80vh;">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- ===== KIRI: Info & CTA ===== -->
            <div class="col-lg-6" data-aos="fade-right">
                <span class="hero-badge" style="background:rgba(56,189,248,0.1); color:var(--sky-blue-dark); border:1px solid rgba(56,189,248,0.3);">
                    <i class="bi bi-stars"></i> Konsultasi Gratis & Instan
                </span>
                <h1 class="section-title my-3" style="font-size:2.4rem;">Siap Menemukan Jurusan yang Tepat untukmu? 🚀</h1>
                <p class="text-muted fs-5 mb-4">Jawab beberapa pertanyaan seputar minat, bakat, kemampuan, kepribadian, dan tujuan karier. Sistem kami akan menganalisis jawabanmu dengan <strong>Metode Dempster-Shafer</strong> dan memberikan rekomendasi fakultas & jurusan yang paling sesuai — lengkap dengan penjelasan yang transparan.</p>

                <div class="row g-3 mb-4">
                    <div class="col-4">
                        <div class="glass-card p-3 text-center">
                            <div class="fs-3 fw-bold text-primary">150</div>
                            <small class="text-muted">Pertanyaan</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="glass-card p-3 text-center">
                            <div class="fs-3 fw-bold text-primary">±10</div>
                            <small class="text-muted">Menit</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="glass-card p-3 text-center">
                            <div class="fs-3 fw-bold text-primary">60+</div>
                            <small class="text-muted">Pilihan Jurusan</small>
                        </div>
                    </div>
                </div>

                <?php if ($wajibLogin && !is_siswa_login()): ?>
                    <div class="alert alert-warning">⚠️ Konsultasi ini mengharuskan Anda login terlebih dahulu.</div>
                    <a href="<?= BASE_URL ?>auth/login" class="btn btn-gradient btn-lg rounded-pill px-5">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Mulai
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>konsultasi/mulai" class="btn btn-gradient btn-lg rounded-pill px-5">
                        <i class="bi bi-play-fill me-2"></i>Mulai Konsultasi Sekarang
                    </a>
                    <p class="text-muted small mt-2 mb-0">✅ Tanpa biaya &nbsp; ✅ Hasil instan &nbsp; ✅ Bisa sebagai tamu</p>
                <?php endif; ?>
            </div>

            <!-- ===== KANAN: Banner / Ilustrasi ===== -->
            <div class="col-lg-6" data-aos="fade-left">
                <?php if ($banner && file_exists(UPLOAD_PATH . $banner)): ?>
                    <div class="glass-card p-2">
                        <img src="<?= UPLOAD_URL . clean($banner) ?>" class="w-100 rounded-4" style="max-height:420px; object-fit:cover;" alt="Konsultasi Jurusan">
                    </div>
                <?php else: ?>
                    <div class="glass-card p-5 text-center position-relative hero-illustration">
                        <i class="bi bi-chat-dots-fill" style="font-size:160px; color: var(--sky-blue); opacity:0.9;"></i>
                        <span class="float-emoji fe1">💡</span>
                        <span class="float-emoji fe2">🎯</span>
                        <span class="float-emoji fe3">🎓</span>
                        <span class="float-emoji fe4">📊</span>
                        <span class="float-emoji fe5">✨</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ===== LANGKAH KONSULTASI ===== -->
        <div class="row g-4 mt-5">
            <div class="col-12 text-center mb-2" data-aos="fade-up">
                <h5 class="fw-bold">Bagaimana Cara Kerjanya?</h5>
            </div>
            <?php
            $langkah = [
                ['icon' => 'bi-person-check-fill', 'title' => '1. Isi Data', 'desc' => 'Login atau lanjut sebagai tamu.'],
                ['icon' => 'bi-sliders', 'title' => '2. Jawab Pertanyaan', 'desc' => 'Pilih skala 1-5 sesuai kesetujuanmu.'],
                ['icon' => 'bi-cpu-fill', 'title' => '3. Diproses Sistem', 'desc' => 'Dihitung dengan Dempster-Shafer.'],
                ['icon' => 'bi-trophy-fill', 'title' => '4. Lihat Hasil', 'desc' => 'Rekomendasi fakultas & jurusan lengkap.'],
            ];
            foreach ($langkah as $i => $l): ?>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="card-modern p-4 text-center h-100">
                    <i class="bi <?= $l['icon'] ?> fs-2 mb-2" style="color: var(--sky-blue-dark);"></i>
                    <h6 class="fw-bold mb-1"><?= $l['title'] ?></h6>
                    <p class="text-muted small mb-0"><?= $l['desc'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require VIEW_PATH . 'layout/footer.php'; ?>
