<?php require VIEW_PATH . 'layout/header.php'; ?>

<?php
$emojiKategori = [
    'minat' => '💡', 'bakat' => '🎯', 'kemampuan' => '🧠', 'kepribadian' => '😊', 'tujuan_karier' => '🚀',
];
$MIN_JAWAB = 10;
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
                            <div class="text-muted small">Jawab minimal <strong><?= $MIN_JAWAB ?> pertanyaan</strong>, lalu klik Selesaikan kapan saja.</div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span id="progressText" class="fw-bold text-primary fs-5">0 / <?= count($pertanyaan) ?></span>
                            <button type="button" id="btnSubmit" class="btn btn-gradient rounded-pill px-4" disabled>
                                <i class="bi bi-check2-circle me-1"></i> Selesaikan
                            </button>
                        </div>
                    </div>
                    <div class="progress progress-modern mb-2">
                        <div id="progressBar" class="progress-bar" style="width:0%"></div>
                    </div>
                    <div class="text-center pt-1 border-top mt-2">
                        <small class="likert-legend text-muted">
                            <span class="badge rounded-pill" style="background:#ef4444;">1</span> Sangat Tidak Setuju &nbsp;
                            <span class="badge rounded-pill" style="background:#fb923c;">2</span> Kurang Setuju &nbsp;
                            <span class="badge rounded-pill" style="background:#eab308;">3</span> Cukup Setuju &nbsp;
                            <span class="badge rounded-pill" style="background:#84cc16;">4</span> Setuju &nbsp;
                            <span class="badge rounded-pill" style="background:var(--green);">5</span> Sangat Setuju
                        </small>
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
                                    <div class="d-flex gap-1 flex-shrink-0 likert-group">
                                        <button type="button" class="likert-btn likert-1" data-id="<?= $p['id_pertanyaan'] ?>" data-value="1" title="Sangat Tidak Setuju">1</button>
                                        <button type="button" class="likert-btn likert-2" data-id="<?= $p['id_pertanyaan'] ?>" data-value="2" title="Kurang Setuju">2</button>
                                        <button type="button" class="likert-btn likert-3" data-id="<?= $p['id_pertanyaan'] ?>" data-value="3" title="Cukup Setuju">3</button>
                                        <button type="button" class="likert-btn likert-4" data-id="<?= $p['id_pertanyaan'] ?>" data-value="4" title="Setuju">4</button>
                                        <button type="button" class="likert-btn likert-5" data-id="<?= $p['id_pertanyaan'] ?>" data-value="5" title="Sangat Setuju">5</button>
                                    </div>
                                </div>
                                <div class="likert-label-hint text-muted" style="font-size:0.65rem; margin-left:34px;"></div>
                                <input type="hidden" name="jawaban[<?= $p['id_pertanyaan'] ?>]" id="input_<?= $p['id_pertanyaan'] ?>" value="">
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>

                    <div class="text-center mt-4 mb-5">
                        <button type="submit" id="btnSubmitBottom" class="btn btn-gradient btn-lg rounded-pill px-5" disabled>
                            <i class="bi bi-cpu-fill me-2"></i>Proses dengan Dempster-Shafer 🎓
                        </button>
                        <p class="text-muted small mt-2" id="hintText">Jawab minimal <?= $MIN_JAWAB ?> pertanyaan untuk mengaktifkan tombol ini</p>
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

/* ===== Skala Likert 5-poin ===== */
.likert-group { gap: 3px !important; }
.likert-btn {
    width: 26px; height: 26px; border-radius: 7px; border: 2px solid #e2e8f0; background: transparent;
    display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700;
    color: #94a3b8; transition: all 0.2s ease; padding: 0;
}
.likert-1:hover, .likert-1.active { background: #ef4444; border-color: #ef4444; color: white; }
.likert-2:hover, .likert-2.active { background: #fb923c; border-color: #fb923c; color: white; }
.likert-3:hover, .likert-3.active { background: #eab308; border-color: #eab308; color: white; }
.likert-4:hover, .likert-4.active { background: #84cc16; border-color: #84cc16; color: white; }
.likert-5:hover, .likert-5.active { background: var(--green); border-color: var(--green); color: white; }
.likert-legend { font-size: 0.72rem; }
@media (max-width: 576px) {
    .likert-btn { width: 24px; height: 24px; font-size: 0.65rem; }
    .likert-legend { display: block; line-height: 1.6; }
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

        document.getElementById('input_' + id).value = value;

        const hint = card.querySelector('.likert-label-hint');
        if (hint) hint.textContent = this.title;

        if (!answeredMap[id]) {
            terjawab++;
            answeredMap[id] = true;
        }

        updateProgress();
    });
});

function updateProgress() {
    const percent = Math.round((terjawab / totalPertanyaan) * 100);
    document.getElementById('progressBar').style.width = percent + '%';
    document.getElementById('progressText').innerText = terjawab + ' / ' + totalPertanyaan;

    const bisaSelesai = terjawab >= minJawab;
    document.getElementById('btnSubmit').disabled = !bisaSelesai;
    document.getElementById('btnSubmitBottom').disabled = !bisaSelesai;

    const hint = document.getElementById('hintText');
    if (bisaSelesai) {
        hint.innerHTML = '✅ Kamu sudah bisa menyelesaikan konsultasi, atau lanjut jawab lebih banyak untuk hasil lebih akurat.';
    } else {
        hint.innerHTML = `Jawab ${minJawab - terjawab} pertanyaan lagi untuk bisa menyelesaikan konsultasi.`;
    }
}

function submitKonsultasi() {
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
