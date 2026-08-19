<?php
/**
 * Generator Seed Data v2
 * ============================================================
 * Menghasilkan file database/seed_data.sql berisi:
 * - 21 Fakultas (struktur terkoreksi mengikuti PTN riil di Indonesia)
 * - 60 Jurusan (deskripsi 2 paragraf, mata kuliah inti, top kampus, gaji)
 * - 150 Pertanyaan generik (many-to-many: 1 pertanyaan bisa mendukung
 *   beberapa jurusan sekaligus dengan bobot belief berbeda-beda)
 * - Aturan (basis pengetahuan Dempster-Shafer, ~500+ baris relasi)
 * - Universitas riil + relasi ke jurusan
 *
 * Jalankan: php generate_seed.php
 */

$struktur = require __DIR__ . '/struktur_fakultas.php';
$pertanyaanBank = require __DIR__ . '/pertanyaan_single_target.php';
$jurusanDetail = require __DIR__ . '/jurusan_detail_data.php';

function esc($str) { return addslashes($str); }

function generate_slug_local($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}

mt_srand(42); // deterministik agar hasil generate konsisten antar-run

$sql = "-- =====================================================================\n";
$sql .= "-- SEED DATA v2: Fakultas, Jurusan, Evidence, Pertanyaan, Aturan, Universitas\n";
$sql .= "-- Auto-generated oleh generate_seed.php\n";
$sql .= "-- =====================================================================\n\n";
$sql .= "USE `sipakar_jurusan`;\n\n";
$sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

// ============================================================
// 1. FAKULTAS & JURUSAN
// ============================================================
$fakultasId = 1;
$jurusanId = 1;
$namaJurusanIdMap = [];   // nama jurusan -> id
$namaFakultasIdMap = [];  // nama fakultas -> id

$rowsFakultas = [];
$rowsJurusan = [];

foreach ($struktur as $namaFakultas => $fak) {
    $slugFakultas = generate_slug_local($namaFakultas);
    $kodeFakultas = 'F' . str_pad($fakultasId, 2, '0', STR_PAD_LEFT);
    $rowsFakultas[] = "($fakultasId, '$kodeFakultas', '" . esc($namaFakultas) . "', '$slugFakultas', 'Fakultas $namaFakultas menaungi program studi unggulan yang relevan dengan bidang keilmuannya.', '{$fak['icon']}', $fakultasId)";
    $namaFakultasIdMap[$namaFakultas] = $fakultasId;

    foreach ($fak['jurusan'] as $namaJurusan) {
        $slugJurusan = generate_slug_local($namaJurusan);
        $kodeJurusan = 'J' . str_pad($jurusanId, 3, '0', STR_PAD_LEFT);

        $detail = $jurusanDetail[$namaJurusan] ?? null;

        $deskripsiP1 = $detail['p1'] ?? "Program Studi $namaJurusan mempelajari berbagai aspek keilmuan terkait $namaJurusan serta penerapannya di dunia kerja. Mahasiswa dibekali fondasi teori yang kuat sekaligus praktik langsung melalui studio, laboratorium, atau studi kasus nyata sesuai bidang keahliannya.";
        $deskripsiP2 = $detail['p2'] ?? "Lulusan $namaJurusan dipersiapkan untuk siap bersaing di dunia kerja maupun melanjutkan studi ke jenjang yang lebih tinggi, dengan bekal kompetensi yang relevan dengan kebutuhan industri masa kini.";
        $deskripsi = $deskripsiP1 . "\n\n" . $deskripsiP2;

        $skill = "Analitis, Problem Solving, Komunikasi, Kolaborasi Tim";
        $prospek = "Lulusan $namaJurusan memiliki peluang karier luas di berbagai instansi pemerintah maupun swasta.";
        $peluang = "Peluang karier terus berkembang seiring kebutuhan industri terhadap lulusan $namaJurusan.";
        $mataKuliah = $detail ? implode(' | ', $detail['mk']) : 'Kurikulum Dasar | Kurikulum Lanjutan | Praktik Kerja Lapangan';
        $gaji = $detail['gaji'] ?? 'Rp 4.000.000 - Rp 10.000.000';
        $topKampus = $detail ? implode(' | ', $detail['kampus']) : 'Universitas Indonesia (UI) | Universitas Gadjah Mada (UGM)';

        $rowsJurusan[] = "($jurusanId, {$namaFakultasIdMap[$namaFakultas]}, '$kodeJurusan', '" . esc($namaJurusan) . "', '$slugJurusan', '" . esc($deskripsi) . "', '" . esc($skill) . "', '" . esc($prospek) . "', '" . esc($peluang) . "', '" . esc($mataKuliah) . "', '" . esc($gaji) . "', '" . esc($topKampus) . "', 'bi-book')";

        $namaJurusanIdMap[$namaJurusan] = $jurusanId;
        $jurusanId++;
    }
    $fakultasId++;
}

