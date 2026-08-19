<?php
/**
 * Dataset Detail Jurusan
 * Berisi informasi tambahan per jurusan: mata kuliah inti, top 10 kampus PTN
 * penyedia jurusan tsb, estimasi range gaji lulusan, dan paragraf deskripsi
 * tambahan. Data disusun berdasarkan kurikulum umum & reputasi akademik
 * PTN di Indonesia untuk masing-masing rumpun ilmu.
 */

return [
    // ================= KEDOKTERAN =================
    'Kedokteran' => [
        'mk' => ['Anatomi', 'Fisiologi', 'Biokimia Kedokteran', 'Patologi Klinik', 'Farmakologi', 'Ilmu Penyakit Dalam', 'Bedah Umum', 'Kedokteran Komunitas'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Sebelas Maret (UNS)', 'Universitas Andalas (UNAND)'],
        'gaji' => 'Rp 8.000.000 - Rp 30.000.000+ (setelah internship & spesialisasi)',
        'p2' => 'Kurikulum Kedokteran menempuh masa studi sekitar 5,5-7 tahun (termasuk co-assistant/koas) sebelum lulus sebagai dokter umum, dan dapat dilanjutkan ke pendidikan spesialis. Program studi ini menuntut komitmen belajar seumur hidup, ketahanan mental tinggi, serta empati mendalam terhadap pasien.',
    ],
    'Kedokteran Gigi' => [
        'mk' => ['Anatomi Kepala Leher', 'Ilmu Konservasi Gigi', 'Ortodonsia', 'Periodonsia', 'Bedah Mulut', 'Radiologi Kedokteran Gigi'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Trisakti', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Brawijaya (UB)', 'Universitas Jember (UNEJ)', 'Universitas Andalas (UNAND)'],
        'gaji' => 'Rp 7.000.000 - Rp 25.000.000+ (praktik mandiri lebih tinggi)',
        'p2' => 'Selain praktik klinis, lulusan Kedokteran Gigi banyak yang membuka praktik mandiri setelah beberapa tahun bekerja di rumah sakit atau puskesmas. Keterampilan motorik halus dan ketelitian tinggi menjadi kunci keberhasilan di bidang ini.',
    ],
    'Farmasi' => [
        'mk' => ['Kimia Farmasi', 'Farmakologi', 'Teknologi Sediaan Farmasi', 'Farmakognosi', 'Biofarmasetika', 'Manajemen Farmasi'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Indonesia (UI)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Andalas (UNAND)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)'],
        'gaji' => 'Rp 4.500.000 - Rp 12.000.000',
        'p2' => 'Lulusan Farmasi dapat bekerja di apotek, rumah sakit, industri farmasi (produksi/QC/R&D), BPOM, hingga menjadi apoteker penanggung jawab. Gelar profesi Apoteker (setelah PSPA) membuka peluang karier dan penghasilan yang lebih tinggi.',
    ],
    'Keperawatan' => [
        'mk' => ['Konsep Dasar Keperawatan', 'Keperawatan Medikal Bedah', 'Keperawatan Anak', 'Keperawatan Jiwa', 'Keperawatan Komunitas', 'Manajemen Keperawatan'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Airlangga (UNAIR)', 'Universitas Gadjah Mada (UGM)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Riau (UNRI)'],
        'gaji' => 'Rp 4.000.000 - Rp 10.000.000 (lebih tinggi di RS swasta/luar negeri)',
        'p2' => 'Profesi perawat sangat dibutuhkan baik di dalam maupun luar negeri (Jepang, Timur Tengah, Eropa membuka jalur perawat migran). Setelah profesi Ners, lulusan dapat melanjutkan spesialisasi seperti perawat ICU, anestesi, atau perawat komunitas.',
    ],
    'Gizi' => [
        'mk' => ['Ilmu Gizi Dasar', 'Penilaian Status Gizi', 'Dietetika Penyakit', 'Gizi Kesehatan Masyarakat', 'Ilmu Bahan Makanan', 'Epidemiologi Gizi'],
        'kampus' => ['Institut Pertanian Bogor (IPB)', 'Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Brawijaya (UB)', 'Universitas Diponegoro (UNDIP)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.000.000 - Rp 9.000.000',
        'p2' => 'Ahli gizi berperan penting di rumah sakit (clinical dietitian), puskesmas, industri makanan (product development), hingga konsultan gizi pribadi/influencer kesehatan yang kini makin diminati generasi muda.',
    ],

    // ================= TEKNIK =================
    'Teknik Informatika' => [
        'mk' => ['Algoritma & Pemrograman', 'Struktur Data', 'Basis Data', 'Rekayasa Perangkat Lunak', 'Jaringan Komputer', 'Kecerdasan Buatan', 'Pemrograman Web/Mobile'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Brawijaya (UB)', 'Universitas Diponegoro (UNDIP)', 'IPB University', 'Universitas Padjadjaran (UNPAD)', 'Universitas Airlangga (UNAIR)', 'Universitas Telkom'],
        'gaji' => 'Rp 5.000.000 - Rp 20.000.000+ (software engineer senior/remote lebih tinggi)',
        'p2' => 'Salah satu jurusan dengan permintaan kerja tertinggi saat ini, mencakup pengembangan software, data science, cybersecurity, hingga AI/ML engineer. Banyak lulusan juga membangun startup teknologi sendiri sejak masih kuliah.',
    ],
    'Sistem Informasi' => [
        'mk' => ['Analisis & Perancangan Sistem', 'Manajemen Basis Data', 'Manajemen Proyek TI', 'Enterprise Resource Planning', 'Tata Kelola TI', 'Interaksi Manusia Komputer'],
        'kampus' => ['Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Indonesia (UI)', 'Institut Pertanian Bogor (IPB)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Brawijaya (UB)', 'Universitas Diponegoro (UNDIP)', 'Universitas Telkom', 'Universitas Padjadjaran (UNPAD)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.500.000 - Rp 15.000.000',
        'p2' => 'Sistem Informasi menjembatani sisi bisnis dan teknologi, cocok untuk yang tertarik menjadi business analyst, IT consultant, atau project manager TI. Kombinasi soft-skill manajemen dan hard-skill teknis menjadi nilai jual utama lulusan.',
    ],
    'Teknik Elektro' => [
        'mk' => ['Rangkaian Listrik', 'Elektronika Dasar', 'Sistem Tenaga Listrik', 'Sistem Kendali', 'Mikroprosesor', 'Telekomunikasi'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Gadjah Mada (UGM)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 5.000.000 - Rp 14.000.000',
        'p2' => 'Lulusan bekerja di sektor kelistrikan (PLN), telekomunikasi, otomasi industri, hingga energi terbarukan. Keahlian di bidang embedded system dan IoT semakin dicari seiring transformasi industri 4.0.',
    ],
    'Teknik Mesin' => [
        'mk' => ['Mekanika Teknik', 'Termodinamika', 'Mekanika Fluida', 'Elemen Mesin', 'Proses Manufaktur', 'Perpindahan Panas'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Gadjah Mada (UGM)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Riau (UNRI)'],
        'gaji' => 'Rp 4.800.000 - Rp 13.000.000',
        'p2' => 'Jurusan klasik namun selalu relevan di sektor manufaktur, otomotif, energi, dan maintenance industri berat. Peluang kerja tersebar luas dari pabrik, tambang, hingga perusahaan minyak & gas.',
    ],
    'Teknik Sipil' => [
        'mk' => ['Mekanika Tanah', 'Struktur Beton Bertulang', 'Hidrologi Teknik', 'Manajemen Konstruksi', 'Rekayasa Jalan Raya', 'Struktur Baja'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Indonesia (UI)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.800.000 - Rp 14.000.000',
        'p2' => 'Lulusan berperan dalam pembangunan infrastruktur nasional: jalan, jembatan, gedung, bendungan. Sertifikasi keahlian (SKA) dari PII menjadi nilai tambah penting untuk berkarier sebagai konsultan atau kontraktor.',
    ],
    'Teknik Industri' => [
        'mk' => ['Riset Operasi', 'Ergonomi', 'Sistem Produksi', 'Pengendalian Kualitas', 'Rantai Pasok', 'Analisis Perancangan Kerja'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Gadjah Mada (UGM)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Telkom', 'Universitas Sebelas Maret (UNS)', 'Universitas Andalas (UNAND)', 'Universitas Trisakti'],
        'gaji' => 'Rp 4.800.000 - Rp 13.500.000',
        'p2' => 'Teknik Industri melahirkan lulusan serba bisa yang dicari untuk posisi supply chain, operasional, hingga konsultan manajemen. Perpaduan analisis kuantitatif dan pemahaman bisnis jadi keunggulan utamanya.',
    ],
    'Arsitektur' => [
        'mk' => ['Perancangan Arsitektur', 'Sejarah Arsitektur', 'Struktur Bangunan', 'Utilitas Bangunan', 'Perancangan Kota', 'Studio Desain'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Indonesia (UI)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Parahyangan (UNPAR)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.500.000 - Rp 15.000.000 (arsitek senior/firma sendiri lebih tinggi)',
        'p2' => 'Arsitek merancang bangunan yang fungsional sekaligus estetis. Banyak lulusan membuka biro arsitek sendiri atau berkarier di firma desain internasional setelah memperoleh sertifikasi Arsitek dari IAI.',
    ],
    'Teknik Kimia' => [
        'mk' => ['Kimia Fisika', 'Neraca Massa & Energi', 'Operasi Teknik Kimia', 'Reaktor Kimia', 'Proses Industri Kimia', 'Teknik Reaksi Kimia'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Indonesia (UI)', 'Universitas Diponegoro (UNDIP)', 'Universitas Sumatera Utara (USU)', 'Universitas Brawijaya (UB)', 'Universitas Sriwijaya (UNSRI)', 'Universitas Andalas (UNAND)', 'Universitas Riau (UNRI)'],
        'gaji' => 'Rp 5.500.000 - Rp 16.000.000 (industri migas/petrokimia lebih tinggi)',
        'p2' => 'Banyak diserap industri petrokimia, minyak & gas, pupuk, hingga manufaktur bahan kimia. Gaji awal termasuk salah satu yang tertinggi di antara rumpun teknik karena spesialisasi industri berat.',
    ],
    'Teknik Lingkungan' => [
        'mk' => ['Kimia Lingkungan', 'Pengelolaan Air Bersih', 'Pengelolaan Limbah Padat', 'Amdal', 'Pencemaran Udara', 'Sanitasi Lingkungan'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Indonesia (UI)', 'Universitas Diponegoro (UNDIP)', 'Universitas Gadjah Mada (UGM)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Riau (UNRI)'],
        'gaji' => 'Rp 4.500.000 - Rp 11.000.000',
        'p2' => 'Isu perubahan iklim dan keberlanjutan membuat permintaan ahli lingkungan terus meningkat, baik di perusahaan tambang/migas (bagian HSE), konsultan Amdal, maupun lembaga pemerintah dan NGO lingkungan.',
    ],

    // ================= EKONOMI DAN BISNIS =================
    'Manajemen' => [
        'mk' => ['Manajemen Pemasaran', 'Manajemen Keuangan', 'Manajemen SDM', 'Manajemen Operasional', 'Kewirausahaan', 'Perilaku Organisasi'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Bandung (ITB - SBM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'IPB University', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)'],
        'gaji' => 'Rp 4.500.000 - Rp 15.000.000 (posisi manajerial lebih tinggi)',
        'p2' => 'Manajemen adalah salah satu jurusan paling fleksibel, membuka peluang di hampir semua industri: perbankan, retail, startup, hingga BUMN. Banyak lulusan juga sukses menjadi pengusaha (entrepreneur).',
    ],
    'Akuntansi' => [
        'mk' => ['Akuntansi Keuangan', 'Akuntansi Biaya', 'Auditing', 'Perpajakan', 'Akuntansi Manajemen', 'Sistem Informasi Akuntansi'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'IPB University', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.500.000 - Rp 13.000.000 (auditor senior/CPA lebih tinggi)',
        'p2' => 'Profesi akuntan selalu dibutuhkan di setiap perusahaan. Dengan sertifikasi tambahan seperti CPA, CA, atau bekerja di Kantor Akuntan Publik Big Four, prospek karier dan penghasilan meningkat signifikan.',
    ],
    'Ekonomi Pembangunan' => [
        'mk' => ['Ekonomi Makro', 'Ekonomi Mikro', 'Ekonometrika', 'Ekonomi Moneter', 'Perencanaan Pembangunan', 'Ekonomi Publik'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Institut Pertanian Bogor (IPB)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)'],
        'gaji' => 'Rp 4.500.000 - Rp 12.000.000',
        'p2' => 'Lulusan banyak berkarier di Bank Indonesia, Kementerian Keuangan, Bappenas, lembaga riset ekonomi, maupun perbankan sebagai ekonom (economist) yang menganalisis kebijakan dan tren makroekonomi.',
    ],
    'Bisnis Digital' => [
        'mk' => ['Digital Marketing', 'E-Commerce', 'Analisis Data Bisnis', 'UI/UX untuk Bisnis', 'Kewirausahaan Digital', 'Manajemen Media Sosial'],
        'kampus' => ['Universitas Indonesia (UI)', 'Institut Teknologi Bandung (ITB)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Airlangga (UNAIR)', 'Universitas Telkom', 'Universitas Brawijaya (UB)', 'Universitas Padjadjaran (UNPAD)', 'IPB University', 'Universitas Diponegoro (UNDIP)'],
        'gaji' => 'Rp 4.500.000 - Rp 14.000.000',
        'p2' => 'Jurusan yang relatif baru namun berkembang pesat mengikuti pertumbuhan ekonomi digital Indonesia. Lulusan banyak diserap startup, e-commerce, dan agensi digital marketing sebagai growth/marketing specialist.',
    ],
    'Perbankan dan Keuangan' => [
        'mk' => ['Manajemen Perbankan', 'Analisis Kredit', 'Pasar Modal', 'Manajemen Risiko', 'Keuangan Internasional', 'Investasi dan Portofolio'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'IPB University', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Hasanuddin (UNHAS)'],
        'gaji' => 'Rp 4.800.000 - Rp 14.000.000 (perbankan/sekuritas lebih tinggi)',
        'p2' => 'Lulusan berpeluang berkarier di bank umum, bank sentral, perusahaan sekuritas, hingga fintech. Sertifikasi profesi seperti CFA atau WPPE menjadi nilai tambah signifikan di industri keuangan.',
    ],

    // ================= HUKUM =================
    'Ilmu Hukum' => [
        'mk' => ['Hukum Perdata', 'Hukum Pidana', 'Hukum Tata Negara', 'Hukum Internasional', 'Hukum Acara', 'Hukum Bisnis'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.500.000 - Rp 20.000.000+ (partner firma hukum jauh lebih tinggi)',
        'p2' => 'Lulusan dapat menempuh jalur profesi advokat, notaris, hakim, jaksa, atau in-house counsel perusahaan. Firma hukum korporat internasional menawarkan penghasilan sangat kompetitif bagi lulusan terbaik.',
    ],

    // ================= PENDIDIKAN =================
    'Pendidikan Guru Sekolah Dasar' => [
        'mk' => ['Pembelajaran Tematik SD', 'Psikologi Perkembangan Anak', 'Media Pembelajaran', 'Evaluasi Pembelajaran', 'Konsep Dasar IPA/IPS SD', 'Manajemen Kelas'],
        'kampus' => ['Universitas Pendidikan Indonesia (UPI)', 'Universitas Negeri Malang (UM)', 'Universitas Negeri Yogyakarta (UNY)', 'Universitas Negeri Jakarta (UNJ)', 'Universitas Negeri Semarang (UNNES)', 'Universitas Negeri Surabaya (UNESA)', 'Universitas Negeri Medan (UNIMED)', 'Universitas Negeri Padang (UNP)', 'Universitas Negeri Makassar (UNM)', 'Universitas Pendidikan Ganesha (UNDIKSHA)'],
        'gaji' => 'Rp 3.500.000 - Rp 8.000.000 (guru PNS/sertifikasi lebih tinggi)',
        'p2' => 'Guru SD berperan fundamental membentuk pondasi belajar anak. Setelah lulus, dapat mengikuti seleksi PPPK/CPNS guru atau mengajar di sekolah swasta, dengan tunjangan sertifikasi meningkatkan penghasilan signifikan.',
    ],
    'Pendidikan Matematika' => [
        'mk' => ['Kalkulus', 'Aljabar Linear', 'Statistika Pendidikan', 'Strategi Pembelajaran Matematika', 'Media Pembelajaran Matematika', 'Evaluasi Pembelajaran Matematika'],
        'kampus' => ['Universitas Pendidikan Indonesia (UPI)', 'Universitas Negeri Yogyakarta (UNY)', 'Universitas Negeri Malang (UM)', 'Universitas Negeri Jakarta (UNJ)', 'Universitas Negeri Semarang (UNNES)', 'Universitas Negeri Surabaya (UNESA)', 'Universitas Negeri Medan (UNIMED)', 'Universitas Negeri Padang (UNP)', 'Universitas Pendidikan Ganesha (UNDIKSHA)', 'Universitas Negeri Makassar (UNM)'],
        'gaji' => 'Rp 3.500.000 - Rp 9.000.000',
        'p2' => 'Selain menjadi guru di sekolah, lulusan juga banyak berkarier sebagai tutor bimbingan belajar, penulis buku ajar, maupun content creator edukasi matematika yang kini populer di platform digital.',
    ],
    'Pendidikan Bahasa Inggris' => [
        'mk' => ['Structure & Grammar', 'Speaking Skills', 'Teaching English as Foreign Language (TEFL)', 'Linguistik Terapan', 'Kurikulum Bahasa Inggris', 'Sastra Inggris'],
        'kampus' => ['Universitas Pendidikan Indonesia (UPI)', 'Universitas Negeri Yogyakarta (UNY)', 'Universitas Negeri Malang (UM)', 'Universitas Negeri Jakarta (UNJ)', 'Universitas Negeri Semarang (UNNES)', 'Universitas Negeri Surabaya (UNESA)', 'Universitas Negeri Medan (UNIMED)', 'Universitas Negeri Padang (UNP)', 'Universitas Sebelas Maret (UNS)', 'Universitas Negeri Makassar (UNM)'],
        'gaji' => 'Rp 3.800.000 - Rp 10.000.000 (lembaga kursus/internasional lebih tinggi)',
        'p2' => 'Kemampuan bahasa Inggris yang mumpuni membuka peluang tak hanya sebagai guru sekolah, tapi juga trainer korporat, translator, hingga mengajar di lembaga kursus internasional dengan penghasilan lebih tinggi.',
    ],
    'Bimbingan dan Konseling' => [
        'mk' => ['Teori Konseling', 'Psikologi Kepribadian', 'Asesmen Bimbingan Konseling', 'Konseling Karier', 'Konseling Kelompok', 'Etika Profesi Konselor'],
        'kampus' => ['Universitas Pendidikan Indonesia (UPI)', 'Universitas Negeri Malang (UM)', 'Universitas Negeri Yogyakarta (UNY)', 'Universitas Negeri Jakarta (UNJ)', 'Universitas Negeri Semarang (UNNES)', 'Universitas Negeri Surabaya (UNESA)', 'Universitas Negeri Medan (UNIMED)', 'Universitas Negeri Padang (UNP)', 'Universitas Negeri Makassar (UNM)', 'Universitas Pendidikan Ganesha (UNDIKSHA)'],
        'gaji' => 'Rp 3.500.000 - Rp 8.500.000',
        'p2' => 'Konselor sekolah (Guru BK) membantu siswa mengatasi masalah akademik, sosial, dan karier — persis seperti peran yang mendukung sistem konsultasi jurusan seperti aplikasi ini. Peluang karier juga terbuka di HRD perusahaan.',
    ],
    'Pendidikan Olahraga' => [
        'mk' => ['Anatomi Olahraga', 'Fisiologi Olahraga', 'Ilmu Kepelatihan', 'Pendidikan Jasmani Adaptif', 'Manajemen Olahraga', 'Tes dan Pengukuran Olahraga'],
        'kampus' => ['Universitas Negeri Yogyakarta (UNY)', 'Universitas Negeri Jakarta (UNJ)', 'Universitas Negeri Surabaya (UNESA)', 'Universitas Pendidikan Indonesia (UPI)', 'Universitas Negeri Semarang (UNNES)', 'Universitas Negeri Malang (UM)', 'Universitas Negeri Medan (UNIMED)', 'Universitas Negeri Padang (UNP)', 'Universitas Negeri Makassar (UNM)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 3.500.000 - Rp 9.000.000 (pelatih profesional lebih tinggi)',
        'p2' => 'Selain menjadi guru olahraga, lulusan dapat berkarier sebagai pelatih klub, personal trainer, hingga bekerja di federasi olahraga nasional. Industri kebugaran (fitness) yang berkembang pesat juga membuka peluang baru.',
    ],

    // ================= PSIKOLOGI =================
    'Psikologi' => [
        'mk' => ['Psikologi Umum', 'Psikologi Perkembangan', 'Psikologi Sosial', 'Psikometri', 'Psikologi Klinis', 'Psikologi Industri dan Organisasi'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Negeri Malang (UM)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.500.000 - Rp 12.000.000 (psikolog klinis bersertifikat lebih tinggi)',
        'p2' => 'Lulusan S1 dapat bekerja di bidang HRD, riset pasar, atau melanjutkan Magister Profesi Psikologi untuk menjadi psikolog klinis, psikolog pendidikan, maupun psikolog industri dengan izin praktik resmi.',
    ],

    // ================= MIPA =================
    'Matematika' => [
        'mk' => ['Kalkulus Lanjut', 'Aljabar Abstrak', 'Analisis Real', 'Statistika Matematika', 'Matematika Diskrit', 'Persamaan Diferensial'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Padjadjaran (UNPAD)'],
        'gaji' => 'Rp 4.500.000 - Rp 13.000.000 (data scientist/aktuaris lebih tinggi)',
        'p2' => 'Kemampuan berpikir logis-matematis dari jurusan ini sangat fleksibel: banyak lulusan berkarier sebagai data scientist, aktuaris (dengan sertifikasi tambahan), programmer, hingga peneliti di lembaga riset.',
    ],
    'Fisika' => [
        'mk' => ['Mekanika Klasik', 'Elektromagnetika', 'Fisika Kuantum', 'Termodinamika Statistik', 'Fisika Komputasi', 'Instrumentasi Fisika'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Padjadjaran (UNPAD)'],
        'gaji' => 'Rp 4.500.000 - Rp 12.000.000',
        'p2' => 'Lulusan Fisika banyak diserap industri energi, geofisika (perminyakan), riset dan pengembangan (R&D) teknologi, hingga menjadi peneliti di BRIN atau melanjutkan studi lanjut ke luar negeri.',
    ],
    'Kimia' => [
        'mk' => ['Kimia Analitik', 'Kimia Organik', 'Kimia Anorganik', 'Kimia Fisik', 'Biokimia', 'Kimia Instrumentasi'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Padjadjaran (UNPAD)'],
        'gaji' => 'Rp 4.500.000 - Rp 12.500.000',
        'p2' => 'Lulusan bekerja sebagai chemist di laboratorium industri (farmasi, kosmetik, makanan), quality control pabrik, hingga peneliti. Sertifikasi keahlian tambahan bisa membuka peluang di industri petrokimia dengan gaji lebih tinggi.',
    ],
    'Biologi' => [
        'mk' => ['Biologi Sel', 'Genetika', 'Mikrobiologi', 'Ekologi', 'Bioteknologi', 'Fisiologi Hewan/Tumbuhan'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'IPB University', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Padjadjaran (UNPAD)'],
        'gaji' => 'Rp 4.200.000 - Rp 11.000.000',
        'p2' => 'Bidang bioteknologi yang berkembang pesat (termasuk riset vaksin dan pangan fungsional) membuka peluang besar bagi lulusan Biologi di industri farmasi, pangan, hingga lembaga konservasi lingkungan.',
    ],
    'Statistika' => [
        'mk' => ['Metode Statistika', 'Analisis Regresi', 'Statistika Non-Parametrik', 'Analisis Deret Waktu', 'Data Mining', 'Perancangan Percobaan'],
        'kampus' => ['Institut Pertanian Bogor (IPB)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Gadjah Mada (UGM)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Islam Indonesia (UII)', 'Universitas Airlangga (UNAIR)', 'Universitas Brawijaya (UB)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)'],
        'gaji' => 'Rp 5.000.000 - Rp 16.000.000 (data scientist/analyst senior lebih tinggi)',
        'p2' => 'Di era big data, lulusan Statistika sangat diburu sebagai data analyst maupun data scientist di perusahaan teknologi, perbankan, dan e-commerce — salah satu profesi dengan pertumbuhan gaji tercepat saat ini.',
    ],

    // ================= ILMU KOMPUTER =================
    'Ilmu Komputer' => [
        'mk' => ['Struktur Data & Algoritma', 'Kecerdasan Buatan', 'Pembelajaran Mesin', 'Pemrosesan Bahasa Alami', 'Sistem Operasi', 'Teori Bahasa Formal'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'IPB University', 'Universitas Brawijaya (UB)', 'Universitas Diponegoro (UNDIP)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Airlangga (UNAIR)', 'Universitas Telkom'],
        'gaji' => 'Rp 6.000.000 - Rp 25.000.000+ (AI/ML engineer sangat kompetitif)',
        'p2' => 'Konsentrasi pada teori komputasi dan AI membuat lulusan sangat kompetitif untuk posisi machine learning engineer, research scientist, hingga bekerja di perusahaan teknologi global dengan skema remote/gaji dalam USD.',
    ],
    'Teknik Komputer' => [
        'mk' => ['Organisasi Komputer', 'Sistem Digital', 'Arsitektur Komputer', 'Sistem Embedded', 'Jaringan Komputer', 'Internet of Things'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Gadjah Mada (UGM)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Telkom', 'Politeknik Negeri Bandung', 'Universitas Padjadjaran (UNPAD)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 5.000.000 - Rp 16.000.000',
        'p2' => 'Lulusan mendalami sisi hardware dan software sekaligus, cocok untuk karier sebagai network engineer, IoT developer, atau system administrator di perusahaan telekomunikasi dan data center.',
    ],
    'Data Science' => [
        'mk' => ['Statistika Komputasi', 'Machine Learning', 'Big Data Analytics', 'Visualisasi Data', 'Data Mining', 'Basis Data NoSQL'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'IPB University', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Telkom', 'Universitas Brawijaya (UB)', 'Universitas Diponegoro (UNDIP)', 'Universitas Padjadjaran (UNPAD)'],
        'gaji' => 'Rp 6.000.000 - Rp 22.000.000',
        'p2' => 'Salah satu jurusan dengan prospek gaji tertinggi karena tingginya permintaan data scientist di hampir semua industri modern — dari e-commerce, fintech, hingga kesehatan digital.',
    ],
    'Keamanan Siber' => [
        'mk' => ['Kriptografi', 'Keamanan Jaringan', 'Etika Hacking', 'Forensik Digital', 'Manajemen Risiko Keamanan Informasi', 'Keamanan Aplikasi Web'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Gadjah Mada (UGM)', 'Politeknik Siber dan Sandi Negara', 'Universitas Telkom', 'Universitas Brawijaya (UB)', 'Universitas Diponegoro (UNDIP)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Airlangga (UNAIR)'],
        'gaji' => 'Rp 6.000.000 - Rp 20.000.000 (security consultant/pentester lebih tinggi)',
        'p2' => 'Meningkatnya kasus kebocoran data membuat profesi cybersecurity analyst dan ethical hacker sangat dicari perusahaan dan pemerintah (BSSN), dengan kompensasi yang kompetitif secara global.',
    ],

    // ================= ILMU SOSIAL DAN POLITIK =================
    'Ilmu Pemerintahan' => [
        'mk' => ['Sistem Pemerintahan Indonesia', 'Kebijakan Publik', 'Otonomi Daerah', 'Teori Politik', 'Administrasi Pemerintahan', 'Manajemen Pelayanan Publik'],
        'kampus' => ['Universitas Gadjah Mada (UGM)', 'Universitas Indonesia (UI)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Airlangga (UNAIR)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'IPDN'],
        'gaji' => 'Rp 4.000.000 - Rp 10.000.000 (ASN/PNS + tunjangan jabatan)',
        'p2' => 'Lulusan banyak berkarier sebagai ASN di kementerian/pemerintah daerah, peneliti kebijakan publik, maupun staf legislatif. Pemahaman mendalam tentang birokrasi menjadi modal penting di sektor ini.',
    ],
    'Sosiologi' => [
        'mk' => ['Teori Sosiologi', 'Metode Penelitian Sosial', 'Sosiologi Perkotaan', 'Perubahan Sosial', 'Sosiologi Ekonomi', 'Stratifikasi Sosial'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.000.000 - Rp 9.500.000',
        'p2' => 'Lulusan bekerja sebagai peneliti sosial, CSR officer perusahaan, konsultan pemberdayaan masyarakat, hingga staf NGO/lembaga internasional yang menangani isu-isu sosial kemasyarakatan.',
    ],
    'Hubungan Internasional' => [
        'mk' => ['Teori Hubungan Internasional', 'Diplomasi', 'Organisasi Internasional', 'Politik Luar Negeri Indonesia', 'Ekonomi Politik Internasional', 'Studi Keamanan Global'],
        'kampus' => ['Universitas Gadjah Mada (UGM)', 'Universitas Indonesia (UI)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Airlangga (UNAIR)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Jember (UNEJ)'],
        'gaji' => 'Rp 4.500.000 - Rp 12.000.000 (diplomat/organisasi internasional lebih tinggi)',
        'p2' => 'Selain jalur diplomat Kementerian Luar Negeri (melalui tes Sekdilu), lulusan juga berkarier di organisasi internasional (PBB, ASEAN), perusahaan multinasional, maupun media internasional.',
    ],
    'Ilmu Administrasi Negara' => [
        'mk' => ['Administrasi Publik', 'Manajemen Sumber Daya Aparatur', 'Kebijakan Publik', 'Keuangan Negara', 'E-Government', 'Etika Administrasi Publik'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Airlangga (UNAIR)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.000.000 - Rp 9.500.000 (ASN + tunjangan)',
        'p2' => 'Jurusan yang secara langsung mempersiapkan lulusan untuk berkarier di sektor pemerintahan sebagai Aparatur Sipil Negara (ASN), dengan jaminan karier jangka panjang dan tunjangan pensiun.',
    ],

    // ================= ILMU KOMUNIKASI =================
    'Ilmu Komunikasi' => [
        'mk' => ['Teori Komunikasi', 'Public Relations', 'Komunikasi Massa', 'Komunikasi Pemasaran', 'Produksi Media', 'Komunikasi Digital'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Airlangga (UNAIR)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Sebelas Maret (UNS)', 'Universitas Multimedia Nusantara'],
        'gaji' => 'Rp 4.200.000 - Rp 12.000.000 (media/agency besar lebih tinggi)',
        'p2' => 'Sangat relevan di era digital: lulusan bisa berkarier sebagai PR/Corporate Communication, content creator, social media strategist, hingga jurnalis di media nasional maupun internasional.',
    ],
    'Jurnalistik' => [
        'mk' => ['Dasar Jurnalistik', 'Reportase Investigasi', 'Jurnalisme Multimedia', 'Etika Pers', 'Penulisan Berita', 'Fotografi Jurnalistik'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Diponegoro (UNDIP)', 'Universitas Sebelas Maret (UNS)', 'Universitas Brawijaya (UB)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Multimedia Nusantara'],
        'gaji' => 'Rp 4.000.000 - Rp 11.000.000',
        'p2' => 'Meski industri media cetak menyusut, jurnalisme digital dan multimedia terus berkembang. Lulusan juga banyak beralih menjadi content writer, editor media online, atau podcaster profesional.',
    ],
    'Ilmu Perpustakaan' => [
        'mk' => ['Manajemen Perpustakaan', 'Katalogisasi dan Klasifikasi', 'Literasi Informasi', 'Perpustakaan Digital', 'Preservasi Bahan Pustaka', 'Sistem Temu Kembali Informasi'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Islam Negeri Syarif Hidayatullah', 'Universitas Sumatera Utara (USU)', 'Universitas Brawijaya (UB)', 'Universitas Negeri Medan (UNIMED)', 'Universitas Hasanuddin (UNHAS)'],
        'gaji' => 'Rp 3.800.000 - Rp 8.500.000',
        'p2' => 'Peran pustakawan modern kini meluas ke pengelolaan data digital dan knowledge management di perusahaan, tidak terbatas pada perpustakaan fisik saja, membuka peluang karier di sektor korporat.',
    ],

    // ================= PERTANIAN =================
    'Agroteknologi' => [
        'mk' => ['Dasar Ilmu Tanah', 'Fisiologi Tumbuhan', 'Pemuliaan Tanaman', 'Pengendalian Hama Terpadu', 'Teknologi Benih', 'Agroklimatologi'],
        'kampus' => ['IPB University', 'Universitas Gadjah Mada (UGM)', 'Universitas Brawijaya (UB)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Jember (UNEJ)', 'Universitas Sebelas Maret (UNS)', 'Universitas Lampung (UNILA)'],
        'gaji' => 'Rp 4.000.000 - Rp 10.000.000',
        'p2' => 'Lulusan berperan penting dalam ketahanan pangan nasional, bekerja di perusahaan agribisnis besar, penyuluh pertanian, hingga peneliti pemuliaan tanaman untuk menghasilkan varietas unggul.',
    ],
    'Agribisnis' => [
        'mk' => ['Ekonomi Pertanian', 'Manajemen Agribisnis', 'Pemasaran Hasil Pertanian', 'Studi Kelayakan Bisnis Pertanian', 'Kewirausahaan Agribisnis', 'Rantai Pasok Pertanian'],
        'kampus' => ['IPB University', 'Universitas Gadjah Mada (UGM)', 'Universitas Brawijaya (UB)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Jember (UNEJ)', 'Universitas Lampung (UNILA)', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.200.000 - Rp 11.000.000',
        'p2' => 'Menggabungkan ilmu pertanian dan bisnis, lulusan cocok berkarier di perusahaan agroindustri, ekspor-impor komoditas pertanian, atau membangun startup agritech yang kini sedang berkembang pesat.',
    ],
    'Peternakan' => [
        'mk' => ['Nutrisi Ternak', 'Reproduksi Ternak', 'Manajemen Produksi Ternak', 'Teknologi Hasil Ternak', 'Pemuliaan Ternak', 'Kesehatan Hewan Ternak'],
        'kampus' => ['IPB University', 'Universitas Gadjah Mada (UGM)', 'Universitas Brawijaya (UB)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Jenderal Soedirman (UNSOED)', 'Universitas Lampung (UNILA)', 'Universitas Diponegoro (UNDIP)'],
        'gaji' => 'Rp 4.000.000 - Rp 10.000.000',
        'p2' => 'Industri peternakan unggas dan sapi terus tumbuh di Indonesia, membuka peluang kerja di perusahaan pakan ternak, farm management, hingga quality control produk peternakan skala industri.',
    ],
    'Perikanan' => [
        'mk' => ['Budidaya Perairan', 'Manajemen Sumber Daya Perikanan', 'Teknologi Hasil Perikanan', 'Ekologi Perairan', 'Nutrisi Ikan', 'Manajemen Kualitas Air'],
        'kampus' => ['IPB University', 'Universitas Hasanuddin (UNHAS)', 'Universitas Brawijaya (UB)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Diponegoro (UNDIP)', 'Universitas Riau (UNRI)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Sumatera Utara (USU)', 'Universitas Airlangga (UNAIR)', 'Universitas Jenderal Soedirman (UNSOED)'],
        'gaji' => 'Rp 4.000.000 - Rp 9.500.000',
        'p2' => 'Sebagai negara maritim, Indonesia memiliki potensi perikanan sangat besar. Lulusan berkarier di industri budidaya udang/ikan skala ekspor, pengolahan hasil laut, hingga konsultan kelautan.',
    ],
    'Kehutanan' => [
        'mk' => ['Silvikultur', 'Inventarisasi Hutan', 'Konservasi Sumber Daya Hutan', 'Pengelolaan Daerah Aliran Sungai', 'Ekonomi Kehutanan', 'Kebijakan Kehutanan'],
        'kampus' => ['IPB University', 'Universitas Gadjah Mada (UGM)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Mulawarman (UNMUL)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Lambung Mangkurat', 'Universitas Tanjungpura', 'Universitas Papua', 'Universitas Jenderal Soedirman (UNSOED)'],
        'gaji' => 'Rp 4.000.000 - Rp 9.500.000',
        'p2' => 'Isu deforestasi dan perubahan iklim membuat ahli kehutanan makin dibutuhkan, baik di Kementerian LHK, perusahaan HTI/HPH yang menerapkan praktik berkelanjutan, maupun organisasi konservasi internasional.',
    ],

    // ================= SENI DAN DESAIN =================
    'Desain Komunikasi Visual' => [
        'mk' => ['Nirmana', 'Tipografi', 'Ilustrasi Digital', 'Desain Grafis Periklanan', 'Motion Graphic', 'Branding dan Identitas Visual'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Institut Kesenian Jakarta (IKJ)', 'Universitas Negeri Yogyakarta (UNY)', 'Institut Seni Indonesia Yogyakarta (ISI)', 'Universitas Trisakti', 'Universitas Multimedia Nusantara', 'Universitas Negeri Malang (UM)', 'Universitas Diponegoro (UNDIP)', 'Universitas Telkom', 'Universitas Sebelas Maret (UNS)'],
        'gaji' => 'Rp 4.500.000 - Rp 14.000.000 (freelance/art director lebih tinggi)',
        'p2' => 'Industri kreatif Indonesia tumbuh pesat — lulusan DKV bekerja sebagai graphic designer, UI/UX designer, art director agensi iklan, hingga membangun bisnis desain/ilustrasi sendiri secara freelance.',
    ],
    'Seni Musik' => [
        'mk' => ['Teori Musik', 'Harmoni', 'Komposisi Musik', 'Sejarah Musik', 'Praktik Instrumen Mayor', 'Aransemen Musik'],
        'kampus' => ['Institut Seni Indonesia Yogyakarta (ISI)', 'Institut Kesenian Jakarta (IKJ)', 'Universitas Negeri Yogyakarta (UNY)', 'Universitas Pendidikan Indonesia (UPI)', 'Institut Seni Indonesia Surakarta', 'Universitas Negeri Jakarta (UNJ)', 'Universitas Negeri Medan (UNIMED)', 'Universitas Negeri Semarang (UNNES)', 'Institut Seni Indonesia Denpasar', 'Universitas Negeri Padang (UNP)'],
        'gaji' => 'Rp 3.500.000 - Rp 12.000.000 (musisi profesional/produser bervariasi luas)',
        'p2' => 'Selain menjadi guru musik atau musisi profesional, lulusan juga berkarier sebagai music producer, sound engineer, komposer musik film/game, atau content creator musik di platform digital.',
    ],

    // ================= SASTRA DAN BAHASA =================
    'Sastra Indonesia' => [
        'mk' => ['Kajian Puisi', 'Kajian Prosa Fiksi', 'Linguistik Umum', 'Sejarah Sastra Indonesia', 'Sosiolinguistik', 'Penulisan Kreatif'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Airlangga (UNAIR)', 'Universitas Diponegoro (UNDIP)', 'Universitas Negeri Yogyakarta (UNY)', 'Universitas Sebelas Maret (UNS)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)'],
        'gaji' => 'Rp 3.800.000 - Rp 9.500.000',
        'p2' => 'Lulusan berkarier sebagai penulis, editor penerbitan, peneliti bahasa/budaya, jurnalis, hingga content writer. Kemampuan berbahasa yang kuat juga membuka peluang di bidang periklanan dan copywriting.',
    ],
    'Sastra Inggris' => [
        'mk' => ['Grammar & Structure', 'Kajian Sastra Inggris', 'Linguistik Terapan', 'Penerjemahan', 'Cross-Cultural Understanding', 'English for Business'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Negeri Yogyakarta (UNY)', 'Universitas Brawijaya (UB)', 'Universitas Andalas (UNAND)', 'Universitas Sumatera Utara (USU)', 'Universitas Hasanuddin (UNHAS)'],
        'gaji' => 'Rp 4.000.000 - Rp 11.000.000 (penerjemah tersumpah/internasional lebih tinggi)',
        'p2' => 'Peluang karier luas sebagai penerjemah tersumpah, content writer internasional, staf hubungan luar negeri perusahaan multinasional, hingga tour guide/staf maskapai penerbangan.',
    ],

    // ================= KEDOKTERAN HEWAN =================
    'Kedokteran Hewan' => [
        'mk' => ['Anatomi Veteriner', 'Fisiologi Veteriner', 'Patologi Veteriner', 'Ilmu Bedah Hewan', 'Kesehatan Masyarakat Veteriner', 'Farmakologi Veteriner'],
        'kampus' => ['IPB University', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Udayana (UNUD)', 'Universitas Syiah Kuala (UNSYIAH)', 'Universitas Wijaya Kusuma Surabaya', 'Universitas Brawijaya (UB)', 'Universitas Nusa Cendana', 'Universitas Hasanuddin (UNHAS)', 'Universitas Kuala Lumpur (referensi luar negeri)'],
        'gaji' => 'Rp 5.000.000 - Rp 15.000.000 (praktik mandiri/klinik hewan lebih tinggi)',
        'p2' => 'Selain praktik klinik hewan kecil (kucing/anjing) yang makin populer di kota besar, dokter hewan juga berperan penting di peternakan skala besar, karantina hewan, industri pangan, dan kesehatan masyarakat veteriner.',
    ],

    // ================= ILMU KEOLAHRAGAAN =================
    'Ilmu Keolahragaan' => [
        'mk' => ['Fisiologi Latihan', 'Biomekanika Olahraga', 'Psikologi Olahraga', 'Ilmu Gizi Olahraga', 'Manajemen Event Olahraga', 'Kepelatihan Fisik'],
        'kampus' => ['Universitas Negeri Yogyakarta (UNY)', 'Universitas Negeri Jakarta (UNJ)', 'Universitas Negeri Surabaya (UNESA)', 'Universitas Pendidikan Indonesia (UPI)', 'Universitas Negeri Semarang (UNNES)', 'Universitas Negeri Malang (UM)', 'Universitas Negeri Medan (UNIMED)', 'Universitas Airlangga (UNAIR)', 'Universitas Sebelas Maret (UNS)', 'Universitas Udayana (UNUD)'],
        'gaji' => 'Rp 4.000.000 - Rp 12.000.000 (pelatih atlet nasional lebih tinggi)',
        'p2' => 'Berbeda dari Pendidikan Olahraga yang fokus mengajar, Ilmu Keolahragaan lebih menekankan riset performa dan sport science, cocok untuk karier sebagai analis performa atlet, sport scientist tim nasional, atau peneliti kebugaran.',
    ],

    // ================= GEOGRAFI DAN PERENCANAAN =================
    'Geografi' => [
        'mk' => ['Kartografi', 'Penginderaan Jauh', 'Sistem Informasi Geografis (SIG)', 'Geografi Lingkungan', 'Geomorfologi', 'Geografi Kependudukan'],
        'kampus' => ['Universitas Gadjah Mada (UGM)', 'Universitas Indonesia (UI)', 'Universitas Negeri Yogyakarta (UNY)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Diponegoro (UNDIP)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Negeri Malang (UM)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)', 'Universitas Negeri Semarang (UNNES)'],
        'gaji' => 'Rp 4.200.000 - Rp 11.000.000',
        'p2' => 'Keahlian SIG (GIS) dan penginderaan jauh sangat dicari perusahaan tambang, perkebunan, hingga BIG (Badan Informasi Geospasial) dan startup teknologi pemetaan yang berkembang pesat di Indonesia.',
    ],
    'Perencanaan Wilayah dan Kota' => [
        'mk' => ['Teori Perencanaan', 'Tata Guna Lahan', 'Perencanaan Transportasi', 'Ekonomi Perkotaan', 'Studio Perencanaan Kota', 'Sistem Informasi Geografis untuk Perencanaan'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Gadjah Mada (UGM)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Institut Teknologi Nasional (ITN)', 'Universitas Trisakti', 'Universitas Padjadjaran (UNPAD)'],
        'gaji' => 'Rp 4.500.000 - Rp 12.500.000',
        'p2' => 'Urbanisasi yang terus meningkat membuat kebutuhan urban planner semakin penting, baik di Kementerian PUPR, Bappeda, konsultan perencanaan swasta, maupun perusahaan pengembang (developer) properti besar.',
    ],

    // ================= JURUSAN BARU =================
    'Teknik Perkapalan' => [
        'mk' => ['Teori Bangunan Kapal', 'Konstruksi Kapal', 'Permesinan Kapal', 'Hidrodinamika', 'Perencanaan Galangan Kapal', 'Sistem Perpipaan Kapal'],
        'kampus' => ['Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Diponegoro (UNDIP)', 'Universitas Pattimura', 'Politeknik Perkapalan Negeri Surabaya', 'Universitas Riau Kepulauan', 'Universitas Indonesia (UI)'],
        'gaji' => 'Rp 5.000.000 - Rp 14.000.000',
        'p2' => 'Sebagai negara kepulauan terbesar di dunia, Indonesia sangat membutuhkan ahli perkapalan untuk industri galangan kapal, pelayaran, dan pertahanan maritim. Lulusan bekerja di galangan kapal, perusahaan pelayaran, maupun otoritas pelabuhan.',
        'p1' => 'Program Studi Teknik Perkapalan mempelajari perancangan, konstruksi, dan perawatan kapal serta bangunan apung lainnya, mencakup aspek hidrodinamika, struktur, dan sistem permesinan kapal.',
    ],
    'Aktuaria' => [
        'mk' => ['Matematika Aktuaria', 'Teori Peluang', 'Manajemen Risiko', 'Aktuaria Asuransi Jiwa', 'Aktuaria Asuransi Umum', 'Ekonomi Keuangan'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'IPB University', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Brawijaya (UB)'],
        'gaji' => 'Rp 6.000.000 - Rp 25.000.000+ (aktuaris bersertifikat FSAI sangat kompetitif)',
        'p2' => 'Profesi aktuaris termasuk salah satu yang bergaji tertinggi di Indonesia, terutama setelah meraih gelar profesi dari PAI (Persatuan Aktuaris Indonesia). Lulusan banyak bekerja di perusahaan asuransi, dana pensiun, dan konsultan aktuaria.',
        'p1' => 'Program Studi Aktuaria mempelajari penerapan matematika, statistika, dan teori peluang untuk mengukur dan mengelola risiko keuangan, terutama di industri asuransi dan dana pensiun.',
    ],
    'Ilmu Politik' => [
        'mk' => ['Teori Politik', 'Sistem Politik Indonesia', 'Perbandingan Politik', 'Partai Politik dan Pemilu', 'Sosiologi Politik', 'Metodologi Penelitian Politik'],
        'kampus' => ['Universitas Indonesia (UI)', 'Universitas Gadjah Mada (UGM)', 'Universitas Airlangga (UNAIR)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Diponegoro (UNDIP)', 'Universitas Brawijaya (UB)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Andalas (UNAND)'],
        'gaji' => 'Rp 4.200.000 - Rp 11.000.000',
        'p2' => 'Berbeda dari Ilmu Pemerintahan yang lebih teknis-administratif, Ilmu Politik menekankan analisis teoritis sistem politik, partai, dan perilaku pemilih. Lulusan berkarier sebagai peneliti politik, konsultan pemenangan pemilu, jurnalis politik, atau analis kebijakan.',
        'p1' => 'Program Studi Ilmu Politik mempelajari teori dan praktik kekuasaan, sistem pemerintahan, partai politik, serta perilaku politik masyarakat baik dalam konteks nasional maupun global.',
    ],
    'Ilmu dan Teknologi Pangan' => [
        'mk' => ['Kimia Pangan', 'Mikrobiologi Pangan', 'Teknologi Pengolahan Pangan', 'Keamanan Pangan', 'Rekayasa Proses Pangan', 'Evaluasi Sensori Pangan'],
        'kampus' => ['IPB University', 'Universitas Gadjah Mada (UGM)', 'Universitas Brawijaya (UB)', 'Universitas Padjadjaran (UNPAD)', 'Universitas Hasanuddin (UNHAS)', 'Universitas Sumatera Utara (USU)', 'Universitas Jember (UNEJ)', 'Universitas Lampung (UNILA)'],
        'gaji' => 'Rp 4.500.000 - Rp 11.500.000',
        'p2' => 'Industri makanan-minuman adalah salah satu sektor manufaktur terbesar di Indonesia. Lulusan berkarier sebagai quality control/quality assurance, product development, hingga peneliti di perusahaan pangan besar maupun BPOM.',
        'p1' => 'Program Studi Ilmu dan Teknologi Pangan mempelajari prinsip kimia, biologi, dan rekayasa dalam pengolahan, pengawetan, dan pengembangan produk pangan yang aman dan bergizi.',
    ],
    'Desain Produk' => [
        'mk' => ['Metodologi Desain', 'Ergonomi Produk', 'Desain 3D dan Prototyping', 'Material dan Proses Produksi', 'Desain Berkelanjutan', 'Studio Desain Produk'],
        'kampus' => ['Institut Teknologi Bandung (ITB)', 'Universitas Trisakti', 'Institut Kesenian Jakarta (IKJ)', 'Universitas Negeri Yogyakarta (UNY)', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Universitas Multimedia Nusantara', 'Universitas Pendidikan Indonesia (UPI)'],
        'gaji' => 'Rp 4.800.000 - Rp 13.000.000',
        'p2' => 'Lulusan Desain Produk berperan merancang produk konsumen sehari-hari mulai dari furnitur, elektronik, hingga kemasan, dengan mempertimbangkan fungsi, estetika, dan kenyamanan pengguna (ergonomi). Peluang karier meliputi industri manufaktur, startup produk, hingga membuka studio desain sendiri.',
        'p1' => 'Program Studi Desain Produk mempelajari proses merancang produk fisik yang fungsional, estetis, dan nyaman digunakan, mulai dari riset kebutuhan pengguna hingga prototyping dan produksi.',
    ],
];
