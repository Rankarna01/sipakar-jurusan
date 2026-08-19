<?php require VIEW_PATH . 'layout/header.php'; ?>

<section class="section-padding">
    <div class="container">

        <!-- ===== HEADER HASIL ===== -->
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Hasil Konsultasi</span>
            <h2 class="section-title">Rekomendasi Fakultas & Jurusan Untukmu</h2>
            <p class="text-muted">Kode Konsultasi: <strong><?= clean($hasil['kode_konsultasi']) ?></strong> | <?= format_tanggal($hasil['created_at'], true) ?></p>
        </div>

        <!-- ===== FAKULTAS TERBAIK (REKOMENDASI UTAMA) ===== -->
        <?php if (!empty($hasil['nama_fakultas_terbaik'])): ?>
        <div class="row justify-content-center mb-4" data-aos="zoom-in">
            <div class="col-lg-8">
                <div class="glass-card p-5 text-center rank-1">
                    <span class="badge bg-warning text-dark fw-bold mb-3">🏆 Fakultas yang Direkomendasikan</span>
                    <h1 class="fw-bold" style="color: var(--navy);"><?= get_fakultas_emoji($hasil['nama_fakultas_terbaik']) ?> Fakultas <?= clean($hasil['nama_fakultas_terbaik']) ?></h1>
                    <h2 class="fw-bold" style="color: var(--sky-blue-dark);"><?= number_format($hasil['persentase_fakultas_terbaik'], 2) ?>%</h2>
                    <p class="small text-muted mb-3">Tingkat Keyakinan Sistem Pakar (agregat seluruh jurusan di fakultas ini)</p>
                    <?php if (!empty($hasil['deskripsi_fakultas_terbaik'])): ?>
                        <p class="mx-auto" style="max-width:650px;"><?= clean($hasil['deskripsi_fakultas_terbaik']) ?></p>
                    <?php endif; ?>
                    <p class="mx-auto text-muted" style="max-width:650px;">Di bawah ini adalah <strong>jurusan-jurusan spesifik</strong> dalam fakultas ini yang paling sesuai dengan profil jawabanmu — silakan pilih salah satu untuk melihat detail lengkapnya. 👇</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                        <a href="<?= BASE_URL ?>hasil/pdf/<?= $hasil['kode_konsultasi'] ?>" class="btn btn-orange rounded-pill px-4"><i class="bi bi-file-earmark-pdf-fill me-1"></i> Unduh PDF</a>
                        <button onclick="window.print()" class="btn btn-outline-navy rounded-pill px-4"><i class="bi bi-printer-fill me-1"></i> Cetak</button>
                        <a href="<?= BASE_URL ?>fakultas/detail/<?= clean($hasil['slug_fakultas_terbaik'] ?? '') ?>" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-info-circle-fill me-1"></i> Lihat Fakultas</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== JURUSAN UNGGULAN DI FAKULTAS INI ===== -->
        <?php if (!empty($jurusanDalamFakultas)): ?>
        <div class="row justify-content-center mb-5" data-aos="fade-up">
            <div class="col-lg-10">
                <h5 class="fw-bold text-center mb-4">🎯 Jurusan Unggulan di Fakultas <?= clean($hasil['nama_fakultas_terbaik']) ?></h5>
                <div class="row g-3">
                    <?php foreach (array_slice($jurusanDalamFakultas, 0, 6) as $i => $jf): ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?= BASE_URL ?>jurusan/detail/<?= clean($jf['slug']) ?>" class="text-decoration-none">
                            <div class="card-modern p-4 h-100 <?= $i === 0 ? 'border border-warning border-2' : '' ?>">
                                <?php if ($i === 0): ?><span class="badge bg-warning text-dark mb-2">⭐ Paling Sesuai</span><?php endif; ?>
                                <h6 class="fw-bold text-dark mb-1">🎓 <?= clean($jf['nama_jurusan']) ?></h6>
                                <?php if (isset($jf['persentase'])): ?>
                                    <span class="badge bg-light text-dark border"><?= number_format($jf['persentase'], 2) ?>% cocok</span>
                                <?php endif; ?>
                                <?php if (!empty($jf['range_gaji'])): ?>
                                    <p class="text-muted small mb-0 mt-2">💰 <?= clean($jf['range_gaji']) ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <!-- ===== JURUSAN TERBAIK (DETAIL) ===== -->
        <?php if (!empty($detailRanking)): $top = $detailRanking[0]; ?>
        <div class="row justify-content-center mb-5" data-aos="zoom-in">
            <div class="col-lg-8">
                <div class="glass-card p-5 text-center">
                    <span class="badge bg-light text-dark border fw-bold mb-3">📄 Detail Jurusan Peringkat #1</span>
                    <h1 class="fw-bold" style="color: var(--navy);">🎓 <?= clean($top['nama_jurusan']) ?></h1>
                    <p class="text-muted mb-3"><?= clean($top['nama_fakultas']) ?></p>
                    <h2 class="fw-bold" style="color: var(--sky-blue-dark);"><?= number_format($top['persentase'], 2) ?>%</h2>
                    <p class="small text-muted">Tingkat Keyakinan (Belief) Sistem Pakar</p>
                    <?php foreach (explode("\n\n", $top['deskripsi'] ?? 'Deskripsi jurusan belum tersedia.') as $paragraf): ?>
                        <p class="mx-auto" style="max-width:600px;"><?= clean($paragraf) ?></p>
                    <?php endforeach; ?>
                    <?php
                        $topKampusListHasil = !empty($top['top_kampus']) ? array_map('trim', explode('|', $top['top_kampus'])) : [];
                        $top3KampusHasil = array_slice($topKampusListHasil, 0, 3);
                        if (!empty($top3KampusHasil) || !empty($top['range_gaji'])):
                    ?>
                    <p class="mx-auto" style="max-width:600px;">
                        Dengan mempertimbangkan prospek karier tersebut, <strong><?= clean($top['nama_jurusan']) ?></strong> menjadi rekomendasi yang layak dipertimbangkan sesuai profil jawabanmu.
                        <?php if (!empty($top['range_gaji'])): ?>Estimasi penghasilan lulusan berkisar antara <strong><?= clean($top['range_gaji']) ?></strong>.<?php endif; ?>
                        <?php if (!empty($top3KampusHasil)): ?> Pertimbangkan melanjutkan studi di <strong><?= clean(implode(', ', $top3KampusHasil)) ?></strong>. 🎓<?php endif; ?>
                    </p>
                    <?php endif; ?>
                    <?php if (!empty($top['range_gaji'])): ?>
                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-2 rounded-pill fs-6 mb-2 badge-pulse">
                            💰 <?= clean($top['range_gaji']) ?>
                        </span>
                    <?php endif; ?>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                        <a href="<?= BASE_URL ?>jurusan/detail/<?= $top['slug'] ?>" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-info-circle-fill me-1"></i> Detail Jurusan</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- ===== CHART & RANKING ===== -->
        <div class="row g-4 mb-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-3">Grafik Perbandingan</h5>
                    <canvas id="chartRanking"></canvas>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-3">Ranking 5 Jurusan Teratas</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead><tr class="text-muted small"><th>#</th><th>Jurusan</th><th>Fakultas</th><th class="text-end">Belief</th></tr></thead>
                            <tbody>
                            <?php foreach ($detailRanking as $d): ?>
                                <tr class="<?= $d['ranking'] == 1 ? 'fw-bold' : '' ?>">
                                    <td><span class="rank-badge" style="width:32px;height:32px;font-size:0.8rem;"><?= $d['ranking'] ?></span></td>
                                    <td><?= clean($d['nama_jurusan']) ?></td>
                                    <td class="text-muted small"><?= clean($d['nama_fakultas']) ?></td>
                                    <td class="text-end"><?= number_format($d['persentase'], 2) ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== DETAIL JURUSAN TERBAIK ===== -->
        <?php if (!empty($top)): ?>
        <div class="row g-4 mb-4">
            <div class="col-md-4" data-aos="fade-up">
                <div class="glass-card p-4 h-100">
                    <i class="bi bi-tools fs-2 mb-2" style="color:var(--sky-blue-dark);"></i>
                    <h6 class="fw-bold">🛠️ Skill yang Dibutuhkan</h6>
                    <p class="text-muted small mb-0"><?= clean($top['skill_dibutuhkan'] ?? '-') ?></p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card p-4 h-100">
                    <i class="bi bi-briefcase-fill fs-2 mb-2" style="color:var(--orange);"></i>
                    <h6 class="fw-bold">💼 Prospek Kerja</h6>
                    <p class="text-muted small mb-0"><?= clean($top['prospek_kerja'] ?? '-') ?></p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card p-4 h-100">
                    <i class="bi bi-graph-up-arrow fs-2 mb-2" style="color:var(--green);"></i>
                    <h6 class="fw-bold">📈 Peluang Karier</h6>
                    <p class="text-muted small mb-0"><?= clean($top['peluang_karier'] ?? '-') ?></p>
                </div>
            </div>
        </div>

        <?php if (!empty($top['mata_kuliah_inti'])): ?>
        <div class="glass-card p-4 mb-5" data-aos="fade-up">
            <h5 class="fw-bold mb-3">📚 Mata Kuliah Inti</h5>
            <div class="d-flex flex-wrap gap-2">
                <?php foreach (explode('|', $top['mata_kuliah_inti']) as $mk): ?>
                    <span class="badge bg-light text-dark border px-3 py-2" style="font-size:0.82rem;">📖 <?= clean(trim($mk)) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <!-- ===== UNIVERSITAS PENYEDIA ===== -->
        <?php if (!empty($universitas)): ?>
        <div class="glass-card p-4 mb-5" data-aos="fade-up">
            <h5 class="fw-bold mb-3">🏛️ Top Kampus Penyedia Jurusan Ini</h5>
            <div class="row g-3">
                <?php foreach ($universitas as $i => $u): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="p-3 border rounded-3 d-flex align-items-center gap-3 h-100">
                        <?php if (!empty($u['logo'])): ?>
                            <img src="<?= UPLOAD_URL . clean($u['logo']) ?>" alt="" style="width:40px;height:40px;object-fit:contain;border-radius:8px;" class="flex-shrink-0">
                        <?php else: ?>
                            <div class="flex-shrink-0 d-flex align-items-center justify-content-center fw-bold text-white" style="width:40px;height:40px;border-radius:8px;background:var(--gradient-main);font-size:0.72rem;">
                                <?= strtoupper(substr($u['singkatan'] ?: $u['nama_universitas'], 0, 3)) ?>
                            </div>
                        <?php endif; ?>
                        <div class="flex-grow-1">
                            <strong class="d-block" style="font-size:0.86rem;"><?= $i < 3 ? '🏆 ' : '' ?><?= clean($u['nama_universitas']) ?></strong>
                            <div class="text-muted small"><?= clean($u['kota'] ?? '') ?> <?= $u['akreditasi'] ? '· Akreditasi ' . clean($u['akreditasi']) : '' ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- ===== PROSES PERHITUNGAN DEMPSTER-SHAFER (TRANSPARAN) ===== -->
        <div class="glass-card p-4 mb-5" data-aos="fade-up">
            <h5 class="fw-bold mb-1"><i class="bi bi-calculator-fill me-1"></i> Proses Perhitungan Metode Dempster-Shafer</h5>
            <p class="text-muted small mb-4">Berikut adalah rincian lengkap kombinasi evidence yang dipilih dan bagaimana sistem menghitung nilai belief setiap jurusan secara bertahap.</p>

            <!-- Evidence terpilih -->
            <h6 class="fw-bold mb-2">Evidence yang Dipilih (Jawaban "Ya")</h6>
            <div class="d-flex flex-wrap gap-2 mb-4">
                <?php foreach ($jawaban as $j): ?>
                    <span class="badge bg-light text-dark border p-2"><?= clean($j['nama_evidence']) ?></span>
                <?php endforeach; ?>
            </div>

            <!-- Langkah kombinasi -->
            <?php foreach ($langkahGrouped as $urutan => $grup): ?>
            <div class="accordion mb-2" id="stepAccordion<?= $urutan ?>">
                <div class="accordion-item border rounded-3 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#stepCollapse<?= $urutan ?>">
                            Langkah <?= $urutan ?>: Kombinasi Evidence "<?= clean($grup['nama_evidence']) ?>"
                        </button>
                    </h2>
                    <div id="stepCollapse<?= $urutan ?>" class="accordion-collapse collapse" data-bs-parent="#stepAccordion<?= $urutan ?>">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-sm step-calc-table">
                                    <thead>
                                        <tr>
                                            <th>Jurusan</th>
                                            <th>m1 (Belief Lama)</th>
                                            <th>m2 (Belief Baru)</th>
                                            <th>m1(θ)</th>
                                            <th>m2(θ)</th>
                                            <th>Kombinasi (sebelum normalisasi)</th>
                                            <th>Konflik (K)</th>
                                            <th>Hasil Normalisasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($grup['detail'] as $d): ?>
                                        <tr>
                                            <td class="fw-semibold"><?= clean($d['nama_jurusan']) ?></td>
                                            <td><?= $d['m1_belief'] !== null ? number_format($d['m1_belief'], 4) : '-' ?></td>
                                            <td><?= number_format($d['m2_belief'], 4) ?></td>
                                            <td><?= $d['m1_theta'] !== null ? number_format($d['m1_theta'], 4) : '-' ?></td>
                                            <td><?= number_format($d['m2_theta'], 4) ?></td>
                                            <td><?= number_format($d['nilai_kombinasi'], 4) ?></td>
                                            <td><?= number_format($d['nilai_konflik'], 4) ?></td>
                                            <td class="fw-bold text-primary"><?= number_format($d['nilai_normalisasi'], 4) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <p class="small text-muted mb-0">
                                Rumus: m3(Z) = [Σ m1(X)·m2(Y) untuk X∩Y=Z] / (1-K), dengan K = Σ m1(X)·m2(Y) untuk X∩Y=∅
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mb-5">
            <a href="<?= BASE_URL ?>konsultasi" class="btn btn-outline-navy rounded-pill px-4 me-2"><i class="bi bi-arrow-repeat me-1"></i> Konsultasi Ulang</a>
            <a href="<?= BASE_URL ?>" class="btn btn-gradient rounded-pill px-4">Kembali ke Beranda</a>
        </div>

    </div>
