<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Perangkat Ajar</div>
      <h2 class="page-title text-indigo"><i class="ti ti-dashboard me-2"></i>Dashboard Perangkat Ajar</h2>
    </div>
    <div class="col-auto ms-auto">
      <div class="btn-list">
        <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'guru'))): ?>
          <a href="<?= base_url('perangkat_ajar/upload') ?>" class="btn btn-indigo">
            <i class="ti ti-upload me-1"></i> Unggah Perangkat
          </a>
        <?php endif; ?>
        <a href="<?= base_url('perangkat_ajar/daftar') ?>" class="btn btn-outline-secondary">
          <i class="ti ti-list me-1"></i> Daftar Perangkat
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Metrics Cards -->
<div class="row row-cards mb-4">
  <!-- Total -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm border-indigo" style="box-shadow: 0 4px 12px rgba(99,102,241,0.05);">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-indigo text-white avatar"><i class="ti ti-books"></i></span>
          </div>
          <div class="col">
            <div class="font-weight-medium">Total Perangkat Ajar</div>
            <div class="text-muted small"><?= number_format($total) ?> berkas aktif</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sudah Diverifikasi -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm border-success" style="box-shadow: 0 4px 12px rgba(40,167,69,0.05);">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-success text-white avatar"><i class="ti ti-circle-check"></i></span>
          </div>
          <div class="col">
            <div class="font-weight-medium">Disetujui (Diverifikasi)</div>
            <div class="text-muted small"><?= number_format($approved) ?> berkas</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Menunggu Verifikasi -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm border-warning" style="box-shadow: 0 4px 12px rgba(255,193,7,0.05);">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-warning text-dark avatar"><i class="ti ti-hourglass-low"></i></span>
          </div>
          <div class="col">
            <div class="font-weight-medium">Menunggu Verifikasi</div>
            <div class="text-muted small"><?= number_format($pending) ?> berkas</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Perlu Revisi / Ditolak -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm border-danger" style="box-shadow: 0 4px 12px rgba(220,53,69,0.05);">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-danger text-white avatar"><i class="ti ti-alert-triangle"></i></span>
          </div>
          <div class="col">
            <div class="font-weight-medium">Revisi & Ditolak</div>
            <div class="text-muted small"><?= number_format($needs_revision) ?> revisi | <?= number_format($rejected) ?> ditolak</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row row-cards">
  <!-- Statistik Berdasarkan Mata Pelajaran -->
  <div class="col-md-6 col-lg-4">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header">
        <h3 class="card-title"><i class="ti ti-chart-bar me-2"></i>Statistik Mata Pelajaran</h3>
      </div>
      <div class="card-body">
        <?php if (empty($stats_mapel)): ?>
          <div class="text-center py-4 text-muted">Belum ada data perangkat ajar.</div>
        <?php else: ?>
          <?php foreach ($stats_mapel as $sm): ?>
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1">
                <span class="fw-medium"><?= html_escape($sm['nama_mapel']) ?></span>
                <span class="text-muted"><?= $sm['total'] ?> berkas</span>
              </div>
              <div class="progress progress-sm">
                <?php $pct = ($total > 0) ? ($sm['total'] / $total) * 100 : 0; ?>
                <div class="progress-bar bg-indigo" style="width: <?= $pct ?>%" role="progressbar" aria-valuenow="<?= $sm['total'] ?>" aria-valuemin="0" aria-valuemax="<?= $total ?>"></div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Statistik Berdasarkan Semester -->
  <div class="col-md-6 col-lg-4">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header">
        <h3 class="card-title"><i class="ti ti-chart-pie me-2"></i>Statistik per Semester</h3>
      </div>
      <div class="card-body">
        <?php if (empty($stats_semester)): ?>
          <div class="text-center py-4 text-muted">Belum ada data perangkat ajar.</div>
        <?php else: ?>
          <?php foreach ($stats_semester as $ss): ?>
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1">
                <span class="fw-medium">Semester <?= $ss['semester'] ?></span>
                <span class="text-muted"><?= $ss['total'] ?> berkas</span>
              </div>
              <div class="progress progress-sm">
                <?php $pct = ($total > 0) ? ($ss['total'] / $total) * 100 : 0; ?>
                <div class="progress-bar bg-success" style="width: <?= $pct ?>%" role="progressbar" aria-valuenow="<?= $ss['total'] ?>" aria-valuemin="0" aria-valuemax="<?= $total ?>"></div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Statistik Berdasarkan Guru (Only show to admin, waka, kamad) -->
  <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'waka', 'kamad'))): ?>
  <div class="col-md-12 col-lg-4">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header">
        <h3 class="card-title"><i class="ti ti-users me-2"></i>Statistik Kontribusi Guru</h3>
      </div>
      <div class="card-body" style="max-height: 350px; overflow-y: auto;">
        <?php if (empty($stats_guru)): ?>
          <div class="text-center py-4 text-muted">Belum ada data guru.</div>
        <?php else: ?>
          <?php foreach ($stats_guru as $sg): ?>
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1">
                <span class="fw-medium text-truncate" style="max-width: 200px;"><?= html_escape($sg['nama_lengkap']) ?></span>
                <span class="text-muted"><?= $sg['total'] ?> berkas</span>
              </div>
              <div class="progress progress-sm">
                <?php $pct = ($total > 0) ? ($sg['total'] / $total) * 100 : 0; ?>
                <div class="progress-bar bg-azure" style="width: <?= $pct ?>%" role="progressbar" aria-valuenow="<?= $sg['total'] ?>" aria-valuemin="0" aria-valuemax="<?= $total ?>"></div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>
