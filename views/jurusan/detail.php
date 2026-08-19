<?php require VIEW_PATH . 'layout/header.php'; ?>
<section class="section-padding">
    <div class="container">
        <nav aria-label="breadcrumb" data-aos="fade-up">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>jurusan">Jurusan</a></li>
                <li class="breadcrumb-item active"><?= clean($jurusan['nama_jurusan']) ?></li>
            </ol>
        </nav>

        <div class="glass-card p-5 mb-4" data-aos="fade-up">
            <span class="badge bg-light text-dark border mb-2"><?= clean($jurusan['nama_fakultas']) ?></span>
            <h2 class="fw-bold">🎓 <?= clean($jurusan['nama_jurusan']) ?></h2>
            <?php foreach (explode("\n\n", $jurusan['deskripsi'] ?? 'Deskripsi belum tersedia.') as $paragraf): ?>
                <p class="text-muted"><?= clean($paragraf) ?></p>
            <?php endforeach; ?>
            <?php
                // Paragraf ke-3 disusun dinamis dari data gaji & top kampus yang tersedia,
                // menekankan prospek kerja spesifik jurusan ini.
                $topKampusList = !empty($jurusan['top_kampus']) ? array_map('trim', explode('|', $jurusan['top_kampus'])) : [];
                $top3Kampus = array_slice($topKampusList, 0, 3);
                if (!empty($top3Kampus) || !empty($jurusan['range_gaji'])):
            ?>
            <p class="text-muted">
                Dengan mempertimbangkan prospek karier tersebut, <strong><?= clean($jurusan['nama_jurusan']) ?></strong> menjadi pilihan yang layak dipertimbangkan bagi siswa yang memiliki minat sesuai bidang ini.
                <?php if (!empty($jurusan['range_gaji'])): ?>Estimasi penghasilan lulusan berkisar antara <strong><?= clean($jurusan['range_gaji']) ?></strong>, tergantung pengalaman dan jenjang karier.<?php endif; ?>
                <?php if (!empty($top3Kampus)): ?> Siswa yang tertarik dapat mempertimbangkan untuk melanjutkan studi di kampus-kampus terkemuka seperti <strong><?= clean(implode(', ', $top3Kampus)) ?></strong>, yang telah dikenal luas dengan kualitas pendidikan pada bidang ini. 🎓<?php endif; ?>
            </p>
            <?php endif; ?>
            <div class="d-flex flex-wrap gap-2 mt-3">
                <a href="<?= BASE_URL ?>konsultasi" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-chat-dots-fill me-1"></i> Cek Kecocokanmu ✨</a>
                <?php if (!empty($jurusan['range_gaji'])): ?>
                <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-2 rounded-pill fs-6">
                    💰 <?= clean($jurusan['range_gaji']) ?>
                </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4" data-aos="fade-up">
                <div class="card-modern p-4 h-100">
                    <i class="bi bi-tools fs-2 mb-2" style="color:var(--sky-blue-dark);"></i>
                    <h6 class="fw-bold">🛠️ Skill yang Dibutuhkan</h6>
                    <p class="text-muted small mb-0"><?= clean($jurusan['skill_dibutuhkan'] ?? '-') ?></p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-modern p-4 h-100">
                    <i class="bi bi-briefcase-fill fs-2 mb-2" style="color:var(--orange);"></i>
                    <h6 class="fw-bold">💼 Prospek Kerja</h6>
                    <p class="text-muted small mb-0"><?= clean($jurusan['prospek_kerja'] ?? '-') ?></p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-modern p-4 h-100">
                    <i class="bi bi-graph-up-arrow fs-2 mb-2" style="color:var(--green);"></i>
                    <h6 class="fw-bold">📈 Peluang Karier</h6>
                    <p class="text-muted small mb-0"><?= clean($jurusan['peluang_karier'] ?? '-') ?></p>
                </div>
            </div>
        </div>

        <?php if (!empty($jurusan['mata_kuliah_inti'])): ?>
        <div class="glass-card p-4 mb-4" data-aos="fade-up">
            <h5 class="fw-bold mb-3">📚 Mata Kuliah Inti</h5>
            <div class="d-flex flex-wrap gap-2">
                <?php foreach (explode('|', $jurusan['mata_kuliah_inti']) as $mk): ?>
                    <span class="badge bg-light text-dark border px-3 py-2" style="font-size:0.82rem;">📖 <?= clean(trim($mk)) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($universitas)): ?>
        <div class="glass-card p-4" data-aos="fade-up">
            <h5 class="fw-bold mb-3">🏛️ Top Kampus Penyedia Jurusan Ini</h5>
            <div class="row g-3">
                <?php foreach ($universitas as $i => $u): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="p-3 border rounded-3 d-flex align-items-center gap-3 h-100">
                        <?php if (!empty($u['logo'])): ?>
                            <img src="<?= UPLOAD_URL . clean($u['logo']) ?>" alt="" style="width:44px;height:44px;object-fit:contain;border-radius:8px;" class="flex-shrink-0">
                        <?php else: ?>
                            <div class="flex-shrink-0 d-flex align-items-center justify-content-center fw-bold text-white" style="width:44px;height:44px;border-radius:8px;background:var(--gradient-main);font-size:0.8rem;">
                                <?= strtoupper(substr($u['singkatan'] ?: $u['nama_universitas'], 0, 3)) ?>
                            </div>
                        <?php endif; ?>
                        <div class="flex-grow-1">
                            <strong class="d-block" style="font-size:0.9rem;"><?= $i < 3 ? '🏆 ' : '' ?><?= clean($u['nama_universitas']) ?></strong>
                            <div class="text-muted small"><?= clean($u['kota'] ?? '') ?> <?= $u['akreditasi'] ? '· Akreditasi ' . clean($u['akreditasi']) : '' ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php require VIEW_PATH . 'layout/footer.php'; ?>
