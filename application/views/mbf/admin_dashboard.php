<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL MBF</div>
        <h2 class="page-title">
          <i class="ti ti-school me-2 text-primary"></i> DASHBOARD ADMIN MBF
        </h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <span class="badge bg-primary-lt fs-4 px-3 py-2">
          <i class="ti ti-calendar me-1"></i> TP <?= html_escape($active_tp['tahun'] ?? '-') ?> (<?= html_escape($active_tp['semester'] ?? '-') ?>)
        </span>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    
    <!-- STATISTIK MBF -->
    <div class="row row-cards mb-4">
      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm border-0 shadow-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-primary text-white avatar shadow-sm">
                  <i class="ti ti-user-check fs-2"></i>
                </span>
              </div>
              <div class="col">
                <div class="subheader">Total Tentor</div>
                <div class="h1 mb-0 fw-bold text-dark"><?= (int)($stats['total_tentor'] ?? 0) ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm border-0 shadow-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-info text-white avatar shadow-sm">
                  <i class="ti ti-books fs-2"></i>
                </span>
              </div>
              <div class="col">
                <div class="subheader">Total Mapel MBF</div>
                <div class="h1 mb-0 fw-bold text-info"><?= (int)($stats['total_mapel'] ?? 0) ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm border-0 shadow-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-success text-white avatar shadow-sm">
                  <i class="ti ti-users fs-2"></i>
                </span>
              </div>
              <div class="col">
                <div class="subheader">Total Siswa MBF</div>
                <div class="h1 mb-0 fw-bold text-success"><?= (int)($stats['total_siswa_mbf'] ?? 0) ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm border-0 shadow-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-warning text-white avatar shadow-sm">
                  <i class="ti ti-clipboard-list fs-2"></i>
                </span>
              </div>
              <div class="col">
                <div class="subheader">Total Enrollment</div>
                <div class="h1 mb-0 fw-bold text-warning"><?= (int)($stats['total_peserta'] ?? 0) ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- QUICK MENU NAVIGATION -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title text-dark mb-0"><i class="ti ti-apps me-2 text-primary"></i> MENU UTAMA MBF</h3>
      </div>
      <div class="card-body py-3">
        <div class="row g-3">
          <div class="col-6 col-md-3">
            <a href="<?= base_url('mbf/tentor') ?>" class="btn btn-outline-primary w-100 py-3 text-start d-flex align-items-center shadow-sm">
              <i class="ti ti-user-check fs-1 me-3 text-primary"></i>
              <div>
                <div class="fw-bold fs-3 text-dark">Tentor MBF</div>
                <div class="small text-muted">Kelola Data Tentor</div>
              </div>
            </a>
          </div>

          <div class="col-6 col-md-3">
            <a href="<?= base_url('mbf/mapel') ?>" class="btn btn-outline-info w-100 py-3 text-start d-flex align-items-center shadow-sm">
              <i class="ti ti-books fs-1 me-3 text-info"></i>
              <div>
                <div class="fw-bold fs-3 text-dark">Mapel MBF</div>
                <div class="small text-muted">Kelola Pelajaran & Peserta</div>
              </div>
            </a>
          </div>

          <div class="col-6 col-md-3">
            <a href="<?= base_url('mbf/siswa') ?>" class="btn btn-outline-success w-100 py-3 text-start d-flex align-items-center shadow-sm">
              <i class="ti ti-users fs-1 me-3 text-success"></i>
              <div>
                <div class="fw-bold fs-3 text-dark">Siswa MBF</div>
                <div class="small text-muted">Roster Siswa Terdaftar</div>
              </div>
            </a>
          </div>

          <div class="col-6 col-md-3">
            <a href="<?= base_url('mbf/presensi') ?>" class="btn btn-outline-warning w-100 py-3 text-start d-flex align-items-center shadow-sm">
              <i class="ti ti-calendar-event fs-1 me-3 text-warning"></i>
              <div>
                <div class="fw-bold fs-3 text-dark">Presensi MBF</div>
                <div class="small text-muted">Monitoring Absensi</div>
              </div>
            </a>
          </div>

          <div class="col-6 col-md-3">
            <a href="<?= base_url('mbf/rekap') ?>" class="btn btn-outline-indigo w-100 py-3 text-start d-flex align-items-center shadow-sm">
              <i class="ti ti-chart-bar fs-1 me-3 text-indigo"></i>
              <div>
                <div class="fw-bold fs-3 text-dark">Rekap Presensi</div>
                <div class="small text-muted">Ringkasan Kehadiran</div>
              </div>
            </a>
          </div>

          <div class="col-6 col-md-3">
            <a href="<?= base_url('mbf/laporan') ?>" class="btn btn-outline-danger w-100 py-3 text-start d-flex align-items-center shadow-sm">
              <i class="ti ti-file-report fs-1 me-3 text-danger"></i>
              <div>
                <div class="fw-bold fs-3 text-dark">Laporan MBF</div>
                <div class="small text-muted">Cetak PDF / Excel / Print</div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- RECENT MAPEL TABLE -->
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h3 class="card-title text-dark mb-0"><i class="ti ti-list me-2 text-info"></i> DAFTAR MAPEL MBF AKTIF</h3>
        <a href="<?= base_url('mbf/mapel') ?>" class="btn btn-sm btn-primary"><i class="ti ti-plus me-1"></i> Tambah Mapel</a>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead class="bg-light">
            <tr>
              <th width="50">No</th>
              <th>Kode</th>
              <th>Nama Mapel MBF</th>
              <th>Tentor Pengajar</th>
              <th class="text-center">Jumlah Peserta</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($list_mapel)): ?>
              <?php $no = 1; foreach ($list_mapel as $m): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><span class="badge bg-secondary-lt fs-3"><?= html_escape($m['kode_mapel']) ?></span></td>
                  <td class="fw-bold text-dark fs-3"><?= html_escape($m['nama_mapel']) ?></td>
                  <td><i class="ti ti-user-check text-info me-1"></i> <?= html_escape($m['nama_tentor']) ?></td>
                  <td class="text-center">
                    <span class="badge bg-success-lt fs-3 px-3"><?= (int)$m['total_peserta'] ?> Siswa</span>
                  </td>
                  <td class="text-center">
                    <a href="<?= base_url('mbf/peserta/' . $m['id']) ?>" class="btn btn-sm btn-outline-info">
                      <i class="ti ti-users me-1"></i> Kelola Peserta
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-4">Belum ada data Mapel MBF. Silakan tambahkan Mapel MBF baru.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
