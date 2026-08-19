<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>adminPengaturan/simpan">
    <?= csrf_field() ?>

    <div class="card-modern p-4 mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-gear-fill me-1"></i> Pengaturan Website</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" class="form-control" value="<?= clean($settings['nama_sekolah'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Sistem</label>
                <input type="text" name="nama_sistem" class="form-control" value="<?= clean($settings['nama_sistem'] ?? '') ?>">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Alamat</label>
                <input type="text" name="alamat_sekolah" class="form-control" value="<?= clean($settings['alamat_sekolah'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">No. WhatsApp</label>
                <input type="text" name="no_wa" class="form-control" value="<?= clean($settings['no_wa'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email Kontak</label>
                <input type="email" name="email_kontak" class="form-control" value="<?= clean($settings['email_kontak'] ?? '') ?>">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Teks Copyright Footer</label>
                <input type="text" name="copyright_text" class="form-control" value="<?= clean($settings['copyright_text'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">🖼️ Logo Sekolah</label>
                <?php if (!empty($settings['logo']) && file_exists(UPLOAD_PATH . $settings['logo'])): ?>
                    <div class="mb-2"><img src="<?= UPLOAD_URL . clean($settings['logo']) ?>" style="height:50px;" class="border rounded p-1"></div>
                <?php endif; ?>
                <input type="file" name="logo" class="form-control" accept="image/*">
                <small class="text-muted">Maksimal 4MB. Kosongkan jika tidak ingin mengubah.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">🔖 Favicon</label>
                <?php if (!empty($settings['favicon']) && file_exists(UPLOAD_PATH . $settings['favicon'])): ?>
                    <div class="mb-2"><img src="<?= UPLOAD_URL . clean($settings['favicon']) ?>" style="height:32px;" class="border rounded p-1"></div>
                <?php endif; ?>
                <input type="file" name="favicon" class="form-control" accept="image/*">
                <small class="text-muted">Maksimal 4MB. Kosongkan jika tidak ingin mengubah.</small>
            </div>
        </div>
    </div>

    <div class="card-modern p-4 mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-toggle-on me-1"></i> Pengaturan Konsultasi</h6>
        <div class="form-check form-switch fs-5">
            <input class="form-check-input" type="checkbox" name="wajib_login" id="wajibLogin" <?= ($settings['wajib_login'] ?? '0') === '1' ? 'checked' : '' ?>>
            <label class="form-check-label fs-6" for="wajibLogin">
                <strong>Konsultasi Wajib Login</strong>
                <div class="text-muted small">Jika aktif, siswa harus login sebelum dapat memulai konsultasi. Jika nonaktif, siswa dapat konsultasi sebagai tamu.</div>
            </label>
        </div>
    </div>

    <div class="card-modern p-4 mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-moon-stars-fill me-1"></i> Pengaturan Tampilan</h6>
        <div class="form-check form-switch fs-5">
            <input class="form-check-input" type="checkbox" name="dark_mode_default" id="darkDefault" <?= ($settings['dark_mode_default'] ?? '0') === '1' ? 'checked' : '' ?>>
            <label class="form-check-label fs-6" for="darkDefault">
                <strong>Mode Gelap Default</strong>
                <div class="text-muted small">Aktifkan agar tampilan default website menggunakan dark mode.</div>
            </label>
        </div>
    </div>

    <div class="card-modern p-4 mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-envelope-fill me-1"></i> Pengaturan Email (SMTP)</h6>
        <div class="form-check form-switch fs-5 mb-3">
            <input class="form-check-input" type="checkbox" name="email_notif_aktif" id="emailNotifAktif" <?= ($settings['email_notif_aktif'] ?? '0') === '1' ? 'checked' : '' ?>>
            <label class="form-check-label fs-6" for="emailNotifAktif">
                <strong>Aktifkan Notifikasi Email</strong>
                <div class="text-muted small">Kirim email otomatis saat registrasi berhasil dan hasil konsultasi tersedia. Pastikan konfigurasi SMTP di bawah sudah benar dan <code>composer require phpmailer/phpmailer</code> sudah dijalankan.</div>
            </label>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">SMTP Host</label>
                <input type="text" name="smtp_host" class="form-control" placeholder="smtp.gmail.com" value="<?= clean($settings['smtp_host'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">SMTP Port</label>
                <input type="number" name="smtp_port" class="form-control" value="<?= clean($settings['smtp_port'] ?? '587') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Enkripsi</label>
                <select name="smtp_encryption" class="form-select">
                    <option value="tls" <?= ($settings['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' ?>>TLS</option>
                    <option value="ssl" <?= ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">SMTP Username</label>
                <input type="text" name="smtp_username" class="form-control" placeholder="email@gmail.com" value="<?= clean($settings['smtp_username'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">SMTP Password</label>
                <input type="password" name="smtp_password" class="form-control" placeholder="App Password" value="<?= clean($settings['smtp_password'] ?? '') ?>">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Email Pengirim (From)</label>
                <input type="email" name="smtp_from_email" class="form-control" value="<?= clean($settings['smtp_from_email'] ?? '') ?>">
            </div>
        </div>
    </div>

    <div class="card-modern p-4 mb-4">
        <h6 class="fw-bold mb-3">🖼️ Banner Halaman Konsultasi</h6>
        <div class="row g-3">
            <div class="col-md-4">
                <?php if (!empty($settings['konsultasi_banner']) && file_exists(UPLOAD_PATH . $settings['konsultasi_banner'])): ?>
                    <div class="mb-2"><img src="<?= UPLOAD_URL . clean($settings['konsultasi_banner']) ?>" style="width:100%;max-height:120px;object-fit:cover;border-radius:8px;" class="border p-1"></div>
                <?php endif; ?>
                <input type="file" name="konsultasi_banner" class="form-control" accept="image/*">
                <small class="text-muted">Maksimal 4MB. Tampil di halaman awal konsultasi. Kosongkan jika tidak ingin mengubah.</small>
            </div>
        </div>
    </div>

    <div class="card-modern p-4 mb-4">
        <h6 class="fw-bold mb-3">👨‍💻 Profil Pengembang (Tampil di Halaman Kontak)</h6>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Foto Profil (maksimal 4MB)</label>
                <?php if (!empty($settings['dev_foto']) && file_exists(UPLOAD_PATH . $settings['dev_foto'])): ?>
                    <div class="mb-2"><img src="<?= UPLOAD_URL . clean($settings['dev_foto']) ?>" style="width:90px;height:90px;object-fit:cover;border-radius:50%;" class="border p-1"></div>
                <?php endif; ?>
                <input type="file" name="dev_foto" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah. Jika kosong & belum pernah diisi, akan tampil avatar inisial.</small>
            </div>
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama</label>
                        <input type="text" name="dev_nama" class="form-control" value="<?= clean($settings['dev_nama'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jabatan / Institusi</label>
                        <input type="text" name="dev_jabatan" class="form-control" value="<?= clean($settings['dev_jabatan'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Bio Singkat</label>
                        <textarea name="dev_bio" class="form-control" rows="3"><?= clean($settings['dev_bio'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Keahlian (pisahkan dengan tanda |)</label>
                        <input type="text" name="dev_keahlian" class="form-control" placeholder="Dosen Polmed | Peneliti Sistem Pakar | Full-Stack Developer" value="<?= clean($settings['dev_keahlian'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-gradient btn-lg rounded-pill px-5">Simpan Pengaturan</button>
</form>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
