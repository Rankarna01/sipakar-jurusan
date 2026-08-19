<?php
/**
 * FakultasController
 */
class FakultasController extends Controller
{
    private $fakultasModel;
    private $jurusanModel;

    public function __construct()
    {
        $this->fakultasModel = $this->model('Fakultas');
        $this->jurusanModel = $this->model('Jurusan');
    }

    public function index()
    {
        $fakultas = $this->fakultasModel->allWithJumlahJurusan();
        $this->view('fakultas/index', [
            'title' => 'Daftar Fakultas - ' . APP_NAME,
            'fakultas' => $fakultas,
        ]);
    }

    public function detail($slug = '')
    {
        if (empty($slug)) {
            $this->redirect('fakultas');
            return;
        }
        $fakultas = $this->fakultasModel->findBySlug($slug);
        if (!$fakultas) {
            http_response_code(404);
            echo 'Fakultas tidak ditemukan.';
            return;
        }
        $jurusan = $this->jurusanModel->byFakultas($fakultas['id_fakultas']);
        $this->view('fakultas/detail', [
            'title' => $fakultas['nama_fakultas'] . ' - ' . APP_NAME,
            'fakultas' => $fakultas,
            'jurusan' => $jurusan,
        ]);
    }
}
