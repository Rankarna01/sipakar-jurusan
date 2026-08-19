<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<div class="card-modern p-4">
    <h6 class="fw-bold mb-4"><?= $pertanyaan ? 'Edit' : 'Tambah' ?> Pertanyaan</h6>
    <form method="POST" action="<?= $pertanyaan ? BASE_URL.'adminPertanyaan/update/'.$pertanyaan['id_pertanyaan'] : BASE_URL.'adminPertanyaan/simpan' ?>">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kode Pertanyaan</label>
                <input type="text" name="kode_pertanyaan" class="form-control" required value="<?= clean($pertanyaan['kode_pertanyaan'] ?? '') ?>">
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Evidence Terkait</label>
                <select name="id_evidence" class="form-select" required onchange="document.getElementById('kategoriInput').value = this.options[this.selectedIndex].dataset.kategori">
                    <option value="">-- Pilih Evidence --</option>
                    <?php foreach ($evidenceList as $e): ?>
                        <option value="<?= $e['id_evidence'] ?>" data-kategori="<?= $e['kategori'] ?>"
                            <?= (isset($pertanyaan['id_evidence']) && $pertanyaan['id_evidence']==$e['id_evidence']) ? 'selected' : '' ?>>
                            <?= clean($e['nama_evidence']) ?> (<?= clean($e['kode_evidence']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Kategori</label>
                <select name="kategori" id="kategoriInput" class="form-select" required>
                    <?php foreach (['minat','bakat','kemampuan','kepribadian','tujuan_karier'] as $k): ?>
                        <option value="<?= $k ?>" <?= (isset($pertanyaan['kategori']) && $pertanyaan['kategori']===$k)?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$k)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Urutan</label>
                <input type="number" name="urutan" class="form-control" value="<?= (int)($pertanyaan['urutan'] ?? 0) ?>">
            </div>
            <?php if ($pertanyaan): ?>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" <?= $pertanyaan['status']==='aktif'?'selected':'' ?>>Aktif</option>
                    <option value="nonaktif" <?= $pertanyaan['status']==='nonaktif'?'selected':'' ?>>Nonaktif</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <label class="form-label fw-semibold">Teks Pertanyaan</label>
                <textarea name="pertanyaan" class="form-control" rows="2" required><?= clean($pertanyaan['pertanyaan'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-gradient rounded-pill px-4">Simpan</button>
            <a href="<?= BASE_URL ?>adminPertanyaan" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
        </div>
    </form>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