// ============================================================
// 2. EVIDENCE, PERTANYAAN, ATURAN (single-target, 1 pertanyaan = 1 jurusan)
// ============================================================
// Pertanyaan SUDAH terurut per blok fakultas->jurusan di file sumbernya
// (pertanyaan_single_target.php), sehingga urutan tampil di form otomatis
// berkelompok: soal Kedokteran duluan, lalu Farmasi, dst.
$rowsEvidence = [];
$rowsPertanyaan = [];
$rowsAturan = [];

$evidenceId = 1;
$pertanyaanId = 1;

// Margin plausibility TETAP (bukan acak) agar hubungan belief<->plausibility
// selalu konsisten dan mudah dipahami: plausibility = belief + margin tetap,
// dibatasi maksimal 1.0. Margin kecil (0.08) merepresentasikan sedikit ruang
// ketidakpastian tersisa di atas belief langsung dari satu evidence tunggal.
const PLAUSIBILITY_MARGIN = 0.08;

foreach ($pertanyaanBank as $idx => $item) {
    $kategori = $item['kategori'];
    $teksPertanyaan = $item['teks'];
    $namaJurusan = $item['jurusan'];
    $belief = round($item['belief'], 3);
    $plausibility = round(min(1.0, $belief + PLAUSIBILITY_MARGIN), 3);

    if (!isset($namaJurusanIdMap[$namaJurusan])) {
        fwrite(STDERR, "WARNING: Jurusan '$namaJurusan' pada pertanyaan #$pertanyaanId tidak ditemukan di struktur fakultas!\n");
        continue;
    }
    $idJ = $namaJurusanIdMap[$namaJurusan];

    $namaEvidence = "Evidence #$evidenceId - " . ucfirst(str_replace('_', ' ', $kategori)) . " ($namaJurusan)";
    $kodeEvidence = 'E' . str_pad($evidenceId, 4, '0', STR_PAD_LEFT);
    $rowsEvidence[] = "($evidenceId, '$kodeEvidence', '" . esc($namaEvidence) . "', '$kategori', 'Evidence single-target untuk jurusan $namaJurusan')";

    $kodePertanyaan = 'P' . str_pad($pertanyaanId, 4, '0', STR_PAD_LEFT);
    $rowsPertanyaan[] = "($pertanyaanId, $evidenceId, '$kodePertanyaan', '$kategori', '" . esc($teksPertanyaan) . "', $idx)";

    // Aturan single-target: evidence ini HANYA mendukung SATU jurusan
    $rowsAturan[] = "($evidenceId, $idJ, $belief, $plausibility)";

    $evidenceId++;
    $pertanyaanId++;
}

$sqlFakultas = "INSERT INTO `fakultas` (`id_fakultas`, `kode_fakultas`, `nama_fakultas`, `slug`, `deskripsi`, `icon`, `urutan`) VALUES\n";
$sqlJurusan = "INSERT INTO `jurusan` (`id_jurusan`, `id_fakultas`, `kode_jurusan`, `nama_jurusan`, `slug`, `deskripsi`, `skill_dibutuhkan`, `prospek_kerja`, `peluang_karier`, `mata_kuliah_inti`, `range_gaji`, `top_kampus`, `icon`) VALUES\n";
$sqlEvidence = "INSERT INTO `evidence` (`id_evidence`, `kode_evidence`, `nama_evidence`, `kategori`, `keterangan`) VALUES\n";
$sqlPertanyaan = "INSERT INTO `pertanyaan` (`id_pertanyaan`, `id_evidence`, `kode_pertanyaan`, `kategori`, `pertanyaan`, `urutan`) VALUES\n";
$sqlAturan = "INSERT INTO `aturan` (`id_evidence`, `id_jurusan`, `nilai_belief`, `nilai_plausibility`) VALUES\n";

$sql .= $sqlFakultas . implode(",\n", $rowsFakultas) . ";\n\n";
$sql .= $sqlJurusan . implode(",\n", $rowsJurusan) . ";\n\n";
$sql .= $sqlEvidence . implode(",\n", $rowsEvidence) . ";\n\n";
$sql .= $sqlPertanyaan . implode(",\n", $rowsPertanyaan) . ";\n\n";
$sql .= $sqlAturan . implode(",\n", $rowsAturan) . ";\n\n";

