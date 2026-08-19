<?php
/**
 * Pengujian Sistem - Unit Test Engine Dempster-Shafer
 * Jalankan: php tests/test_dempster_shafer.php
 *
 * Skenario diuji:
 * 1. Evidence tunggal (baseline)
 * 2. Evidence konvergen (saling mendukung jurusan sama)
 * 3. Evidence konflik (mendukung jurusan berbeda)
 * 4. Evidence campuran (beberapa jurusan, beberapa evidence)
 */

require_once __DIR__ . '/../core/DempsterShafer.php';

$totalTest = 0;
$passedTest = 0;

function assertAlmostEqual($actual, $expected, $label, $tolerance = 0.0001) {
    global $totalTest, $passedTest;
    $totalTest++;
    $diff = abs($actual - $expected);
    if ($diff <= $tolerance) {
        echo "  [PASS] $label (actual=$actual, expected=$expected)\n";
        $passedTest++;
    } else {
        echo "  [FAIL] $label (actual=$actual, expected=$expected, diff=$diff)\n";
    }
}

echo "=====================================================\n";
echo " PENGUJIAN SISTEM: Engine Dempster-Shafer\n";
echo "=====================================================\n\n";

// ===== TEST 1: Evidence Tunggal =====
echo "TEST 1: Evidence Tunggal (baseline)\n";
$ds = new DempsterShafer();
$ds->tambahEvidence(1, ['id_evidence' => 1, 'nama_evidence' => 'E1'], [
    ['id_jurusan' => 1, 'nama_jurusan' => 'Jurusan A', 'belief' => 0.8],
]);
$hasil = $ds->getHasilAkhir();
assertAlmostEqual($hasil[0]['belief'], 0.8, 'Belief evidence tunggal harus sama dengan nilai belief aturan');
assertAlmostEqual($ds->getFinalTheta(), 0.2, 'Theta sisa harus 1 - belief');

// ===== TEST 2: Evidence Konvergen (3x mendukung jurusan sama, belief 0.75) =====
echo "\nTEST 2: Evidence Konvergen (3 evidence, jurusan sama, belief=0.75)\n";
$ds2 = new DempsterShafer();
for ($i = 1; $i <= 3; $i++) {
    $ds2->tambahEvidence($i, ['id_evidence' => $i, 'nama_evidence' => "E$i"], [
        ['id_jurusan' => 1, 'nama_jurusan' => 'Teknik Informatika', 'belief' => 0.75],
    ]);
}
$hasil2 = $ds2->getHasilAkhir();
// Perhitungan manual: 0.75 -> combine -> 0.9375 -> combine -> 0.984375
assertAlmostEqual($hasil2[0]['belief'], 0.984375, 'Belief hasil kombinasi 3x evidence 0.75 harus 0.984375');

// ===== TEST 3: Evidence Konflik (2 evidence, jurusan berbeda, belief 0.9) =====
echo "\nTEST 3: Evidence Konflik (2 evidence, jurusan berbeda, belief=0.9)\n";
$ds3 = new DempsterShafer();
$ds3->tambahEvidence(1, ['id_evidence' => 1, 'nama_evidence' => 'Suka A'], [
    ['id_jurusan' => 1, 'nama_jurusan' => 'Jurusan A', 'belief' => 0.9],
]);
$ds3->tambahEvidence(2, ['id_evidence' => 2, 'nama_evidence' => 'Suka B'], [
    ['id_jurusan' => 2, 'nama_jurusan' => 'Jurusan B', 'belief' => 0.9],
]);
$hasil3 = $ds3->getHasilAkhir();
// Manual: K = 0.9*0.9 = 0.81; m3(A) = m3(B) = 0.09/(1-0.81) = 0.473684
assertAlmostEqual($hasil3[0]['belief'], 0.473684, 'Belief jurusan A setelah konflik harus 0.473684', 0.001);
assertAlmostEqual($hasil3[1]['belief'], 0.473684, 'Belief jurusan B setelah konflik harus 0.473684 (seri)', 0.001);

