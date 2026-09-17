<?php if (isset($kelas['is_admin_mode']) && $kelas['is_admin_mode']): ?>
<div class="card mb-4 d-print-none border-0 shadow-sm overflow-hidden position-relative" style="border-radius: 12px; background: linear-gradient(135deg, #eff6ff 0%, #f5f3ff 100%); border-left: 5px solid #6366f1 !important;">
  <div class="card-body py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div class="d-flex align-items-center gap-2">
      <span class="avatar avatar-sm bg-indigo text-white rounded-3">
        <i class="ti ti-shield-check fs-3"></i>
      </span>
      <div>
        <h4 class="mb-0 fw-bold text-indigo">Simulasi Wali Kelas (Mode Admin)</h4>
        <p class="text-muted small mb-0">Anda sedang mengakses halaman khusus wali kelas. Silakan pilih kelas binaan:</p>
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <span class="text-muted small fw-semibold"><i class="ti ti-building me-1"></i>Pilih Kelas:</span>
      <div style="width: 200px;">
        <select class="form-select form-select-sm fw-bold border-indigo" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(99, 102, 241, 0.1);" onchange="location = '<?= base_url($this->uri->uri_string()) ?>?kelas_id=' + this.value;">
          <?php foreach ($kelas['list_kelas_all'] as $k): ?>
            <option value="<?= $k['id'] ?>" <?= ($kelas['id'] == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Wali Kelas</div>
      <h2 class="page-title">Wali Kelas Dashboard: Kelas <?= html_escape($kelas['nama_kelas']) ?></h2>
      <div class="text-muted small mt-1">Pantau perkembangan program kelas, log pembinaan/kasus siswa, serta aktivitas kokurikuler.</div>
    </div>
  </div>
</div>

<div class="row row-cards g-3">
  <!-- Card 1: Total Siswa -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar bg-blue text-white rounded-3 me-3"><i class="ti ti-users fs-2"></i></span>
          <div>
            <div class="text-muted small">Total Siswa Binaan</div>
            <div class="h2 mb-0 fw-bold"><?= $total_siswa ?> Siswa</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 2: Program Kerja Kelas Realized -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar bg-success text-white rounded-3 me-3"><i class="ti ti-checklist fs-2"></i></span>
          <div>
            <div class="text-muted small">Realisasi Program Kerja</div>
            <div class="h2 mb-0 fw-bold"><?= $done_program ?> / <?= $total_program ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 3: Solved Cases -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar bg-teal text-white rounded-3 me-3"><i class="ti ti-heart-handshake fs-2"></i></span>
          <div>
            <div class="text-muted small">Kasus Selesai Ditangani</div>
            <div class="h2 mb-0 fw-bold"><?= $solved_cases ?> Kasus</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 4: Pending cases -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar bg-danger text-white rounded-3 me-3"><i class="ti ti-alert-circle fs-2"></i></span>
          <div>
            <div class="text-muted small">Kasus Dalam Monitoring</div>
            <div class="h2 mb-0 fw-bold"><?= $pending_cases ?> Kasus</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row row-cards mt-3">
  <!-- Program Kerja Realization Progress Graph / Card -->
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title text-white"><i class="ti ti-chart-pie me-2"></i>Progres Program Kerja</h3>
      </div>
      <div class="card-body text-center d-flex flex-column justify-content-center align-items-center py-5">
        <div class="position-relative d-inline-flex mb-3">
          <!-- Premium Circular Progress bar using pure CSS gradients -->
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 140px; height: 140px; background: radial-gradient(closest-side, white 79%, transparent 80% 100%), conic-gradient(#6366f1 <?= $percent_program ?>%, #e2e8f0 0);">
            <span class="fs-1 fw-bold text-indigo"><?= $percent_program ?>%</span>
          </div>
        </div>
        <div class="h3 fw-bold mb-1">Realisasi Target Program</div>
        <p class="text-muted small">Dari total <?= $total_program ?> rencana program kelas yang disusun untuk semester ini.</p>
        <a href="<?= base_url('walikelas/program_kelas') ?>" class="btn btn-outline-primary mt-2">
          <i class="ti ti-edit me-1"></i> Kelola Program Kerja
        </a>
      </div>
    </div>
  </div>

  <!-- Recent Cases -->
  <div class="col-md-8">
    <div class="card h-100">
      <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title text-white"><i class="ti ti-user-exclamation me-2"></i>Jurnal Pembinaan & Kasus Terkini</h3>
        <a href="<?= base_url('walikelas/penanganan_siswa') ?>" class="btn btn-sm btn-outline-light text-white">
          <i class="ti ti-plus me-1"></i> Kasus Baru
        </a>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Nama Siswa</th>
              <th>Permasalahan</th>
              <th>Kategori</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($recent_cases)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">Belum ada catatan penanganan kasus siswa.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($recent_cases as $c): ?>
                <tr>
                  <td><?= date('d/m/Y', strtotime($c['tanggal'])) ?></td>
                  <td class="fw-bold text-indigo"><?= html_escape($c['nama_siswa']) ?></td>
                  <td class="small" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= html_escape($c['permasalahan']) ?></td>
                  <td>
                    <span class="badge bg-secondary-lt"><?= html_escape($c['kategori']) ?></span>
                  </td>
                  <td>
                    <?php if ($c['status'] == 'Selesai'): ?>
                      <span class="badge bg-success text-white">Selesai</span>
                    <?php elseif ($c['status'] == 'Monitoring'): ?>
                      <span class="badge bg-warning text-white">Monitoring</span>
                    <?php else: ?>
                      <span class="badge bg-danger text-white">Proses</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
