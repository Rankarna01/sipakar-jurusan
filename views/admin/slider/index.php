<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
<div class="alert alert-danger alert-auto-dismiss"><?= clean($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="fw-bold mb-0">Daftar Slider Hero Homepage (<?= count($slider) ?>)</h6>
            <p class="text-muted small mb-0">💡 Disarankan minimal <strong>4 foto aktif</strong> agar slider tampil optimal di homepage. Ukuran gambar maksimal <strong>4MB</strong>.</p>
        </div>
        <a href="<?= BASE_URL ?>adminSlider/tambah" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Tambah Slider</a>
    </div>
    <?php $aktifCount = count(array_filter($slider, fn($s) => $s['status'] === 'aktif')); ?>
    <?php if ($aktifCount < 4): ?>
        <div class="alert alert-warning small">⚠️ Baru ada <strong><?= $aktifCount ?></strong> slider aktif. Tambahkan minimal <?= 4 - $aktifCount ?> foto lagi agar mencapai 4 slide.</div>
    <?php endif; ?>
    <div class="row g-3">
        <?php foreach ($slider as $s): ?>
        <div class="col-md-4">
            <div class="border rounded-3 overflow-hidden">
                <img src="<?= UPLOAD_URL . clean($s['gambar']) ?>" class="w-100" style="height:150px;object-fit:cover;" onerror="this.src='https://placehold.co/400x150?text=Slider'">
                <div class="p-3">
                    <h6 class="fw-bold mb-1"><?= clean($s['judul'] ?? '-') ?></h6>
                    <p class="text-muted small mb-2"><?= clean($s['subjudul'] ?? '') ?></p>
                    <div class="d-flex justify-content-between">
                        <a href="<?= BASE_URL ?>adminSlider/toggleStatus/<?= $s['id_slider'] ?>" class="badge bg-<?= $s['status']==='aktif'?'success':'secondary' ?> text-decoration-none"><?= ucfirst($s['status']) ?></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminSlider/hapus/<?= $s['id_slider'] ?>', 'slider ini')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($slider)): ?>
            <div class="col-12 text-center text-muted py-4">Belum ada slider.</div>
        <?php endif; ?>
    </div>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
