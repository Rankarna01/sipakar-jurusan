<?php
/**
 * Model Jurusan
 */
class Jurusan extends Model
{
    protected string $table = 'jurusan';
    protected string $primaryKey = 'id_jurusan';

    public function allWithFakultas(): array
    {
        return $this->query(
            "SELECT j.*, f.nama_fakultas, f.slug as slug_fakultas
             FROM jurusan j
             JOIN fakultas f ON f.id_fakultas = j.id_fakultas
             WHERE j.status = 'aktif'
             ORDER BY j.nama_jurusan ASC"
        );
    }

    public function byFakultas(int $idFakultas): array
    {
        return $this->query(
            "SELECT j.*, f.nama_fakultas FROM jurusan j
             JOIN fakultas f ON f.id_fakultas = j.id_fakultas
             WHERE j.id_fakultas = :id_fakultas AND j.status = 'aktif'
             ORDER BY j.nama_jurusan ASC",
            ['id_fakultas' => $idFakultas]
        );
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->queryOne(
            "SELECT j.*, f.nama_fakultas, f.slug as slug_fakultas
             FROM jurusan j JOIN fakultas f ON f.id_fakultas = j.id_fakultas
             WHERE j.slug = :slug LIMIT 1",
            ['slug' => $slug]
        );
    }

    /** Ambil daftar universitas penyedia jurusan tertentu */
    public function getUniversitas(int $idJurusan): array
    {
        return $this->query(
            "SELECT u.*, ju.akreditasi, ju.jalur_masuk
             FROM jurusan_universitas ju
             JOIN universitas u ON u.id_universitas = ju.id_universitas
             WHERE ju.id_jurusan = :id_jurusan AND u.status = 'aktif'
             ORDER BY u.nama_universitas ASC",
            ['id_jurusan' => $idJurusan]
        );
    }

    public function search(string $keyword): array
    {
        return $this->query(
            "SELECT j.*, f.nama_fakultas FROM jurusan j
             JOIN fakultas f ON f.id_fakultas = j.id_fakultas
             WHERE j.status = 'aktif' AND (j.nama_jurusan LIKE :kw1 OR f.nama_fakultas LIKE :kw2)
             ORDER BY j.nama_jurusan ASC",
            ['kw1' => '%' . $keyword . '%', 'kw2' => '%' . $keyword . '%']
        );
    }
}
