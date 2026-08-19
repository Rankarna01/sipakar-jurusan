<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<div class="card-modern p-4">
    <h6 class="fw-bold mb-4"><?= $universitas ? 'Edit' : 'Tambah' ?> Universitas</h6>
    <form method="POST" action="<?= $universitas ? BASE_URL.'adminUniversitas/update/'.$universitas['id_universitas'] : BASE_URL.'adminUniversitas/simpan' ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row g-3">
            <?php if (!empty($universitas['logo'])): ?>
            <div class="col-12">
                <img src="<?= UPLOAD_URL . clean($universitas['logo']) ?>" alt="Logo" style="height:60px;border-radius:8px;" class="border p-1">
            </div>
            <?php endif; ?>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Universitas</label>
                <input type="text" name="nama_universitas" class="form-control" required value="<?= clean($universitas['nama_universitas'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Singkatan</label>
                <input type="text" name="singkatan" class="form-control" value="<?= clean($universitas['singkatan'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kota</label>
                <input type="text" name="kota" class="form-control" value="<?= clean($universitas['kota'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Provinsi</label>
                <input type="text" name="provinsi" class="form-control" value="<?= clean($universitas['provinsi'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Jenis</label>
                <select name="jenis" class="form-select">
                    <?php foreach (['negeri'=>'Negeri','swasta'=>'Swasta','kedinasan'=>'Kedinasan'] as $k=>$v): ?>
                        <option value="<?= $k ?>" <?= (isset($universitas['jenis']) && $universitas['jenis']===$k)?'selected':'' ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Akreditasi Institusi</label>
                <select name="akreditasi_institusi" class="form-select">
                    <option value="">-</option>
                    <?php foreach (['A','B','C','Unggul','Baik Sekali'] as $ak): ?>
                        <option value="<?= $ak ?>" <?= (isset($universitas['akreditasi_institusi']) && $universitas['akreditasi_institusi']===$ak)?'selected':'' ?>><?= $ak ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tahun Berdiri</label>
                <input type="number" name="tahun_berdiri" class="form-control" min="1800" max="<?= date('Y') ?>" value="<?= clean($universitas['tahun_berdiri'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Jumlah Mahasiswa (perkiraan)</label>
                <input type="text" name="jumlah_mahasiswa" class="form-control" placeholder="contoh: 45.000+" value="<?= clean($universitas['jumlah_mahasiswa'] ?? '') ?>">
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Website</label>
                <input type="url" name="website" class="form-control" value="<?= clean($universitas['website'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Logo Kampus</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
            </div>
            <?php if ($universitas): ?>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" <?= $universitas['status']==='aktif'?'selected':'' ?>>Aktif</option>
                    <option value="nonaktif" <?= $universitas['status']==='nonaktif'?'selected':'' ?>>Nonaktif</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <label class="form-label fw-semibold">Jurusan yang Tersedia</label>
                <div class="border rounded-3 p-3" style="max-height:300px; overflow-y:auto;">
                    <?php foreach ($jurusanList as $j): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jurusan[]" value="<?= $j['id_jurusan'] ?>"
                                id="jur<?= $j['id_jurusan'] ?>" <?= in_array($j['id_jurusan'], $jurusanTerpilih) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="jur<?= $j['id_jurusan'] ?>"><?= clean($j['nama_jurusan']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <small class="text-muted">Centang jurusan yang tersedia di universitas ini.</small>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-gradient rounded-pill px-4">Simpan</button>
            <a href="<?= BASE_URL ?>adminUniversitas" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
        </div>
    </form>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
