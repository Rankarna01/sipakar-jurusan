<?php
/**
 * Class DempsterShafer
 * ============================================================
 * Implementasi lengkap Metode Dempster-Shafer untuk kombinasi
 * evidence (bukti) dalam menentukan rekomendasi jurusan PTN.
 *
 * Konsep dasar:
 * - Frame of Discernment (Theta): himpunan seluruh jurusan yang mungkin
 * - Mass Function m(X): tingkat kepercayaan terhadap himpunan bagian X
 * - Belief: total kepercayaan langsung terhadap suatu hipotesis
 * - Plausibility: batas atas kepercayaan (belum ada bukti yang membantahnya)
 * - Kombinasi (Dempster's Rule of Combination):
 *
 *      m3(Z) = [ Σ (m1(X) * m2(Y)) untuk X∩Y=Z ] / (1 - K)
 *
 *   dengan K (konflik) = Σ (m1(X) * m2(Y)) untuk X∩Y=∅
 *
 * Karena setiap evidence di sistem ini men-support himpunan jurusan
 * tertentu (bukan hanya satu jurusan tunggal), maka:
 *      - m(Hipotesis)     = nilai_belief evidence terhadap jurusan tsb
 *      - m(Theta)         = 1 - nilai_belief  (ketidakpastian / semesta)
 *
 * Setiap kali evidence baru masuk, dilakukan kombinasi antara mass
 * function "lama" (hasil kombinasi sebelumnya) dengan mass function
 * evidence baru, secara TERPISAH untuk setiap jurusan yang didukung
 * evidence tersebut. Seluruh langkah dicatat agar dapat ditampilkan
 * secara transparan ke pengguna.
 * ============================================================
 */

class DempsterShafer
{
    /** @var array Menyimpan mass function belief per jurusan: ['id_jurusan' => belief] */
    private array $currentBelief = [];

    /** @var float Menyimpan nilai theta (ketidakpastian) global saat ini */
    private float $currentTheta = 1.0;

    /** @var array Menyimpan seluruh log langkah perhitungan untuk ditampilkan ke user */
    private array $steps = [];

    /** @var bool Menandai apakah ini evidence pertama yang diproses */
    private bool $isFirstEvidence = true;

    public function __construct()
    {
        $this->currentBelief = [];
        $this->currentTheta = 1.0;
        $this->steps = [];
    }

