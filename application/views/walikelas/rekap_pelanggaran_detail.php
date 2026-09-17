<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Wali Kelas</div>
      <h2 class="page-title text-indigo"><i class="ti ti-user-exclamation me-2"></i>Detail Riwayat Pelanggaran</h2>
      <div class="text-muted small mt-1">Profile lengkap dan riwayat penanganan pelanggaran siswa.</div>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('walikelas/rekap_pelanggaran?kelas_id=' . $kelas['id']) ?>" class="btn btn-outline-secondary">
        <i class="ti ti-arrow-left me-1"></i> Kembali ke Rekap
      </a>
    </div>
  </div>
</div>

<div class="row row-cards mb-4">
  <!-- Profile Card -->
  <div class="col-md-4">
    <div class="card card-sm shadow-sm border-0 mb-3" style="border-radius: 12px; overflow: hidden;">
      <div class="card-body p-4 text-center bg-dark text-white">
        <span class="avatar avatar-xl rounded-circle mb-3 bg-indigo text-white" style="font-size: 2rem;">
          <?= strtoupper(substr($siswa['nama_lengkap'], 0, 2)) ?>
        </span>
        <h3 class="fw-bold mb-1 text-white"><?= html_escape($siswa['nama_lengkap']) ?></h3>
        <p class="text-muted small mb-3">NIS: <?= html_escape($siswa['nis']) ?> | NISN: <?= html_escape($siswa['nisn']) ?></p>
        <span class="badge bg-indigo-lt px-3 py-2 text-white">Kelas: <?= html_escape($siswa['nama_kelas']) ?></span>
      </div>
      <div class="card-body p-4">
        <div class="mb-3">
          <div class="text-muted small">Jenis Kelamin</div>
          <div class="fw-bold"><?= $siswa['jk'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Tempat & Tanggal Lahir</div>
          <div class="fw-bold"><?= html_escape($siswa['tempat_lahir'] ?? '-') ?>, <?= html_escape($siswa['tanggal_lahir'] ?? '-') ?></div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Alamat Rumah</div>
          <div class="fw-bold"><?= html_escape($siswa['alamat'] ?? '-') ?></div>
        </div>
        <div class="mb-0">
          <div class="text-muted small">Status Kehadiran</div>
          <div class="fw-bold">
            <?php if ($siswa['status_aktif'] == 1): ?>
              <span class="badge bg-success text-white">Aktif</span>
            <?php else: ?>
              <span class="badge bg-danger text-white">Non-Aktif</span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Poin Box -->
    <div class="card shadow-sm border-0" style="border-radius: 12px; border-left: 5px solid #ef4444 !important;">
      <div class="card-body text-center p-4">
        <div class="text-muted small fw-semibold uppercase mb-1">Akumulasi Poin</div>
        <?php 
          $total_poin = 0;
          foreach($timeline as $t) {
            $total_poin += $t['poin'];
          }
        ?>
        <h1 class="display-4 fw-bold text-danger mb-1"><?= $total_poin ?></h1>
        <p class="text-muted mb-0 small">Batas maksimal akumulasi poin wajar: 100 Poin</p>
      </div>
    </div>
  </div>

  <!-- Trends / Timeline -->
  <div class="col-md-8">
    <!-- Chart Card -->
    <div class="card mb-4" style="border-radius: 12px; overflow: hidden;">
      <div class="card-header bg-dark text-white">
        <h3 class="card-title text-white"><i class="ti ti-chart-line me-2"></i>Tren Pelanggaran Bulanan (Poin)</h3>
      </div>
      <div class="card-body">
        <div style="height: 250px; position: relative;">
          <canvas id="trendChartDetail"></canvas>
        </div>
      </div>
    </div>

    <!-- Timeline Card -->
    <div class="card" style="border-radius: 12px; overflow: hidden;">
      <div class="card-header bg-indigo text-white">
        <h3 class="card-title text-white"><i class="ti ti-history me-2"></i>Timeline Kasus & Tindakan</h3>
      </div>
      <div class="card-body">
        <?php if (empty($timeline)): ?>
          <div class="text-center py-5 text-muted">
            <i class="ti ti-circle-check fs-1 text-success mb-2"></i>
            <h4 class="fw-bold">Siswa bersih dari kasus pelanggaran</h4>
            <p class="mb-0 small">Belum ada catatan pelanggaran terdaftar untuk siswa ini.</p>
          </div>
        <?php else: ?>
          <div class="vertical-timeline position-relative ps-4" style="border-left: 2px solid #e2e8f0; margin-left: 10px;">
            <?php foreach ($timeline as $t): ?>
              <div class="timeline-item mb-4 position-relative">
                <!-- Dot -->
                <span class="timeline-dot position-absolute bg-danger" style="width: 12px; height: 12px; border-radius: 50%; left: -27px; top: 6px; border: 2px solid #fff;"></span>
                
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="fw-bold text-indigo" style="font-size: 1.05rem;"><?= html_escape($t['kategori']) ?></span>
                  <small class="text-muted"><i class="ti ti-calendar me-1"></i><?= date('d M Y', strtotime($t['tanggal'])) ?></small>
                </div>
                <div class="card card-sm border-0 bg-light p-3">
                  <div class="row">
                    <div class="col-8">
                      <div class="mb-2">
                        <span class="text-muted small d-block">Pelanggaran / Masalah:</span>
                        <strong class="text-dark"><?= html_escape($t['permasalahan']) ?></strong>
                      </div>
                      <div>
                        <span class="text-muted small d-block">Tindakan / Solusi:</span>
                        <span class="text-indigo fw-semibold"><?= html_escape($t['tindakan'] ? $t['tindakan'] : 'Belum ditindaklanjuti') ?></span>
                      </div>
                    </div>
                    <div class="col-4 text-end d-flex flex-column justify-content-between align-items-end">
                      <span class="badge bg-danger-lt px-2 py-1">+ <?= $t['poin'] ?> Poin</span>
                      <small class="text-muted mt-2">Oleh: <?= html_escape($t['nama_wali'] ? $t['nama_wali'] : 'Wali Kelas') ?></small>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Chart Script -->
<?php
  $labels = [];
  $poin_data = [];
  foreach ($trends as $tr) {
      $labels[] = date('M Y', strtotime($tr['bulan'] . '-01'));
      $poin_data[] = (int)$tr['total_poin'];
  }
  // Fill in current month if empty
  if (empty($labels)) {
      $labels[] = date('M Y');
      $poin_data[] = 0;
  }
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('trendChartDetail').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
          label: 'Poin Pelanggaran',
          data: <?= json_encode($poin_data) ?>,
          borderColor: '#ef4444',
          backgroundColor: 'rgba(239, 68, 68, 0.1)',
          borderWidth: 3,
          tension: 0.3,
          fill: true,
          pointBackgroundColor: '#ef4444',
          pointRadius: 5
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 5
            }
          }
        }
      }
    });
  });
</script>
