<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
<div class="alert alert-danger alert-auto-dismiss"><?= clean($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card-modern p-4 h-100">
            <h6 class="fw-bold mb-2"><i class="bi bi-database-fill-down me-1"></i> Backup Database</h6>
            <p class="text-muted small">Unduh salinan lengkap seluruh data sistem dalam format SQL.</p>
            <a href="<?= BASE_URL ?>adminBackup/backup" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-download me-1"></i> Backup Sekarang</a>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-modern p-4 h-100">
            <h6 class="fw-bold mb-2"><i class="bi bi-database-fill-up me-1"></i> Restore Database</h6>
            <p class="text-muted small">Unggah file .sql hasil backup untuk mengembalikan data.</p>
            <form method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>adminBackup/restore" onsubmit="return confirm('PERINGATAN: Restore akan menimpa data yang ada. Lanjutkan?')">
                <?= csrf_field() ?>
                <input type="file" name="file_sql" class="form-control mb-2" accept=".sql" required>
                <button type="submit" class="btn btn-outline-navy rounded-pill px-4"><i class="bi bi-upload me-1"></i> Restore</button>
            </form>
        </div>
    </div>
</div>

<div class="card-modern p-4 mt-4">
    <h6 class="fw-bold mb-3">Riwayat Backup</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>Nama File</th><th>Ukuran</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($files as $f): ?>
                <tr>
                    <td><?= clean($f['nama']) ?></td>
                    <td><?= $f['ukuran'] ?> KB</td>
                    <td><?= $f['tanggal'] ?></td>
                    <td><a href="<?= BASE_URL ?>adminBackup/download/<?= urlencode($f['nama']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i></a></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($files)): ?>
                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada riwayat backup.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
