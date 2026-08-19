</main>

<!-- Footer -->
<footer class="footer-modern">
    <div class="container">
        <div class="row g-4 py-5">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
                    <span class="brand-title text-white">SiJurusan</span>
                </div>
                <p class="text-light opacity-75">Sistem Pakar Rekomendasi Jurusan Perguruan Tinggi Negeri menggunakan Metode Dempster-Shafer, dikembangkan untuk membantu siswa SMA Muhammadiyah 18 Sunggal menemukan jurusan kuliah yang tepat.</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="text-white fw-bold mb-3">Menu</h6>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>">Home</a></li>
                    <li><a href="<?= BASE_URL ?>home/tentang">Tentang</a></li>
                    <li><a href="<?= BASE_URL ?>fakultas">Fakultas</a></li>
                    <li><a href="<?= BASE_URL ?>jurusan">Jurusan</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="text-white fw-bold mb-3">Bantuan</h6>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>#faq">FAQ</a></li>
                    <li><a href="<?= BASE_URL ?>home/kontak">Kontak</a></li>
                    <li><a href="<?= BASE_URL ?>auth/login">Masuk</a></li>
                    <li><a href="<?= BASE_URL ?>auth/register">Daftar</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="text-white fw-bold mb-3">Kontak Kami</h6>
                <ul class="footer-links">
                    <li><i class="bi bi-geo-alt-fill me-2"></i>Jalan Medan Krio, Sunggal</li>
                    <li><i class="bi bi-envelope-fill me-2"></i>info@smamuh18sunggal.sch.id</li>
                    <li><i class="bi bi-telephone-fill me-2"></i>(061) 000-0000</li>
                </ul>
            </div>
        </div>
        <hr class="border-light opacity-25">
        <div class="text-center py-3 text-light opacity-75 small">
            &copy; <?= date('Y') ?> SMA Muhammadiyah 18 Sunggal. Seluruh Hak Cipta Dilindungi. | Sistem Pakar Metode Dempster-Shafer
        </div>
    </div>
</footer>

<!-- Back to top -->
<button id="backToTop" class="back-to-top"><i class="bi bi-arrow-up"></i></button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AOS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<!-- Custom JS -->
<script src="<?= BASE_URL ?>assets/js/main.js"></script>

</body>
</html>
