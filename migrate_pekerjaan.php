<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/Database.php';

try {
    $db = Database::getInstance();
    
    // 1. Create table `pekerjaan`
    $db->query("CREATE TABLE IF NOT EXISTS `pekerjaan` (
        `id_pekerjaan` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `nama_pekerjaan` VARCHAR(255) NOT NULL,
        `deskripsi` TEXT,
        `tugas_utama` TEXT,
        `skill_dibutuhkan` TEXT,
        `bidang_industri` VARCHAR(255),
        `contoh_instansi` TEXT,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 2. Create table `pekerjaan_jurusan`
    $db->query("CREATE TABLE IF NOT EXISTS `pekerjaan_jurusan` (
        `id_pekerjaan` INT UNSIGNED NOT NULL,
        `id_jurusan` INT UNSIGNED NOT NULL,
        PRIMARY KEY (`id_pekerjaan`, `id_jurusan`),
        FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan`(`id_pekerjaan`) ON DELETE CASCADE,
        FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan`(`id_jurusan`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 3. Seed data
    $jobs = [
        [
            'nama_pekerjaan' => 'Programmer Web / Web Developer',
            'deskripsi' => 'Profesional yang bertugas merancang, membangun, dan memelihara situs web dan aplikasi berbasis web.',
            'tugas_utama' => '- Menulis kode (HTML, CSS, JavaScript, PHP, dsb.)\n- Membangun antarmuka pengguna\n- Menghubungkan aplikasi web dengan database\n- Melakukan pengujian dan debugging',
            'skill_dibutuhkan' => 'HTML, CSS, JavaScript, Framework (React/Vue/Laravel), Version Control (Git), Problem Solving',
            'bidang_industri' => 'Teknologi Informasi (TI), Start-up, Agensi Digital',
            'contoh_instansi' => 'Tokopedia, Gojek, Agensi Pembuatan Website, BUMN (Divisi IT)'
        ],
        [
            'nama_pekerjaan' => 'Backend Developer',
            'deskripsi' => 'Pengembang perangkat lunak yang berfokus pada sisi server (backend) dari sebuah aplikasi web, mencakup logika bisnis, pengelolaan database, dan API.',
            'tugas_utama' => '- Merancang arsitektur server dan database\n- Membangun API (Application Programming Interface)\n- Mengoptimalkan performa dan keamanan server\n- Mengelola integrasi dengan layanan pihak ketiga',
            'skill_dibutuhkan' => 'Bahasa Pemrograman (Java, Python, PHP, Node.js), Database (MySQL, PostgreSQL, MongoDB), API Design, Server Administration',
            'bidang_industri' => 'Teknologi Informasi, Keuangan (Fintech), E-Commerce',
            'contoh_instansi' => 'Bank Mandiri (IT), Shopee, Bukalapak, Perusahaan Software House'
        ],
        [
            'nama_pekerjaan' => 'Frontend Developer',
            'deskripsi' => 'Pengembang web yang bertanggung jawab mengimplementasikan desain visual menjadi antarmuka interaktif yang dapat digunakan langsung oleh pengguna.',
            'tugas_utama' => '- Mengubah desain UI/UX menjadi kode (HTML/CSS/JS)\n- Memastikan antarmuka responsif di berbagai perangkat\n- Mengoptimalkan kecepatan muat halaman\n- Berinteraksi dengan API dari backend',
            'skill_dibutuhkan' => 'HTML5, CSS3, JavaScript (ES6+), React/Vue/Angular, Responsive Design, Web Performance',
            'bidang_industri' => 'Teknologi Informasi, Start-up, Media/Publishing',
            'contoh_instansi' => 'Traveloka, IDN Media, Kompas Digital'
        ],
        [
            'nama_pekerjaan' => 'UI/UX Designer',
            'deskripsi' => 'Profesional yang merancang pengalaman pengguna (User Experience) dan antarmuka pengguna (User Interface) agar aplikasi mudah digunakan, efisien, dan menarik secara visual.',
            'tugas_utama' => '- Melakukan riset pengguna (User Research)\n- Membuat wireframe dan purwarupa (prototype)\n- Merancang elemen visual (tombol, warna, tipografi)\n- Melakukan pengujian kegunaan (usability testing)',
            'skill_dibutuhkan' => 'Figma / Adobe XD, User Research, Wireframing, Prototyping, Empati Pengguna',
            'bidang_industri' => 'Teknologi Informasi, Agensi Kreatif, E-Commerce',
            'contoh_instansi' => 'Gojek, Tiket.com, Studio Desain UI/UX'
        ],
        [
            'nama_pekerjaan' => 'Database Administrator (DBA)',
            'deskripsi' => 'Spesialis IT yang bertugas merancang, mengimplementasikan, dan memelihara sistem basis data (database) perusahaan agar data aman, dapat diakses dengan cepat, dan bebas dari kerusakan.',
            'tugas_utama' => '- Merancang struktur database\n- Mengelola hak akses dan keamanan data\n- Melakukan pencadangan (backup) dan pemulihan (recovery)\n- Mengoptimalkan performa query dan server database',
            'skill_dibutuhkan' => 'SQL, Database Management System (Oracle, MySQL, SQL Server), Backup & Recovery, Server Tuning',
            'bidang_industri' => 'Perbankan, Telekomunikasi, Pemerintahan, Kesehatan',
            'contoh_instansi' => 'Telkomsel, BCA, Kementerian Kominfo, Rumah Sakit Besar'
        ],
        [
            'nama_pekerjaan' => 'System Analyst',
            'deskripsi' => 'Profesional yang menganalisis kebutuhan bisnis atau organisasi dan merancang solusi sistem informasi yang efisien untuk mengatasi masalah tersebut.',
            'tugas_utama' => '- Menganalisis masalah bisnis dan kebutuhan sistem\n- Membuat spesifikasi teknis dan dokumen rancangan sistem\n- Menjembatani komunikasi antara manajemen dan tim programmer\n- Memastikan sistem yang dikembangkan sesuai dengan kebutuhan',
            'skill_dibutuhkan' => 'Analisis Bisnis, Pemodelan Sistem (UML/BPMN), Komunikasi, Problem Solving',
            'bidang_industri' => 'Konsultan IT, Perusahaan Multinasional, Pemerintahan',
            'contoh_instansi' => 'Accenture, IBM, BPK RI'
        ],
        [
            'nama_pekerjaan' => 'Network Engineer',
            'deskripsi' => 'Ahli jaringan komputer yang bertugas merancang, membangun, mengelola, dan memelihara jaringan komputer agar komunikasi data berjalan lancar dan aman.',
            'tugas_utama' => '- Merancang topologi jaringan (LAN, WAN, VPN)\n- Memasang dan mengkonfigurasi perangkat jaringan (Router, Switch, Firewall)\n- Memonitor performa dan keamanan jaringan\n- Memperbaiki gangguan (troubleshooting) jaringan',
            'skill_dibutuhkan' => 'Cisco Routing & Switching, Network Security, Linux, TCP/IP, Troubleshooting',
            'bidang_industri' => 'Telekomunikasi, Internet Service Provider (ISP), Perusahaan Besar',
            'contoh_instansi' => 'Biznet, Indosat Ooredoo, PLN (Divisi IT)'
        ],
        [
            'nama_pekerjaan' => 'Data Analyst',
            'deskripsi' => 'Profesional yang mengumpulkan, memproses, dan menganalisis kumpulan data besar untuk menemukan pola atau wawasan berharga yang membantu pengambilan keputusan bisnis.',
            'tugas_utama' => '- Mengumpulkan dan membersihkan data dari berbagai sumber\n- Menganalisis data menggunakan metode statistik\n- Membuat visualisasi data dan laporan/dashboard\n- Memberikan rekomendasi bisnis berdasarkan data',
            'skill_dibutuhkan' => 'SQL, Python/R, Alat Visualisasi (Tableau/Power BI), Statistik, Critical Thinking',
            'bidang_industri' => 'Fintech, E-Commerce, Pemasaran Digital, Logistik',
            'contoh_instansi' => 'OVO, Tokopedia, Perusahaan Logistik (JNE/J&T)'
        ],
        [
            'nama_pekerjaan' => 'Dokter Umum',
            'deskripsi' => 'Tenaga medis profesional yang memberikan pelayanan kesehatan tingkat pertama, mencakup diagnosis, pengobatan, pencegahan penyakit, dan edukasi kesehatan dasar kepada pasien secara holistik.',
            'tugas_utama' => '- Melakukan anamnesis (wawancara medis) dan pemeriksaan fisik\n- Mendiagnosis penyakit umum dan meresepkan obat\n- Melakukan tindakan medis dasar\n- Merujuk pasien ke dokter spesialis jika diperlukan',
            'skill_dibutuhkan' => 'Pengetahuan Medis Klinis, Komunikasi Terapeutik, Empati, Pengambilan Keputusan Cepat, Etika Medis',
            'bidang_industri' => 'Kesehatan, Pelayanan Publik',
            'contoh_instansi' => 'Puskesmas, Klinik Pratama, Rumah Sakit Umum (RSUD/Swasta)'
        ],
        [
            'nama_pekerjaan' => 'Dokter Spesialis',
            'deskripsi' => 'Dokter yang telah menempuh pendidikan lanjutan dan memiliki keahlian mendalam pada bidang kedokteran tertentu (misal: Spesialis Anak, Penyakit Dalam, Bedah, Kandungan).',
            'tugas_utama' => '- Mendiagnosis dan mengobati penyakit kompleks sesuai spesialisasi\n- Melakukan tindakan medis lanjutan atau operasi bedah\n- Membaca dan menginterpretasikan hasil tes lab atau pencitraan medis yang spesifik\n- Berkonsultasi dengan dokter umum dan tenaga medis lain',
            'skill_dibutuhkan' => 'Keahlian Medis Lanjutan, Ketelitian Tinggi, Kemampuan Bedah (untuk dokter bedah), Kepemimpinan Medis',
            'bidang_industri' => 'Kesehatan',
            'contoh_instansi' => 'Rumah Sakit Rujukan, Rumah Sakit Spesialis, Klinik Utama'
        ],
        [
            'nama_pekerjaan' => 'Dokter Gigi',
            'deskripsi' => 'Dokter yang berspesialisasi dalam mendiagnosis, mencegah, dan mengobati masalah serta penyakit pada gigi, gusi, rahang, dan mulut.',
            'tugas_utama' => '- Memeriksa kondisi kesehatan gigi dan mulut pasien\n- Menambal gigi berlubang, mencabut gigi, dan membersihkan karang gigi\n- Melakukan perawatan saluran akar atau estetika gigi\n- Memberikan edukasi tentang kebersihan mulut',
            'skill_dibutuhkan' => 'Ketangkasan Manual (Motorik Halus), Pengetahuan Kedokteran Gigi, Ketelitian, Interpersonal Skill',
            'bidang_industri' => 'Kesehatan, Perawatan Gigi dan Estetika',
            'contoh_instansi' => 'Klinik Gigi Swasta, Puskesmas, Rumah Sakit Gigi dan Mulut (RSGM)'
        ]
    ];

    $stmt = $db->prepare("INSERT INTO `pekerjaan` (nama_pekerjaan, deskripsi, tugas_utama, skill_dibutuhkan, bidang_industri, contoh_instansi) VALUES (:nama, :deskripsi, :tugas, :skill, :bidang, :instansi)");

    foreach ($jobs as $job) {
        // Cek jika sudah ada
        $check = $db->prepare("SELECT id_pekerjaan FROM pekerjaan WHERE nama_pekerjaan = ?");
        $check->execute([$job['nama_pekerjaan']]);
        if (!$check->fetch()) {
            $stmt->execute([
                'nama' => $job['nama_pekerjaan'],
                'deskripsi' => $job['deskripsi'],
                'tugas' => str_replace('\n', "\n", $job['tugas_utama']),
                'skill' => $job['skill_dibutuhkan'],
                'bidang' => $job['bidang_industri'],
                'instansi' => $job['contoh_instansi']
            ]);
            $jobId = $db->lastInsertId();

            // Hubungkan dengan jurusan secara otomatis sebagai data awal (seeder pintar)
            $jurusanIds = [];
            $jobNameLower = strtolower($job['nama_pekerjaan']);
            
            // Logika sederhana untuk mencari jurusan yang mungkin relevan dengan pekerjaan ini di db
            // Cari ID jurusan "Teknik Informatika" / "Sistem Informasi" dsb jika pekerjaannya IT
            if (strpos($jobNameLower, 'web') !== false || strpos($jobNameLower, 'developer') !== false || strpos($jobNameLower, 'programmer') !== false || strpos($jobNameLower, 'ui/ux') !== false || strpos($jobNameLower, 'database') !== false || strpos($jobNameLower, 'analyst') !== false || strpos($jobNameLower, 'network') !== false) {
                $jurusans = $db->query("SELECT id_jurusan FROM jurusan WHERE nama_jurusan LIKE '%Informatika%' OR nama_jurusan LIKE '%Sistem Informasi%' OR nama_jurusan LIKE '%Komputer%'")->fetchAll();
                foreach($jurusans as $j) $jurusanIds[] = $j['id_jurusan'];
            }
            if (strpos($jobNameLower, 'dokter gigi') !== false) {
                $jurusans = $db->query("SELECT id_jurusan FROM jurusan WHERE nama_jurusan LIKE '%Kedokteran Gigi%'")->fetchAll();
                foreach($jurusans as $j) $jurusanIds[] = $j['id_jurusan'];
            } elseif (strpos($jobNameLower, 'dokter') !== false) {
                $jurusans = $db->query("SELECT id_jurusan FROM jurusan WHERE nama_jurusan LIKE '%Kedokteran%' AND nama_jurusan NOT LIKE '%Gigi%' AND nama_jurusan NOT LIKE '%Hewan%'")->fetchAll();
                foreach($jurusans as $j) $jurusanIds[] = $j['id_jurusan'];
            }

            // Insert relasi jurusan
            if (!empty($jurusanIds)) {
                $jurusanIds = array_unique($jurusanIds);
                $stmtRel = $db->prepare("INSERT IGNORE INTO pekerjaan_jurusan (id_pekerjaan, id_jurusan) VALUES (?, ?)");
                foreach ($jurusanIds as $jid) {
                    $stmtRel->execute([$jobId, $jid]);
                }
            }
        }
    }

    echo "Migration & Seeding Success!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
