<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<div class="card-modern p-4">
    <h6 class="fw-bold mb-3">Riwayat Konsultasi (<?= count($konsultasi) ?>)</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light"><tr><th>Kode</th><th>Nama</th><th>Rekomendasi</th><th>Persentase</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($konsultasi as $k): ?>
                <tr>
                    <td><span class="badge bg-light text-dark border"><?= clean($k['kode_konsultasi']) ?></span></td>
                    <td><?= clean($k['nama_pengguna']) ?></td>
                    <td><?= clean($k['nama_jurusan'] ?? '-') ?></td>
                    <td><?= number_format($k['persentase_akhir'], 2) ?>%</td>
                    <td class="text-muted small"><?= format_tanggal($k['created_at'], true) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>hasil/detail/<?= $k['kode_konsultasi'] ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminKonsultasi/hapus/<?= $k['id_hasil'] ?>', 'data konsultasi ini')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($konsultasi)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data konsultasi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
