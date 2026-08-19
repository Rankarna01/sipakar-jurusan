<?php
/**
 * Class Model
 * Model dasar (base model) yang menyediakan operasi CRUD generik
 * menggunakan PDO Prepared Statement. Semua model spesifik (JurusanModel,
 * FakultasModel, dll) meng-extend class ini.
 */

class Model
{
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Ambil semua data dari tabel, dengan opsi kondisi & urutan
     */
    public function all(string $orderBy = '', string $direction = 'ASC'): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($orderBy !== '') {
            $sql .= " ORDER BY {$orderBy} {$direction}";
        }
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Cari satu baris berdasarkan primary key
     */
    public function find($id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Cari satu baris berdasarkan kolom tertentu
     */
    public function findBy(string $column, $value): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1");
        $stmt->execute(['value' => $value]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Cari banyak baris berdasarkan kolom tertentu
     */
    public function where(string $column, $value, string $operator = '='): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} {$operator} :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll();
    }

    /**
     * Insert data baru, mengembalikan last insert id
     */
    public function insert(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    /**
     * Update data berdasarkan primary key
     */
    public function update($id, array $data): bool
    {
        $setClause = [];
        foreach (array_keys($data) as $column) {
            $setClause[] = "{$column} = :{$column}";
        }
        $setClause = implode(', ', $setClause);
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :pk_id";
        $data['pk_id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Hapus data berdasarkan primary key
     */
    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Hitung jumlah baris (opsional dengan kondisi)
     */
    public function count(string $where = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if ($where !== '') {
            $sql .= " WHERE {$where}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetch()['total'];
    }

    /**
     * Menjalankan query custom (SELECT) - untuk kebutuhan JOIN kompleks
     */
    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Menjalankan query custom (SELECT satu baris)
     */
    public function queryOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Menjalankan query custom non-SELECT (INSERT/UPDATE/DELETE manual)
     */
    public function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