</section>

<script>
const rankingData = <?= json_encode(array_map(fn($d) => ['nama' => $d['nama_jurusan'], 'persentase' => (float)$d['persentase']], $detailRanking), JSON_UNESCAPED_UNICODE) ?>;

// Ditunda sampai DOM + seluruh skrip (termasuk Chart.js dari footer) selesai dimuat,
// karena Chart.js baru di-load di footer.php SETELAH blok script ini.
document.addEventListener('DOMContentLoaded', function () {
    function renderChart() {
        if (typeof Chart === 'undefined') {
            // Chart.js belum siap, coba lagi sebentar
            setTimeout(renderChart, 100);
            return;
        }
        const ctx = document.getElementById('chartRanking');
        if (!ctx) return;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: rankingData.map(d => d.nama),
                datasets: [{
                    label: 'Persentase Belief (%)',
                    data: rankingData.map(d => d.persentase),
                    backgroundColor: rankingData.map((_, i) => i === 0 ? '#fb923c' : 'rgba(56, 189, 248, 0.7)'),
                    borderRadius: 8,
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, max: 100 } }
            }
        });
    }
    renderChart();
});
</script>

<!-- Efek Confetti saat hasil rekomendasi muncul 🎉 -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
<script>
window.addEventListener('load', function () {
    if (typeof confetti === 'function') {
        confetti({
            particleCount: 120,
            spread: 90,
            origin: { y: 0.3 },
            colors: ['#38bdf8', '#fb923c', '#22c55e', '#0f172a'],
        });
        setTimeout(() => confetti({ particleCount: 60, angle: 60, spread: 70, origin: { x: 0 } }), 300);
        setTimeout(() => confetti({ particleCount: 60, angle: 120, spread: 70, origin: { x: 1 } }), 300);
    }
});
</script>

<?php require VIEW_PATH . 'layout/footer.php'; ?>