    /**
     * Memproses satu evidence baru (yang men-support beberapa jurusan dengan
     * nilai belief masing-masing) dan mengombinasikannya dengan mass function
     * yang sudah ada menggunakan Dempster's Rule of Combination.
     *
     * @param int   $urutan       Urutan evidence ke-berapa (untuk logging)
     * @param array $evidenceInfo Info evidence: ['id_evidence' => int, 'nama_evidence' => string]
     * @param array $ruleJurusan  Daftar aturan: [['id_jurusan' => int, 'nama_jurusan'=>string, 'belief' => float], ...]
     */
    public function tambahEvidence(int $urutan, array $evidenceInfo, array $ruleJurusan): void
    {
        if (empty($ruleJurusan)) {
            return; // Evidence ini tidak punya aturan yang relevan, dilewati
        }

        // ==== Mass function BARU (m2) dari evidence saat ini ====
        // Karena satu evidence bisa mendukung >1 jurusan, sisa mass "theta"
        // dibagi rata sesuai konsep ketidakpastian gabungan.
        $m2 = [];
        $totalBeliefBaru = 0.0;
        foreach ($ruleJurusan as $rule) {
            $m2[$rule['id_jurusan']] = (float) $rule['belief'];
            $totalBeliefBaru += (float) $rule['belief'];
        }
        // Jika total belief evidence baru >= 1 (banyak jurusan didukung sekaligus),
        // skala proporsional ke MAKSIMAL 0.90 -- SENGAJA TIDAK dinormalisasi sampai
        // tepat 1.0. Jika theta (sisa ketidakpastian) jatuh ke PERSIS 0, evidence
        // berikutnya yang tidak menyinggung jurusan-jurusan ini akan mengalikannya
        // dengan 0 pada langkah kombinasi (karena m1Theta/m2Theta dipakai untuk
        // "meneruskan" belief jurusan yang tidak disebut evidence baru), sehingga
        // jurusan tsb hilang permanen dari hasil akhir -- inilah akar penyebab bug
        // "semua persentase menjadi 0.00%" saat banyak evidence diproses berurutan.
        // Menjaga theta minimum (>=0.10) memastikan setiap jurusan tetap "dibawa
        // maju" melalui iterasi kombinasi berikutnya.
        $batasMaksimalBelief = 0.90;
        if ($totalBeliefBaru >= $batasMaksimalBelief) {
            foreach ($m2 as $key => $val) {
                $m2[$key] = ($val / $totalBeliefBaru) * $batasMaksimalBelief;
            }
            $totalBeliefBaru = $batasMaksimalBelief;
        }
        $m2Theta = 1 - $totalBeliefBaru;

        if ($this->isFirstEvidence) {
            // Evidence pertama: mass function langsung menjadi current belief
            $this->currentBelief = $m2;
            $this->currentTheta = $m2Theta;
            $this->isFirstEvidence = false;

            foreach ($m2 as $idJurusan => $belief) {
                $this->steps[] = [
                    'urutan_evidence'   => $urutan,
                    'id_evidence'       => $evidenceInfo['id_evidence'],
                    'nama_evidence'     => $evidenceInfo['nama_evidence'],
                    'id_jurusan'        => $idJurusan,
                    'nama_jurusan'      => $rule['nama_jurusan'] ?? '',
                    'm1_belief'         => null,
                    'm2_belief'         => $belief,
                    'm1_theta'          => null,
                    'm2_theta'          => $m2Theta,
                    'nilai_kombinasi'   => $belief,
                    'nilai_konflik'     => 0,
                    'nilai_normalisasi' => $belief,
                    'keterangan'        => 'Evidence pertama - mass function langsung menjadi belief awal',
                ];
            }
            return;
        }

        // ==== Mass function LAMA (m1) ====
        $m1 = $this->currentBelief;
        $m1Theta = $this->currentTheta;

        // ==== Kombinasikan m1 dan m2 menggunakan Dempster's Rule ====
        $m3 = [];         // hasil kombinasi sebelum normalisasi
        $konflik = 0.0;    // K = total mass yang berbenturan (irisan kosong)

        // Union semua jurusan yang terlibat (baik dari m1 maupun m2)
        $semuaJurusan = array_unique(array_merge(array_keys($m1), array_keys($m2)));

        foreach ($semuaJurusan as $idJurusan) {
            $bel1 = $m1[$idJurusan] ?? 0.0;
            $bel2 = $m2[$idJurusan] ?? 0.0;

            // X∩Y = jurusan yang sama (kedua evidence sepakat mendukung jurusan ini)
            $intersect = ($bel1 * $bel2);
            // X(jurusan) ∩ Theta(evidence baru tidak spesifik) = tetap mendukung jurusan
            $fromM1AndTheta2 = $bel1 * $m2Theta;
            // Theta(evidence lama) ∩ Y(jurusan dari evidence baru)
            $fromTheta1AndM2 = $m1Theta * $bel2;

            $m3[$idJurusan] = $intersect + $fromM1AndTheta2 + $fromTheta1AndM2;
        }

        // Konflik terjadi ketika evidence lama mendukung jurusan A secara eksklusif
        // sedangkan evidence baru mendukung jurusan B (A != B) secara eksklusif -> irisan kosong
        foreach ($m1 as $idJ1 => $bel1) {
            foreach ($m2 as $idJ2 => $bel2) {
                if ($idJ1 !== $idJ2) {
                    $konflik += $bel1 * $bel2;
                }
            }
        }

        // Mass function Theta gabungan (kedua-duanya tidak yakin)
        $m3Theta = $m1Theta * $m2Theta;

        // ==== Normalisasi: bagi seluruh mass dengan (1 - K) agar total = 1 ====
        $normalisasiFaktor = (1 - $konflik);
        $normalisasiFaktor = $normalisasiFaktor > 0 ? $normalisasiFaktor : 0.0001; // hindari pembagian nol

        $m3Normalized = [];
        foreach ($m3 as $idJurusan => $val) {
            // TIDAK dibulatkan di sini -- nilai ini akan dipakai sebagai input
            // kombinasi pada evidence BERIKUTNYA. Pembulatan dini ke sedikit
            // desimal dapat menyebabkan nilai kecil "underflow" menjadi 0
            // secara permanen setelah beberapa kali iterasi berturut-turut
            // (terutama saat evidence tersebar ke banyak jurusan berbeda).
            $m3Normalized[$idJurusan] = $val / $normalisasiFaktor;
        }
        $m3ThetaNormalized = $m3Theta / $normalisasiFaktor;

        // ==== SAFETY RENORMALIZATION ====
        // Saat evidence yang dikombinasikan berasal dari BANYAK jurusan yang saling
        // eksklusif (konflik K mendekati 1), pembagian dengan (1-K) yang sangat kecil
        // dapat membuat nilai belief individual "meledak" melebihi 1 -- ini adalah
        // instabilitas numerik yang dikenal pada Dempster's Rule saat konflik tinggi
        // (Zadeh's paradox). Untuk menjaga validitas sebagai distribusi probabilitas
        // (setiap nilai dalam rentang [0,1] dan totalnya <= 1), seluruh massa
        // dinormalisasi ulang secara proporsional jika totalnya melebihi 1.
        $totalMassa = array_sum($m3Normalized) + $m3ThetaNormalized;
        if ($totalMassa > 1.0 || $totalMassa <= 0) {
            $totalMassa = $totalMassa > 0 ? $totalMassa : 1.0;
            foreach ($m3Normalized as $idJurusan => $val) {
                $m3Normalized[$idJurusan] = max(0, min(1, $val / $totalMassa));
            }
            $m3ThetaNormalized = max(0, min(1, $m3ThetaNormalized / $totalMassa));
        }

        // ==== Catat langkah untuk setiap jurusan yang terlibat (transparansi proses) ====
        foreach ($semuaJurusan as $idJurusan) {
            $namaJurusan = '';
            foreach ($ruleJurusan as $r) {
                if ($r['id_jurusan'] == $idJurusan) { $namaJurusan = $r['nama_jurusan']; break; }
            }
            $this->steps[] = [
                'urutan_evidence'   => $urutan,
                'id_evidence'       => $evidenceInfo['id_evidence'],
                'nama_evidence'     => $evidenceInfo['nama_evidence'],
                'id_jurusan'        => $idJurusan,
                'nama_jurusan'      => $namaJurusan,
                'm1_belief'         => $m1[$idJurusan] ?? 0,
                'm2_belief'         => $m2[$idJurusan] ?? 0,
                'm1_theta'          => $m1Theta,
                'm2_theta'          => $m2Theta,
                'nilai_kombinasi'   => round($m3[$idJurusan], 6),
                'nilai_konflik'     => round($konflik, 6),
                'nilai_normalisasi' => $m3Normalized[$idJurusan],
                'keterangan'        => "Kombinasi m1 (lama) dengan m2 (evidence: {$evidenceInfo['nama_evidence']})",
            ];
        }

        // ==== Simpan sebagai current belief untuk iterasi berikutnya ====
        $this->currentBelief = $m3Normalized;
        $this->currentTheta = $m3ThetaNormalized;
    }

