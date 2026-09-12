<?php require VIEW_PATH . 'layout/header.php'; ?>

<?php
$emojiKategori = [
    'minat' => '💡', 'bakat' => '🎯', 'kemampuan' => '🧠', 'kepribadian' => '😊', 'tujuan_karier' => '🚀',
];
$MIN_JAWAB = count($pertanyaan);
?>

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Progress + Tombol Selesai (sticky, selalu terlihat) -->
                <div class="glass-card p-4 mb-4 sticky-top" style="top: 90px; z-index: 10;">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                        <div>
                            <span class="fw-bold">📋 Progress Konsultasi</span>
                            <div class="text-muted small">Jawab <strong>semua pertanyaan</strong>, lalu klik Selesaikan.</div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span id="progressText" class="fw-bold text-primary fs-5">0 / <?= count($pertanyaan) ?></span>
                            <button type="button" id="btnSubmit" class="btn btn-gradient rounded-pill px-4">
                                <i class="bi bi-check2-circle me-1"></i> Selesaikan
                            </button>
                        </div>
                    </div>
                    <div class="progress progress-modern mb-2">
                        <div id="progressBar" class="progress-bar" style="width:0%"></div>
                    </div>
                    <div class="text-center pt-2 border-top mt-2">
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Jawab <strong>YA</strong> atau <strong>TIDAK</strong> dengan jujur sesuai dengan diri Anda.</small>
                    </div>
                </div>

                <?php if (!is_siswa_login()): ?>
                <div class="glass-card p-4 mb-4">
                    <h6 class="fw-bold mb-3">🙋 Data Diri (Opsional, untuk hasil lebih personal)</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input type="text" id="namaTamu" class="form-control" placeholder="Nama Lengkap">
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="kelasTamu" class="form-control" placeholder="Kelas (XII IPA 1)">
                        </div>
                        <div class="col-md-3">
                            <select id="genderTamu" class="form-select">
                                <option value="">Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="email" id="emailTamu" class="form-control" placeholder="Email (opsional)">
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <form id="formKonsultasi">
                    <?= csrf_field() ?>
                    <div class="row g-3" id="questionGrid">
                    <?php foreach ($pertanyaan as $i => $p): ?>
                        <div class="col-md-6">
                            <div class="question-card-mini h-100" data-question-index="<?= $i ?>">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="qnum"><?= $i + 1 ?></div>
                                    <div class="flex-grow-1">
                                        <span class="badge bg-light text-dark border mb-1 text-capitalize" style="font-size:0.68rem;">
                                            <?= $emojiKategori[$p['kategori']] ?? '' ?> <?= str_replace('_', ' ', $p['kategori']) ?>
                                        </span>
                                        <p class="fw-semibold mb-0 small-q"><?= clean($p['pertanyaan']) ?></p>
                                    </div>
                                    <div class="d-flex gap-2 flex-shrink-0 align-items-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm px-3 fw-bold likert-btn btn-tidak" data-id="<?= $p['id_pertanyaan'] ?>" data-value="T" title="TIDAK">TIDAK</button>
                                        <button type="button" class="btn btn-outline-success btn-sm px-3 fw-bold likert-btn btn-ya" data-id="<?= $p['id_pertanyaan'] ?>" data-value="Y" title="YA">YA</button>
                                    </div>
                                </div>
                                <div class="likert-label-hint text-muted" style="font-size:0.65rem; margin-left:34px;"></div>
                                <input type="hidden" name="jawaban[<?= $p['id_pertanyaan'] ?>]" id="input_<?= $p['id_pertanyaan'] ?>" value="">
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>

                    <div class="text-center mt-4 mb-5">
                        <button type="submit" id="btnSubmitBottom" class="btn btn-gradient btn-lg rounded-pill px-5">
                            <i class="bi bi-cpu-fill me-2"></i>Proses dengan Dempster-Shafer 🎓
                        </button>
                        <p class="text-muted small mt-2 fw-bold" id="hintText"><span class="text-danger">⚠ Masih ada <?= count($pertanyaan) ?> pertanyaan yang belum dijawab.</span></p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<style>
