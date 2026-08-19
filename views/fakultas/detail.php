<?php require VIEW_PATH . 'layout/header.php'; ?>
<section class="section-padding">
    <div class="container">
        <nav aria-label="breadcrumb" data-aos="fade-up">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>fakultas">Fakultas</a></li>
                <li class="breadcrumb-item active"><?= clean($fakultas['nama_fakultas']) ?></li>
            </ol>
        </nav>

        <div class="glass-card p-5 text-center mb-5" data-aos="fade-up">
            <div class="fakultas-icon mx-auto mb-3" style="width:80px;height:80px;font-size:2.2rem;"><i class="bi <?= clean($fakultas['icon'] ?: 'bi-mortarboard') ?>"></i></div>
            <div class="mb-2" style="font-size:2rem;"><?= get_fakultas_emoji($fakultas['nama_fakultas']) ?></div>
            <h2 class="fw-bold"><?= clean($fakultas['nama_fakultas']) ?></h2>
            <p class="text-muted mx-auto" style="max-width:700px;"><?= clean($fakultas['deskripsi'] ?? '') ?></p>
        </div>

        <h5 class="fw-bold mb-4" data-aos="fade-up">Program Studi (<?= count($jurusan) ?>)</h5>
        <div class="row g-4">
            <?php foreach ($jurusan as $i => $j): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
                <a href="<?= BASE_URL ?>jurusan/detail/<?= $j['slug'] ?>" class="text-decoration-none">
                    <div class="card-modern p-4 h-100">
                        <i class="bi <?= clean($j['icon'] ?: 'bi-book') ?> fs-2 mb-2" style="color: var(--sky-blue-dark);"></i>
                        <h6 class="fw-bold text-dark"><?= clean($j['nama_jurusan']) ?></h6>
                        <p class="text-muted small mb-0"><?= truncate_text(clean($j['deskripsi'] ?? ''), 90) ?></p>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require VIEW_PATH . 'layout/footer.php'; ?>
