<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php require VIEW_PATH . 'partials/alert.php'; ?>

<div class="card-modern p-4 mb-3">
    <h6 class="fw-bold mb-3">📋 Rentang Nomor Soal per Fakultas</h6>
    <p class="text-muted small mb-3">Pertanyaan tersusun berkelompok per fakultas secara berurutan — setiap pertanyaan hanya menunjuk ke <strong>1 fakultas</strong> (via 1 jurusan), tidak ambigu.</p>
    <div class="row g-2">
        <?php foreach ($rekapFakultas as $r): ?>
        <div class="col-md-4 col-6">
            <div class="p-2 border rounded-3 d-flex justify-content-between align-items-center">
                <span class="small fw-semibold"><?= clean($r['nama_fakultas']) ?></span>
                <span class="badge bg-light text-dark border">#<?= $r['nomor_awal'] ?>–<?= $r['nomor_akhir'] ?> (<?= $r['jumlah_soal'] ?> soal)</span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="fw-bold mb-0">Master Pertanyaan & Basis Pengetahuan (<?= count($pertanyaanLengkap) ?>)</h6>
            <p class="text-muted small mb-0">Edit teks pertanyaan dan nilai belief-nya langsung di sini — tidak perlu berpindah menu.</p>
        </div>
        <a href="<?= BASE_URL ?>adminPertanyaan/tambah" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Tambah Pertanyaan</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light">
                <tr><th>Kode</th><th>Pertanyaan</th><th>Kategori</th><th>Fakultas</th><th>Jurusan</th><th style="width:130px;">Belief</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            <?php foreach ($pertanyaanLengkap as $p): ?>
                <tr>
                    <td><span class="badge bg-light text-dark border"><?= clean($p['kode_pertanyaan']) ?></span></td>
                    <td style="max-width:320px;"><?= clean($p['pertanyaan']) ?></td>
                    <td><span class="badge bg-info text-dark text-capitalize"><?= str_replace('_',' ',$p['kategori']) ?></span></td>
                    <td class="fw-semibold small"><?= clean($p['nama_fakultas'] ?? '-') ?></td>
                    <td class="text-muted small"><?= clean($p['nama_jurusan'] ?? '-') ?></td>
                    <td>
                        <?php if ($p['id_aturan']): ?>
                        <input type="number" class="form-control form-control-sm input-belief-inline"
                               data-id-aturan="<?= $p['id_aturan'] ?>"
                               value="<?= number_format($p['nilai_belief'], 3) ?>"
                               step="0.001" min="0" max="1">
                        <?php else: ?>
                        <span class="text-muted small">-</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge bg-<?= $p['status']==='aktif'?'success':'secondary' ?>"><?= ucfirst($p['status']) ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>adminPertanyaan/edit/<?= $p['id_pertanyaan'] ?>" class="btn btn-sm btn-outline-primary" title="Edit teks pertanyaan"><i class="bi bi-pencil"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminPertanyaan/hapus/<?= $p['id_pertanyaan'] ?>', 'pertanyaan ini')" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelectorAll('.input-belief-inline').forEach(input => {
    let originalValue = input.value;
    input.addEventListener('change', function () {
        const idAturan = this.dataset.idAturan;
        const nilai = parseFloat(this.value);
        if (isNaN(nilai) || nilai < 0 || nilai > 1) {
            Swal.fire('Nilai Tidak Valid', 'Belief harus antara 0 - 1', 'warning');
            this.value = originalValue;
            return;
        }
        const formData = new FormData();
        formData.append('<?= CSRF_TOKEN_NAME ?>', '<?= csrf_token() ?>');
        formData.append('nilai_belief', nilai);

        fetch('<?= BASE_URL ?>adminPertanyaan/updateBelief/' + idAturan, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                originalValue = this.value;
                this.classList.add('border-success');
                setTimeout(() => this.classList.remove('border-success'), 1200);
            } else {
                Swal.fire('Gagal', data.message || 'Terjadi kesalahan', 'error');
                this.value = originalValue;
            }
        })
        .catch(() => {
            Swal.fire('Error', 'Gagal terhubung ke server', 'error');
            this.value = originalValue;
        });
    });
});
</script>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
