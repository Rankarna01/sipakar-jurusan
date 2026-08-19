<?php require VIEW_PATH . 'layout/admin_header.php'; ?>

<ul class="nav nav-pills mb-4">
    <li class="nav-item"><a class="nav-link active" href="<?= BASE_URL ?>log/logActivity">Log Aktivitas</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>log/logLogin">Log Login</a></li>
</ul>

<div class="card-modern p-4">
    <h6 class="fw-bold mb-3">Log Aktivitas Admin (200 terbaru)</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light"><tr><th>Admin</th><th>Modul</th><th>Aksi</th><th>Deskripsi</th><th>IP</th><th>Waktu</th></tr></thead>
            <tbody>
            <?php foreach ($logs as $l): ?>
                <tr>
                    <td><?= clean($l['nama_admin'] ?? 'System') ?></td>
                    <td><?= clean($l['modul']) ?></td>
                    <td><span class="badge bg-<?= $l['aksi']==='delete'?'danger':($l['aksi']==='create'?'success':'primary') ?> text-capitalize"><?= $l['aksi'] ?></span></td>
                    <td class="small"><?= clean($l['deskripsi'] ?? '-') ?></td>
                    <td class="small text-muted"><?= clean($l['ip_address'] ?? '-') ?></td>
                    <td class="small text-muted"><?= format_tanggal($l['created_at'], true) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($logs)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada log aktivitas.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
