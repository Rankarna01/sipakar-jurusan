<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/Database.php';

try {
    $db = Database::getInstance();
    echo "<h1>Mulai Proses Migrasi Update...</h1>";

    // ==========================================
    // 1. BUAT TABEL PEKERJAAN & RELASINYA
    // ==========================================
    $db->query("CREATE TABLE IF NOT EXISTS `pekerjaan` (
        `id_pekerjaan` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `nama_pekerjaan` VARCHAR(150) NOT NULL,
        `deskripsi` TEXT,
        `tugas_utama` TEXT,
        `skill_dibutuhkan` TEXT,
        `bidang_industri` VARCHAR(100),
        `contoh_instansi` TEXT,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;");
    echo "<p>✅ Tabel <b>pekerjaan</b> berhasil diperiksa/dibuat.</p>";

    $db->query("CREATE TABLE IF NOT EXISTS `pekerjaan_jurusan` (
        `id_pekerjaan` INT UNSIGNED NOT NULL,
        `id_jurusan` INT UNSIGNED NOT NULL,
        PRIMARY KEY (`id_pekerjaan`, `id_jurusan`),
        FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan`(`id_pekerjaan`) ON DELETE CASCADE,
        FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan`(`id_jurusan`) ON DELETE CASCADE
    ) ENGINE=InnoDB;");
    echo "<p>✅ Tabel <b>pekerjaan_jurusan</b> berhasil diperiksa/dibuat.</p>";


    // ==========================================
    // 2. SEEDER DATA PEKERJAAN
    // ==========================================
    $defaultPekerjaan = [
        ['Programmer Web', 'Pengembang website dan aplikasi berbasis web', 'Menulis kode, memperbaiki bug, membangun UI/UX web', 'HTML, CSS, JS, PHP, Frameworks', 'Teknologi Informasi', 'Google, Tokopedia, Startup IT'],
        ['Backend Developer', 'Pengembang sisi server dari sebuah aplikasi', 'Mengelola database, API, keamanan server', 'PHP, Node.js, Python, SQL', 'Teknologi Informasi', 'Gojek, Bukalapak, Bank BCA'],
        ['UI/UX Designer', 'Perancang antarmuka dan pengalaman pengguna', 'Membuat wireframe, desain visual, riset pengguna', 'Figma, Adobe XD, Design Thinking', 'Desain / IT', 'Traveloka, Agensi Digital'],
        ['Dokter Umum', 'Praktisi medis yang melayani perawatan kesehatan primer', 'Mendiagnosis penyakit, memberikan resep, tindakan medis dasar', 'Ilmu Medis, Empati, Analisis', 'Kesehatan', 'RSUD, Puskesmas, Klinik Swasta'],
        ['Dokter Spesialis', 'Praktisi medis dengan keahlian khusus', 'Menangani kasus medis spesifik sesuai bidang (Bedah, Anak, dll)', 'Spesialisasi Medis, Presisi', 'Kesehatan', 'RS Siloam, RS Mitra Keluarga'],
        ['Dokter Gigi', 'Praktisi medis untuk kesehatan gigi dan mulut', 'Merawat masalah gigi, rahang, dan gusi', 'Ilmu Kedokteran Gigi, Motorik Halus', 'Kesehatan', 'Klinik Gigi, RSUD'],
        ['System Analyst', 'Penganalisis kebutuhan sistem IT', 'Merancang solusi IT untuk masalah bisnis perusahaan', 'Analisis Sistem, Komunikasi, UML', 'Teknologi / Bisnis', 'Accenture, IBM, Telkom'],
        ['Network Engineer', 'Teknisi jaringan komputer', 'Merancang, mengatur, dan merawat jaringan internet/intranet', 'Cisco, Mikrotik, Jaringan', 'Telekomunikasi', 'Telkomsel, Biznet, Indosat'],
        ['Data Analyst', 'Penganalisis data', 'Mengolah data mentah menjadi insight untuk bisnis', 'SQL, Python, Excel, Tableau', 'Teknologi / Keuangan', 'Shopee, Bank Mandiri, Startup']
    ];

    $stmtCekPekerjaan = $db->prepare("SELECT id_pekerjaan FROM pekerjaan WHERE nama_pekerjaan = ?");
    $stmtInsPekerjaan = $db->prepare("INSERT INTO pekerjaan (nama_pekerjaan, deskripsi, tugas_utama, skill_dibutuhkan, bidang_industri, contoh_instansi) VALUES (?, ?, ?, ?, ?, ?)");
    
    $pekerjaanCount = 0;
    foreach ($defaultPekerjaan as $p) {
        $stmtCekPekerjaan->execute([$p[0]]);
        if (!$stmtCekPekerjaan->fetch()) {
            $stmtInsPekerjaan->execute($p);
            $pekerjaanCount++;
        }
    }
    echo "<p>✅ $pekerjaanCount data <b>Pekerjaan</b> default berhasil disisipkan (yang sudah ada dilewati).</p>";


    // ==========================================
    // 3. SEEDER PERTANYAAN BARU (KUESIONER YA/TIDAK)
    // ==========================================
    $targetJurusan = [
        'Kedokteran' => [
            ['kode' => 'E-KED-01', 'nama' => 'Pemahaman Anatomi', 'pertanyaan' => 'Apakah Anda tertarik untuk mempelajari secara mendalam tentang struktur anatomi dan fisiologi tubuh manusia?'],
            ['kode' => 'E-KED-02', 'nama' => 'Kemampuan Biologi', 'pertanyaan' => 'Apakah Anda memiliki pemahaman yang kuat dan minat yang tinggi pada pelajaran Biologi, terutama biologi manusia?'],
            ['kode' => 'E-KED-03', 'nama' => 'Empati Pasien', 'pertanyaan' => 'Apakah Anda merasa peduli dan memiliki keinginan kuat untuk merawat serta menyembuhkan orang yang sedang sakit?'],
            ['kode' => 'E-KED-04', 'nama' => 'Tahan Tekanan Medis', 'pertanyaan' => 'Apakah Anda sanggup bekerja di bawah tekanan tinggi dan mengambil keputusan cepat dalam kondisi kritis/darurat?'],
            ['kode' => 'E-KED-05', 'nama' => 'Ketahanan Fisik Medis', 'pertanyaan' => 'Apakah Anda memiliki ketahanan fisik dan mental untuk bekerja dengan sistem shift yang panjang di rumah sakit?']
        ],
        'Kedokteran Gigi' => [
            ['kode' => 'E-KG-01', 'nama' => 'Kesehatan Mulut', 'pertanyaan' => 'Apakah Anda tertarik secara khusus pada kesehatan mulut, gigi, dan rahang?'],
            ['kode' => 'E-KG-02', 'nama' => 'Motorik Halus', 'pertanyaan' => 'Apakah Anda memiliki ketangkasan tangan (motorik halus) yang baik untuk melakukan pekerjaan detail pada area sempit?'],
            ['kode' => 'E-KG-03', 'nama' => 'Estetika Gigi', 'pertanyaan' => 'Apakah Anda tertarik untuk memperbaiki penampilan (estetika) gigi seseorang agar mereka lebih percaya diri?'],
            ['kode' => 'E-KG-04', 'nama' => 'Ketelitian Praktik', 'pertanyaan' => 'Apakah Anda merupakan orang yang sangat teliti dan sabar saat melakukan tindakan medis atau kerajinan tangan sekecil apa pun?'],
            ['kode' => 'E-KG-05', 'nama' => 'Edukasi Pasien', 'pertanyaan' => 'Apakah Anda suka mengedukasi orang lain tentang pentingnya menjaga kebersihan dan kesehatan area mulut?']
        ],
        'Sistem Informasi' => [
            ['kode' => 'E-SI-01', 'nama' => 'Analisis Bisnis', 'pertanyaan' => 'Apakah Anda tertarik untuk memahami bagaimana proses bisnis sebuah perusahaan berjalan dan bagaimana memperbaikinya?'],
            ['kode' => 'E-SI-02', 'nama' => 'Solusi IT', 'pertanyaan' => 'Apakah Anda suka merancang solusi berbasis teknologi (software) untuk menyelesaikan masalah manajemen di sebuah organisasi?'],
            ['kode' => 'E-SI-03', 'nama' => 'Komunikasi Tim', 'pertanyaan' => 'Apakah Anda merasa nyaman menjadi jembatan komunikasi antara tim teknis (programmer) dan pihak manajemen/klien?'],
            ['kode' => 'E-SI-04', 'nama' => 'Manajemen Proyek', 'pertanyaan' => 'Apakah Anda memiliki ketertarikan dalam mengatur dan mengelola jalannya sebuah proyek pembuatan aplikasi dari awal hingga akhir?'],
            ['kode' => 'E-SI-05', 'nama' => 'Data Bisnis', 'pertanyaan' => 'Apakah Anda tertarik untuk menganalisis data perusahaan agar dapat digunakan sebagai dasar pengambilan keputusan bisnis?']
        ],
        'Ilmu Komputer' => [
            ['kode' => 'E-ILK-01', 'nama' => 'Algoritma Kompleks', 'pertanyaan' => 'Apakah Anda suka memecahkan masalah logika matematika yang kompleks dan merancang algoritma dari awal?'],
            ['kode' => 'E-ILK-02', 'nama' => 'Teori Komputasi', 'pertanyaan' => 'Apakah Anda tertarik untuk mempelajari teori dasar ilmu komputer seperti kecerdasan buatan (AI), machine learning, atau kriptografi?'],
            ['kode' => 'E-ILK-03', 'nama' => 'Optimasi Kode', 'pertanyaan' => 'Apakah Anda merasa tertantang untuk membuat struktur kode atau program agar berjalan dengan efisiensi memori yang sangat tinggi?'],
            ['kode' => 'E-ILK-04', 'nama' => 'Pemrosesan Data', 'pertanyaan' => 'Apakah Anda tertarik mempelajari bagaimana komputer memproses, menyimpan, dan mentransmisikan data pada tingkat mesin?'],
            ['kode' => 'E-ILK-05', 'nama' => 'Riset Teknologi', 'pertanyaan' => 'Apakah Anda lebih tertarik pada penelitian dan pengembangan (R&D) teknologi baru dibandingkan hanya membuat aplikasi biasa?']
        ],
        'Teknik Informatika' => [
            ['kode' => 'E-TI-01', 'nama' => 'Coding Aplikasi', 'pertanyaan' => 'Apakah Anda sangat tertarik untuk menulis kode program (coding) secara langsung untuk membuat aplikasi web atau mobile?'],
            ['kode' => 'E-TI-02', 'nama' => 'Software Engineering', 'pertanyaan' => 'Apakah Anda ingin mempelajari siklus rekayasa perangkat lunak (software engineering) dari perancangan hingga pengujian aplikasi?'],
            ['kode' => 'E-TI-03', 'nama' => 'Database App', 'pertanyaan' => 'Apakah Anda tertarik untuk membangun struktur database yang solid untuk mendukung aplikasi skala besar?'],
            ['kode' => 'E-TI-04', 'nama' => 'Teknologi Terapan', 'pertanyaan' => 'Apakah Anda lebih suka mempraktekkan teknologi IT secara langsung untuk menghasilkan produk siap pakai (aplikasi)?'],
            ['kode' => 'E-TI-05', 'nama' => 'Troubleshooting Kode', 'pertanyaan' => 'Apakah Anda sabar dan pantang menyerah saat harus mencari dan memperbaiki error (debugging) pada puluhan baris kode?']
        ]
    ];

    $kategori = 'minat';
    $pertanyaanCount = 0;

    foreach ($targetJurusan as $namaJurusan => $listEvidence) {
        $stmtJur = $db->prepare("SELECT id_jurusan FROM jurusan WHERE nama_jurusan LIKE ? LIMIT 1");
        $stmtJur->execute(["%$namaJurusan%"]);
        $jurusan = $stmtJur->fetch();

        if (!$jurusan) continue;
        $idJurusan = $jurusan['id_jurusan'];

        foreach ($listEvidence as $ev) {
            // 1. Evidence
            $stmtCekEv = $db->prepare("SELECT id_evidence FROM evidence WHERE kode_evidence = ?");
            $stmtCekEv->execute([$ev['kode']]);
            $evidence = $stmtCekEv->fetch();
            
            if (!$evidence) {
                $stmtInsEv = $db->prepare("INSERT INTO evidence (kode_evidence, nama_evidence) VALUES (?, ?)");
                $stmtInsEv->execute([$ev['kode'], $ev['nama']]);
                $idEvidence = $db->lastInsertId();
            } else {
                $idEvidence = $evidence['id_evidence'];
            }

            // 2. Pertanyaan
            $stmtCekPertanyaan = $db->prepare("SELECT id_pertanyaan FROM pertanyaan WHERE id_evidence = ?");
            $stmtCekPertanyaan->execute([$idEvidence]);
            if (!$stmtCekPertanyaan->fetch()) {
                $kodeP = 'P-' . $ev['kode'];
                $stmtInsP = $db->prepare("INSERT INTO pertanyaan (kode_pertanyaan, id_evidence, pertanyaan, kategori) VALUES (?, ?, ?, ?)");
                $stmtInsP->execute([$kodeP, $idEvidence, $ev['pertanyaan'], $kategori]);
                $pertanyaanCount++;
            }

            // 3. Aturan
            $stmtCekAturan = $db->prepare("SELECT id_aturan FROM aturan WHERE id_jurusan = ? AND id_evidence = ?");
            $stmtCekAturan->execute([$idJurusan, $idEvidence]);
            if (!$stmtCekAturan->fetch()) {
                $stmtInsA = $db->prepare("INSERT INTO aturan (id_jurusan, id_evidence, nilai_belief) VALUES (?, ?, ?)");
                $stmtInsA->execute([$idJurusan, $idEvidence, 0.8]);
            }
        }
    }
    echo "<p>✅ $pertanyaanCount <b>Pertanyaan/Aturan spesifik jurusan</b> berhasil disisipkan (yang sudah ada dilewati).</p>";


    // ==========================================
    // 4. TABEL SLIDER (BACKGROUND WEBSITE)
    // ==========================================
    $db->query("CREATE TABLE IF NOT EXISTS `slider` (
        `id_slider` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `judul` VARCHAR(100) DEFAULT NULL,
        `deskripsi` TEXT,
        `gambar` VARCHAR(255) NOT NULL,
        `urutan` INT DEFAULT 0,
        `is_active` TINYINT(1) DEFAULT 1,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;");
    echo "<p>✅ Tabel <b>slider</b> berhasil diperiksa/dibuat.</p>";


    echo "<h2>🎉 Semua Migrasi Berhasil!</h2>";
    echo "<p>Database sudah up-to-date. Anda bisa menghapus file ini jika tidak diperlukan lagi.</p>";
    echo "<a href='".BASE_URL."'>Kembali ke Home</a>";

} catch (Exception $e) {
    echo "<h1>❌ Terjadi Kesalahan</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
