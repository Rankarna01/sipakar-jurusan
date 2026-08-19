<?php
/**
 * Model Hasil
 * Menyimpan header hasil konsultasi + relasi detail ranking, jawaban, dan langkah perhitungan.
 */
class Hasil extends Model
{
    protected string $table = 'hasil';
    protected string $primaryKey = 'id_hasil';

    public function findByKode(string $kode): ?array
    {
        return $this->queryOne(
            "SELECT h.*, j.nama_jurusan as nama_jurusan_terbaik, j.slug as slug_jurusan_terbaik,
                    f.nama_fakultas, s.nama as nama_siswa, s.kelas as kelas_siswa,
                    fak.nama_fakultas as nama_fakultas_terbaik, fak.slug as slug_fakultas_terbaik, fak.deskripsi as deskripsi_fakultas_terbaik
             FROM hasil h
             LEFT JOIN jurusan j ON j.id_jurusan = h.id_jurusan_terbaik
             LEFT JOIN fakultas f ON f.id_fakultas = j.id_fakultas
             LEFT JOIN fakultas fak ON fak.id_fakultas = h.id_fakultas_terbaik
             LEFT JOIN siswa s ON s.id_siswa = h.id_siswa
             WHERE h.kode_konsultasi = :kode LIMIT 1",
            ['kode' => $kode]
        );
    }

    /** Ambil jurusan-jurusan (dari hasil top ranking) yang berada dalam fakultas tertentu */
    public function getJurusanDalamFakultas(int $idHasil, int $idFakultas): array
    {
        return $this->query(
            "SELECT dh.*, j.nama_jurusan, j.slug, j.range_gaji
             FROM detail_hasil dh
             JOIN jurusan j ON j.id_jurusan = dh.id_jurusan
             WHERE dh.id_hasil = :id_hasil AND j.id_fakultas = :id_fakultas
             ORDER BY dh.ranking ASC",
            ['id_hasil' => $idHasil, 'id_fakultas' => $idFakultas]
        );
    }

    public function simpanDetailHasil(int $idHasil, array $rankingList): void
    {
        foreach ($rankingList as $row) {
            $this->execute(
                "INSERT INTO detail_hasil (id_hasil, id_jurusan, nilai_belief, nilai_plausibility, persentase, ranking)
                 VALUES (:id_hasil, :id_jurusan, :belief, :plausibility, :persentase, :ranking)",
                [
                    'id_hasil' => $idHasil,
                    'id_jurusan' => $row['id_jurusan'],
                    'belief' => $row['belief'],
                    'plausibility' => $row['plausibility'],
                    'persentase' => $row['persentase'],
                    'ranking' => $row['ranking'],
                ]
            );
        }
    }

    public function simpanJawaban(int $idHasil, int $idPertanyaan, int $idEvidence, string $jawaban): void
    {
        $this->execute(
            "INSERT INTO jawaban_konsultasi (id_hasil, id_pertanyaan, id_evidence, jawaban) VALUES (:h, :p, :e, :j)",
            ['h' => $idHasil, 'p' => $idPertanyaan, 'e' => $idEvidence, 'j' => $jawaban]
        );
    }

    public function simpanLangkah(int $idHasil, array $steps): void
    {
        foreach ($steps as $s) {
            $this->execute(
                "INSERT INTO langkah_perhitungan
                    (id_hasil, urutan_evidence, id_evidence, id_jurusan, m1_belief, m2_belief, m1_theta, m2_theta, nilai_kombinasi, nilai_konflik, nilai_normalisasi)
                 VALUES (:id_hasil, :urutan, :id_evidence, :id_jurusan, :m1b, :m2b, :m1t, :m2t, :komb, :konflik, :norm)",
                [
                    'id_hasil' => $idHasil,
                    'urutan' => $s['urutan_evidence'],
                    'id_evidence' => $s['id_evidence'],
                    'id_jurusan' => $s['id_jurusan'],
                    'm1b' => $s['m1_belief'],
                    'm2b' => $s['m2_belief'],
                    'm1t' => $s['m1_theta'],
                    'm2t' => $s['m2_theta'],
                    'komb' => $s['nilai_kombinasi'],
                    'konflik' => $s['nilai_konflik'],
                    'norm' => $s['nilai_normalisasi'],
                ]
            );
        }
    }

    public function getDetailHasil(int $idHasil): array
    {
        return $this->query(
            "SELECT dh.*, j.nama_jurusan, j.slug, j.skill_dibutuhkan, j.prospek_kerja, j.peluang_karier, j.deskripsi,
                    j.mata_kuliah_inti, j.range_gaji, j.top_kampus, f.nama_fakultas
             FROM detail_hasil dh
             JOIN jurusan j ON j.id_jurusan = dh.id_jurusan
             JOIN fakultas f ON f.id_fakultas = j.id_fakultas
             WHERE dh.id_hasil = :id_hasil ORDER BY dh.ranking ASC",
            ['id_hasil' => $idHasil]
        );
    }

    public function getLangkahPerhitungan(int $idHasil): array
    {
        return $this->query(
            "SELECT lp.*, e.nama_evidence, j.nama_jurusan
             FROM langkah_perhitungan lp
             JOIN evidence e ON e.id_evidence = lp.id_evidence
             JOIN jurusan j ON j.id_jurusan = lp.id_jurusan
             WHERE lp.id_hasil = :id_hasil
             ORDER BY lp.urutan_evidence ASC, lp.id_langkah ASC",
            ['id_hasil' => $idHasil]
        );
    }

    public function getJawaban(int $idHasil): array
    {
        return $this->query(
            "SELECT jk.*, p.pertanyaan, e.nama_evidence
             FROM jawaban_konsultasi jk
             JOIN pertanyaan p ON p.id_pertanyaan = jk.id_pertanyaan
             JOIN evidence e ON e.id_evidence = jk.id_evidence
             WHERE jk.id_hasil = :id_hasil",
            ['id_hasil' => $idHasil]
        );
    }

    public function riwayatBySiswa(int $idSiswa): array
    {
        return $this->query(
            "SELECT h.*, j.nama_jurusan as nama_jurusan_terbaik
             FROM hasil h LEFT JOIN jurusan j ON j.id_jurusan = h.id_jurusan_terbaik
             WHERE h.id_siswa = :id_siswa AND h.status = 'selesai'
             ORDER BY h.created_at DESC",
            ['id_siswa' => $idSiswa]
        );
    }

    public function statistikJurusanTerpopuler(int $limit = 10): array
    {
        // LIMIT tidak dapat di-bind sebagai parameter string saat emulate_prepares=false,
        // sehingga nilai di-cast ke int (aman dari SQL Injection) lalu disisipkan langsung.
        $limit = (int) $limit;
        return $this->query(
            "SELECT j.nama_jurusan, COUNT(*) as jumlah
             FROM hasil h JOIN jurusan j ON j.id_jurusan = h.id_jurusan_terbaik
             WHERE h.status = 'selesai'
             GROUP BY h.id_jurusan_terbaik ORDER BY jumlah DESC LIMIT {$limit}"
        );
    }
}