// ===== TEST 4: Evidence Campuran (1 evidence mendukung 2 jurusan sekaligus) =====
echo "\nTEST 4: Evidence Mendukung Multi-Jurusan Sekaligus\n";
$ds4 = new DempsterShafer();
$ds4->tambahEvidence(1, ['id_evidence' => 1, 'nama_evidence' => 'E1'], [
    ['id_jurusan' => 1, 'nama_jurusan' => 'Jurusan A', 'belief' => 0.5],
    ['id_jurusan' => 2, 'nama_jurusan' => 'Jurusan B', 'belief' => 0.3],
]);
$hasil4 = $ds4->getHasilAkhir();
$totalBelief4 = array_sum(array_column($hasil4, 'belief'));
assertAlmostEqual($totalBelief4, 0.8, 'Total belief 2 jurusan dari 1 evidence harus 0.5+0.3=0.8');

// ===== TEST 5: Ranking Terurut Benar =====
echo "\nTEST 5: Validasi Urutan Ranking (belief tertinggi harus ranking 1)\n";
$ds5 = new DempsterShafer();
$ds5->tambahEvidence(1, ['id_evidence' => 1, 'nama_evidence' => 'E1'], [
    ['id_jurusan' => 1, 'nama_jurusan' => 'Rendah', 'belief' => 0.2],
    ['id_jurusan' => 2, 'nama_jurusan' => 'Tinggi', 'belief' => 0.6],
]);
$hasil5 = $ds5->getHasilAkhir();
$totalTest++;
if ($hasil5[0]['id_jurusan'] === 2 && $hasil5[0]['ranking'] === 1) {
    echo "  [PASS] Ranking 1 adalah jurusan dengan belief tertinggi\n";
    $passedTest++;
} else {
    echo "  [FAIL] Urutan ranking salah\n";
}

// ===== TEST 6: Total Persentase Tidak Melebihi 100% =====
echo "\nTEST 6: Sanity Check - Total Persentase Tidak Melebihi 100%\n";
$totalPersen = array_sum(array_column($hasil3, 'persentase'));
$totalTest++;
if ($totalPersen <= 100.01) {
    echo "  [PASS] Total persentase seluruh jurusan = " . round($totalPersen, 2) . "% (<= 100%)\n";
    $passedTest++;
} else {
    echo "  [FAIL] Total persentase melebihi 100%: " . round($totalPersen, 2) . "%\n";
}

// ===== TEST 7: Skenario Ekstrem - Banyak Jurusan Eksklusif Berturut-turut =====
// Ini adalah skenario yang sebelumnya menyebabkan bug "Out of range value" saat
// disimpan ke database, karena belief bisa "meledak" > 1 akibat konflik tinggi.
echo "\nTEST 7: Skenario Ekstrem - 24 Evidence dari 24 Jurusan Berbeda (konflik tinggi)\n";
$ds7 = new DempsterShafer();
for ($i = 1; $i <= 24; $i++) {
    $ds7->tambahEvidence($i, ['id_evidence' => $i, 'nama_evidence' => "E$i"], [
        ['id_jurusan' => $i, 'nama_jurusan' => "Jurusan $i", 'belief' => 0.6 + (($i % 5) * 0.05)],
    ]);
}
$hasil7 = $ds7->getHasilAkhir();
$semuaValid = true;
foreach ($hasil7 as $h) {
    if ($h['belief'] < 0 || $h['belief'] > 1) { $semuaValid = false; break; }
}
$totalTest++;
if ($semuaValid) {
    echo "  [PASS] Seluruh nilai belief tetap dalam rentang valid [0,1] meski 24 jurusan saling eksklusif\n";
    $passedTest++;
} else {
    echo "  [FAIL] Ada nilai belief di luar rentang [0,1]!\n";
}

// Pastikan juga bisa disimpan ke kolom DECIMAL(6,4) -- max 99.9999
$totalTest++;
$semuaMuatDecimal = true;
foreach ($hasil7 as $h) {
    if ($h['belief'] >= 99.9999) { $semuaMuatDecimal = false; break; }
}
if ($semuaMuatDecimal) {
    echo "  [PASS] Seluruh nilai belief muat disimpan ke kolom DECIMAL(6,4)\n";
    $passedTest++;
} else {
    echo "  [FAIL] Ada nilai belief yang akan overflow saat disimpan ke database!\n";
}

