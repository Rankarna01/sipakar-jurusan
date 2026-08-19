<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php require VIEW_PATH . 'partials/alert.php'; ?>

<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="fw-bold mb-0">Daftar Pengembang (<?= count($pengembang) ?> / <?= $maxPengembang ?>)</h6>
            <p class="text-muted small mb-0">👨‍💻 Ditampilkan di halaman Kontak publik. Maksimal <?= $maxPengembang ?> orang.</p>
        </div>
        <?php if (count($pengembang) < $maxPengembang): ?>
            <a href="<?= BASE_URL ?>adminPengembang/tambah" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Tambah Pengembang</a>
        <?php else: ?>
            <span class="badge bg-warning text-dark px-3 py-2">Batas maksimal tercapai</span>
        <?php endif; ?>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>Foto</th><th>Nama</th><th>Jabatan</th><th>Urutan</th><th>Status</th><th class="text-center">Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($pengembang as $p): ?>
                <tr>
                    <td>
                        <?php if (!empty($p['foto'])): ?>
                            <img src="<?= UPLOAD_URL . clean($p['foto']) ?>" style="width:44px;height:44px;object-fit:cover;border-radius:50%;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white" style="width:44px;height:44px;background:var(--gradient-main);"><?= strtoupper(substr($p['nama'],0,1)) ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="fw-semibold"><?= clean($p['nama']) ?></td>
                    <td class="text-muted small"><?= clean(mb_strimwidth($p['jabatan'] ?? '-', 0, 50, '...')) ?></td>
                    <td><?= (int) $p['urutan'] ?></td>
                    <td><span class="badge bg-<?= $p['status']==='aktif'?'success':'secondary' ?>"><?= ucfirst($p['status']) ?></span></td>
                    <td class="text-center">
                        <a href="<?= BASE_URL ?>adminPengembang/edit/<?= $p['id_pengembang'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-fill"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminPengembang/hapus/<?= $p['id_pengembang'] ?>', '<?= clean($p['nama']) ?>')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash-fill"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($pengembang)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data pengembang.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
