<?php
/**
 * Model Fakultas
 */
class Fakultas extends Model
{
    protected string $table = 'fakultas';
    protected string $primaryKey = 'id_fakultas';

    /** Ambil semua fakultas aktif beserta jumlah jurusannya */
    public function allWithJumlahJurusan(): array
    {
        return $this->query(
            "SELECT f.*, COUNT(j.id_jurusan) as jumlah_jurusan
             FROM fakultas f
             LEFT JOIN jurusan j ON j.id_fakultas = f.id_fakultas AND j.status = 'aktif'
             WHERE f.status = 'aktif'
             GROUP BY f.id_fakultas
             ORDER BY f.urutan ASC, f.nama_fakultas ASC"
        );
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->findBy('slug', $slug);
    }
}
