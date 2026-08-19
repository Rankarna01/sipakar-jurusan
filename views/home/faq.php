<?php require VIEW_PATH . 'layout/header.php'; ?>
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Bantuan</span>
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqPage">
                    <?php
                    $faqs = [
                        ['q' => 'Apakah hasil konsultasi bersifat final?', 'a' => 'Hasil merupakan rekomendasi berbasis data, tetap disarankan berdiskusi dengan Guru BK sebelum memutuskan.'],
                        ['q' => 'Berapa lama proses konsultasi?', 'a' => 'Sekitar 10-15 menit tergantung jumlah pertanyaan yang dijawab.'],
                        ['q' => 'Apakah data saya aman?', 'a' => 'Ya, seluruh data disimpan aman menggunakan enkripsi password dan proteksi database standar industri.'],
                    ];
                    foreach ($faqs as $i => $f): ?>
                    <div class="accordion-item glass-card mb-3 border-0 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?= $i>0?'collapsed':'' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#fp<?= $i ?>"><?= $f['q'] ?></button>
                        </h2>
                        <div id="fp<?= $i ?>" class="accordion-collapse collapse <?= $i===0?'show':'' ?>" data-bs-parent="#faqPage">
                            <div class="accordion-body text-muted"><?= $f['a'] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require VIEW_PATH . 'layout/footer.php'; ?>
