<?php require VIEW_PATH . 'layout/header.php'; ?>
<section class="section-padding section-tint-orange">
    <span class="bg-blob bg-blob-2"></span>
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">🎓 Tentang</span>
            <h2 class="section-title">Mengenal SiJurusan Lebih Dekat</h2>
        </div>

        <!-- ===== APA ITU SIJURUSAN (2 PARAGRAF) ===== -->
        <div class="glass-card p-5 mb-4" data-aos="fade-up">
            <h4 class="fw-bold mb-3">📖 Apa itu SiJurusan?</h4>
            <p class="text-muted">SiJurusan adalah sistem pakar (expert system) berbasis web yang dikembangkan khusus untuk membantu siswa kelas XII SMA Muhammadiyah 18 Sunggal dalam menentukan pilihan jurusan Perguruan Tinggi Negeri (PTN) yang paling sesuai dengan potensi diri mereka. Sistem ini menggabungkan data minat, bakat, kemampuan akademik, kepribadian, dan tujuan karier siswa ke dalam satu kerangka penalaran yang sistematis, sehingga rekomendasi yang dihasilkan tidak sekadar tebakan, melainkan hasil analisis berbasis data yang dapat dijelaskan secara logis.</p>
            <p class="text-muted mb-0">Kesalahan memilih jurusan (salah jurusan) adalah masalah umum yang dialami banyak mahasiswa baru di Indonesia, berdampak pada motivasi belajar yang menurun hingga keputusan pindah jurusan yang merugikan waktu dan biaya. SiJurusan hadir sebagai alat bantu preventif: siswa dapat berkonsultasi secara mandiri kapan saja, mendapatkan hasil instan lengkap dengan penjelasan mengapa suatu jurusan direkomendasikan, dan tetap didorong untuk berdiskusi lebih lanjut dengan Guru BK sebelum mengambil keputusan akhir.</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6" data-aos="fade-right">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-2">🎯 Tujuan</h5>
                    <p class="text-muted mb-0">Membantu siswa SMA Muhammadiyah 18 Sunggal menentukan jurusan Perguruan Tinggi Negeri yang paling sesuai dengan minat, bakat, kemampuan, kepribadian, dan tujuan kariernya secara objektif dan berbasis data.</p>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-2">💡 Manfaat</h5>
                    <p class="text-muted mb-0">Mengurangi kesalahan pemilihan jurusan, mempercepat proses konsultasi dengan Guru BK, dan memberikan gambaran prospek karier, mata kuliah, hingga estimasi gaji sebelum siswa mendaftar ke perguruan tinggi.</p>
                </div>
            </div>
        </div>

        <!-- ===== METODE DEMPSTER-SHAFER DETAIL ===== -->
        <div class="glass-card p-5 mb-4" data-aos="fade-up">
            <h4 class="fw-bold mb-3">🧮 Metode Dempster-Shafer: Penjelasan Lengkap</h4>
            <p class="text-muted">Dempster-Shafer adalah metode penalaran untuk menggabungkan beberapa <strong>bukti (evidence)</strong> yang masing-masing punya tingkat kepercayaan tidak pasti, lalu menghasilkan kesimpulan yang lebih meyakinkan. Berbeda dari probabilitas klasik yang mengharuskan totalnya 100%, metode ini punya konsep <strong>"ketidaktahuan" (uncertainty)</strong> yang diakui secara eksplisit — cocok untuk kasus seperti pemilihan jurusan, di mana jawaban siswa tidak selalu memberi kepastian mutlak.</p>

            <h6 class="fw-bold mt-4 mb-2">Istilah Kunci</h6>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100"><strong>Frame of Discernment (θ)</strong><br><span class="text-muted small">Himpunan semua kemungkinan jurusan yang bisa direkomendasikan.</span></div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100"><strong>Mass Function m(X)</strong><br><span class="text-muted small">Seberapa besar suatu evidence mendukung himpunan jurusan X.</span></div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100"><strong>Belief</strong><br><span class="text-muted small">Total kepercayaan minimum terhadap suatu jurusan.</span></div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100"><strong>Plausibility</strong><br><span class="text-muted small">Kepercayaan maksimum yang mungkin (belum terbantahkan evidence lain).</span></div>
                </div>
            </div>

            <h6 class="fw-bold mt-4 mb-2">Rumus Kombinasi (Dempster's Rule of Combination)</h6>
            <div class="bg-light rounded-3 p-4 text-center mb-2" style="font-family:'Courier New',monospace;">
                <div class="fs-5 mb-2">m₃(Z) = [ Σ m₁(X)·m₂(Y) untuk X∩Y=Z ] / (1 − K)</div>
                <div class="fs-6 text-muted">K = Σ m₁(X)·m₂(Y) untuk X∩Y = ∅ &nbsp;(nilai konflik)</div>
            </div>
            <p class="text-muted small">m₁ dan m₂ adalah dua mass function yang akan dikombinasikan (misalnya belief dari evidence sebelumnya dan belief dari evidence baru), sedangkan m₃ adalah hasil kombinasi keduanya setelah dinormalisasi terhadap nilai konflik K.</p>

            <h6 class="fw-bold mt-4 mb-3">📊 Contoh Perhitungan Nyata</h6>
            <p class="text-muted">Misalkan seorang siswa menjawab <strong>"Ya"</strong> pada 2 pertanyaan yang sama-sama mendukung jurusan <strong>Teknik Informatika</strong>:</p>

            <div class="table-responsive mb-3">
                <table class="table table-bordered align-middle">
                    <thead class="table-light"><tr><th>Evidence</th><th>Belief thd Teknik Informatika</th><th>θ (tidak tahu)</th></tr></thead>
                    <tbody>
                        <tr><td>E1: "Saya suka pemrograman"</td><td>0.85</td><td>0.15</td></tr>
                        <tr><td>E2: "Saya suka Matematika"</td><td>0.70</td><td>0.30</td></tr>
                    </tbody>
                </table>
            </div>

            <p class="fw-semibold mb-2">Langkah 1 — Kombinasikan E1 dan E2:</p>
            <div class="bg-light rounded-3 p-3 mb-3" style="font-family:'Courier New',monospace; font-size:0.9rem;">
                m₃(TI) = m1(TI)·m2(TI) + m1(TI)·m2(θ) + m1(θ)·m2(TI)<br>
                &nbsp;&nbsp;&nbsp;&nbsp; = (0.85 × 0.70) + (0.85 × 0.30) + (0.15 × 0.70)<br>
                &nbsp;&nbsp;&nbsp;&nbsp; = 0.595 + 0.255 + 0.105 = <strong>0.955</strong><br><br>
                m₃(θ) = m1(θ)·m2(θ) = 0.15 × 0.30 = <strong>0.045</strong><br><br>
                K = 0 &nbsp;(karena tidak ada evidence yang mendukung jurusan lain secara eksklusif)<br><br>
                Belief akhir Teknik Informatika = 0.955 / (1 − 0) = <strong>95.5%</strong>
            </div>

            <p class="fw-semibold mb-2">Langkah 2 — Jika ada evidence ketiga yang mendukung jurusan LAIN:</p>
            <p class="text-muted">Misalkan evidence ketiga "Saya suka berhitung" mendukung <strong>Akuntansi</strong> dengan belief 0.60. Karena Akuntansi ≠ Teknik Informatika, terjadi <strong>konflik (K)</strong> antara kedua hipotesis ini. Sistem akan menormalisasi ulang seluruh nilai belief dengan membagi (1−K), sehingga jurusan yang paling konsisten didukung banyak evidence akan tetap unggul, sementara jurusan yang jarang didukung akan turun proporsinya.</p>
            <p class="text-muted mb-0">Semakin banyak pertanyaan relevan yang dijawab "Ya" secara konsisten untuk satu bidang tertentu, semakin tinggi dan presisi nilai belief jurusan tersebut — inilah yang membuat rekomendasi SiJurusan semakin akurat seiring semakin banyak evidence yang terkumpul dari jawaban siswa.</p>
        </div>

        <div class="glass-card p-4" data-aos="fade-up">
            <h5 class="fw-bold mb-2">👨‍💻 Tim Pengembang</h5>
            <p class="text-muted mb-0">Sistem ini dikembangkan sebagai bagian dari penelitian terapan program studi Manajemen Informatika, dengan dukungan penuh dari pihak SMA Muhammadiyah 18 Sunggal sebagai mitra implementasi.</p>
        </div>
    </div>
</section>
<?php require VIEW_PATH . 'layout/footer.php'; ?>
