<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="alert alert-info">
    <i class="bi bi-info-circle-fill me-2"></i>
    Kelola aturan per jurusan lebih mudah lewat menu <strong>Master Jurusan &rarr; ikon <i class="bi bi-diagram-3"></i></strong>, atau lihat seluruh basis pengetahuan di bawah ini.
</div>

<div class="card-modern p-4">
    <h6 class="fw-bold mb-3">Seluruh Basis Pengetahuan (<?= count($aturan) ?> aturan)</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light"><tr><th>Jurusan</th><th>Fakultas</th><th>Evidence</th><th>Belief</th><th>Plausibility</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($aturan as $a): ?>
                <tr>
                    <td><?= clean($a['nama_jurusan']) ?></td>
                    <td class="text-muted small"><?= clean($a['nama_fakultas']) ?></td>
                    <td><?= clean($a['nama_evidence']) ?></td>
                    <td><span class="badge bg-primary"><?= number_format($a['nilai_belief'], 3) ?></span></td>
                    <td><span class="badge bg-secondary"><?= number_format($a['nilai_plausibility'], 3) ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>adminAturan/jurusan/<?= $a['id_jurusan'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Kelola</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
