<?php require VIEW_PATH . 'layout/admin_header.php'; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-auto-dismiss"><?= clean($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Master Data Pekerjaan</h6>
        <a href="<?= BASE_URL ?>adminPekerjaan/tambah" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pekerjaan
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Pekerjaan</th>
                    <th>Bidang/Industri</th>
                    <th>Jurusan Terkait</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pekerjaan as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <strong class="d-block text-primary"><?= clean($p['nama_pekerjaan']) ?></strong>
                            <small class="text-muted d-block text-truncate" style="max-width: 250px;"><?= clean($p['deskripsi']) ?></small>
                        </td>
                        <td><?= clean($p['bidang_industri'] ?? '-') ?></td>
                        <td>
                            <?php if (!empty($p['jurusan'])): ?>
                                <?php 
                                    $count = count($p['jurusan']);
                                    $firstFew = array_slice($p['jurusan'], 0, 2);
                                ?>
                                <?php foreach ($firstFew as $j): ?>
                                    <span class="badge bg-info text-dark mb-1 d-inline-block"><?= clean($j['nama_jurusan']) ?></span><br>
                                <?php endforeach; ?>
                                <?php if ($count > 2): ?>
                                    <span class="badge bg-secondary">+<?= $count - 2 ?> lainnya</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="badge bg-light text-muted">Belum ada jurusan</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?= BASE_URL ?>adminPekerjaan/edit/<?= $p['id_pekerjaan'] ?>" class="btn btn-sm btn-outline-primary mb-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button onclick="confirmDelete('<?= BASE_URL ?>adminPekerjaan/hapus/<?= $p['id_pekerjaan'] ?>', '<?= clean($p['nama_pekerjaan']) ?>')" class="btn btn-sm btn-outline-danger mb-1">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
