<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<div class="card-modern p-4">
    <h6 class="fw-bold mb-4"><?= $artikel ? 'Edit' : 'Tulis' ?> Artikel</h6>
    <form method="POST" enctype="multipart/form-data"
          action="<?= $artikel ? BASE_URL.'adminArtikel/update/'.$artikel['id_artikel'] : BASE_URL.'adminArtikel/simpan' ?>">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-semibold">Judul</label>
                <input type="text" name="judul" class="form-control" required value="<?= clean($artikel['judul'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="<?= clean($artikel['kategori'] ?? '') ?>">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Ringkasan</label>
                <textarea name="ringkasan" class="form-control" rows="2"><?= clean($artikel['ringkasan'] ?? '') ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Konten</label>
                <textarea name="konten" id="editorKonten" rows="10"><?= $artikel['konten'] ?? '' ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" <?= (isset($artikel['status']) && $artikel['status']==='draft')?'selected':'' ?>>Draft</option>
                    <option value="publish" <?= (isset($artikel['status']) && $artikel['status']==='publish')?'selected':'' ?>>Publish</option>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-gradient rounded-pill px-4">Simpan</button>
            <a href="<?= BASE_URL ?>adminArtikel" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
        </div>
    </form>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>CKEDITOR.replace('editorKonten');</script>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
