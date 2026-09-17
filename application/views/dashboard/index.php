<!-- Page Header -->
<div class="page-header d-print-none mb-3 mb-md-4">
  <div class="row align-items-center g-2">
    <div class="col-12 col-sm-auto me-auto">
      <div class="page-pretitle">Ikhtisar Performance</div>
      <h2 class="page-title">Welcome Back, <?= html_escape($_user['full_name'] ?? 'User') ?> 👋</h2>
    </div>
    <div class="col-12 col-sm-auto ms-auto d-print-none">
      <div class="btn-list">
        <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
          <a href="<?= base_url('jurnal/add') ?>" class="btn btn-primary w-100 w-sm-auto">
            <i class="ti ti-plus me-1"></i> Input Jurnal Baru
          </a>
        <?php endif; ?>
        <a href="<?= base_url('laporan') ?>" class="btn btn-outline-secondary w-100 w-sm-auto">
          <i class="ti ti-file-export me-1"></i> Export Laporan
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Statistic Cards -->
<div class="row row-deck row-cards mb-4 g-2 g-md-3">
  <div class="col-6 col-lg-3">
    <div class="card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center">
          <div class="subheader">Total Guru</div>
        </div>
        <div class="h2 h1-md mb-1 mb-md-3 me-2"><?= number_format($total_guru) ?></div>
        <div class="d-flex">
          <div class="text-muted small">Tenaga Pendidik</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center">
          <div class="subheader">Total Siswa</div>
        </div>
        <div class="h2 h1-md mb-1 mb-md-3 text-primary"><?= number_format($total_siswa) ?></div>
        <div class="d-flex">
          <div class="text-muted small">Siswa Aktif</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center">
          <div class="subheader">Jurnal Hari Ini</div>
        </div>
        <div class="h2 h1-md mb-1 mb-md-3 text-success"><?= number_format($jurnal_today) ?></div>
        <div class="d-flex">
          <div class="text-muted small">Jurnal Input</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center">
          <div class="subheader">Data Rombel</div>
        </div>
        <div class="h2 h1-md mb-1 mb-md-3 text-info"><?= number_format($total_kelas) ?></div>
        <div class="d-flex">
          <div class="text-muted small">Rombongan Belajar</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- KBM & Presensi Workflow Stats (CR-003) -->
<h3 class="mb-2 fw-bold text-indigo"><i class="ti ti-report-analytics me-1"></i>Statistik Pembelajaran & Kehadiran (Semester Aktif)</h3>
<div class="row row-deck row-cards mb-4 g-2 g-md-3">
  <!-- Card 1: Jurnal Mengajar -->
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-3">
        <div class="subheader text-muted small">Total Jurnal Mengajar</div>
        <div class="h2 fw-bold text-dark my-1"><?= number_format($total_jurnal) ?></div>
        <div class="text-muted small">Kegiatan KBM Terinput</div>
      </div>
    </div>
  </div>

  <!-- Card 2: Presensi Kelas -->
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-3">
        <div class="subheader text-muted small">Presensi Kelas / Sesi</div>
        <div class="h2 fw-bold text-indigo my-1"><?= number_format($total_presensi_kelas) ?></div>
        <div class="text-muted small">
          <span class="text-success"><i class="ti ti-check small"></i> <?= $pembelajaran_terlaksana ?> Ok</span> | 
          <span class="text-danger"><i class="ti ti-x small"></i> <?= $pembelajaran_tidak_terlaksana ?> Batal</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 3: Kehadiran Guru -->
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm" style="border-left: 4px solid #10b981 !important;">
      <div class="card-body p-3">
        <div class="subheader text-muted small">Kehadiran Mengajar Guru</div>
        <div class="h2 fw-bold text-success my-1"><?= $persen_guru ?>%</div>
        <div class="text-muted small">Rasio KBM Terlaksana</div>
      </div>
    </div>
  </div>

  <!-- Card 4: Kehadiran Siswa -->
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm" style="border-left: 4px solid #6366f1 !important;">
      <div class="card-body p-3">
        <div class="subheader text-muted small">Persentase Presensi Siswa</div>
        <div class="h2 fw-bold text-indigo my-1"><?= $persen_siswa ?>%</div>
        <div class="text-muted small">Rasio Hadir/Izin/Sakit</div>
      </div>
    </div>
  </div>
</div>

<div class="row row-cards">
  <!-- Chart -->
  <div class="col-lg-5">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="ti ti-chart-pie me-2"></i>Statistik Kehadiran Siswa Hari Ini</h3>
      </div>
      <div class="card-body">
        <canvas id="presensiChart" style="max-height: 280px;"></canvas>
      </div>
    </div>
  </div>

  <!-- Recent Jurnal Activity -->
  <div class="col-lg-7">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="ti ti-history me-2"></i>Jurnal Pembelajaran Terakhir</h3>
        <div class="card-header-actions">
          <a href="<?= base_url('jurnal') ?>" class="btn btn-sm btn-link">Lihat Semua</a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped">
          <thead>
            <tr>
              <th>Tanggal / Jam</th>
              <th>Kelas & Mapel</th>
              <th>Guru</th>
              <th>Materi</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($recent_jurnal)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">Belum ada aktivitas jurnal pembelajaran.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($recent_jurnal as $j): ?>
                <tr>
                  <td>
                    <div class="fw-bold"><?= format_indo_date($j['tanggal']) ?></div>
                    <div class="text-muted small">Jam ke-<?= html_escape($j['jam_ke']) ?></div>
                  </td>
                  <td>
                    <div class="fw-bold"><?= html_escape($j['nama_kelas']) ?></div>
                    <div class="text-muted small"><?= html_escape($j['nama_mapel']) ?></div>
                  </td>
                  <td><?= html_escape($j['nama_guru']) ?></td>
                  <td class="text-truncate" style="max-width: 180px;"><?= html_escape($j['materi_pembelajaran']) ?></td>
                  <td><?= get_badge_jurnal_status($j['status']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById('presensiChart').getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Hadir', 'Izin', 'Sakit', 'Alpa', 'Dispen'],
        datasets: [{
          data: [
            <?= $presensi_chart['Hadir'] ?? 0 ?>,
            <?= $presensi_chart['Izin'] ?? 0 ?>,
            <?= $presensi_chart['Sakit'] ?? 0 ?>,
            <?= $presensi_chart['Alpa'] ?? 0 ?>,
            <?= $presensi_chart['Dispen'] ?? 0 ?>
          ],
          backgroundColor: ['#2fb344', '#4299e1', '#f59f00', '#d63939', '#ae3ec9']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    });
  });
</script>
