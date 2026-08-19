<?php require VIEW_PATH . 'layout/header.php'; ?>

<!-- ===== HERO SECTION ===== -->
<section class="hero-section">
    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="hero-badge"><i class="bi bi-stars"></i> Sistem Pakar Berbasis Web</span>
                <h1 class="hero-title my-4">Temukan Jurusan Kuliah <span>Paling Sesuai</span> untuk Masa Depanmu</h1>
                <p class="fs-5 opacity-75 mb-4">Gunakan Sistem Pakar berbasis Metode <strong>Dempster-Shafer</strong> untuk mendapatkan rekomendasi jurusan Perguruan Tinggi Negeri berdasarkan minat, bakat, kemampuan, kepribadian, dan tujuan karier kamu.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= BASE_URL ?>konsultasi" class="btn btn-gradient btn-lg rounded-pill px-4"><i class="bi bi-play-circle-fill me-2"></i>Mulai Konsultasi</a>
                    <a href="<?= BASE_URL ?>home/tentang" class="btn btn-outline-light btn-lg rounded-pill px-4">Pelajari Metode</a>
                </div>
                <div class="row g-3 mt-4">
                    <div class="col-4"><div class="hero-stats-box"><h3><?= $totalFakultas ?></h3><small>Fakultas</small></div></div>
                    <div class="col-4"><div class="hero-stats-box"><h3><?= $totalJurusan ?>+</h3><small>Jurusan</small></div></div>
                    <div class="col-4"><div class="hero-stats-box"><h3><?= $totalKonsultasi ?></h3><small>Konsultasi</small></div></div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <?php if (!empty($slider) && count($slider) >= 1): ?>
                <div id="heroCarousel" class="carousel slide hero-carousel glass-card p-2" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-indicators">
                        <?php foreach ($slider as $i => $s): ?>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>"></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-inner rounded-4 overflow-hidden">
                        <?php foreach ($slider as $i => $s): ?>
                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                            <img src="<?= UPLOAD_URL . clean($s['gambar']) ?>" class="d-block w-100 hero-slide-img" alt="<?= clean($s['judul'] ?? '') ?>">
                            <?php if (!empty($s['judul']) || !empty($s['subjudul'])): ?>
                            <div class="carousel-caption d-none d-md-block">
                                <?php if (!empty($s['judul'])): ?><h5><?= clean($s['judul']) ?></h5><?php endif; ?>
                                <?php if (!empty($s['subjudul'])): ?><p class="small"><?= clean($s['subjudul']) ?></p><?php endif; ?>
                                <?php if (!empty($s['link_tombol'])): ?>
                                    <a href="<?= clean($s['link_tombol']) ?>" class="btn btn-sm btn-gradient rounded-pill"><?= clean($s['teks_tombol'] ?: 'Selengkapnya') ?></a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($slider) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div id="heroIconCarousel" class="carousel slide glass-card p-4 hero-illustration" data-bs-ride="carousel" data-bs-interval="3500">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#heroIconCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#heroIconCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#heroIconCarousel" data-bs-slide-to="2"></button>
                        <button type="button" data-bs-target="#heroIconCarousel" data-bs-slide-to="3"></button>
                    </div>
                    <div class="carousel-inner text-center" style="min-height:340px;">
                        <div class="carousel-item active">
                            <i class="bi bi-mortarboard-fill icon-slide" style="color: var(--sky-blue);"></i>
                            <p class="fw-bold mt-2 text-muted">🎓 Temukan Jurusan Impianmu</p>
                        </div>
                        <div class="carousel-item">
                            <i class="bi bi-cpu-fill icon-slide" style="color: var(--orange);"></i>
                            <p class="fw-bold mt-2 text-muted">🧮 Dihitung dengan Dempster-Shafer</p>
                        </div>
                        <div class="carousel-item">
                            <i class="bi bi-graph-up-arrow icon-slide" style="color: var(--green);"></i>
                            <p class="fw-bold mt-2 text-muted">📈 Prospek Karier Transparan</p>
                        </div>
                        <div class="carousel-item">
                            <i class="bi bi-bank2 icon-slide" style="color: var(--sky-blue-dark);"></i>
                            <p class="fw-bold mt-2 text-muted">🏛️ 60+ Pilihan Jurusan PTN</p>
                        </div>
                    </div>
                    <span class="float-emoji fe1">📚</span>
                    <span class="float-emoji fe2">💡</span>
                    <span class="float-emoji fe3">🎯</span>
                    <span class="float-emoji fe4">🚀</span>
                    <span class="float-emoji fe5">🧠</span>
                </div>
                <style>.icon-slide { font-size: 180px; opacity: 0.9; }</style>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
