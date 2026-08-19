<?php require VIEW_PATH . 'layout/admin_header.php'; ?>

<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
<div class="alert alert-danger alert-auto-dismiss"><?= clean($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= BASE_URL ?>adminJurusan" class="btn btn-sm btn-light border"><i class="bi bi-arrow-left"></i></a>
    <h6 class="fw-bold mb-0">Basis Pengetahuan: <?= clean($jurusan['nama_jurusan']) ?></h6>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card-modern p-4">
            <h6 class="fw-bold mb-3">Evidence Terkait (<?= count($aturanJurusan) ?>)</h6>
            <p class="text-muted small">Nilai <strong>belief</strong> menunjukkan seberapa kuat evidence ini mendukung jurusan ini (0.000 - 1.000). <strong>Plausibility</strong> harus selalu &ge; belief (batas atas kepercayaan). Kolom <strong>Ketidakpastian</strong> = 1 &minus; Plausibility, otomatis dihitung sebagai pengecekan konsistensi. Klik nilai untuk mengubah langsung.</p>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light"><tr><th>Evidence</th><th>Kategori</th><th style="width:120px;">Belief</th><th style="width:120px;">Plausibility</th><th style="width:110px;">Ketidakpastian</th><th>Aksi</th></tr></thead>
                    <tbody>
                    <?php foreach ($aturanJurusan as $a): ?>
                        <tr>
                            <td><?= clean($a['nama_evidence']) ?></td>
                            <td><span class="badge bg-info text-dark text-capitalize"><?= str_replace('_',' ',$a['kategori']) ?></span></td>
                            <td>
                                <input type="number" class="form-control form-control-sm input-belief" data-id="<?= $a['id_aturan'] ?>" data-field="nilai_belief" value="<?= number_format($a['nilai_belief'],3) ?>" step="0.001" min="0" max="1">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm input-belief" data-id="<?= $a['id_aturan'] ?>" data-field="nilai_plausibility" value="<?= number_format($a['nilai_plausibility'],3) ?>" step="0.001" min="0" max="1">
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border" title="1 - Plausibility"><?= number_format(1 - $a['nilai_plausibility'], 3) ?></span>
                                <?php if ($a['nilai_plausibility'] < $a['nilai_belief']): ?>
                                    <div class="text-danger small mt-1">⚠️ Plausibility &lt; Belief!</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button onclick="confirmDelete('<?= BASE_URL ?>adminAturan/hapus/<?= $a['id_aturan'] ?>', 'aturan ini')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($aturanJurusan)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada aturan untuk jurusan ini.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card-modern p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle-fill me-1"></i> Tambah Evidence Baru</h6>
            <form method="POST" action="<?= BASE_URL ?>adminAturan/tambah/<?= $jurusan['id_jurusan'] ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Evidence</label>
                    <select name="id_evidence" class="form-select" required>
                        <option value="">-- Pilih Evidence --</option>
                        <?php foreach ($evidenceBelumDipakai as $e): ?>
                            <option value="<?= $e['id_evidence'] ?>"><?= clean($e['nama_evidence']) ?> (<?= str_replace('_',' ',$e['kategori']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (empty($evidenceBelumDipakai)): ?>
                        <small class="text-muted">Seluruh evidence aktif sudah digunakan pada jurusan ini.</small>
                    <?php endif; ?>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Nilai Belief</label>
                        <input type="number" name="nilai_belief" class="form-control" step="0.001" min="0" max="1" value="0.750" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Nilai Plausibility</label>
                        <input type="number" name="nilai_plausibility" class="form-control" step="0.001" min="0" max="1" value="1.000" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Keterangan (opsional)</label>
                    <input type="text" name="keterangan" class="form-control">
                </div>
                <button type="submit" class="btn btn-gradient w-100 rounded-pill" <?= empty($evidenceBelumDipakai) ? 'disabled' : '' ?>>Tambahkan Aturan</button>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.input-belief').forEach(input => {
    input.addEventListener('change', function () {
        const id = this.dataset.id;
        const field = this.dataset.field;
        let val = parseFloat(this.value);
        if (isNaN(val) || val < 0 || val > 1) {
            Swal.fire('Nilai Tidak Valid', 'Nilai harus antara 0.000 - 1.000', 'error');
            return;
        }

        const row = this.closest('tr');
        const beliefInput = row.querySelector('[data-field="nilai_belief"]');
        const plausInput = row.querySelector('[data-field="nilai_plausibility"]');

        const formData = new FormData();
        formData.append('<?= CSRF_TOKEN_NAME ?>', '<?= csrf_token() ?>');
        formData.append('nilai_belief', beliefInput.value);
        formData.append('nilai_plausibility', plausInput.value);

        fetch('<?= BASE_URL ?>adminAturan/updateNilai/' + id, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: 'success', title: 'Tersimpan', timer: 1000, showConfirmButton: false });
                } else {
                    Swal.fire('Gagal', data.message, 'error');
                }
            });
    });
});
</script>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
