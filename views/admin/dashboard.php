<?php require VIEW_PATH . 'layout/admin_header.php'; ?>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card blue"><i class="bi bi-people-fill bg-icon"></i>
            <h6 class="opacity-75 mb-1">👥 Total Siswa</h6><h2 class="fw-bold mb-0"><?= $totalSiswa ?></h2></div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card orange"><i class="bi bi-book-fill bg-icon"></i>
            <h6 class="opacity-75 mb-1">📚 Jurusan Aktif</h6><h2 class="fw-bold mb-0"><?= $totalJurusan ?></h2></div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card navy"><i class="bi bi-bank2 bg-icon"></i>
            <h6 class="opacity-75 mb-1">🏛️ Fakultas</h6><h2 class="fw-bold mb-0"><?= $totalFakultas ?></h2></div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card green"><i class="bi bi-clipboard-check-fill bg-icon"></i>
            <h6 class="opacity-75 mb-1">✅ Total Konsultasi</h6><h2 class="fw-bold mb-0"><?= $totalKonsultasi ?></h2></div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card-modern p-4 h-100">
            <h6 class="fw-bold mb-3">Tren Konsultasi 7 Hari Terakhir</h6>
            <canvas id="chartTrend" height="90"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-modern p-4 h-100">
            <h6 class="fw-bold mb-3">Jurusan Terpopuler</h6>
            <?php if (empty($jurusanPopuler)): ?>
                <p class="text-muted small">Belum ada data konsultasi.</p>
            <?php endif; ?>
            <?php foreach ($jurusanPopuler as $j): ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small fw-semibold"><?= clean($j['nama_jurusan']) ?></span>
                    <span class="badge bg-primary rounded-pill"><?= $j['jumlah'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="card-modern p-4">
    <h6 class="fw-bold mb-3">Konsultasi Terbaru</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Kode</th><th>Nama</th><th>Rekomendasi Jurusan</th><th>Persentase</th><th>Tanggal</th></tr></thead>
            <tbody>
            <?php foreach ($konsultasiTerbaru as $k): ?>
                <tr>
                    <td><span class="badge bg-light text-dark border"><?= clean($k['kode_konsultasi']) ?></span></td>
                    <td><?= clean($k['nama_pengguna']) ?></td>
                    <td><?= clean($k['nama_jurusan'] ?? '-') ?></td>
                    <td><?= number_format($k['persentase_akhir'], 2) ?>%</td>
                    <td class="text-muted small"><?= format_tanggal($k['created_at'], true) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($konsultasiTerbaru)): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada konsultasi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
const trendData = <?= json_encode($trend, JSON_UNESCAPED_UNICODE) ?>;
document.addEventListener('DOMContentLoaded', function () {
    function renderTrendChart() {
        if (typeof Chart === 'undefined') { setTimeout(renderTrendChart, 100); return; }
        const el = document.getElementById('chartTrend');
        if (!el) return;
        new Chart(el, {
            type: 'line',
            data: {
                labels: trendData.map(t => t.tgl),
                datasets: [{
                    label: 'Jumlah Konsultasi',
                    data: trendData.map(t => t.jumlah),
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56,189,248,0.15)',
                    tension: 0.4, fill: true,
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    }
    renderTrendChart();
});
</script>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
