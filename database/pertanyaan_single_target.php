<?php
/**
 * Bank Pertanyaan Single-Target (Terurut per Fakultas)
 * ============================================================
 * Setiap pertanyaan HANYA mendukung SATU jurusan (bukan many-to-many),
 * sesuai permintaan: "1 pertanyaan fokus hanya 1 hasil". Pertanyaan
 * diurutkan BERKELOMPOK sesuai fakultas -> jurusan agar konsisten dan
 * mudah ditelusuri (misal soal 1-10 untuk Kedokteran, dst).
 *
 * Format tiap item: ['teks' => '...', 'kategori' => '...', 'jurusan' => 'Nama Jurusan', 'belief' => float]
 *
 * Nilai belief bervariasi (0.62 - 0.92) mencerminkan kekuatan indikator
 * berbeda per pertanyaan -- BUKAN nilai seragam.
 */

return [
    // ================= FAKULTAS KEDOKTERAN =================
    ['teks' => 'Saya ingin membantu menyembuhkan orang yang sakit', 'kategori' => 'tujuan_karier', 'jurusan' => 'Kedokteran', 'belief' => 0.90],
    ['teks' => 'Saya menyukai pelajaran Biologi dan tertarik pada tubuh manusia', 'kategori' => 'minat', 'jurusan' => 'Kedokteran', 'belief' => 0.82],
    ['teks' => 'Saya tidak takut melihat darah atau luka', 'kategori' => 'kepribadian', 'jurusan' => 'Kedokteran', 'belief' => 0.75],
    ['teks' => 'Saya tertarik pada kesehatan gigi dan mulut', 'kategori' => 'minat', 'jurusan' => 'Kedokteran Gigi', 'belief' => 0.88],
    ['teks' => 'Saya cekatan dan teliti menggunakan tangan untuk pekerjaan presisi', 'kategori' => 'bakat', 'jurusan' => 'Kedokteran Gigi', 'belief' => 0.78],

    // ================= FAKULTAS FARMASI =================
    ['teks' => 'Saya tertarik pada obat-obatan dan cara kerja senyawa kimia dalam tubuh', 'kategori' => 'minat', 'jurusan' => 'Farmasi', 'belief' => 0.88],
    ['teks' => 'Saya ingin bekerja sebagai apoteker atau di industri farmasi', 'kategori' => 'tujuan_karier', 'jurusan' => 'Farmasi', 'belief' => 0.90],
    ['teks' => 'Saya teliti dalam menghitung takaran dan dosis secara akurat', 'kategori' => 'kemampuan', 'jurusan' => 'Farmasi', 'belief' => 0.72],

    // ================= FAKULTAS ILMU KEPERAWATAN =================
    ['teks' => 'Saya senang merawat dan mendampingi orang lain yang sedang sakit', 'kategori' => 'minat', 'jurusan' => 'Keperawatan', 'belief' => 0.88],
    ['teks' => 'Saya memiliki empati tinggi dan sabar menghadapi pasien', 'kategori' => 'kepribadian', 'jurusan' => 'Keperawatan', 'belief' => 0.80],
    ['teks' => 'Saya mampu bekerja di bawah tekanan dengan tenang', 'kategori' => 'kemampuan', 'jurusan' => 'Keperawatan', 'belief' => 0.68],

    // ================= FAKULTAS KESEHATAN MASYARAKAT DAN GIZI =================
    ['teks' => 'Saya tertarik pada pola makan sehat dan kandungan gizi makanan', 'kategori' => 'minat', 'jurusan' => 'Gizi', 'belief' => 0.88],
    ['teks' => 'Saya ingin bekerja sebagai ahli gizi klinis atau konsultan kesehatan', 'kategori' => 'tujuan_karier', 'jurusan' => 'Gizi', 'belief' => 0.85],

    // ================= FAKULTAS KEDOKTERAN HEWAN =================
    ['teks' => 'Saya menyukai dan peduli pada kesehatan hewan', 'kategori' => 'minat', 'jurusan' => 'Kedokteran Hewan', 'belief' => 0.90],
    ['teks' => 'Saya bercita-cita menjadi dokter hewan', 'kategori' => 'tujuan_karier', 'jurusan' => 'Kedokteran Hewan', 'belief' => 0.85],

    // ================= FAKULTAS TEKNIK =================
    ['teks' => 'Saya tertarik pada kelistrikan, rangkaian, dan elektronika', 'kategori' => 'minat', 'jurusan' => 'Teknik Elektro', 'belief' => 0.86],
    ['teks' => 'Saya ingin bekerja di sektor kelistrikan atau telekomunikasi', 'kategori' => 'tujuan_karier', 'jurusan' => 'Teknik Elektro', 'belief' => 0.74],
    ['teks' => 'Saya senang membongkar dan merakit mesin atau alat mekanik', 'kategori' => 'bakat', 'jurusan' => 'Teknik Mesin', 'belief' => 0.86],
    ['teks' => 'Saya tertarik bekerja di industri manufaktur atau otomotif', 'kategori' => 'tujuan_karier', 'jurusan' => 'Teknik Mesin', 'belief' => 0.72],
    ['teks' => 'Saya tertarik pada bangunan, jembatan, dan infrastruktur', 'kategori' => 'minat', 'jurusan' => 'Teknik Sipil', 'belief' => 0.87],
    ['teks' => 'Saya ingin terlibat dalam proyek pembangunan nasional', 'kategori' => 'tujuan_karier', 'jurusan' => 'Teknik Sipil', 'belief' => 0.73],
    ['teks' => 'Saya senang mengatur efisiensi proses kerja dan produksi', 'kategori' => 'minat', 'jurusan' => 'Teknik Industri', 'belief' => 0.84],
    ['teks' => 'Saya ingin bekerja sebagai konsultan manajemen operasional', 'kategori' => 'tujuan_karier', 'jurusan' => 'Teknik Industri', 'belief' => 0.70],
    ['teks' => 'Saya senang menggambar dan mendesain ruang atau bangunan', 'kategori' => 'bakat', 'jurusan' => 'Arsitektur', 'belief' => 0.88],
    ['teks' => 'Saya ingin berkarier sebagai arsitek profesional', 'kategori' => 'tujuan_karier', 'jurusan' => 'Arsitektur', 'belief' => 0.80],
    ['teks' => 'Saya senang meneliti reaksi dan proses produksi bahan kimia', 'kategori' => 'minat', 'jurusan' => 'Teknik Kimia', 'belief' => 0.85],
    ['teks' => 'Saya tertarik bekerja di industri petrokimia atau energi', 'kategori' => 'tujuan_karier', 'jurusan' => 'Teknik Kimia', 'belief' => 0.73],
    ['teks' => 'Saya peduli pada isu lingkungan hidup dan pengelolaan limbah', 'kategori' => 'minat', 'jurusan' => 'Teknik Lingkungan', 'belief' => 0.86],
    ['teks' => 'Saya ingin berkontribusi menjaga kelestarian lingkungan', 'kategori' => 'tujuan_karier', 'jurusan' => 'Teknik Lingkungan', 'belief' => 0.74],
    ['teks' => 'Saya tertarik pada dunia perkapalan dan transportasi laut', 'kategori' => 'minat', 'jurusan' => 'Teknik Perkapalan', 'belief' => 0.87],
    ['teks' => 'Saya ingin bekerja di galangan kapal atau industri maritim', 'kategori' => 'tujuan_karier', 'jurusan' => 'Teknik Perkapalan', 'belief' => 0.75],

    // ================= FAKULTAS ILMU KOMPUTER =================
    ['teks' => 'Saya tertarik membuat aplikasi, website, atau program komputer', 'kategori' => 'minat', 'jurusan' => 'Teknik Informatika', 'belief' => 0.90],
    ['teks' => 'Saya senang memecahkan teka-teki logika dan algoritma', 'kategori' => 'bakat', 'jurusan' => 'Teknik Informatika', 'belief' => 0.80],
    ['teks' => 'Saya bercita-cita bekerja di industri teknologi atau startup digital', 'kategori' => 'tujuan_karier', 'jurusan' => 'Teknik Informatika', 'belief' => 0.72],
    ['teks' => 'Saya tertarik pada manajemen data dan proses bisnis berbasis sistem', 'kategori' => 'minat', 'jurusan' => 'Sistem Informasi', 'belief' => 0.85],
    ['teks' => 'Saya senang menganalisis dan merancang alur sistem informasi organisasi', 'kategori' => 'kemampuan', 'jurusan' => 'Sistem Informasi', 'belief' => 0.76],
    ['teks' => 'Saya ingin menjadi konsultan IT atau business analyst', 'kategori' => 'tujuan_karier', 'jurusan' => 'Sistem Informasi', 'belief' => 0.68],
    ['teks' => 'Saya senang mempelajari kecerdasan buatan (AI) dan machine learning', 'kategori' => 'minat', 'jurusan' => 'Ilmu Komputer', 'belief' => 0.88],
    ['teks' => 'Saya tertarik pada riset teori komputasi dan algoritma tingkat lanjut', 'kategori' => 'minat', 'jurusan' => 'Ilmu Komputer', 'belief' => 0.75],
    ['teks' => 'Saya tertarik pada perangkat keras dan arsitektur komputer', 'kategori' => 'minat', 'jurusan' => 'Teknik Komputer', 'belief' => 0.86],
    ['teks' => 'Saya senang merakit dan memperbaiki komputer atau jaringan', 'kategori' => 'bakat', 'jurusan' => 'Teknik Komputer', 'belief' => 0.74],
    ['teks' => 'Saya senang mengolah dan menganalisis data dalam jumlah besar', 'kategori' => 'kemampuan', 'jurusan' => 'Data Science', 'belief' => 0.88],
    ['teks' => 'Saya ingin bekerja sebagai analis data atau data scientist', 'kategori' => 'tujuan_karier', 'jurusan' => 'Data Science', 'belief' => 0.82],
    ['teks' => 'Saya tertarik pada isu keamanan data dan celah sistem komputer', 'kategori' => 'minat', 'jurusan' => 'Keamanan Siber', 'belief' => 0.90],
    ['teks' => 'Saya ingin bekerja di bidang keamanan siber atau digital forensik', 'kategori' => 'tujuan_karier', 'jurusan' => 'Keamanan Siber', 'belief' => 0.80],

    // ================= FAKULTAS GEOGRAFI DAN PERENCANAAN =================
    ['teks' => 'Saya tertarik pada peta, wilayah, dan fenomena kebumian', 'kategori' => 'minat', 'jurusan' => 'Geografi', 'belief' => 0.87],
    ['teks' => 'Saya ingin bekerja di bidang pemetaan atau geospasial', 'kategori' => 'tujuan_karier', 'jurusan' => 'Geografi', 'belief' => 0.72],
    ['teks' => 'Saya senang merancang konsep tata ruang dan pembangunan kota', 'kategori' => 'minat', 'jurusan' => 'Perencanaan Wilayah dan Kota', 'belief' => 0.86],
    ['teks' => 'Saya ingin bekerja sebagai perencana kota atau urban planner', 'kategori' => 'tujuan_karier', 'jurusan' => 'Perencanaan Wilayah dan Kota', 'belief' => 0.78],

    // ================= FAKULTAS EKONOMI DAN BISNIS =================
    ['teks' => 'Saya senang mengatur dan memimpin sebuah tim', 'kategori' => 'bakat', 'jurusan' => 'Manajemen', 'belief' => 0.85],
    ['teks' => 'Saya ingin membangun bisnis atau menjadi wirausahawan', 'kategori' => 'tujuan_karier', 'jurusan' => 'Manajemen', 'belief' => 0.75],
    ['teks' => 'Saya menyukai angka dan senang menyusun laporan keuangan', 'kategori' => 'minat', 'jurusan' => 'Akuntansi', 'belief' => 0.90],
    ['teks' => 'Saya sangat teliti dan detail dalam bekerja', 'kategori' => 'kepribadian', 'jurusan' => 'Akuntansi', 'belief' => 0.76],
    ['teks' => 'Saya tertarik pada isu ekonomi makro dan kebijakan pemerintah', 'kategori' => 'minat', 'jurusan' => 'Ekonomi Pembangunan', 'belief' => 0.86],
    ['teks' => 'Saya ingin bekerja di Bank Indonesia atau lembaga riset ekonomi', 'kategori' => 'tujuan_karier', 'jurusan' => 'Ekonomi Pembangunan', 'belief' => 0.72],
    ['teks' => 'Saya tertarik pada bisnis berbasis teknologi dan media sosial', 'kategori' => 'minat', 'jurusan' => 'Bisnis Digital', 'belief' => 0.87],
    ['teks' => 'Saya ingin membangun startup atau bisnis digital sendiri', 'kategori' => 'tujuan_karier', 'jurusan' => 'Bisnis Digital', 'belief' => 0.76],
    ['teks' => 'Saya tertarik pada dunia perbankan dan investasi', 'kategori' => 'minat', 'jurusan' => 'Perbankan dan Keuangan', 'belief' => 0.86],
    ['teks' => 'Saya ingin bekerja di bank atau perusahaan sekuritas', 'kategori' => 'tujuan_karier', 'jurusan' => 'Perbankan dan Keuangan', 'belief' => 0.75],

    // ================= FAKULTAS HUKUM =================
    ['teks' => 'Saya tertarik pada isu keadilan, hukum, dan peraturan', 'kategori' => 'minat', 'jurusan' => 'Ilmu Hukum', 'belief' => 0.90],
    ['teks' => 'Saya bercita-cita menjadi pengacara, hakim, atau notaris', 'kategori' => 'tujuan_karier', 'jurusan' => 'Ilmu Hukum', 'belief' => 0.85],
    ['teks' => 'Saya memiliki kemampuan berargumentasi dan bernegosiasi', 'kategori' => 'bakat', 'jurusan' => 'Ilmu Hukum', 'belief' => 0.72],

    // ================= FAKULTAS PENDIDIKAN =================
    ['teks' => 'Saya senang mengajar dan membimbing anak-anak belajar', 'kategori' => 'minat', 'jurusan' => 'Pendidikan Guru Sekolah Dasar', 'belief' => 0.88],
    ['teks' => 'Saya bercita-cita menjadi guru SD', 'kategori' => 'tujuan_karier', 'jurusan' => 'Pendidikan Guru Sekolah Dasar', 'belief' => 0.80],
    ['teks' => 'Saya senang menjelaskan konsep matematika dengan cara sederhana', 'kategori' => 'bakat', 'jurusan' => 'Pendidikan Matematika', 'belief' => 0.86],
    ['teks' => 'Saya bercita-cita menjadi guru Matematika', 'kategori' => 'tujuan_karier', 'jurusan' => 'Pendidikan Matematika', 'belief' => 0.78],
    ['teks' => 'Saya menyukai dan mahir berkomunikasi dalam Bahasa Inggris', 'kategori' => 'minat', 'jurusan' => 'Pendidikan Bahasa Inggris', 'belief' => 0.87],
    ['teks' => 'Saya bercita-cita menjadi guru Bahasa Inggris', 'kategori' => 'tujuan_karier', 'jurusan' => 'Pendidikan Bahasa Inggris', 'belief' => 0.78],
    ['teks' => 'Saya senang mendengarkan masalah dan memberi solusi bagi orang lain', 'kategori' => 'minat', 'jurusan' => 'Bimbingan dan Konseling', 'belief' => 0.87],
    ['teks' => 'Saya ingin menjadi konselor atau psikolog pendidikan', 'kategori' => 'tujuan_karier', 'jurusan' => 'Bimbingan dan Konseling', 'belief' => 0.78],

    // ================= FAKULTAS ILMU KEOLAHRAGAAN =================
    ['teks' => 'Saya menyukai riset performa fisik dan sport science', 'kategori' => 'minat', 'jurusan' => 'Ilmu Keolahragaan', 'belief' => 0.85],
    ['teks' => 'Saya ingin menjadi analis performa atlet atau sport scientist', 'kategori' => 'tujuan_karier', 'jurusan' => 'Ilmu Keolahragaan', 'belief' => 0.74],
    ['teks' => 'Saya menyukai olahraga dan senang melatih orang lain', 'kategori' => 'minat', 'jurusan' => 'Pendidikan Olahraga', 'belief' => 0.86],
    ['teks' => 'Saya bercita-cita menjadi guru olahraga atau pelatih', 'kategori' => 'tujuan_karier', 'jurusan' => 'Pendidikan Olahraga', 'belief' => 0.76],

    // ================= FAKULTAS PSIKOLOGI =================
    ['teks' => 'Saya tertarik memahami perilaku dan pikiran manusia', 'kategori' => 'minat', 'jurusan' => 'Psikologi', 'belief' => 0.90],
    ['teks' => 'Saya ingin menjadi psikolog profesional', 'kategori' => 'tujuan_karier', 'jurusan' => 'Psikologi', 'belief' => 0.82],
    ['teks' => 'Saya memiliki empati dan kepekaan sosial yang tinggi', 'kategori' => 'kepribadian', 'jurusan' => 'Psikologi', 'belief' => 0.74],

    // ================= FAKULTAS MIPA =================
    ['teks' => 'Saya menyukai pelajaran Matematika dan berpikir logis', 'kategori' => 'minat', 'jurusan' => 'Matematika', 'belief' => 0.88],
    ['teks' => 'Saya senang memecahkan soal-soal matematika yang rumit', 'kategori' => 'bakat', 'jurusan' => 'Matematika', 'belief' => 0.76],
    ['teks' => 'Saya menyukai pelajaran Fisika dan fenomena alam semesta', 'kategori' => 'minat', 'jurusan' => 'Fisika', 'belief' => 0.87],
    ['teks' => 'Saya ingin menjadi peneliti atau ilmuwan fisika', 'kategori' => 'tujuan_karier', 'jurusan' => 'Fisika', 'belief' => 0.72],
    ['teks' => 'Saya menyukai pelajaran Kimia dan senang bereksperimen', 'kategori' => 'minat', 'jurusan' => 'Kimia', 'belief' => 0.87],
    ['teks' => 'Saya teliti mengamati reaksi kimia di laboratorium', 'kategori' => 'kemampuan', 'jurusan' => 'Kimia', 'belief' => 0.73],
    ['teks' => 'Saya menyukai pelajaran Biologi dan tertarik pada makhluk hidup', 'kategori' => 'minat', 'jurusan' => 'Biologi', 'belief' => 0.87],
    ['teks' => 'Saya ingin menjadi peneliti biologi atau bioteknologi', 'kategori' => 'tujuan_karier', 'jurusan' => 'Biologi', 'belief' => 0.72],
    ['teks' => 'Saya senang menganalisis pola dari sekumpulan data statistik', 'kategori' => 'kemampuan', 'jurusan' => 'Statistika', 'belief' => 0.86],
    ['teks' => 'Saya ingin menjadi ahli statistik atau data analyst', 'kategori' => 'tujuan_karier', 'jurusan' => 'Statistika', 'belief' => 0.75],
    ['teks' => 'Saya menyukai kegiatan hitungan probabilitas dan risiko keuangan', 'kategori' => 'bakat', 'jurusan' => 'Aktuaria', 'belief' => 0.86],
    ['teks' => 'Saya ingin menjadi aktuaris bersertifikat', 'kategori' => 'tujuan_karier', 'jurusan' => 'Aktuaria', 'belief' => 0.78],

    // ================= FAKULTAS ILMU SOSIAL DAN POLITIK =================
    ['teks' => 'Saya tertarik pada sistem pemerintahan dan otonomi daerah', 'kategori' => 'minat', 'jurusan' => 'Ilmu Pemerintahan', 'belief' => 0.86],
    ['teks' => 'Saya ingin berkarier menjadi ASN di pemerintahan', 'kategori' => 'tujuan_karier', 'jurusan' => 'Ilmu Pemerintahan', 'belief' => 0.74],
    ['teks' => 'Saya tertarik pada fenomena sosial dan interaksi masyarakat', 'kategori' => 'minat', 'jurusan' => 'Sosiologi', 'belief' => 0.87],
    ['teks' => 'Saya ingin menjadi peneliti sosial atau CSR officer', 'kategori' => 'tujuan_karier', 'jurusan' => 'Sosiologi', 'belief' => 0.72],
    ['teks' => 'Saya tertarik pada isu global, diplomasi, dan budaya negara lain', 'kategori' => 'minat', 'jurusan' => 'Hubungan Internasional', 'belief' => 0.88],
    ['teks' => 'Saya ingin menjadi diplomat atau bekerja di organisasi internasional', 'kategori' => 'tujuan_karier', 'jurusan' => 'Hubungan Internasional', 'belief' => 0.78],
    ['teks' => 'Saya tertarik pada tata kelola dan pelayanan pemerintahan', 'kategori' => 'minat', 'jurusan' => 'Ilmu Administrasi Negara', 'belief' => 0.85],
    ['teks' => 'Saya teliti mengikuti prosedur administrasi', 'kategori' => 'kemampuan', 'jurusan' => 'Ilmu Administrasi Negara', 'belief' => 0.70],
    ['teks' => 'Saya tertarik pada isu politik, partai, dan perilaku pemilih', 'kategori' => 'minat', 'jurusan' => 'Ilmu Politik', 'belief' => 0.86],
    ['teks' => 'Saya ingin menjadi peneliti politik atau konsultan pemilu', 'kategori' => 'tujuan_karier', 'jurusan' => 'Ilmu Politik', 'belief' => 0.73],

    // ================= FAKULTAS ILMU KOMUNIKASI =================
    ['teks' => 'Saya senang berbicara di depan umum dan menyampaikan pesan', 'kategori' => 'bakat', 'jurusan' => 'Ilmu Komunikasi', 'belief' => 0.86],
    ['teks' => 'Saya ingin berkarier di bidang media atau public relations', 'kategori' => 'tujuan_karier', 'jurusan' => 'Ilmu Komunikasi', 'belief' => 0.75],
    ['teks' => 'Saya senang menulis berita, artikel, atau opini', 'kategori' => 'bakat', 'jurusan' => 'Jurnalistik', 'belief' => 0.87],
    ['teks' => 'Saya bercita-cita menjadi jurnalis', 'kategori' => 'tujuan_karier', 'jurusan' => 'Jurnalistik', 'belief' => 0.78],

    // ================= FAKULTAS ILMU BUDAYA =================
    ['teks' => 'Saya senang membaca dan menulis karya sastra', 'kategori' => 'minat', 'jurusan' => 'Sastra Indonesia', 'belief' => 0.85],
    ['teks' => 'Saya ingin menjadi penulis atau editor penerbitan', 'kategori' => 'tujuan_karier', 'jurusan' => 'Sastra Indonesia', 'belief' => 0.72],
    ['teks' => 'Saya menyukai membaca literatur berbahasa Inggris', 'kategori' => 'minat', 'jurusan' => 'Sastra Inggris', 'belief' => 0.85],
    ['teks' => 'Saya ingin menjadi penerjemah tersumpah', 'kategori' => 'tujuan_karier', 'jurusan' => 'Sastra Inggris', 'belief' => 0.74],
    ['teks' => 'Saya teliti mengklasifikasikan dan mengelola informasi', 'kategori' => 'kemampuan', 'jurusan' => 'Ilmu Perpustakaan', 'belief' => 0.82],
    ['teks' => 'Saya ingin bekerja sebagai pustakawan atau pengelola arsip', 'kategori' => 'tujuan_karier', 'jurusan' => 'Ilmu Perpustakaan', 'belief' => 0.70],

    // ================= FAKULTAS PERTANIAN =================
    ['teks' => 'Saya tertarik pada pertanian, tanaman, dan cara budidayanya', 'kategori' => 'minat', 'jurusan' => 'Agroteknologi', 'belief' => 0.87],
    ['teks' => 'Saya ingin berkontribusi pada ketahanan pangan nasional', 'kategori' => 'tujuan_karier', 'jurusan' => 'Agroteknologi', 'belief' => 0.73],
    ['teks' => 'Saya tertarik pada bisnis di sektor pertanian', 'kategori' => 'minat', 'jurusan' => 'Agribisnis', 'belief' => 0.86],
    ['teks' => 'Saya ingin menjadi pengusaha di bidang agribisnis', 'kategori' => 'tujuan_karier', 'jurusan' => 'Agribisnis', 'belief' => 0.75],
    ['teks' => 'Saya peduli pada kelestarian hutan dan alam liar', 'kategori' => 'minat', 'jurusan' => 'Kehutanan', 'belief' => 0.87],
    ['teks' => 'Saya ingin bekerja di Kementerian LHK atau konservasi hutan', 'kategori' => 'tujuan_karier', 'jurusan' => 'Kehutanan', 'belief' => 0.72],
    ['teks' => 'Saya tertarik pada teknologi pengolahan pangan modern', 'kategori' => 'minat', 'jurusan' => 'Ilmu dan Teknologi Pangan', 'belief' => 0.86],
    ['teks' => 'Saya ingin bekerja di industri makanan-minuman', 'kategori' => 'tujuan_karier', 'jurusan' => 'Ilmu dan Teknologi Pangan', 'belief' => 0.74],

    // ================= FAKULTAS PETERNAKAN =================
    ['teks' => 'Saya menyukai dan peduli pada hewan ternak', 'kategori' => 'minat', 'jurusan' => 'Peternakan', 'belief' => 0.87],
    ['teks' => 'Saya ingin bekerja di industri peternakan atau pakan ternak', 'kategori' => 'tujuan_karier', 'jurusan' => 'Peternakan', 'belief' => 0.73],

    // ================= FAKULTAS PERIKANAN DAN ILMU KELAUTAN =================
    ['teks' => 'Saya tertarik pada dunia kelautan dan budidaya perikanan', 'kategori' => 'minat', 'jurusan' => 'Perikanan', 'belief' => 0.87],
    ['teks' => 'Saya ingin berkontribusi menjaga kelestarian laut', 'kategori' => 'tujuan_karier', 'jurusan' => 'Perikanan', 'belief' => 0.74],

    // ================= FAKULTAS SENI DAN DESAIN =================
    ['teks' => 'Saya senang menggambar, melukis, atau berkarya visual', 'kategori' => 'bakat', 'jurusan' => 'Desain Komunikasi Visual', 'belief' => 0.88],
    ['teks' => 'Saya ingin menjadi graphic designer atau UI/UX designer', 'kategori' => 'tujuan_karier', 'jurusan' => 'Desain Komunikasi Visual', 'belief' => 0.78],
    ['teks' => 'Saya menyukai musik dan senang bermain alat musik', 'kategori' => 'minat', 'jurusan' => 'Seni Musik', 'belief' => 0.90],
    ['teks' => 'Saya ingin menjadi musisi atau music producer', 'kategori' => 'tujuan_karier', 'jurusan' => 'Seni Musik', 'belief' => 0.78],
    ['teks' => 'Saya senang merancang produk fisik yang fungsional dan estetis', 'kategori' => 'minat', 'jurusan' => 'Desain Produk', 'belief' => 0.87],
    ['teks' => 'Saya ingin menjadi product designer di industri manufaktur', 'kategori' => 'tujuan_karier', 'jurusan' => 'Desain Produk', 'belief' => 0.75],
];