// ===== TEST 8: Regression - Theta Tidak Boleh Collapse ke 0 (bug lama) =====
// Bug lama: saat 1 evidence mendukung banyak jurusan dengan total belief
// mendekati/melebihi 1, theta bisa jatuh ke PERSIS 0, menyebabkan jurusan
// yang tidak disebut evidence berikutnya "ternolkan" permanen setelah
// beberapa iterasi. Ini menyebabkan SEMUA persentase tampil 0.00%.
echo "\nTEST 8: Regression - 11 Evidence Realistis (skenario siswa minat IT)\n";
$ds8 = new DempsterShafer();
$skenarioIT = [
    [1, ['Teknik Informatika' => 0.85, 'Ilmu Komputer' => 0.85, 'Sistem Informasi' => 0.65, 'Teknik Komputer' => 0.75, 'Data Science' => 0.60, 'Keamanan Siber' => 0.65]],
    [2, ['Teknik Informatika' => 0.90, 'Ilmu Komputer' => 0.80, 'Sistem Informasi' => 0.60]],
    [3, ['Teknik Informatika' => 0.80, 'Ilmu Komputer' => 0.85, 'Matematika' => 0.60, 'Data Science' => 0.70, 'Statistika' => 0.55]],
    [4, ['Keamanan Siber' => 0.90, 'Teknik Informatika' => 0.45, 'Teknik Komputer' => 0.50]],
    [5, ['Teknik Komputer' => 0.85, 'Keamanan Siber' => 0.60, 'Teknik Informatika' => 0.45]],
    [6, ['Ilmu Komputer' => 0.88, 'Data Science' => 0.80, 'Teknik Informatika' => 0.55]],
    [7, ['Teknik Informatika' => 0.75, 'Ilmu Komputer' => 0.72, 'Sistem Informasi' => 0.65, 'Bisnis Digital' => 0.65, 'Data Science' => 0.60]],
    [8, ['Data Science' => 0.90, 'Statistika' => 0.70, 'Sistem Informasi' => 0.45]],
    [9, ['Teknik Informatika' => 0.50, 'Matematika' => 0.70, 'Teknik Industri' => 0.55]],
    [10, ['Teknik Informatika' => 0.50, 'Bisnis Digital' => 0.45, 'Data Science' => 0.50]],
    [11, ['Keamanan Siber' => 0.90, 'Teknik Informatika' => 0.35]],
];
$namaToId = ['Teknik Informatika'=>1,'Ilmu Komputer'=>2,'Sistem Informasi'=>3,'Teknik Komputer'=>4,'Data Science'=>5,'Keamanan Siber'=>6,'Matematika'=>7,'Statistika'=>8,'Bisnis Digital'=>9,'Teknik Industri'=>10];
foreach ($skenarioIT as [$urutan, $rules]) {
    $ruleFormatted = [];
    foreach ($rules as $nama => $belief) {
        $ruleFormatted[] = ['id_jurusan' => $namaToId[$nama], 'nama_jurusan' => $nama, 'belief' => $belief];
    }
    $ds8->tambahEvidence($urutan, ['id_evidence' => $urutan, 'nama_evidence' => "E$urutan"], $ruleFormatted);
}
$hasil8 = $ds8->getHasilAkhir();
$totalTest++;
$topBelief = $hasil8[0]['belief'] ?? 0;
if ($topBelief > 0.5) {
    echo "  [PASS] Jurusan teratas (Teknik Informatika, paling sering muncul) memiliki belief tinggi (" . round($topBelief * 100, 2) . "%), TIDAK collapse ke 0\n";
    $passedTest++;
} else {
    echo "  [FAIL] Belief teratas hanya " . round($topBelief * 100, 4) . "% -- kemungkinan bug theta-collapse muncul kembali!\n";
}
$totalTest++;
if ($hasil8[0]['id_jurusan'] === $namaToId['Teknik Informatika']) {
    echo "  [PASS] Ranking 1 adalah Teknik Informatika (jurusan paling konsisten didukung evidence)\n";
    $passedTest++;
} else {
    echo "  [FAIL] Ranking 1 bukan Teknik Informatika, melainkan ID {$hasil8[0]['id_jurusan']}\n";
}

echo "\n=====================================================\n";
echo " HASIL AKHIR: $passedTest / $totalTest test PASSED\n";
echo "=====================================================\n";

exit($passedTest === $totalTest ? 0 : 1);