.question-card-mini {
    background: var(--white); border-radius: 14px; box-shadow: var(--shadow-soft);
    padding: 14px 16px; transition: all 0.25s ease; border: 2px solid transparent;
}
.question-card-mini:hover { box-shadow: var(--shadow-hover); }
.question-card-mini.answered { border-color: #38bdf8; }
.qnum {
    width: 26px; height: 26px; border-radius: 50%; background: var(--gradient-main); color: white;
    display: flex; align-items: center; justify-content: center; font-size: 0.72rem; font-weight: 700; flex-shrink: 0;
}
.small-q { font-size: 0.86rem; line-height: 1.3; }
.answer-btn-mini {
    width: 36px; height: 36px; border-radius: 10px; border: 2px solid #e2e8f0; background: transparent;
    display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; font-size: 1rem;
}
.answer-btn-mini.btn-ya.active, .answer-btn-mini.btn-ya:hover { background: var(--green); border-color: var(--green); color: white; }
.answer-btn-mini.btn-tidak.active, .answer-btn-mini.btn-tidak:hover { background: #ef4444; border-color: #ef4444; color: white; }

.btn-ya.active { background: var(--green) !important; border-color: var(--green) !important; color: white !important; }
.btn-tidak.active { background: #ef4444 !important; border-color: #ef4444 !important; color: white !important; }
@media (max-width: 576px) {
    .likert-btn { padding-left: 10px !important; padding-right: 10px !important; font-size: 0.75rem; }
}
</style>

<script>
const totalPertanyaan = <?= count($pertanyaan) ?>;
const minJawab = <?= $MIN_JAWAB ?>;
let terjawab = 0;
const answeredMap = {};

document.querySelectorAll('.likert-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const value = this.dataset.value;
        const card = this.closest('.question-card-mini');

        card.querySelectorAll('.likert-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        card.classList.add('answered');
        card.style.border = '2px solid transparent';
        card.style.borderColor = '#38bdf8';

        document.getElementById('input_' + id).value = value;

        const hint = card.querySelector('.likert-label-hint');
        if (hint) hint.textContent = this.title;

        if (!answeredMap[id]) {
            terjawab++;
            answeredMap[id] = true;
        }

        // Simpan ke localStorage
        let savedAnswers = JSON.parse(localStorage.getItem('jawabanKonsultasi')) || {};
        savedAnswers[id] = value;
        localStorage.setItem('jawabanKonsultasi', JSON.stringify(savedAnswers));

        updateProgress();
    });
});

// Load data dari localStorage saat halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    let savedAnswers = JSON.parse(localStorage.getItem('jawabanKonsultasi'));
    if (savedAnswers) {
        for (const [id, value] of Object.entries(savedAnswers)) {
            const btn = document.querySelector(`.likert-btn[data-id="${id}"][data-value="${value}"]`);
            if (btn) {
                // Trigger click manual untuk memicu class update dan progress
                btn.click();
            }
        }
    }

    ['namaTamu', 'kelasTamu', 'genderTamu', 'emailTamu'].forEach(elId => {
        const el = document.getElementById(elId);
        if (el) {
            const savedVal = localStorage.getItem(elId);
            if (savedVal) el.value = savedVal;
            el.addEventListener('input', () => {
                localStorage.setItem(elId, el.value);
            });
        }
    });
});

function updateProgress() {
    const percent = Math.round((terjawab / totalPertanyaan) * 100);
    document.getElementById('progressBar').style.width = percent + '%';
    document.getElementById('progressText').innerText = terjawab + ' / ' + totalPertanyaan;

    const bisaSelesai = terjawab >= totalPertanyaan;

    const hint = document.getElementById('hintText');
    if (bisaSelesai) {
        hint.innerHTML = '<span class="text-success">✅ Semua pertanyaan telah dijawab. Anda bisa menyelesaikan konsultasi.</span>';
    } else {
        const sisa = totalPertanyaan - terjawab;
        hint.innerHTML = `<span class="text-danger">⚠ Masih ada ${sisa} pertanyaan yang belum dijawab. Silakan lengkapi terlebih dahulu.</span>`;
    }
}

function submitKonsultasi() {
    if (terjawab < totalPertanyaan) {
        const sisa = totalPertanyaan - terjawab;
        Swal.fire('Belum Lengkap', `Masih ada ${sisa} pertanyaan yang belum dijawab. Silakan lengkapi terlebih dahulu.`, 'warning');
        
        // Highlight unanswered
        document.querySelectorAll('.question-card-mini').forEach(card => {
            if (!card.classList.contains('answered')) {
                card.style.border = '2px solid #ef4444';
            }
        });
        
        // Scroll to the first unanswered question
        const firstUnanswered = document.querySelector('.question-card-mini:not(.answered)');
        if (firstUnanswered) {
            firstUnanswered.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        return;
    }
    const form = document.getElementById('formKonsultasi');
    const formData = new FormData(form);
    const namaTamu = document.getElementById('namaTamu');
    const kelasTamu = document.getElementById('kelasTamu');
    const emailTamu = document.getElementById('emailTamu');
    const genderTamu = document.getElementById('genderTamu');
    if (namaTamu) formData.append('nama_tamu', namaTamu.value);
    if (kelasTamu) formData.append('kelas_tamu', kelasTamu.value);
    if (emailTamu) formData.append('email_tamu', emailTamu.value);
    if (genderTamu) formData.append('jenis_kelamin', genderTamu.value);

    [document.getElementById('btnSubmit'), document.getElementById('btnSubmitBottom')].forEach(b => {
        b.disabled = true;
        b.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
    });

    fetch('<?= BASE_URL ?>konsultasi/proses', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Hapus session/localStorage jika sukses
            localStorage.removeItem('jawabanKonsultasi');
            ['namaTamu', 'kelasTamu', 'genderTamu', 'emailTamu'].forEach(elId => localStorage.removeItem(elId));
            
            window.location.href = data.redirect;
        } else {
            Swal.fire('Gagal', data.message, 'error');
            resetButtons();
        }
    })
    .catch(() => {
        Swal.fire('Error', 'Terjadi kesalahan sistem. Silakan coba lagi.', 'error');
        resetButtons();
    });
}

function resetButtons() {
    [document.getElementById('btnSubmit'), document.getElementById('btnSubmitBottom')].forEach(b => {
        b.disabled = false;
    });
    document.getElementById('btnSubmit').innerHTML = '<i class="bi bi-check2-circle me-1"></i> Selesaikan';
    document.getElementById('btnSubmitBottom').innerHTML = '<i class="bi bi-cpu-fill me-2"></i>Proses dengan Dempster-Shafer 🎓';
}

document.getElementById('btnSubmit').addEventListener('click', submitKonsultasi);
document.getElementById('formKonsultasi').addEventListener('submit', function (e) {
    e.preventDefault();
    submitKonsultasi();
});
</script>

<?php require VIEW_PATH . 'layout/footer.php'; ?>