    /**
     * Mengembalikan hasil akhir belief per jurusan, diurutkan dari terbesar
     * Format: [['id_jurusan' => int, 'belief' => float, 'persentase' => float], ...]
     *
     * CATATAN PERSENTASE: dihitung relatif terhadap TOTAL BELIEF seluruh
     * jurusan kandidat (tidak termasuk sisa theta/ketidakpastian). Ini
     * dilakukan karena saat banyak evidence tersebar ke puluhan jurusan
     * berbeda, sisa theta bisa mendominasi total massa sehingga persentase
     * yang ditampilkan ke pengguna menjadi mendekati 0% meski secara
     * RANKING hasilnya tetap benar. Menormalisasi terhadap total belief
     * jurusan saja menghasilkan angka yang lebih bermakna dan mudah
     * dipahami siswa ("dari jurusan yang cocok, X paling unggul"), sementara
     * nilai belief mentah (raw) tetap disimpan apa adanya untuk transparansi
     * proses perhitungan.
     */
    public function getHasilAkhir(): array
    {
        $hasil = [];
        $totalBeliefJurusan = array_sum($this->currentBelief);
        $totalBeliefJurusan = $totalBeliefJurusan > 0 ? $totalBeliefJurusan : 1;

        foreach ($this->currentBelief as $idJurusan => $belief) {
            $belief = max(0, min(1, $belief)); // clamp defensif lapis kedua
            $hasil[] = [
                'id_jurusan' => $idJurusan,
                'belief'     => $belief,
                'plausibility' => round(min(1, $belief + $this->currentTheta), 6), // belief + ketidakpastian yang masih mungkin
                'persentase' => round(($belief / $totalBeliefJurusan) * 100, 2),
            ];
        }

        // Urutkan dari belief tertinggi ke terendah
        usort($hasil, fn($a, $b) => $b['belief'] <=> $a['belief']);

        // Tambahkan ranking
        foreach ($hasil as $i => &$row) {
            $row['ranking'] = $i + 1;
        }

        return $hasil;
    }

    /**
     * Mengembalikan seluruh log langkah perhitungan (untuk ditampilkan step-by-step)
     */
    public function getSteps(): array
    {
        return $this->steps;
    }

    /**
     * Mengembalikan nilai theta (ketidakpastian) akhir
     */
    public function getFinalTheta(): float
    {
        return $this->currentTheta;
    }
}
