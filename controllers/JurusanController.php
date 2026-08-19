<?php
/**
 * JurusanController
 */
class JurusanController extends Controller
{
    private $jurusanModel;

    public function __construct()
    {
        $this->jurusanModel = $this->model('Jurusan');
    }

    public function index()
    {
        $keyword = clean($_GET['q'] ?? '');
        $jurusan = $keyword !== '' ? $this->jurusanModel->search($keyword) : $this->jurusanModel->allWithFakultas();

        $this->view('jurusan/index', [
            'title' => 'Daftar Jurusan - ' . APP_NAME,
            'jurusan' => $jurusan,
            'keyword' => $keyword,
        ]);
    }

    public function detail($slug = '')
    {
        if (empty($slug)) {
            $this->redirect('jurusan');
            return;
        }
        $jurusan = $this->jurusanModel->findBySlug($slug);
        if (!$jurusan) {
            http_response_code(404);
            echo 'Jurusan tidak ditemukan.';
            return;
        }
        $universitas = $this->jurusanModel->getUniversitas($jurusan['id_jurusan']);

        $this->view('jurusan/detail', [
            'title' => $jurusan['nama_jurusan'] . ' - ' . APP_NAME,
            'jurusan' => $jurusan,
            'universitas' => $universitas,
        ]);
    }
}
