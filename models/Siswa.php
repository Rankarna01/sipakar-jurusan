<?php
/**
 * Model Siswa
 */
class Siswa extends Model
{
    protected string $table = 'siswa';
    protected string $primaryKey = 'id_siswa';

    public function findByEmail(string $email): ?array
    {
        return $this->findBy('email', $email);
    }

    public function findByNisn(string $nisn): ?array
    {
        return $this->findBy('nisn', $nisn);
    }
}
