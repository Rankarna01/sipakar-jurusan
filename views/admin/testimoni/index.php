<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<div class="card-modern p-4">
    <h6 class="fw-bold mb-3">Daftar Testimoni (<?= count($testimoni) ?>)</h6>
    <div class="row g-3">
        <?php foreach ($testimoni as $t): ?>
        <div class="col-md-4">
            <div class="border rounded-3 p-3 h-100">
                <div class="mb-2"><?php for($i=0;$i<$t['rating'];$i++) echo '<i class="bi bi-star-fill text-warning"></i>'; ?></div>
                <p class="small fst-italic">"<?= clean($t['pesan']) ?>"</p>
                <strong><?= clean($t['nama']) ?></strong>
                <div class="text-muted small mb-2"><?= clean($t['sekolah_asal'] ?? '') ?></div>
                <div class="d-flex gap-1 flex-wrap">
                    <a href="<?= BASE_URL ?>adminTestimoni/ubahStatus/<?= $t['id_testimoni'] ?>/tampil" class="btn btn-sm btn-outline-success">Tampilkan</a>
                    <a href="<?= BASE_URL ?>adminTestimoni/ubahStatus/<?= $t['id_testimoni'] ?>/sembunyi" class="btn btn-sm btn-outline-secondary">Sembunyikan</a>
                    <button onclick="confirmDelete('<?= BASE_URL ?>adminTestimoni/hapus/<?= $t['id_testimoni'] ?>', 'testimoni ini')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </div>
                <span class="badge bg-<?= $t['status']==='tampil'?'success':($t['status']==='pending'?'warning':'secondary') ?> mt-2"><?= ucfirst($t['status']) ?></span>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($testimoni)): ?>
            <div class="col-12 text-center text-muted py-4">Belum ada testimoni.</div>
        <?php endif; ?>
    </div>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
