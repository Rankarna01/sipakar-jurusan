<?php require VIEW_PATH . 'layout/admin_header.php'; ?>

<?php require VIEW_PATH . 'partials/alert.php'; ?>

<div class="card-modern p-4 mb-4">
    <form method="GET" id="filterForm" class="row g-3 align-items-end">
        <div class="col-md-2">
            <label class="form-label small fw-semibold">📅 Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="<?= clean($tanggalMulai) ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">📅 Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control" value="<?= clean($tanggalAkhir) ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">🏫 Kelas</label>
            <select name="kelas" class="form-select">
                <option value="">Semua Kelas</option>
                <?php foreach ($daftarKelas as $k): if (empty($k['kelas'])) continue; ?>
                    <option value="<?= clean($k['kelas']) ?>" <?= $filterKelas === $k['kelas'] ? 'selected' : '' ?>><?= clean($k['kelas']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">🚻 Jenis Kelamin</label>
            <select name="gender" class="form-select">
                <option value="">Semua</option>
                <option value="L" <?= $filterGender === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= $filterGender === 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">🎓 Jurusan</label>
            <select name="jurusan" class="form-select">
                <option value="0">Semua Jurusan</option>
                <?php foreach ($daftarJurusan as $j): ?>
                    <option value="<?= $j['id_jurusan'] ?>" <?= $filterJurusan == $j['id_jurusan'] ? 'selected' : '' ?>><?= clean($j['nama_jurusan']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-1 d-flex gap-2">
            <button class="btn btn-gradient w-100" title="Filter"><i class="bi bi-funnel-fill"></i></button>
        </div>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="card-modern p-4 h-100">
            <h6 class="fw-bold mb-3">📊 Rekap per Fakultas</h6>
            <?php foreach ($rekapFakultas as $r): ?>
                <div class="d-flex justify-content-between mb-2 small">
                    <span><?= clean($r['nama_fakultas']) ?></span>
                    <span class="badge bg-primary rounded-pill"><?= $r['jumlah'] ?></span>
                </div>
            <?php endforeach; ?>
            <?php if (empty($rekapFakultas)): ?><p class="text-muted small">Tidak ada data pada rentang ini.</p><?php endif; ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-modern p-4 h-100">
            <h6 class="fw-bold mb-3">🚻 Rekap per Jenis Kelamin</h6>
            <?php foreach ($rekapGender as $r):
                $label = $r['gender'] === 'L' ? '👦 Laki-laki' : ($r['gender'] === 'P' ? '👧 Perempuan' : '❔ Tidak diketahui'); ?>
                <div class="d-flex justify-content-between mb-2 small">
                    <span><?= $label ?></span>
                    <span class="badge bg-info rounded-pill"><?= $r['jumlah'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-modern p-4 h-100">
            <h6 class="fw-bold mb-3">🧾 Total Konsultasi</h6>
            <h2 class="fw-bold text-primary"><?= count($laporan) ?></h2>
            <p class="text-muted small mb-0">Periode: <?= format_tanggal($tanggalMulai) ?> — <?= format_tanggal($tanggalAkhir) ?></p>
        </div>
    </div>
</div>

<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h6 class="fw-bold mb-0">Detail Laporan Konsultasi</h6>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" onclick="downloadSelected()" class="btn btn-sm btn-outline-primary"><i class="bi bi-download me-1"></i> Unduh CSV (Terpilih)</button>
            <a href="<?= BASE_URL ?>adminLaporan/export?<?= http_build_query($_GET) ?>" class="btn btn-sm btn-outline-navy"><i class="bi bi-cloud-download me-1"></i> Unduh CSV (Sesuai Filter)</a>
            <button type="button" onclick="hapusTerpilih()" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i> Hapus Terpilih</button>
            <button type="button" onclick="hapusSemuaFilter()" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill me-1"></i> Hapus Semua (Sesuai Filter)</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light">
                <tr>
                    <th><input type="checkbox" id="checkAll" class="form-check-input"></th>
                    <th>Kode</th><th>Nama</th><th>Kelas</th><th>Gender</th><th>Fakultas Direkomendasikan</th><th>Jurusan Terbaik</th><th>%</th><th>💼 Peluang Kerja</th><th>💰 Estimasi Gaji</th><th>Tanggal</th><th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($laporan as $l): ?>
                <tr>
                    <td><input type="checkbox" class="form-check-input row-check" value="<?= $l['id_hasil'] ?>"></td>
                    <td><span class="badge bg-light text-dark border"><?= clean($l['kode_konsultasi']) ?></span></td>
                    <td><?= clean($l['nama_pengguna']) ?></td>
                    <td><?= clean($l['kelas']) ?></td>
                    <td><?= $l['jenis_kelamin'] === 'L' ? '👦 L' : ($l['jenis_kelamin'] === 'P' ? '👧 P' : '-') ?></td>
                    <td><strong><?= clean($l['nama_fakultas'] ?? '-') ?></strong> <?= $l['persentase_fakultas_terbaik'] ? '('.number_format($l['persentase_fakultas_terbaik'],1).'%)' : '' ?></td>
                    <td><?= clean($l['nama_jurusan'] ?? '-') ?></td>
                    <td><?= number_format($l['persentase_akhir'], 1) ?>%</td>
                    <td class="small text-muted" style="max-width:220px;"><?= clean(mb_strimwidth($l['prospek_kerja'] ?? '-', 0, 80, '...')) ?></td>
                    <td class="small text-muted"><?= clean($l['range_gaji'] ?? '-') ?></td>
                    <td class="text-muted small"><?= format_tanggal($l['created_at'], true) ?></td>
                    <td class="text-center">
                        <a href="<?= BASE_URL ?>hasil/detail/<?= $l['kode_konsultasi'] ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat Detail Lengkap"><i class="bi bi-eye"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminLaporan/hapus/<?= $l['id_hasil'] ?>', '<?= clean($l['kode_konsultasi']) ?>')" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($laporan)): ?>
                <tr><td colspan="11" class="text-center text-muted py-4">Tidak ada data konsultasi pada filter ini. 🔍</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Form tersembunyi untuk aksi grup (POST + CSRF) -->
<form id="formHapusGrup" method="POST" action="<?= BASE_URL ?>adminLaporan/hapusGrup" style="display:none;">
    <?= csrf_field() ?>
    <div id="idsContainer"></div>
</form>
<form id="formHapusSemua" method="POST" action="<?= BASE_URL ?>adminLaporan/hapusSemua" style="display:none;">
    <?= csrf_field() ?>
    <input type="hidden" name="tanggal_mulai" value="<?= clean($tanggalMulai) ?>">
    <input type="hidden" name="tanggal_akhir" value="<?= clean($tanggalAkhir) ?>">
    <input type="hidden" name="kelas" value="<?= clean($filterKelas) ?>">
    <input type="hidden" name="gender" value="<?= clean($filterGender) ?>">
    <input type="hidden" name="jurusan" value="<?= (int) $filterJurusan ?>">
</form>

<script>
document.getElementById('checkAll').addEventListener('change', function () {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
});

function getSelectedIds() {
    return Array.from(document.querySelectorAll('.row-check:checked')).map(cb => cb.value);
}

function hapusTerpilih() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        Swal.fire('Belum ada yang dipilih', 'Centang minimal satu data terlebih dahulu.', 'warning');
        return;
    }
    Swal.fire({
        title: `Hapus ${ids.length} data terpilih?`,
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#ef4444', confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal',
    }).then(result => {
        if (result.isConfirmed) {
            const container = document.getElementById('idsContainer');
            container.innerHTML = '';
            ids.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden'; input.name = 'ids[]'; input.value = id;
                container.appendChild(input);
            });
            document.getElementById('formHapusGrup').submit();
        }
    });
}

function hapusSemuaFilter() {
    Swal.fire({
        title: 'Hapus SEMUA data sesuai filter aktif?',
        text: 'Seluruh data yang cocok dengan filter saat ini akan dihapus permanen.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#ef4444', confirmButtonText: 'Ya, Hapus Semua', cancelButtonText: 'Batal',
    }).then(result => {
        if (result.isConfirmed) document.getElementById('formHapusSemua').submit();
    });
}

function downloadSelected() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        Swal.fire('Belum ada yang dipilih', 'Centang minimal satu data, atau gunakan "Unduh CSV (Sesuai Filter)".', 'info');
        return;
    }
    window.location.href = '<?= BASE_URL ?>adminLaporan/export?ids=' + ids.join(',');
}
</script>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
