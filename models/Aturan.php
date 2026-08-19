<?php
/**
 * Model Aturan
 * Basis pengetahuan many-to-many antara evidence dan jurusan,
 * berisi nilai belief & plausibility untuk perhitungan Dempster-Shafer.
 */
class Aturan extends Model
{
    protected string $table = 'aturan';
    protected string $primaryKey = 'id_aturan';

    /**
     * Ambil seluruh aturan untuk satu evidence tertentu, lengkap dengan
     * nama jurusan (dipakai oleh engine DempsterShafer)
     */
    public function byEvidence(int $idEvidence): array
    {
        return $this->query(
            "SELECT a.*, j.nama_jurusan, j.id_fakultas
             FROM aturan a
             JOIN jurusan j ON j.id_jurusan = a.id_jurusan
             WHERE a.id_evidence = :id_evidence AND a.status = 'aktif' AND j.status = 'aktif'",
            ['id_evidence' => $idEvidence]
        );
    }

    public function allWithRelasi(): array
    {
        return $this->query(
            "SELECT a.*, e.nama_evidence, e.kode_evidence, j.nama_jurusan, f.nama_fakultas
             FROM aturan a
             JOIN evidence e ON e.id_evidence = a.id_evidence
             JOIN jurusan j ON j.id_jurusan = a.id_jurusan
             JOIN fakultas f ON f.id_fakultas = j.id_fakultas
             ORDER BY j.nama_jurusan ASC, e.nama_evidence ASC"
        );
    }

    public function byJurusan(int $idJurusan): array
    {
        return $this->query(
            "SELECT a.*, e.nama_evidence, e.kode_evidence, e.kategori
             FROM aturan a JOIN evidence e ON e.id_evidence = a.id_evidence
             WHERE a.id_jurusan = :id_jurusan ORDER BY e.kategori ASC",
            ['id_jurusan' => $idJurusan]
        );
    }

    public function existsRule(int $idEvidence, int $idJurusan): ?array
    {
        return $this->queryOne(
            "SELECT * FROM aturan WHERE id_evidence = :e AND id_jurusan = :j",
            ['e' => $idEvidence, 'j' => $idJurusan]
        );
    }
}
