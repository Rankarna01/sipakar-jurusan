<?php
/**
 * Class PdfExporter
 * Menghasilkan PDF hasil konsultasi berupa LAPORAN NARATIF: rekomendasi
 * fakultas & jurusan, deskripsi, peluang kerja, dan estimasi gaji.
 * (Tabel evidence & langkah perhitungan step-by-step SENGAJA tidak
 * disertakan di PDF karena terlalu panjang/"spam" untuk dokumen cetak;
 * rincian teknis tersebut tetap dapat dilihat di halaman web hasil.)
 *
 * CATATAN INSTALASI:
 *   composer require dompdf/dompdf
 * Jika belum terinstal, otomatis fallback ke versi HTML siap cetak.
 */

class PdfExporter
{
    private bool $dompdfAvailable = false;

    public function __construct()
    {
        $autoload = ROOT_PATH . '/vendor/autoload.php';
        if (file_exists($autoload)) {
            require_once $autoload;
            $this->dompdfAvailable = class_exists('Dompdf\Dompdf');
        }
    }

    public function exportHasilKonsultasi(array $hasil, array $detailRanking, array $jurusanDalamFakultas, array $universitas, array $siswa = []): void
    {
        $html = $this->buildHtml($hasil, $detailRanking, $jurusanDalamFakultas, $universitas, $siswa);
        
        $namaPengguna = $siswa['nama'] ?? $hasil['nama_siswa'] ?? $hasil['nama_tamu'] ?? 'Tamu';
        $safeName = preg_replace('/[^a-zA-Z0-9_]/', '_', str_replace(' ', '_', $namaPengguna));

        if ($this->dompdfAvailable) {
            $dompdf = new \Dompdf\Dompdf(['isRemoteEnabled' => true]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('Hasil_Konsultasi_' . $safeName . '.pdf', ['Attachment' => true]);
            exit;
        }

        header('Content-Type: text/html; charset=utf-8');
        echo $html;
        echo '<script>window.onload = () => window.print();</script>';
        exit;
    }

    private function buildHtml(array $hasil, array $detailRanking, array $jurusanDalamFakultas, array $universitas, array $siswa): string
    {
        $namaPengguna = $siswa['nama'] ?? $hasil['nama_siswa'] ?? $hasil['nama_tamu'] ?? 'Tamu';
        $kelas = $siswa['kelas'] ?? $hasil['kelas_siswa'] ?? $hasil['kelas_tamu'] ?? '-';
        $nis = $siswa['nisn'] ?? '-';
        $npsn = function_exists('get_setting') ? get_setting('npsn_sekolah', '10214151') : '10214151';
        $top = $detailRanking[0] ?? null;
        $namaFakultas = $hasil['nama_fakultas_terbaik'] ?? ($top['nama_fakultas'] ?? '-');
        $persenFakultas = $hasil['persentase_fakultas_terbaik'] ?? ($top['persentase'] ?? 0);

        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1e293b; line-height: 1.55; }
                h1 { font-size: 19px; color: #0284c7; margin-bottom: 4px; }
                h2 { font-size: 15px; margin-top: 22px; border-bottom: 2px solid #38bdf8; padding-bottom: 5px; color: #0f172a; }
                .header-box { border-bottom: 3px solid #0284c7; padding-bottom: 12px; margin-bottom: 18px; }
                table { width: 100%; border-collapse: collapse; margin-top: 8px; }
                th, td { border: 1px solid #cbd5e1; padding: 7px 9px; text-align: left; font-size: 11px; }
                th { background: #0f172a; color: white; }
                .highlight-row { background: #fef3c7; font-weight: bold; }
                .info-table td { border: none; padding: 2px 8px 2px 0; font-size: 12px; }
                .footer { margin-top: 30px; font-size: 10px; color: #64748b; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 10px; }
                .fakultas-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 14px 16px; margin-top: 10px; }
                .fakultas-box .persen { font-size: 26px; font-weight: bold; color: #0284c7; }
                .narasi { text-align: justify; margin: 6px 0; }
                .job-badge { display: inline-block; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 3px 10px; margin: 2px 4px 2px 0; font-size: 10.5px; }
            </style>
        </head>
        <body>
            <div class="header-box">
                <h1>SMA Muhammadiyah 18 Sunggal</h1>
                <p style="margin:0;">Laporan Hasil Konsultasi Sistem Pakar Rekomendasi Jurusan PTN — Metode Dempster-Shafer</p>
            </div>

            <h2>Identitas Peserta</h2>
            <table class="info-table">
                <tr><td><strong>Nama</strong></td><td>: <?= htmlspecialchars($namaPengguna) ?></td></tr>
                <tr><td><strong>NIS / NISN</strong></td><td>: <?= htmlspecialchars($nis) ?></td></tr>
                <tr><td><strong>Kelas</strong></td><td>: <?= htmlspecialchars($kelas) ?></td></tr>
                <tr><td><strong>NPSN Sekolah</strong></td><td>: <?= htmlspecialchars($npsn) ?></td></tr>
                <tr><td><strong>Kode Konsultasi</strong></td><td>: <?= htmlspecialchars($hasil['kode_konsultasi']) ?></td></tr>
                <tr><td><strong>Tanggal</strong></td><td>: <?= function_exists('format_tanggal') ? format_tanggal($hasil['created_at'], true) : htmlspecialchars($hasil['created_at']) ?></td></tr>
            </table>

            <h2>Fakultas yang Direkomendasikan</h2>
            <div class="fakultas-box">
                <div class="persen"><?= number_format((float) $persenFakultas, 2) ?>%</div>
                <p style="margin:4px 0 0;"><strong>Fakultas <?= htmlspecialchars($namaFakultas) ?></strong></p>
            </div>
            <p class="narasi">
                Berdasarkan hasil analisis jawaban terhadap seluruh pertanyaan yang mencakup aspek minat, bakat,
                kemampuan, kepribadian, dan tujuan karier, sistem pakar merekomendasikan
                <strong><?= htmlspecialchars($namaPengguna) ?></strong> untuk mempertimbangkan <strong>Fakultas <?= htmlspecialchars($namaFakultas) ?></strong>
                sebagai bidang studi yang paling sesuai, dengan tingkat keyakinan sistem sebesar
                <strong><?= number_format((float) $persenFakultas, 2) ?>%</strong>.
                Di dalam fakultas ini, terdapat beberapa program studi spesifik yang dapat dipertimbangkan lebih lanjut sesuai kecocokan masing-masing.
            </p>

            <?php if (!empty($jurusanDalamFakultas)): ?>
            <h2>Program Studi Unggulan di Fakultas Ini</h2>
            <table>
                <thead><tr><th>#</th><th>Program Studi</th><th>Kecocokan</th><th>Estimasi Gaji Lulusan</th></tr></thead>
                <tbody>
                <?php foreach (array_slice($jurusanDalamFakultas, 0, 6) as $i => $jd): ?>
                    <tr class="<?= $i === 0 ? 'highlight-row' : '' ?>">
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($jd['nama_jurusan']) ?></td>
                        <td><?= isset($jd['persentase']) ? number_format((float) $jd['persentase'], 2) . '%' : '-' ?></td>
                        <td><?= htmlspecialchars($jd['range_gaji'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

            <?php foreach (array_slice($detailRanking, 0, 3) as $idx => $rank): ?>
            <h2>Detail Rekomendasi #<?= $idx + 1 ?>: <?= htmlspecialchars($rank['nama_jurusan']) ?> (Skor: <?= number_format((float) $rank['persentase'], 2) ?>%)</h2>
            <?php foreach (explode("\n\n", $rank['deskripsi'] ?? '') as $paragraf): if (trim($paragraf) === '') continue; ?>
                <p class="narasi"><?= htmlspecialchars($paragraf) ?></p>
            <?php endforeach; ?>

            <table class="info-table">
                <?php if (!empty($rank['skill_dibutuhkan'])): ?>
                <tr><td style="width:160px;"><strong>🛠️ Skill Dibutuhkan</strong></td><td>: <?= htmlspecialchars($rank['skill_dibutuhkan']) ?></td></tr>
                <?php endif; ?>
                <?php if (!empty($rank['pekerjaan_list'])): ?>
                <tr><td><strong>💼 Prospek Kerja</strong></td><td>: <?= htmlspecialchars(implode(', ', $rank['pekerjaan_list'])) ?></td></tr>
                <?php elseif (!empty($rank['prospek_kerja'])): ?>
                <tr><td><strong>💼 Prospek Kerja</strong></td><td>: <?= htmlspecialchars($rank['prospek_kerja']) ?></td></tr>
                <?php endif; ?>
                <?php if (!empty($rank['range_gaji'])): ?>
                <tr><td><strong>💰 Estimasi Gaji</strong></td><td>: <?= htmlspecialchars($rank['range_gaji']) ?></td></tr>
                <?php endif; ?>
            </table>
            <?php endforeach; ?>

            <?php if (!empty($top['mata_kuliah_inti'])): ?>
            <h2>Mata Kuliah Inti</h2>
            <p class="narasi">
                <?php foreach (explode('|', $top['mata_kuliah_inti']) as $mk): ?>
                    <span class="job-badge">📖 <?= htmlspecialchars(trim($mk)) ?></span>
                <?php endforeach; ?>
            </p>
            <?php endif; ?>

            <?php if (!empty($universitas) && !empty($top)): ?>
            <h2>Rekomendasi Kampus Penyedia Program Studi Ini</h2>
            <table>
                <thead><tr><th>Universitas</th><th>Kota</th><th>Akreditasi</th></tr></thead>
                <tbody>
                <?php foreach (array_slice($universitas, 0, 8) as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['nama_universitas']) ?></td>
                        <td><?= htmlspecialchars($u['kota'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($u['akreditasi'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
            
            <h2>Ringkasan Ranking Program Studi</h2>
            <table>
                <thead><tr><th>#</th><th>Program Studi</th><th>Fakultas</th><th>Persentase Kecocokan</th></tr></thead>
                <tbody>
                <?php foreach ($detailRanking as $d): ?>
                    <tr class="<?= $d['ranking'] == 1 ? 'highlight-row' : '' ?>">
                        <td><?= $d['ranking'] ?></td>
                        <td><?= htmlspecialchars($d['nama_jurusan']) ?></td>
                        <td><?= htmlspecialchars($d['nama_fakultas']) ?></td>
                        <td><?= number_format((float) $d['persentase'], 2) ?>%</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="footer">
                Dokumen ini dihasilkan otomatis oleh Sistem Pakar SiJurusan — SMA Muhammadiyah 18 Sunggal.<br>
                Kode Verifikasi: <?= htmlspecialchars($hasil['kode_konsultasi']) ?> &nbsp;|&nbsp;
                Hasil ini bersifat rekomendasi; disarankan tetap berdiskusi dengan Guru BK sebelum memutuskan.
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}
