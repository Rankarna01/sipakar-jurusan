<?php
/**
 * Model Pengembang (profil pembuat sistem, maksimal 5, tampil di Kontak)
 */
class Pengembang extends Model
{
    protected string $table = 'pengembang';
    protected string $primaryKey = 'id_pengembang';

    public function allAktif(): array
    {
        return $this->query("SELECT * FROM pengembang WHERE status = 'aktif' ORDER BY urutan ASC, id_pengembang ASC");
    }
}
