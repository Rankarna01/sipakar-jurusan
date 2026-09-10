<?php
class PekerjaanModel extends Model
{
    protected string $table = 'pekerjaan';
    protected string $primaryKey = 'id_pekerjaan';

    public function findAllWithRelations()
    {
        $pekerjaan = $this->all();
        
        // Ambil relasi jurusan untuk setiap pekerjaan
        foreach ($pekerjaan as &$p) {
            $p['jurusan'] = $this->getJurusanByPekerjaan($p['id_pekerjaan']);
        }
        
        return $pekerjaan;
    }

    public function getJurusanByPekerjaan($id_pekerjaan)
    {
        $stmt = $this->db->prepare("
            SELECT j.* FROM jurusan j
            JOIN pekerjaan_jurusan pj ON j.id_jurusan = pj.id_jurusan
            WHERE pj.id_pekerjaan = ?
        ");
        $stmt->execute([$id_pekerjaan]);
        return $stmt->fetchAll();
    }

    public function syncJurusan($id_pekerjaan, $jurusan_ids)
    {
        // Hapus relasi lama
        $stmt = $this->db->prepare("DELETE FROM pekerjaan_jurusan WHERE id_pekerjaan = ?");
        $stmt->execute([$id_pekerjaan]);

        // Masukkan relasi baru
        if (!empty($jurusan_ids)) {
            $stmtInsert = $this->db->prepare("INSERT INTO pekerjaan_jurusan (id_pekerjaan, id_jurusan) VALUES (?, ?)");
            foreach ($jurusan_ids as $id_jurusan) {
                if (!empty($id_jurusan)) {
                    $stmtInsert->execute([$id_pekerjaan, $id_jurusan]);
                }
            }
        }
    }
}