.hero-carousel { border-radius: 24px; }
.hero-slide-img { height: 420px; object-fit: cover; }
.hero-carousel .carousel-indicators button { background-color: var(--sky-blue); }
@media (max-width: 768px) { .hero-slide-img { height: 260px; } }
</style>

<!-- ===== TENTANG SISTEM ===== -->
<section class="section-padding section-tint-blue" id="tentang-singkat">
    <span class="bg-blob bg-blob-1"></span>
    <span class="bg-blob bg-blob-3"></span>
    <div class="container" data-aos="fade-up">
        <div class="text-center mb-4">
            <span class="section-badge">🎓 Tentang Sistem</span>
            <h2 class="section-title mb-3">Apa itu SiJurusan?</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9 text-center">
                <p class="section-subtitle mx-auto mb-3" style="max-width:100%;">SiJurusan adalah sistem pakar (expert system) berbasis web yang dirancang khusus untuk membantu siswa SMA Muhammadiyah 18 Sunggal menentukan jurusan Perguruan Tinggi Negeri yang paling sesuai dengan minat, bakat, kemampuan, kepribadian, dan tujuan karier mereka. Sistem ini dibangun agar setiap siswa dapat memperoleh gambaran objektif tentang pilihan jurusan sebelum mendaftar ke perguruan tinggi, mengurangi risiko "salah jurusan" yang sering dialami banyak mahasiswa baru.</p>
                <p class="section-subtitle mx-auto" style="max-width:100%;">Berbeda dari tes minat-bakat biasa yang hanya memberikan hasil akhir tanpa penjelasan, SiJurusan menggunakan penalaran ketidakpastian <strong>Metode Dempster-Shafer</strong> yang transparan — setiap langkah perhitungan dapat dilihat dan dipertanggungjawabkan secara akademik, bukan sekadar "kotak hitam" (black box).</p>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-2">🧮 Apa itu Metode Dempster-Shafer?</h5>
                    <p class="text-muted mb-2">Dempster-Shafer adalah metode penalaran berbasis teori evidence (bukti) yang memungkinkan sistem mengombinasikan beberapa sumber bukti dengan tingkat ketidakpastian, menghasilkan nilai <strong>belief</strong> (kepercayaan minimum) dan <strong>plausibility</strong> (kepercayaan maksimum yang mungkin) terhadap suatu jurusan.</p>
                    <p class="text-muted mb-0">Berbeda dari probabilitas klasik yang mengharuskan totalnya 100%, metode ini punya konsep <strong>"ketidaktahuan" (uncertainty)</strong> yang diakui secara eksplisit — cocok untuk kasus pemilihan jurusan, di mana jawaban siswa tidak selalu memberi kepastian mutlak.</p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-2">📐 Rumus Kombinasi (Dempster's Rule)</h5>
                    <div class="bg-light rounded-3 p-3 text-center mb-2" style="font-family: 'Courier New', monospace; font-size:0.9rem;">
                        m₃(Z) = [ Σ m₁(X)·m₂(Y) untuk X∩Y=Z ] / (1 − K)
                    </div>
                    <p class="text-muted small mb-0">dengan K = konflik = Σ m₁(X)·m₂(Y) untuk X∩Y=∅. Semakin banyak evidence yang konsisten dijawab, semakin presisi rekomendasi yang dihasilkan sistem. ✨</p>
                </div>
            </div>
        </div>

        <!-- ===== ISTILAH KUNCI ===== -->
        <div class="row g-3 mt-2">
            <div class="col-12 text-center" data-aos="fade-up">
                <h5 class="fw-bold mb-3 mt-3">🔑 Istilah Kunci dalam Dempster-Shafer</h5>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="0">
                <div class="card-modern p-3 h-100">
                    <strong class="d-block mb-1">θ (Frame of Discernment)</strong>
                    <span class="text-muted small">Himpunan semua kemungkinan fakultas/jurusan yang bisa direkomendasikan.</span>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card-modern p-3 h-100">
                    <strong class="d-block mb-1">Mass Function m(X)</strong>
                    <span class="text-muted small">Seberapa besar satu evidence (jawaban) mendukung suatu jurusan tertentu.</span>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card-modern p-3 h-100">
                    <strong class="d-block mb-1">Belief</strong>
                    <span class="text-muted small">Total kepercayaan minimum yang benar-benar didukung evidence langsung.</span>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card-modern p-3 h-100">
                    <strong class="d-block mb-1">Plausibility</strong>
                    <span class="text-muted small">Batas atas kepercayaan — kemungkinan maksimum bila ketidakpastian yang tersisa ternyata mendukung juga.</span>
                </div>
            </div>
        </div>

        <!-- ===== CONTOH PERHITUNGAN NYATA ===== -->
        <div class="row justify-content-center mt-4">
            <div class="col-lg-10" data-aos="fade-up">
                <div class="glass-card p-4 p-md-5">
                    <h5 class="fw-bold mb-3">📊 Contoh Perhitungan Nyata</h5>
                    <p class="text-muted">Misalkan seorang siswa menjawab <strong>"Sangat Setuju"</strong> pada 2 pertanyaan yang sama-sama mendukung jurusan <strong>Teknik Informatika</strong>:</p>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered align-middle bg-white">
                            <thead class="table-light"><tr><th>Evidence</th><th>Belief thd Teknik Informatika</th><th>θ (tidak tahu)</th></tr></thead>
                            <tbody>
                                <tr><td>E1: "Saya suka pemrograman"</td><td>0.85</td><td>0.15</td></tr>
                                <tr><td>E2: "Saya suka Matematika"</td><td>0.70</td><td>0.30</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="fw-semibold mb-2">Langkah kombinasi:</p>
                    <div class="bg-light rounded-3 p-3 mb-2" style="font-family:'Courier New',monospace; font-size:0.88rem;">
                        m₃(TI) = m1(TI)·m2(TI) + m1(TI)·m2(θ) + m1(θ)·m2(TI)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp; = (0.85 × 0.70) + (0.85 × 0.30) + (0.15 × 0.70)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp; = 0.595 + 0.255 + 0.105 = <strong class="text-primary">0.955</strong><br><br>
                        K (konflik) = 0 &nbsp;(tidak ada evidence yang mendukung jurusan lain)<br>
                        Belief akhir = 0.955 / (1 − 0) = <strong class="text-success">95.5%</strong> ✅
                    </div>
                    <p class="text-muted small mb-0">Semakin banyak evidence konsisten yang mendukung satu jurusan/fakultas yang sama, semakin tinggi dan presisi nilai belief-nya — inilah yang membuat rekomendasi SiJurusan semakin akurat seiring semakin banyak pertanyaan yang dijawab jujur.</p>
                </div>
            </div>
        </div>

        <!-- ===== BAGAIMANA SISTEM PAKAR BEKERJA ===== -->
        <div class="row g-4 mt-4">
            <div class="col-12 text-center" data-aos="fade-up">
                <h5 class="fw-bold mb-3">⚙️ Alur Kerja Sistem Pakar Ini</h5>
            </div>
            <?php
            $alurKerja = [
                ['icon' => 'bi-list-check', 'title' => '1. Kumpulkan Evidence', 'desc' => 'Setiap jawaban skala 1-5 pada pertanyaan menjadi evidence dengan bobot sesuai tingkat kesetujuan.'],
                ['icon' => 'bi-diagram-3-fill', 'title' => '2. Kombinasikan Evidence', 'desc' => 'Setiap evidence baru dikombinasikan dengan evidence sebelumnya memakai Dempster\'s Rule.'],
                ['icon' => 'bi-bank2', 'title' => '3. Agregasi ke Fakultas', 'desc' => 'Belief seluruh jurusan dijumlahkan per fakultas induknya agar rekomendasi tidak ambigu.'],
                ['icon' => 'bi-trophy-fill', 'title' => '4. Rekomendasi Final', 'desc' => 'Fakultas dengan belief agregat tertinggi jadi rekomendasi utama, lengkap jurusan unggulannya.'],
            ];
            foreach ($alurKerja as $i => $a): ?>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="card-modern p-4 text-center h-100">
                    <i class="bi <?= $a['icon'] ?> fs-2 mb-2" style="color: var(--sky-blue-dark);"></i>
                    <h6 class="fw-bold mb-1"><?= $a['title'] ?></h6>
                    <p class="text-muted small mb-0"><?= $a['desc'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== CARA KERJA ===== -->
<section class="section-padding section-tint-orange">
    <span class="bg-blob bg-blob-2"></span>
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Cara Kerja</span>
            <h2 class="section-title">Langkah Konsultasi</h2>
        </div>
        <div class="row g-4">
            <?php
            $steps = [
                ['icon' => 'bi-person-check-fill', 'title' => 'Isi Data / Login', 'desc' => 'Masuk sebagai siswa atau lanjut sebagai tamu.'],
                ['icon' => 'bi-list-check', 'title' => 'Jawab Pertanyaan', 'desc' => 'Jawab pertanyaan seputar minat, bakat, dan kepribadian.'],
                ['icon' => 'bi-cpu-fill', 'title' => 'Proses Dempster-Shafer', 'desc' => 'Sistem menghitung belief & plausibility tiap jurusan.'],
                ['icon' => 'bi-trophy-fill', 'title' => 'Lihat Hasil', 'desc' => 'Dapatkan ranking jurusan terbaik beserta penjelasannya.'],
            ];
            foreach ($steps as $i => $s): ?>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="step-card glass-card h-100">
                    <div class="step-number"><?= $i + 1 ?></div>
                    <i class="bi <?= $s['icon'] ?> fs-1 mb-3" style="color: var(--sky-blue-dark);"></i>
                    <h5 class="fw-bold"><?= $s['title'] ?></h5>
                    <p class="text-muted small mb-0"><?= $s['desc'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== DAFTAR FAKULTAS ===== -->
<section class="section-padding section-tint-green">
    <span class="bg-blob bg-blob-4"></span>
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Jelajahi Pilihan</span>
            <h2 class="section-title">Daftar Fakultas</h2>
            <p class="section-subtitle mx-auto">Klik salah satu fakultas untuk melihat daftar jurusan yang tersedia</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach (array_slice($fakultas, 0, 12) as $i => $f): ?>
            <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="<?= ($i % 4) * 100 ?>">
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
        <?php if (count($fakultas) > 12): ?>
        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>fakultas" class="btn btn-outline-navy rounded-pill px-4">Lihat Semua Fakultas (<?= count($fakultas) ?>) <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ===== STATISTIK ===== -->
<section class="section-padding" style="background: var(--gradient-navy);">
    <div class="container">
        <div class="row text-center text-white g-4">
            <div class="col-md-4" data-aos="fade-up"><i class="bi bi-mortarboard fs-1" style="color: var(--sky-blue);"></i><h2 class="fw-bold mt-2"><?= $totalFakultas ?></h2><p class="opacity-75">Fakultas Tersedia</p></div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100"><i class="bi bi-book fs-1" style="color: var(--orange);"></i><h2 class="fw-bold mt-2"><?= $totalJurusan ?></h2><p class="opacity-75">Program Studi</p></div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200"><i class="bi bi-people fs-1" style="color: var(--green);"></i><h2 class="fw-bold mt-2"><?= $totalKonsultasi ?></h2><p class="opacity-75">Siswa Terbantu</p></div>
        </div>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="section-padding section-tint-blue" id="faq">
    <span class="bg-blob bg-blob-1"></span>
    <span class="bg-blob bg-blob-2"></span>
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Pertanyaan Umum</span>
            <h2 class="section-title">FAQ</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <?php
                    $faqs = [
                        ['q' => 'Apakah konsultasi ini berbayar?', 'a' => 'Tidak, seluruh proses konsultasi menggunakan sistem ini sepenuhnya gratis untuk siswa SMA Muhammadiyah 18 Sunggal.'],
                        ['q' => 'Apakah saya harus login untuk konsultasi?', 'a' => 'Tergantung pengaturan yang ditentukan oleh admin. Jika mode wajib login aktif, Anda perlu mendaftar akun terlebih dahulu.'],
                        ['q' => 'Bagaimana metode Dempster-Shafer bekerja?', 'a' => 'Metode ini menghitung tingkat kepercayaan (belief) dan kemungkinan (plausibility) dari setiap jurusan berdasarkan kombinasi bukti (evidence) dari jawaban Anda, lalu mengombinasikannya secara matematis.'],
                        ['q' => 'Apakah hasil konsultasi dapat diunduh?', 'a' => 'Ya, hasil konsultasi dapat dicetak maupun diunduh dalam format PDF lengkap dengan rincian perhitungan.'],
                    ];
                    foreach ($faqs as $i => $faq): ?>
                    <div class="accordion-item glass-card mb-3 border-0 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $i ?>">
                                <?= $faq['q'] ?>
                            </button>
                        </h2>
                        <div id="faq<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted"><?= $faq['a'] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== TESTIMONI ===== -->
<?php if (!empty($testimoni)): ?>
<section class="section-padding section-tint-orange">
    <span class="bg-blob bg-blob-3"></span>
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Testimoni</span>
            <h2 class="section-title">Kata Mereka</h2>
        </div>
        <div class="row g-4">
            <?php foreach ($testimoni as $t): ?>
            <div class="col-md-4" data-aos="fade-up">
                <div class="glass-card p-4 h-100">
                    <div class="mb-2"><?php for($i=0;$i<$t['rating'];$i++) echo '<i class="bi bi-star-fill text-warning"></i>'; ?></div>
                    <p class="text-muted fst-italic">"<?= clean($t['pesan']) ?>"</p>
                    <h6 class="fw-bold mb-0 mt-3"><?= clean($t['nama']) ?></h6>
                    <small class="text-muted"><?= clean($t['sekolah_asal'] ?? '') ?></small>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ===== CTA ===== -->
<section class="section-padding text-center">
    <div class="container" data-aos="zoom-in">
        <div class="glass-card p-5" style="background: var(--gradient-main); color: white;">
            <h2 class="fw-bold mb-3">Siap Menemukan Jurusan Impianmu?</h2>
            <p class="opacity-90 mb-4">Mulai konsultasi sekarang dan dapatkan rekomendasi jurusan PTN yang sesuai dengan dirimu.</p>
            <a href="<?= BASE_URL ?>konsultasi" class="btn btn-light btn-lg rounded-pill px-5 fw-bold">Mulai Sekarang</a>
        </div>
    </div>
</section>

<?php require VIEW_PATH . 'layout/footer.php'; ?>
