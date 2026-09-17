<div class="container-xl">
  <!-- Page Header -->
  <div class="page-header d-print-none mb-4">
    <div class="row align-items-center">
      <div class="col">
        <div class="page-pretitle">Modul Supervisi Akademik</div>
        <h2 class="page-title text-indigo fw-bold">
          <i class="ti ti-school me-2"></i>Dashboard Waka Kurikulum
        </h2>
        <div class="text-muted small mt-1">
          Monitoring & Pelaksanaan Supervisi Akademik Guru (TP <?= html_escape($active_tp['tahun'] ?? '-') ?> - Semester <?= html_escape($active_tp['semester'] ?? 'Ganjil') ?>)
        </div>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="<?= base_url('supervisi/guru') ?>" class="btn btn-indigo shadow-sm">
            <i class="ti ti-list-check me-1"></i> Mulai Supervisi Guru
          </a>
          <a href="<?= base_url('supervisi/rekap') ?>" class="btn btn-outline-secondary">
            <i class="ti ti-report-analytics me-1"></i> Rekap Monitoring
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Metric Cards Row 1 -->
  <div class="row row-cards mb-4">
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm border-0 shadow-sm rounded-3">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-indigo text-white avatar rounded-3 shadow">
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
              <div class="font-weight-medium text-muted">Guru Belum Disupervisi</div>
              <div class="h2 mb-0 font-weight-bold text-warning"><?= $stats['guru_belum_disupervisi'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

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
              <div class="font-weight-medium text-muted">Guru Sudah Disupervisi</div>
              <div class="h2 mb-0 font-weight-bold text-success"><?= $stats['guru_disupervisi'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm border-0 shadow-sm rounded-3">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-danger text-white avatar rounded-3 shadow">
                <i class="ti ti-clock fs-2"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium text-muted">Supervisi Belum Selesai</div>
              <div class="h2 mb-0 font-weight-bold text-danger"><?= $stats['supervisi_berjalan'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Metric Cards Row 2 (Forms Breakdown) -->
  <div class="row row-cards mb-4">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm p-3">
        <div class="subheader text-muted">Supervisi Form 1</div>
        <div class="h2 mb-1 text-indigo"><?= $stats['total_form1'] ?> <span class="fs-6 text-muted">selesai</span></div>
        <a href="<?= base_url('supervisi/form1') ?>" class="small text-decoration-none">Administrasi Guru &rarr;</a>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm p-3">
        <div class="subheader text-muted">Supervisi Form 2</div>
        <div class="h2 mb-1 text-teal"><?= $stats['total_form2'] ?> <span class="fs-6 text-muted">selesai</span></div>
        <a href="<?= base_url('supervisi/form2') ?>" class="small text-decoration-none">RPP / Modul Ajar &rarr;</a>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm p-3">
        <div class="subheader text-muted">Supervisi Form 3</div>
        <div class="h2 mb-1 text-purple"><?= $stats['total_form3'] ?> <span class="fs-6 text-muted">selesai</span></div>
        <a href="<?= base_url('supervisi/form3') ?>" class="small text-decoration-none">Observasi Kelas &rarr;</a>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm p-3">
        <div class="subheader text-muted">Supervisi Form 4</div>
        <div class="h2 mb-1 text-pink"><?= $stats['total_form4'] ?> <span class="fs-6 text-muted">selesai</span></div>
        <a href="<?= base_url('supervisi/form4') ?>" class="small text-decoration-none">Penilaian Siswa &rarr;</a>
      </div>
    </div>
  </div>

  <!-- Charts Grid for Waka Kurikulum -->
  <div class="row row-cards mb-4">
    <!-- Chart 1: Rekap Supervisi per Form -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pb-0">
          <h3 class="card-title fw-bold text-dark">
            <i class="ti ti-chart-bar me-2 text-indigo"></i>Rekap Supervisi per Form
          </h3>
        </div>
        <div class="card-body">
          <div id="chart-form-waka" style="min-height: 280px;"></div>
        </div>
      </div>
    </div>

    <!-- Chart 2: Rekap per Mata Pelajaran -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pb-0">
          <h3 class="card-title fw-bold text-dark">
            <i class="ti ti-books me-2 text-info"></i>Rekap per Mata Pelajaran
          </h3>
        </div>
        <div class="card-body">
          <div id="chart-mapel-waka" style="min-height: 280px;"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row row-cards mb-4">
    <!-- Chart 3: Rekap Top Hasil per Guru -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pb-0">
          <h3 class="card-title fw-bold text-dark">
            <i class="ti ti-trophy me-2 text-warning"></i>Rekap Hasil Terbaik per Guru
          </h3>
        </div>
        <div class="card-body">
          <div id="chart-guru-waka" style="min-height: 280px;"></div>
        </div>
      </div>
    </div>

    <!-- Chart 4: Rekap Perkembangan per Periode -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pb-0">
          <h3 class="card-title fw-bold text-dark">
            <i class="ti ti-trending-up me-2 text-success"></i>Perkembangan Hasil Supervisi
          </h3>
        </div>
        <div class="card-body">
          <div id="chart-trend-waka" style="min-height: 280px;"></div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- ApexCharts JS -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Chart 1: Form Breakdown (Bar)
  var optionsForm = {
    series: [{
      name: 'Jumlah Supervisi Selesai',
      data: [<?= (int)$stats['total_form1'] ?>, <?= (int)$stats['total_form2'] ?>, <?= (int)$stats['total_form3'] ?>, <?= (int)$stats['total_form4'] ?>]
    }],
    chart: { type: 'bar', height: 280 },
    colors: ['#6366f1'],
    xaxis: { categories: ['Form 1 (Admin)', 'Form 2 (RPP)', 'Form 3 (Observasi)', 'Form 4 (Penilaian)'] }
  };
  new ApexCharts(document.querySelector("#chart-form-waka"), optionsForm).render();

  // Chart 2: Per Mapel
  var mapelNames = [<?php foreach ($stats['rekap_mapel'] as $m) { echo "'" . addslashes($m['nama_mapel']) . "',"; } ?>];
  var mapelScores = [<?php foreach ($stats['rekap_mapel'] as $m) { echo round($m['avg_nilai'], 1) . ","; } ?>];
  var optionsMapel = {
    series: [{ name: 'Rata-Rata Nilai', data: mapelScores }],
    chart: { type: 'bar', height: 280 },
    colors: ['#0ca678'],
    plotOptions: { bar: { horizontal: true } },
    xaxis: { categories: mapelNames, max: 100 }
  };
  new ApexCharts(document.querySelector("#chart-mapel-waka"), optionsMapel).render();

  // Chart 3: Per Guru
  var guruNames = [<?php foreach ($stats['rekap_guru'] as $g) { echo "'" . addslashes($g['nama_guru']) . "',"; } ?>];
  var guruScores = [<?php foreach ($stats['rekap_guru'] as $g) { echo round($g['avg_nilai'], 1) . ","; } ?>];
  var optionsGuru = {
    series: [{ name: 'Rata-Rata Nilai Guru', data: guruScores }],
    chart: { type: 'bar', height: 280 },
    colors: ['#f59f00'],
    plotOptions: { bar: { horizontal: true } },
    xaxis: { categories: guruNames, max: 100 }
  };
  new ApexCharts(document.querySelector("#chart-guru-waka"), optionsGuru).render();

  // Chart 4: Trend per Periode
  var trendDates = [<?php foreach ($stats['trend'] as $t) { echo "'" . $t['periode'] . "',"; } ?>];
  var trendScores = [<?php foreach ($stats['trend'] as $t) { echo round($t['avg_nilai'], 1) . ","; } ?>];
  var optionsTrend = {
    series: [{ name: 'Rata-Rata Nilai', data: trendScores }],
    chart: { type: 'line', height: 280, stroke: { curve: 'smooth' } },
    colors: ['#3b82f6'],
    xaxis: { categories: trendDates },
    yaxis: { max: 100 }
  };
  new ApexCharts(document.querySelector("#chart-trend-waka"), optionsTrend).render();
});
</script>
