<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php require VIEW_PATH . 'partials/alert.php'; ?>
<div class="card-modern p-4">
    <h6 class="fw-bold mb-4">Tambah Slider</h6>
    <form method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>adminSlider/simpan">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Judul</label>
                <input type="text" name="judul" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Subjudul</label>
                <input type="text" name="subjudul" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Teks Tombol</label>
                <input type="text" name="teks_tombol" class="form-control" placeholder="Mulai Sekarang">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Link Tombol</label>
                <input type="text" name="link_tombol" class="form-control" placeholder="konsultasi">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Urutan</label>
                <input type="number" name="urutan" class="form-control" value="0">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Gambar (rasio disarankan 16:9, maksimal 4MB)</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" required>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-gradient rounded-pill px-4">Simpan</button>
            <a href="<?= BASE_URL ?>adminSlider" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
        </div>
    </form>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
