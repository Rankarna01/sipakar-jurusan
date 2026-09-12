<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Daftar Siswa Terdaftar (<?= count($siswa) ?>)</h6>
        <button type="button" class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#importExcelModal">
            <i class="bi bi-file-earmark-excel me-1"></i> Import Excel
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light"><tr><th>Nama</th><th>NISN</th><th>Kelas</th><th>Email</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($siswa as $s): ?>
                <tr>
                    <td><?= clean($s['nama']) ?></td>
                    <td><?= clean($s['nisn']) ?></td>
                    <td><?= clean($s['kelas']) ?></td>
                    <td><?= clean($s['email']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>adminSiswa/toggleStatus/<?= $s['id_siswa'] ?>" class="badge bg-<?= $s['status']==='aktif'?'success':'secondary' ?> text-decoration-none">
                            <?= ucfirst($s['status']) ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>adminSiswa/resetPassword/<?= $s['id_siswa'] ?>" onclick="return confirm('Reset password siswa ini ke default (NPSN Sekolah)?')" class="btn btn-sm btn-outline-warning"><i class="bi bi-key"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminSiswa/hapus/<?= $s['id_siswa'] ?>', '<?= clean($s['nama']) ?>')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($siswa)): ?>
                <!-- DataTables will handle empty state automatically -->
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= BASE_URL ?>adminSiswa/importExcel" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Siswa (CSV)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info small">
                        <strong>Format Wajib (CSV):</strong> Nama, NIS, Tempat Lahir, Tanggal Lahir, Kelas, NPSN Sekolah. 
                        <br><a href="<?= BASE_URL ?>assets/templates/template_siswa.csv" download class="fw-bold text-decoration-none">Download Template CSV</a>
                    </div>
                    <input type="file" name="file_excel" class="form-control" accept=".csv" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Proses Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (isset($_GET['import'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    new bootstrap.Modal(document.getElementById('importExcelModal')).show();
});
</script>
<?php endif; ?>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
