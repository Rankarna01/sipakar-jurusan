<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<div class="card-modern p-4">
    <h6 class="fw-bold mb-4"><?= $evidence ? 'Edit' : 'Tambah' ?> Evidence</h6>
    <form method="POST" action="<?= $evidence ? BASE_URL.'adminEvidence/update/'.$evidence['id_evidence'] : BASE_URL.'adminEvidence/simpan' ?>">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kode Evidence</label>
                <input type="text" name="kode_evidence" class="form-control" required value="<?= clean($evidence['kode_evidence'] ?? '') ?>">
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Evidence</label>
                <input type="text" name="nama_evidence" class="form-control" required value="<?= clean($evidence['nama_evidence'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Kategori</label>
                <select name="kategori" class="form-select" required>
                    <?php foreach (['minat','bakat','kemampuan','kepribadian','tujuan_karier'] as $k): ?>
                        <option value="<?= $k ?>" <?= (isset($evidence['kategori']) && $evidence['kategori']===$k)?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$k)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if ($evidence): ?>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" <?= $evidence['status']==='aktif'?'selected':'' ?>>Aktif</option>
                    <option value="nonaktif" <?= $evidence['status']==='nonaktif'?'selected':'' ?>>Nonaktif</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2"><?= clean($evidence['keterangan'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-gradient rounded-pill px-4">Simpan</button>
            <a href="<?= BASE_URL ?>adminEvidence" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
        </div>
    </form>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
