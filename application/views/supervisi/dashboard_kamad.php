<div class="container-xl">
  <!-- Page Header -->
  <div class="page-header d-print-none mb-4">
    <div class="row align-items-center">
      <div class="col">
        <div class="page-pretitle">Modul Supervisi Akademik</div>
        <h2 class="page-title text-primary fw-bold">
          <i class="ti ti-dashboard me-2"></i>Dashboard Kepala Madrasah
        </h2>
        <div class="text-muted small mt-1">
          Monitoring & Evaluasi Supervisi Akademik Guru MA Darul Faqih Indonesia (<?= html_escape($active_tp['tahun'] ?? '-') ?> - Semester <?= html_escape($active_tp['semester'] ?? 'Ganjil') ?>)
        </div>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="<?= base_url('supervisi/guru') ?>" class="btn btn-primary shadow-sm">
            <i class="ti ti-plus me-1"></i> Mulai Supervisi Guru
          </a>
          <a href="<?= base_url('supervisi/rekap') ?>" class="btn btn-outline-secondary">
            <i class="ti ti-report-analytics me-1"></i> Rekap Supervisi
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Metric Cards Grid (10 Metrics) -->
  <div class="row row-cards mb-4">
    <!-- Card 1: Total Guru -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm border-0 shadow-sm rounded-3">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-primary text-white avatar rounded-3 shadow">
                <i class="ti ti-users fs-2"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium text-muted">Total Guru</div>
              <div class="h2 mb-0 font-weight-bold text-dark"><?= $stats['total_guru'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2: Guru Sudah Disupervisi -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm border-0 shadow-sm rounded-3">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-success text-white avatar rounded-3 shadow">
                <i class="ti ti-user-check fs-2"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium text-muted">Sudah Disupervisi</div>
              <div class="h2 mb-0 font-weight-bold text-success"><?= $stats['guru_disupervisi'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3: Guru Belum Disupervisi -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm border-0 shadow-sm rounded-3">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-warning text-white avatar rounded-3 shadow">
                <i class="ti ti-user-x fs-2"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium text-muted">Belum Disupervisi</div>
              <div class="h2 mb-0 font-weight-bold text-warning"><?= $stats['guru_belum_disupervisi'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 4: Rata-Rata Nilai -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm border-0 shadow-sm rounded-3">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-info text-white avatar rounded-3 shadow">
                <i class="ti ti-award fs-2"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium text-muted">Rata-Rata Hasil</div>
              <div class="h2 mb-0 font-weight-bold text-info"><?= number_format($stats['rata_rata_hasil'], 1) ?> <span class="fs-6 text-muted">/ 100</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 2: Status Breakdown & Form Metrics -->
  <div class="row row-cards mb-4">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm p-3">
        <div class="d-flex align-items-center">
          <div class="subheader text-muted">Supervisi Berjalan</div>
        </div>
        <div class="h1 mb-1 text-primary"><?= $stats['supervisi_berjalan'] ?></div>
        <div class="text-muted small">Status Draft & Dalam Proses</div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm p-3">
        <div class="d-flex align-items-center">
          <div class="subheader text-muted">Supervisi Selesai</div>
        </div>
        <div class="h1 mb-1 text-success"><?= $stats['supervisi_selesai'] ?></div>
        <div class="text-muted small">Status Selesai Dikunci</div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm p-3">
        <div class="d-flex align-items-center">
          <div class="subheader text-muted">Form 1 (Administrasi)</div>
        </div>
        <div class="h2 mb-1 text-indigo"><?= $stats['total_form1'] ?> <span class="fs-6 text-muted">selesai</span></div>
        <a href="<?= base_url('supervisi/form1') ?>" class="small text-decoration-none">Buka Form 1 &rarr;</a>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm p-3">
        <div class="d-flex align-items-center">
          <div class="subheader text-muted">Form 2 (RPP/Modul Ajar)</div>
        </div>
        <div class="h2 mb-1 text-teal"><?= $stats['total_form2'] ?> <span class="fs-6 text-muted">selesai</span></div>
        <a href="<?= base_url('supervisi/form2') ?>" class="small text-decoration-none">Buka Form 2 &rarr;</a>
      </div>
    </div>
  </div>

  <div class="row row-cards mb-4">
    <div class="col-sm-6 col-lg-6">
      <div class="card border-0 shadow-sm p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div class="subheader text-muted">Form 3 (Observasi Kelas)</div>
          <span class="badge bg-purple-lt"><?= $stats['total_form3'] ?> Selesai</span>
        </div>
        <div class="d-flex align-items-center mt-2 justify-content-between">
          <span class="text-muted small">Pelaksanaan Pembelajaran Kelas</span>
          <a href="<?= base_url('supervisi/form3') ?>" class="btn btn-sm btn-outline-purple">Buka Form 3 &rarr;</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-6">
      <div class="card border-0 shadow-sm p-3">
        <div class="d-flex align-items-center justify-content-between">
          <div class="subheader text-muted">Form 4 (Supervisi Penilaian)</div>
          <span class="badge bg-pink-lt"><?= $stats['total_form4'] ?> Selesai</span>
        </div>
        <div class="d-flex align-items-center mt-2 justify-content-between">
          <span class="text-muted small">Proses & Hasil Belajar Siswa</span>
          <a href="<?= base_url('supervisi/form4') ?>" class="btn btn-sm btn-outline-pink">Buka Form 4 &rarr;</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="row row-cards mb-4">
    <!-- Progress Supervisi Chart -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pb-0">
          <h3 class="card-title fw-bold text-dark">
            <i class="ti ti-chart-pie me-2 text-primary"></i>Progress Supervisi Guru
          </h3>
        </div>
        <div class="card-body">
          <div id="chart-progress" style="min-height: 280px;"></div>
        </div>
      </div>
    </div>

    <!-- Rekap Rata-Rata Hasil per Form -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pb-0">
          <h3 class="card-title fw-bold text-dark">
            <i class="ti ti-chart-bar me-2 text-success"></i>Rata-Rata Hasil Supervisi per Form
          </h3>
        </div>
        <div class="card-body">
          <div id="chart-form-avg" style="min-height: 280px;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Supervisions Table -->
  <div class="card border-0 shadow-sm mb-5">
    <div class="card-header bg-transparent d-flex align-items-center justify-content-between">
      <h3 class="card-title fw-bold text-dark mb-0">
        <i class="ti ti-history me-2 text-info"></i>Daftar Supervisi Terbaru
      </h3>
      <a href="<?= base_url('supervisi/rekap') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua Rekap</a>
    </div>
    <div class="table-responsive">
      <table class="table table-vcenter card-table table-hover">
        <thead>
          <tr class="bg-light">
            <th class="w-1">No</th>
            <th>Nama Guru</th>
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            <th>Supervisor</th>
            <th>Form</th>
            <th>Tanggal</th>
            <th>Nilai</th>
            <th>Status</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($stats['supervisi_terbaru'])): ?>
            <tr>
              <td colspan="10" class="text-center py-4 text-muted">Belum ada data supervisi akademik.</td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($stats['supervisi_terbaru'] as $sup): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <div class="fw-bold text-dark"><?= html_escape($sup['nama_guru']) ?></div>
                  <div class="small text-muted">NIP: <?= html_escape($sup['nip_guru'] ?? '-') ?></div>
                </td>
                <td><?= html_escape($sup['nama_mapel'] ?? '-') ?></td>
                <td><span class="badge bg-blue-lt"><?= html_escape($sup['nama_kelas'] ?? '-') ?></span></td>
                <td><?= html_escape($sup['nama_supervisor'] ?? 'Supervisor') ?></td>
                <td><span class="badge bg-indigo-lt"><?= html_escape($sup['kode_form']) ?></span></td>
                <td><?= date('d/m/Y', strtotime($sup['tanggal_supervisi'])) ?></td>
                <td>
                  <span class="fw-bold fs-3 <?= $sup['nilai_akhir'] >= 80 ? 'text-success' : ($sup['nilai_akhir'] >= 70 ? 'text-primary' : 'text-warning') ?>">
                    <?= number_format($sup['nilai_akhir'], 1) ?>
                  </span>
                </td>
                <td>
                  <?php if ($sup['status'] == 'SELESAI'): ?>
                    <span class="badge bg-success">Selesai</span>
                  <?php elseif ($sup['status'] == 'DALAM PROSES'): ?>
                    <span class="badge bg-warning">Dalam Proses</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">Draft</span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <div class="btn-list flex-nowrap justify-content-end">
                    <a href="<?= base_url('supervisi/form' . $sup['form_id'] . '?id=' . $sup['id']) ?>" class="btn btn-sm btn-outline-primary" title="Detail / Edit">
                      <i class="ti ti-eye"></i>
                    </a>
                    <a href="<?= base_url('supervisi/export_pdf/' . $sup['id']) ?>" class="btn btn-sm btn-outline-danger" target="_blank" title="Cetak PDF">
                      <i class="ti ti-file-pdf"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ApexCharts JS -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Chart Progress Supervisi (Donut)
  var optionsProgress = {
    series: [<?= (int)$stats['guru_disupervisi'] ?>, <?= (int)$stats['guru_belum_disupervisi'] ?>],
    chart: { type: 'donut', height: 280 },
    labels: ['Sudah Disupervisi', 'Belum Disupervisi'],
    colors: ['#2fb344', '#f59f00'],
    legend: { position: 'bottom' },
    dataLabels: { enabled: true }
  };
  var chartProgress = new ApexCharts(document.querySelector("#chart-progress"), optionsProgress);
  chartProgress.render();

  // Chart Form Average (Bar)
  var optionsFormAvg = {
    series: [{
      name: 'Rata-Rata Nilai',
      data: [
        <?= (float)($stats['chart_form_avg']['Form 1'] ?? 0) ?>,
        <?= (float)($stats['chart_form_avg']['Form 2'] ?? 0) ?>,
        <?= (float)($stats['chart_form_avg']['Form 3'] ?? 0) ?>,
        <?= (float)($stats['chart_form_avg']['Form 4'] ?? 0) ?>
      ]
    }],
    chart: { type: 'bar', height: 280 },
    plotOptions: { bar: { borderRadius: 6, horizontal: false, columnWidth: '45%' } },
    colors: ['#4263eb'],
    xaxis: { categories: ['Form 1', 'Form 2', 'Form 3', 'Form 4'] },
    yaxis: { max: 100 }
  };
  var chartFormAvg = new ApexCharts(document.querySelector("#chart-form-avg"), optionsFormAvg);
  chartFormAvg.render();
});
</script>
