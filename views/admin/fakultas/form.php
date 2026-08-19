<?php require VIEW_PATH . 'layout/admin_header.php'; ?>

<div class="card-modern p-4">
    <h6 class="fw-bold mb-4"><?= $fakultas ? 'Edit' : 'Tambah' ?> Fakultas</h6>
    <form method="POST" enctype="multipart/form-data"
          action="<?= $fakultas ? BASE_URL . 'adminFakultas/update/' . $fakultas['id_fakultas'] : BASE_URL . 'adminFakultas/simpan' ?>">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kode Fakultas</label>
                <input type="text" name="kode_fakultas" class="form-control" required value="<?= clean($fakultas['kode_fakultas'] ?? '') ?>">
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Fakultas</label>
                <input type="text" name="nama_fakultas" class="form-control" required value="<?= clean($fakultas['nama_fakultas'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Icon (Bootstrap Icons class)</label>
                <input type="text" name="icon" class="form-control" placeholder="bi-mortarboard-fill" value="<?= clean($fakultas['icon'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Urutan</label>
                <input type="number" name="urutan" class="form-control" value="<?= (int)($fakultas['urutan'] ?? 0) ?>">
            </div>
            <?php if ($fakultas): ?>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" <?= $fakultas['status'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="nonaktif" <?= $fakultas['status'] === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"><?= clean($fakultas['deskripsi'] ?? '') ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Gambar (opsional)</label>
                <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-gradient rounded-pill px-4">Simpan</button>
            <a href="<?= BASE_URL ?>adminFakultas" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
        </div>
    </form>
</div>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
