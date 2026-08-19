<?php
/**
 * AdminLaporanController
 * Laporan konsultasi dengan filter multi-dimensi (tanggal, kelas, jenis
 * kelamin, jurusan) serta kemampuan CRUD: hapus data individual, hapus
 * per kelompok (checkbox terpilih), atau hapus seluruh hasil sesuai filter
 * aktif. Export (CSV) juga mengikuti scope yang sama.
 */
class AdminLaporanController extends Controller
{
    private $db;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->db = Database::getInstance();
    }

    /** Membangun kondisi WHERE + parameter berdasarkan filter GET yang aktif */
    private function buildFilter(array $source): array
    {
        $where = ["h.status = 'selesai'"];
        $params = [];

        $tanggalMulai = clean($source['tanggal_mulai'] ?? date('Y-m-01'));
        $tanggalAkhir = clean($source['tanggal_akhir'] ?? date('Y-m-d'));
        $where[] = "DATE(h.created_at) BETWEEN :mulai AND :akhir";
        $params['mulai'] = $tanggalMulai;
        $params['akhir'] = $tanggalAkhir;

        $kelas = clean($source['kelas'] ?? '');
        if ($kelas !== '') {
            $where[] = "COALESCE(s.kelas, h.kelas_tamu) = :kelas";
            $params['kelas'] = $kelas;
        }

        $gender = clean($source['gender'] ?? '');
        if (in_array($gender, ['L', 'P'], true)) {
            $where[] = "COALESCE(s.jenis_kelamin, h.jenis_kelamin) = :gender";
            $params['gender'] = $gender;
        }

        $idJurusan = (int) ($source['jurusan'] ?? 0);
        if ($idJurusan > 0) {
            $where[] = "h.id_jurusan_terbaik = :id_jurusan";
            $params['id_jurusan'] = $idJurusan;
        }

        return [implode(' AND ', $where), $params, $tanggalMulai, $tanggalAkhir, $kelas, $gender, $idJurusan];
    }

    public function index()
    {
        [$whereSql, $params, $tanggalMulai, $tanggalAkhir, $kelas, $gender, $idJurusan] = $this->buildFilter($_GET);

        $sqlBase = "FROM hasil h
             LEFT JOIN siswa s ON s.id_siswa = h.id_siswa
             LEFT JOIN jurusan j ON j.id_jurusan = h.id_jurusan_terbaik
             LEFT JOIN fakultas f ON f.id_fakultas = COALESCE(h.id_fakultas_terbaik, j.id_fakultas)
             WHERE {$whereSql}";

        $stmt = $this->db->prepare(
            "SELECT h.id_hasil, h.kode_konsultasi, h.created_at, h.persentase_akhir, h.jumlah_evidence_dipilih,
                    h.persentase_fakultas_terbaik,
                    COALESCE(s.nama, h.nama_tamu, 'Tamu') as nama_pengguna,
                    COALESCE(s.kelas, h.kelas_tamu, '-') as kelas,
                    COALESCE(s.jenis_kelamin, h.jenis_kelamin, '-') as jenis_kelamin,
                    j.nama_jurusan, f.nama_fakultas, j.prospek_kerja, j.range_gaji
             {$sqlBase}
             ORDER BY h.created_at DESC"
        );
        $stmt->execute($params);
        $laporan = $stmt->fetchAll();

        $stmtRekap = $this->db->prepare("SELECT f.nama_fakultas, COUNT(*) as jumlah {$sqlBase} GROUP BY f.id_fakultas ORDER BY jumlah DESC");
        $stmtRekap->execute($params);
        $rekapFakultas = $stmtRekap->fetchAll();

        // Rekap tambahan: per jenis kelamin (untuk ringkasan visual)
        $stmtGender = $this->db->prepare("SELECT COALESCE(s.jenis_kelamin, h.jenis_kelamin, '-') as gender, COUNT(*) as jumlah {$sqlBase} GROUP BY gender");
        $stmtGender->execute($params);
        $rekapGender = $stmtGender->fetchAll();

        // Daftar kelas & jurusan unik untuk dropdown filter
        $daftarKelas = $this->db->query("SELECT DISTINCT COALESCE(s.kelas, h.kelas_tamu) as kelas FROM hasil h LEFT JOIN siswa s ON s.id_siswa=h.id_siswa WHERE COALESCE(s.kelas, h.kelas_tamu) IS NOT NULL ORDER BY kelas")->fetchAll();
        $daftarJurusan = $this->db->query("SELECT id_jurusan, nama_jurusan FROM jurusan WHERE status='aktif' ORDER BY nama_jurusan")->fetchAll();

        $this->view('admin/laporan/index', [
            'title' => 'Laporan Konsultasi - Admin',
            'pageTitle' => 'Laporan Konsultasi',
            'activeMenu' => 'laporan',
            'laporan' => $laporan,
            'rekapFakultas' => $rekapFakultas,
            'rekapGender' => $rekapGender,
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir,
            'filterKelas' => $kelas,
            'filterGender' => $gender,
            'filterJurusan' => $idJurusan,
            'daftarKelas' => $daftarKelas,
            'daftarJurusan' => $daftarJurusan,
        ]);
    }

    /** Hapus satu data hasil konsultasi (individual) */
    public function hapus($id)
    {
        $this->hapusHasilByIds([(int) $id]);
        $_SESSION['success'] = 'Data konsultasi berhasil dihapus.';
        $this->redirect('adminLaporan');
    }

    /** Hapus banyak data terpilih (checkbox) sekaligus */
    public function hapusGrup()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $ids = array_map('intval', $_POST['ids'] ?? []);
        if (empty($ids)) {
            $_SESSION['error'] = 'Tidak ada data yang dipilih.';
            $this->redirect('adminLaporan');
            return;
        }

        $this->hapusHasilByIds($ids);
        $_SESSION['success'] = count($ids) . ' data konsultasi berhasil dihapus.';
        $this->redirect('adminLaporan');
    }

    /** Hapus SELURUH data konsultasi sesuai filter yang sedang aktif */
    public function hapusSemua()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        [$whereSql, $params] = $this->buildFilter($_POST);

        $stmt = $this->db->prepare(
            "SELECT h.id_hasil FROM hasil h
             LEFT JOIN siswa s ON s.id_siswa = h.id_siswa
             LEFT JOIN jurusan j ON j.id_jurusan = h.id_jurusan_terbaik
             WHERE {$whereSql}"
        );
        $stmt->execute($params);
        $ids = array_column($stmt->fetchAll(), 'id_hasil');

        if (empty($ids)) {
            $_SESSION['error'] = 'Tidak ada data pada rentang filter ini.';
            $this->redirect('adminLaporan');
            return;
        }

        $this->hapusHasilByIds($ids);
        $_SESSION['success'] = count($ids) . ' data konsultasi (sesuai filter) berhasil dihapus.';
        $this->redirect('adminLaporan');
    }

    /** Helper internal: hapus baris hasil beserta relasi turunannya */
    private function hapusHasilByIds(array $ids): void
    {
        if (empty($ids)) return;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        foreach (['detail_hasil', 'jawaban_konsultasi', 'langkah_perhitungan'] as $childTable) {
            $stmt = $this->db->prepare("DELETE FROM {$childTable} WHERE id_hasil IN ({$placeholders})");
            $stmt->execute($ids);
        }
        $stmt = $this->db->prepare("DELETE FROM hasil WHERE id_hasil IN ({$placeholders})");
        $stmt->execute($ids);

        log_activity('Laporan Konsultasi', 'delete', 'Menghapus ' . count($ids) . ' data hasil konsultasi (id: ' . implode(',', $ids) . ')');
    }

    /**
     * Export laporan ke CSV, mengikuti scope filter aktif ATAU baris terpilih (jika ada 'ids').
     */
    public function export()
    {
        $ids = isset($_GET['ids']) ? array_map('intval', explode(',', $_GET['ids'])) : [];
        $selectCols = "h.kode_konsultasi, h.created_at, COALESCE(s.nama, h.nama_tamu, 'Tamu') as nama,
                        COALESCE(s.kelas, h.kelas_tamu, '-') as kelas,
                        COALESCE(s.jenis_kelamin, h.jenis_kelamin, '-') as jenis_kelamin,
                        j.nama_jurusan, f.nama_fakultas, h.persentase_akhir, h.persentase_fakultas_terbaik,
                        j.prospek_kerja, j.range_gaji";
        $joinSql = "FROM hasil h
                 LEFT JOIN siswa s ON s.id_siswa = h.id_siswa
                 LEFT JOIN jurusan j ON j.id_jurusan = h.id_jurusan_terbaik
                 LEFT JOIN fakultas f ON f.id_fakultas = COALESCE(h.id_fakultas_terbaik, j.id_fakultas)";

        if (!empty($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $this->db->prepare("SELECT {$selectCols} {$joinSql} WHERE h.id_hasil IN ({$placeholders}) ORDER BY h.created_at DESC");
            $stmt->execute($ids);
        } else {
            [$whereSql, $params] = $this->buildFilter($_GET);
            $stmt = $this->db->prepare("SELECT {$selectCols} {$joinSql} WHERE {$whereSql} ORDER BY h.created_at DESC");
            $stmt->execute($params);
        }

        $rows = $stmt->fetchAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="laporan-konsultasi-' . date('Ymd-His') . '.csv"');

        $out = fopen('php://output', 'w');
        fputs($out, "\xEF\xBB\xBF"); // BOM agar Excel baca UTF-8 dengan benar
        fputcsv($out, ['Kode Konsultasi', 'Tanggal', 'Nama', 'Kelas', 'Jenis Kelamin', 'Fakultas Direkomendasikan', 'Persentase Fakultas', 'Jurusan Terbaik', 'Persentase Jurusan', 'Peluang Kerja', 'Estimasi Gaji']);
        foreach ($rows as $r) {
            fputcsv($out, [
                $r['kode_konsultasi'], $r['created_at'], $r['nama'], $r['kelas'],
                $r['jenis_kelamin'] === 'L' ? 'Laki-laki' : ($r['jenis_kelamin'] === 'P' ? 'Perempuan' : '-'),
                $r['nama_fakultas'] ?? '-', $r['persentase_fakultas_terbaik'] !== null ? number_format($r['persentase_fakultas_terbaik'], 2) . '%' : '-',
                $r['nama_jurusan'] ?? '-', number_format($r['persentase_akhir'], 2) . '%',
                $r['prospek_kerja'] ?? '-', $r['range_gaji'] ?? '-',
            ]);
        }
        fclose($out);
        exit;
    }
}