// ============================================================
// 3. UNIVERSITAS + RELASI JURUSAN_UNIVERSITAS
// ============================================================
$petaKota = [
    'Universitas Indonesia (UI)' => ['Depok', 'Jawa Barat', 1950], 'Institut Teknologi Bandung (ITB)' => ['Bandung', 'Jawa Barat', 1920],
    'Universitas Gadjah Mada (UGM)' => ['Yogyakarta', 'DI Yogyakarta', 1949], 'Institut Teknologi Sepuluh Nopember (ITS)' => ['Surabaya', 'Jawa Timur', 1957],
    'IPB University' => ['Bogor', 'Jawa Barat', 1963], 'Universitas Airlangga (UNAIR)' => ['Surabaya', 'Jawa Timur', 1954],
    'Universitas Padjadjaran (UNPAD)' => ['Bandung', 'Jawa Barat', 1957], 'Universitas Diponegoro (UNDIP)' => ['Semarang', 'Jawa Tengah', 1957],
    'Universitas Brawijaya (UB)' => ['Malang', 'Jawa Timur', 1963], 'Universitas Hasanuddin (UNHAS)' => ['Makassar', 'Sulawesi Selatan', 1956],
    'Universitas Sumatera Utara (USU)' => ['Medan', 'Sumatera Utara', 1952], 'Universitas Andalas (UNAND)' => ['Padang', 'Sumatera Barat', 1956],
    'Universitas Sebelas Maret (UNS)' => ['Surakarta', 'Jawa Tengah', 1976], 'Universitas Negeri Yogyakarta (UNY)' => ['Yogyakarta', 'DI Yogyakarta', 1964],
    'Universitas Negeri Malang (UM)' => ['Malang', 'Jawa Timur', 1954], 'Universitas Negeri Jakarta (UNJ)' => ['Jakarta', 'DKI Jakarta', 1964],
    'Universitas Negeri Semarang (UNNES)' => ['Semarang', 'Jawa Tengah', 1965], 'Universitas Negeri Surabaya (UNESA)' => ['Surabaya', 'Jawa Timur', 1964],
    'Universitas Negeri Medan (UNIMED)' => ['Medan', 'Sumatera Utara', 1963], 'Universitas Negeri Padang (UNP)' => ['Padang', 'Sumatera Barat', 1954],
    'Universitas Negeri Makassar (UNM)' => ['Makassar', 'Sulawesi Selatan', 1961], 'Universitas Pendidikan Ganesha (UNDIKSHA)' => ['Singaraja', 'Bali', 1955],
    'Universitas Pendidikan Indonesia (UPI)' => ['Bandung', 'Jawa Barat', 1954], 'Universitas Telkom' => ['Bandung', 'Jawa Barat', 1990],
    'Universitas Trisakti' => ['Jakarta', 'DKI Jakarta', 1965], 'Universitas Jember (UNEJ)' => ['Jember', 'Jawa Timur', 1964],
    'Universitas Riau (UNRI)' => ['Pekanbaru', 'Riau', 1962], 'Universitas Sriwijaya (UNSRI)' => ['Palembang', 'Sumatera Selatan', 1960],
    'Universitas Lampung (UNILA)' => ['Bandar Lampung', 'Lampung', 1965], 'Universitas Jenderal Soedirman (UNSOED)' => ['Purwokerto', 'Jawa Tengah', 1963],
    'Universitas Udayana (UNUD)' => ['Denpasar', 'Bali', 1962], 'Universitas Mulawarman (UNMUL)' => ['Samarinda', 'Kalimantan Timur', 1962],
    'Universitas Multimedia Nusantara' => ['Tangerang', 'Banten', 2006], 'Universitas Parahyangan (UNPAR)' => ['Bandung', 'Jawa Barat', 1955],
    'Universitas Islam Indonesia (UII)' => ['Yogyakarta', 'DI Yogyakarta', 1945], 'Institut Seni Indonesia Yogyakarta (ISI)' => ['Yogyakarta', 'DI Yogyakarta', 1984],
    'Institut Kesenian Jakarta (IKJ)' => ['Jakarta', 'DKI Jakarta', 1970], 'Institut Seni Indonesia Surakarta' => ['Surakarta', 'Jawa Tengah', 1964],
    'Institut Seni Indonesia Denpasar' => ['Denpasar', 'Bali', 1967], 'Politeknik Negeri Bandung' => ['Bandung', 'Jawa Barat', 1979],
    'Politeknik Siber dan Sandi Negara' => ['Bogor', 'Jawa Barat', 2003], 'Universitas Islam Negeri Syarif Hidayatullah' => ['Tangerang Selatan', 'Banten', 1957],
    'IPDN' => ['Jatinangor', 'Jawa Barat', 1956], 'Institut Teknologi Nasional (ITN)' => ['Malang', 'Jawa Timur', 1969],
    'Universitas Lambung Mangkurat' => ['Banjarmasin', 'Kalimantan Selatan', 1958], 'Universitas Tanjungpura' => ['Pontianak', 'Kalimantan Barat', 1959],
    'Universitas Papua' => ['Manokwari', 'Papua Barat', 2000], 'Universitas Syiah Kuala (UNSYIAH)' => ['Banda Aceh', 'Aceh', 1961],
    'Universitas Wijaya Kusuma Surabaya' => ['Surabaya', 'Jawa Timur', 1981], 'Universitas Nusa Cendana' => ['Kupang', 'Nusa Tenggara Timur', 1962],
    'Politeknik Perkapalan Negeri Surabaya' => ['Surabaya', 'Jawa Timur', 1987], 'Universitas Pattimura' => ['Ambon', 'Maluku', 1963],
    'Universitas Riau Kepulauan' => ['Batam', 'Kepulauan Riau', 1995],
];

