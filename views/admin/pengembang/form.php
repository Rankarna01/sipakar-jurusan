<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php require VIEW_PATH . 'partials/alert.php'; ?>

<div class="card-modern p-4">
    <h6 class="fw-bold mb-4"><?= $pengembang ? 'Edit' : 'Tambah' ?> Pengembang</h6>
    <form method="POST" enctype="multipart/form-data" action="<?= $pengembang ? BASE_URL.'adminPengembang/update/'.$pengembang['id_pengembang'] : BASE_URL.'adminPengembang/simpan' ?>">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Foto (maksimal 4MB)</label>
                <?php if (!empty($pengembang['foto'])): ?>
                    <div class="mb-2"><img src="<?= UPLOAD_URL . clean($pengembang['foto']) ?>" style="width:90px;height:90px;object-fit:cover;border-radius:50%;" class="border p-1"></div>
                <?php endif; ?>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Nama</label>
                        <input type="text" name="nama" class="form-control" required value="<?= clean($pengembang['nama'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" value="<?= clean($pengembang['urutan'] ?? 0) ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Jabatan / Institusi</label>
                        <input type="text" name="jabatan" class="form-control" value="<?= clean($pengembang['jabatan'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Bio Singkat</label>
                        <textarea name="bio" class="form-control" rows="3"><?= clean($pengembang['bio'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Keahlian (pisahkan dengan tanda |)</label>
                        <input type="text" name="keahlian" class="form-control" placeholder="🎓 Dosen | 🧠 Peneliti | 💻 Developer" value="<?= clean($pengembang['keahlian'] ?? '') ?>">
                    </div>
                    <?php if ($pengembang): ?>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif" <?= $pengembang['status']==='aktif'?'selected':'' ?>>Aktif</option>
                            <option value="nonaktif" <?= $pengembang['status']==='nonaktif'?'selected':'' ?>>Nonaktif</option>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-gradient rounded-pill px-4">Simpan</button>
            <a href="<?= BASE_URL ?>adminPengembang" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
        </div>
    </form>
</div>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
