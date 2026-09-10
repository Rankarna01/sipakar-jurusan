<?php require VIEW_PATH . 'layout/admin_header.php'; ?>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="fw-bold mb-0"><?= $title ?></h6>
        <a href="<?= BASE_URL ?>adminPekerjaan" class="btn btn-light border rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="<?= BASE_URL ?>adminPekerjaan/simpan" method="POST">
        <?= csrf_field() ?>
        <?php if (!empty($pekerjaan)): ?>
            <input type="hidden" name="id_pekerjaan" value="<?= $pekerjaan['id_pekerjaan'] ?>">
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Pekerjaan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pekerjaan" class="form-control" value="<?= clean($pekerjaan['nama_pekerjaan'] ?? '') ?>" required>
                    <div class="form-text">Contoh: Programmer Web, Dokter Umum, dll.</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Bidang / Industri</label>
                    <input type="text" name="bidang_industri" class="form-control" value="<?= clean($pekerjaan['bidang_industri'] ?? '') ?>">
                    <div class="form-text">Contoh: Teknologi Informasi, Kesehatan, Keuangan.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi" class="form-control" rows="4"><?= clean($pekerjaan['deskripsi'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tugas Utama</label>
                    <textarea name="tugas_utama" class="form-control" rows="4"><?= clean($pekerjaan['tugas_utama'] ?? '') ?></textarea>
                    <div class="form-text">Gunakan enter/baris baru untuk setiap poin tugas.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Skill yang Dibutuhkan</label>
                    <textarea name="skill_dibutuhkan" class="form-control" rows="3"><?= clean($pekerjaan['skill_dibutuhkan'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Contoh Instansi / Perusahaan</label>
                    <textarea name="contoh_instansi" class="form-control" rows="2"><?= clean($pekerjaan['contoh_instansi'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="glass-card p-4 bg-light rounded-4">
                    <label class="form-label fw-semibold"><i class="bi bi-diagram-3-fill text-primary"></i> Jurusan yang Relevan</label>
                    <p class="text-muted small mb-3">Pilih satu atau lebih jurusan kuliah yang lulusannya cocok untuk bekerja di posisi ini.</p>
                    <select name="jurusan_ids[]" class="form-select select2-multiple" multiple="multiple" data-placeholder="Pilih jurusan yang sesuai...">
                        <?php foreach ($semua_jurusan as $j): ?>
                            <option value="<?= $j['id_jurusan'] ?>" <?= in_array($j['id_jurusan'], $jurusan_terkait) ? 'selected' : '' ?>>
                                <?= clean($j['nama_jurusan']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="text-end mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-primary rounded-pill px-5"><i class="bi bi-save me-1"></i> Simpan Data</button>
        </div>
    </form>
</div>

<!-- Select2 JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-multiple').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
});
</script>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
