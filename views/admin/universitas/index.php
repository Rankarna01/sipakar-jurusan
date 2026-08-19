<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Daftar Universitas (<?= count($universitas) ?>)</h6>
        <a href="<?= BASE_URL ?>adminUniversitas/tambah" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Tambah Universitas</a>
    </div>
    <div class="alert alert-info small mb-3">
        ℹ️ <strong>Catatan penting:</strong> Data nama, kota, dan tahun berdiri kampus pada seed awal bersumber dari data umum yang dikenal luas. Namun <strong>nilai akreditasi (Unggul/A/B/dst) dan jumlah mahasiswa</strong> pada seed awal adalah <strong>estimasi/placeholder</strong> yang perlu diverifikasi dan diperbarui admin secara berkala melalui tombol "Edit", karena status akreditasi resmi berubah dari waktu ke waktu.
        Silakan cek data resmi &amp; terkini di <a href="https://www.banpt.or.id" target="_blank" rel="noopener" class="fw-bold">banpt.or.id</a> atau <a href="https://pddikti.kemdikbud.go.id" target="_blank" rel="noopener" class="fw-bold">pddikti.kemdikbud.go.id</a>.
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light"><tr><th>Logo</th><th>Nama</th><th>Kota</th><th>Jenis</th><th>Akreditasi</th><th>Berdiri</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($universitas as $u): ?>
                <tr>
                    <td>
                        <?php if (!empty($u['logo'])): ?>
                            <img src="<?= UPLOAD_URL . clean($u['logo']) ?>" alt="" style="width:36px;height:36px;object-fit:contain;border-radius:6px;" class="border p-1">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center fw-bold text-white" style="width:36px;height:36px;border-radius:6px;background:var(--gradient-main);font-size:0.65rem;">
                                <?= strtoupper(substr($u['singkatan'] ?: $u['nama_universitas'], 0, 3)) ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td><?= clean($u['nama_universitas']) ?> <?= $u['singkatan'] ? '('.clean($u['singkatan']).')' : '' ?></td>
                    <td><?= clean($u['kota'] ?? '-') ?></td>
                    <td><span class="badge bg-light text-dark border text-capitalize"><?= $u['jenis'] ?></span></td>
                    <td><?= clean($u['akreditasi_institusi'] ?? '-') ?></td>
                    <td><?= clean($u['tahun_berdiri'] ?? '-') ?></td>
                    <td><span class="badge bg-<?= $u['status']==='aktif'?'success':'secondary' ?>"><?= ucfirst($u['status']) ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>adminUniversitas/edit/<?= $u['id_universitas'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminUniversitas/hapus/<?= $u['id_universitas'] ?>', '<?= clean($u['nama_universitas']) ?>')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
