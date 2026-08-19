<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<div class="card-modern p-4">
    <h6 class="fw-bold mb-4"><?= $adminData ? 'Edit' : 'Tambah' ?> Admin</h6>
    <form method="POST" action="<?= $adminData ? BASE_URL.'adminAdmin/update/'.$adminData['id_admin'] : BASE_URL.'adminAdmin/simpan' ?>">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required value="<?= clean($adminData['nama'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" class="form-control" required value="<?= clean($adminData['username'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" required value="<?= clean($adminData['email'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" class="form-select">
                    <?php foreach (['superadmin'=>'Super Admin','admin'=>'Admin','guru_bk'=>'Guru BK'] as $k=>$v): ?>
                        <option value="<?= $k ?>" <?= (isset($adminData['role']) && $adminData['role']===$k)?'selected':'' ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if ($adminData): ?>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" <?= $adminData['status']==='aktif'?'selected':'' ?>>Aktif</option>
                    <option value="nonaktif" <?= $adminData['status']==='nonaktif'?'selected':'' ?>>Nonaktif</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Password <?= $adminData ? '(kosongkan jika tidak ingin mengubah)' : '' ?></label>
                <input type="password" name="password" class="form-control" <?= $adminData ? '' : 'required' ?>>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-gradient rounded-pill px-4">Simpan</button>
            <a href="<?= BASE_URL ?>adminAdmin" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
        </div>
    </form>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
