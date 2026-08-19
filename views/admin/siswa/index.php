<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<div class="card-modern p-4">
    <h6 class="fw-bold mb-3">Daftar Siswa Terdaftar (<?= count($siswa) ?>)</h6>
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
                        <a href="<?= BASE_URL ?>adminSiswa/resetPassword/<?= $s['id_siswa'] ?>" onclick="return confirm('Reset password siswa ini ke default (siswa123)?')" class="btn btn-sm btn-outline-warning"><i class="bi bi-key"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminSiswa/hapus/<?= $s['id_siswa'] ?>', '<?= clean($s['nama']) ?>')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($siswa)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada siswa terdaftar.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
