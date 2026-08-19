<?php require VIEW_PATH . 'layout/admin_header.php'; ?>

<div class="card-modern p-4">
    <h6 class="fw-bold mb-4"><?= $jurusan ? 'Edit' : 'Tambah' ?> Jurusan</h6>
    <form method="POST" enctype="multipart/form-data"
          action="<?= $jurusan ? BASE_URL . 'adminJurusan/update/' . $jurusan['id_jurusan'] : BASE_URL . 'adminJurusan/simpan' ?>">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kode Jurusan</label>
                <input type="text" name="kode_jurusan" class="form-control" required value="<?= clean($jurusan['kode_jurusan'] ?? '') ?>">
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Jurusan</label>
                <input type="text" name="nama_jurusan" class="form-control" required value="<?= clean($jurusan['nama_jurusan'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Fakultas</label>
                <select name="id_fakultas" class="form-select" required>
                    <option value="">-- Pilih Fakultas --</option>
                    <?php foreach ($fakultasList as $f): ?>
                        <option value="<?= $f['id_fakultas'] ?>" <?= (isset($jurusan['id_fakultas']) && $jurusan['id_fakultas'] == $f['id_fakultas']) ? 'selected' : '' ?>>
                            <?= clean($f['nama_fakultas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Icon</label>
                <input type="text" name="icon" class="form-control" placeholder="bi-book" value="<?= clean($jurusan['icon'] ?? '') ?>">
            </div>
            <?php if ($jurusan): ?>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" <?= $jurusan['status'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="nonaktif" <?= $jurusan['status'] === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"><?= clean($jurusan['deskripsi'] ?? '') ?></textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Skill yang Dibutuhkan</label>
                <textarea name="skill_dibutuhkan" class="form-control" rows="3"><?= clean($jurusan['skill_dibutuhkan'] ?? '') ?></textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Prospek Kerja</label>
                <textarea name="prospek_kerja" class="form-control" rows="3"><?= clean($jurusan['prospek_kerja'] ?? '') ?></textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Peluang Karier</label>
                <textarea name="peluang_karier" class="form-control" rows="3"><?= clean($jurusan['peluang_karier'] ?? '') ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">📚 Mata Kuliah Inti (pisahkan dengan tanda |)</label>
                <textarea name="mata_kuliah_inti" class="form-control" rows="2" placeholder="Contoh: Kalkulus | Algoritma | Basis Data"><?= clean($jurusan['mata_kuliah_inti'] ?? '') ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">🏛️ Top Kampus (pisahkan dengan tanda |)</label>
                <textarea name="top_kampus" class="form-control" rows="2" placeholder="Contoh: Universitas Indonesia (UI) | Universitas Gadjah Mada (UGM)"><?= clean($jurusan['top_kampus'] ?? '') ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">💰 Range Gaji</label>
                <input type="text" name="range_gaji" class="form-control" placeholder="Rp 4.000.000 - Rp 10.000.000" value="<?= clean($jurusan['range_gaji'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">🖼️ Foto Pendukung Jurusan (opsional, maksimal 4MB)</label>
                <?php if (!empty($jurusan['gambar'])): ?>
                    <div class="mb-2"><img src="<?= UPLOAD_URL . clean($jurusan['gambar']) ?>" style="height:60px;border-radius:8px;" class="border p-1"></div>
                <?php endif; ?>
                <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-gradient rounded-pill px-4">Simpan</button>
            <a href="<?= BASE_URL ?>adminJurusan" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
        </div>
    </form>
</div>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
