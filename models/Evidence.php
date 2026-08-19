<?php
/**
 * Model Evidence
 */
class Evidence extends Model
{
    protected string $table = 'evidence';
    protected string $primaryKey = 'id_evidence';

    public function allAktif(): array
    {
        return $this->query("SELECT * FROM evidence WHERE status = 'aktif' ORDER BY kategori ASC, nama_evidence ASC");
    }
}
