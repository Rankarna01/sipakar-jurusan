<?php require VIEW_PATH . 'layout/header.php'; ?>
<section class="section-padding section-tint-green">
    <span class="bg-blob bg-blob-4"></span>
    <div class="container">
        <div class="text-center mb-4" data-aos="fade-up">
            <span class="section-badge">Jelajahi</span>
            <h2 class="section-title">Daftar Jurusan</h2>
        </div>

        <div class="row justify-content-center mb-5" data-aos="fade-up">
            <div class="col-lg-6">
                <form method="GET" action="<?= BASE_URL ?>jurusan" class="d-flex gap-2">
                    <input type="text" name="q" class="form-control form-control-lg rounded-pill" placeholder="Cari jurusan atau fakultas..." value="<?= clean($keyword) ?>">
                    <button class="btn btn-gradient rounded-pill px-4"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <?php if (empty($jurusan)): ?>
                <div class="col-12 text-center text-muted py-5"><i class="bi bi-search fs-1 d-block mb-2"></i>Tidak ditemukan jurusan yang sesuai.</div>
            <?php endif; ?>
            <?php foreach ($jurusan as $i => $j): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <a href="<?= BASE_URL ?>jurusan/detail/<?= $j['slug'] ?>" class="text-decoration-none">
                    <div class="card-modern p-4 h-100">
                        <span class="badge bg-light text-dark border mb-2"><?= clean($j['nama_fakultas']) ?></span>
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