$rowsUniversitas = [];
$rowsJurusanUniv = [];
$universitasIdMap = [];
$univId = 1;

foreach ($jurusanDetail as $namaJ => $detail) {
    foreach ($detail['kampus'] as $namaKampus) {
        if (!isset($universitasIdMap[$namaKampus])) {
            $universitasIdMap[$namaKampus] = $univId;
            $singkatan = '';
            if (preg_match('/\(([^)]+)\)/', $namaKampus, $m)) $singkatan = $m[1];
            $namaBersih = trim(preg_replace('/\s*\([^)]+\)/', '', $namaKampus));
            $info = $petaKota[$namaKampus] ?? ['Indonesia', 'Indonesia', null];
            [$kota, $provinsi, $tahun] = $info;
            $slugWeb = strtolower(preg_replace('/[^a-z0-9]/', '', strtolower($singkatan ?: $namaBersih)));
            $website = "https://www.{$slugWeb}.ac.id";
            $jumlahMhs = number_format(mt_rand(8, 55) * 1000) . '+';
            $akInstitusi = ['Unggul', 'A', 'A', 'Baik Sekali'][mt_rand(0, 3)];
            $tahunSql = $tahun ? $tahun : 'NULL';
            $rowsUniversitas[] = "($univId, '" . esc($namaBersih) . "', '" . esc($singkatan) . "', '" . esc($kota) . "', '" . esc($provinsi) . "', 'negeri', '$akInstitusi', $tahunSql, '$jumlahMhs', '" . esc($website) . "')";
            $univId++;
        }
    }
}

foreach ($jurusanDetail as $namaJ => $detail) {
    if (!isset($namaJurusanIdMap[$namaJ])) continue;
    $idJ = $namaJurusanIdMap[$namaJ];
    $kampusUnik = array_unique($detail['kampus']); // safeguard: cegah duplikat kampus dalam 1 jurusan
    foreach ($kampusUnik as $namaKampus) {
        if (!isset($universitasIdMap[$namaKampus])) continue;
        $idU = $universitasIdMap[$namaKampus];
        $akProdi = ['A', 'A', 'Unggul', 'B'][mt_rand(0, 3)];
        $jalur = ['SNBP/SNBT', 'SNBP/SNBT/Mandiri'][mt_rand(0, 1)];
        $rowsJurusanUniv[] = "($idJ, $idU, '$akProdi', '$jalur')";
    }
}

$sqlUniversitas = "INSERT INTO `universitas` (`id_universitas`, `nama_universitas`, `singkatan`, `kota`, `provinsi`, `jenis`, `akreditasi_institusi`, `tahun_berdiri`, `jumlah_mahasiswa`, `website`) VALUES\n";
$sqlJurusanUniv = "INSERT INTO `jurusan_universitas` (`id_jurusan`, `id_universitas`, `akreditasi`, `jalur_masuk`) VALUES\n";
$sql .= $sqlUniversitas . implode(",\n", $rowsUniversitas) . ";\n\n";
$sql .= $sqlJurusanUniv . implode(",\n", $rowsJurusanUniv) . ";\n\n";

$sql .= "SET FOREIGN_KEY_CHECKS = 1;\n";

// ============================================================
// RINGKASAN
// ============================================================
echo "Generated:\n";
echo "- Fakultas: " . count($rowsFakultas) . "\n";
echo "- Jurusan: " . count($rowsJurusan) . "\n";
echo "- Evidence (Pertanyaan): " . count($rowsEvidence) . "\n";
echo "- Aturan (relasi many-to-many): " . count($rowsAturan) . "\n";
echo "- Universitas: " . count($rowsUniversitas) . "\n";
echo "- Relasi Jurusan-Universitas: " . count($rowsJurusanUniv) . "\n";

file_put_contents(__DIR__ . '/seed_data.sql', $sql);
echo "\nFile database/seed_data.sql berhasil dibuat.\n";
