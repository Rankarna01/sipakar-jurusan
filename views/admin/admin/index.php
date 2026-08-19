<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
<div class="alert alert-danger alert-auto-dismiss"><?= clean($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Daftar Admin (<?= count($admins) ?>)</h6>
        <?php if (($_SESSION['admin_role'] ?? '') === 'superadmin'): ?>
            <a href="<?= BASE_URL ?>adminAdmin/tambah" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Tambah Admin</a>
        <?php endif; ?>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light"><tr><th>Nama</th><th>Username</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($admins as $a): ?>
                <tr>
                    <td><?= clean($a['nama']) ?></td>
                    <td><?= clean($a['username']) ?></td>
                    <td><span class="badge bg-dark text-capitalize"><?= $a['role'] ?></span></td>
                    <td><span class="badge bg-<?= $a['status']==='aktif'?'success':'secondary' ?>"><?= ucfirst($a['status']) ?></span></td>
                    <td>
                        <?php if (($_SESSION['admin_role'] ?? '') === 'superadmin'): ?>
                            <a href="<?= BASE_URL ?>adminAdmin/edit/<?= $a['id_admin'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <button onclick="confirmDelete('<?= BASE_URL ?>adminAdmin/hapus/<?= $a['id_admin'] ?>', '<?= clean($a['nama']) ?>')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
