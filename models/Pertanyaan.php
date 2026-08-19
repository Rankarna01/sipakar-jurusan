<?php
/**
 * Model Pertanyaan
 */
class Pertanyaan extends Model
{
    protected string $table = 'pertanyaan';
    protected string $primaryKey = 'id_pertanyaan';

    /** Ambil seluruh pertanyaan aktif beserta info evidence-nya, untuk sesi konsultasi */
    public function allForKonsultasi(): array
    {
        return $this->query(
            "SELECT p.*, e.kode_evidence, e.nama_evidence
             FROM pertanyaan p
             JOIN evidence e ON e.id_evidence = p.id_evidence
             WHERE p.status = 'aktif' AND e.status = 'aktif'
             ORDER BY p.urutan ASC, p.id_pertanyaan ASC"
        );
    }

    public function byEvidence(int $idEvidence): array
    {
        return $this->where('id_evidence', $idEvidence);
    }
}
