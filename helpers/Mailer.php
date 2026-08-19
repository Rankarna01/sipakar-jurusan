<?php
/**
 * Class Mailer
 * Wrapper pengiriman email menggunakan PHPMailer (SMTP).
 *
 * CATATAN INSTALASI:
 *   composer require phpmailer/phpmailer
 * Konfigurasi SMTP diambil dari tabel `setting` (grup 'email') agar dapat
 * diubah admin lewat Dashboard > Pengaturan tanpa mengubah source code.
 *
 * Jika PHPMailer belum terpasang atau SMTP belum dikonfigurasi, seluruh
 * method akan gagal secara "silent" (return false) dan dicatat ke error log,
 * sehingga TIDAK mengganggu jalannya fitur utama (registrasi/konsultasi
 * tetap berhasil walau email gagal terkirim).
 */

class Mailer
{
    private bool $available = false;
    private array $config = [];

    public function __construct()
    {
        $autoload = ROOT_PATH . '/vendor/autoload.php';
        if (file_exists($autoload)) {
            require_once $autoload;
            $this->available = class_exists('PHPMailer\PHPMailer\PHPMailer');
        }

        $this->config = [
            'host'       => get_setting('smtp_host', ''),
            'port'       => (int) get_setting('smtp_port', 587),
            'username'   => get_setting('smtp_username', ''),
            'password'   => get_setting('smtp_password', ''),
            'encryption' => get_setting('smtp_encryption', 'tls'),
            'from_email' => get_setting('smtp_from_email', 'noreply@smamuh18sunggal.sch.id'),
            'from_name'  => get_setting('nama_sekolah', 'SiJurusan'),
        ];
    }

    public function isReady(): bool
    {
        $notifAktif = get_setting('email_notif_aktif', '0') === '1';
        return $notifAktif && $this->available && !empty($this->config['host']) && !empty($this->config['username']);
    }

    /**
     * Kirim email generik. Mengembalikan true jika terkirim, false jika gagal/tidak siap.
     */
    public function send(string $toEmail, string $toName, string $subject, string $bodyHtml): bool
    {
        if (!$this->isReady()) {
            error_log("Mailer: SMTP belum dikonfigurasi atau PHPMailer belum terpasang. Email ke {$toEmail} dilewati.");
            return false;
        }

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $this->config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->config['username'];
            $mail->Password = $this->config['password'];
            $mail->SMTPSecure = $this->config['encryption'];
            $mail->Port = $this->config['port'];
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($this->config['from_email'], $this->config['from_name']);
            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $bodyHtml;
            $mail->AltBody = strip_tags($bodyHtml);

            $mail->send();
            return true;
        } catch (\Throwable $e) {
            error_log('Mailer Error: ' . $e->getMessage());
            return false;
        }
    }

    /** Email selamat datang setelah registrasi siswa berhasil */
    public function kirimSelamatDatang(string $email, string $nama): bool
    {
        $namaSekolah = get_setting('nama_sekolah', 'SMA Muhammadiyah 18 Sunggal');
        $html = $this->wrapTemplate("
            <h2>Selamat Datang, {$nama}!</h2>
            <p>Akun Anda di Sistem Pakar Rekomendasi Jurusan PTN <strong>{$namaSekolah}</strong> berhasil dibuat.</p>
            <p>Anda sekarang dapat login dan memulai konsultasi untuk menemukan jurusan Perguruan Tinggi Negeri yang paling sesuai dengan minat dan bakat Anda.</p>
            <p><a href='" . BASE_URL . "konsultasi' style='display:inline-block;background:#0284c7;color:#fff;padding:10px 24px;border-radius:30px;text-decoration:none;'>Mulai Konsultasi</a></p>
        ");
        return $this->send($email, $nama, 'Selamat Datang di ' . $namaSekolah, $html);
    }

    /** Email hasil konsultasi (ringkasan + link lengkap) */
    public function kirimHasilKonsultasi(string $email, string $nama, array $hasil, array $topJurusan): bool
    {
        $link = BASE_URL . 'hasil/detail/' . $hasil['kode_konsultasi'];
        $html = $this->wrapTemplate("
            <h2>Hasil Konsultasi Jurusan Anda</h2>
            <p>Halo {$nama}, berikut ringkasan hasil konsultasi Anda:</p>
            <div style='background:#f1f5f9;border-radius:12px;padding:20px;margin:16px 0;'>
                <p style='margin:0;color:#64748b;'>Rekomendasi Terbaik</p>
                <h3 style='margin:4px 0;color:#0284c7;'>{$topJurusan['nama_jurusan']}</h3>
                <p style='margin:0;'>Tingkat Keyakinan: <strong>" . number_format($topJurusan['persentase'], 2) . "%</strong></p>
            </div>
            <p>Kode Konsultasi: <strong>{$hasil['kode_konsultasi']}</strong></p>
            <p><a href='{$link}' style='display:inline-block;background:#0284c7;color:#fff;padding:10px 24px;border-radius:30px;text-decoration:none;'>Lihat Rincian Lengkap</a></p>
        ");
        return $this->send($email, $nama, 'Hasil Konsultasi Jurusan Anda - ' . $hasil['kode_konsultasi'], $html);
    }

    private function wrapTemplate(string $content): string
    {
        $namaSekolah = get_setting('nama_sekolah', 'SMA Muhammadiyah 18 Sunggal');
        return "
        <div style='font-family:Arial,sans-serif;max-width:560px;margin:0 auto;padding:24px;'>
            <div style='text-align:center;margin-bottom:24px;'>
                <h3 style='color:#0f172a;'>{$namaSekolah}</h3>
                <p style='color:#64748b;font-size:12px;'>Sistem Pakar Rekomendasi Jurusan PTN - Metode Dempster-Shafer</p>
            </div>
            {$content}
            <hr style='border:none;border-top:1px solid #e2e8f0;margin:24px 0;'>
            <p style='color:#94a3b8;font-size:11px;text-align:center;'>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
        </div>";
    }
}
