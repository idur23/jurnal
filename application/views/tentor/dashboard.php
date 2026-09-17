<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-primary fw-bold">DASHBOARD TENTOR MBF</div>
        <h2 class="page-title text-dark">
          Selamat Datang, <span class="text-primary ms-1"><?= html_escape($tentor['nama_lengkap'] ?? 'Tentor MBF') ?></span> 👋
        </h2>
      </div>
      <div class="col-auto ms-auto">
        <span class="badge bg-primary-lt fs-3 px-3 py-2">
          <i class="ti ti-calendar me-1"></i> <?= date('d F Y') ?>
        </span>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <!-- STATISTIK TENTOR -->
    <div class="row row-cards mb-4">
      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm border-0 shadow-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-info text-white avatar shadow-sm fs-2">
                  <i class="ti ti-books"></i>
                </span>
              </div>
              <div class="col">
                <div class="subheader">Total Mapel Diampu</div>
                <div class="h1 mb-0 fw-bold text-info"><?= (int)($stats['total_mapel'] ?? 0) ?> Mapel</div>
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
                <span class="bg-success text-white avatar shadow-sm fs-2">
                  <i class="ti ti-users"></i>
                </span>
              </div>
              <div class="col">
                <div class="subheader">Total Siswa Diampu</div>
                <div class="h1 mb-0 fw-bold text-success"><?= (int)($stats['total_siswa'] ?? 0) ?> Siswa</div>
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
                <span class="bg-warning text-white avatar shadow-sm fs-2">
                  <i class="ti ti-calendar-event"></i>
                </span>
              </div>
              <div class="col">
                <div class="subheader">Pertemuan Bulan Ini</div>
                <div class="h1 mb-0 fw-bold text-warning"><?= (int)($stats['pertemuan_bulan_ini'] ?? 0) ?> Kali</div>
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
                <span class="bg-primary text-white avatar shadow-sm fs-2">
                  <i class="ti ti-user-check"></i>
                </span>
              </div>
              <div class="col">
                <div class="subheader">Kehadiran Hari Ini</div>
                <div class="h1 mb-0 fw-bold text-primary"><?= (int)($stats['kehadiran_hari_ini']['Hadir'] ?? 0) ?> Siswa</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- QUICK MENU UTAMA -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title text-dark mb-0"><i class="ti ti-apps me-2 text-primary"></i> MENU UTAMA TENTOR</h3>
      </div>
      <div class="card-body py-3">
        <div class="row g-3">
          <div class="col-6 col-md-3">
            <a href="<?= base_url('tentor/presensi') ?>" class="btn btn-warning w-100 py-3 text-start d-flex align-items-center shadow-sm">
              <i class="ti ti-notebook fs-1 me-3 text-dark"></i>
              <div>
                <div class="fw-bold fs-3 text-dark">Jurnal & Presensi</div>
                <div class="small text-dark opacity-75">Input Jurnal & Presensi MBF</div>
              </div>
            </a>
          </div>

          <div class="col-6 col-md-3">
            <a href="<?= base_url('tentor/mapel') ?>" class="btn btn-outline-info w-100 py-3 text-start d-flex align-items-center shadow-sm">
              <i class="ti ti-books fs-1 me-3 text-info"></i>
              <div>
                <div class="fw-bold fs-3 text-dark">Mapel Saya</div>
                <div class="small text-muted">Daftar Mapel Diampu</div>
              </div>
            </a>
          </div>

          <div class="col-6 col-md-3">
            <a href="<?= base_url('tentor/peserta') ?>" class="btn btn-outline-success w-100 py-3 text-start d-flex align-items-center shadow-sm">
              <i class="ti ti-users fs-1 me-3 text-success"></i>
              <div>
                <div class="fw-bold fs-3 text-dark">Peserta Saya</div>
                <div class="small text-muted">Siswa Bimbingan</div>
              </div>
            </a>
          </div>

          <div class="col-6 col-md-3">
            <a href="<?= base_url('tentor/rekap') ?>" class="btn btn-outline-indigo w-100 py-3 text-start d-flex align-items-center shadow-sm">
              <i class="ti ti-chart-bar fs-1 me-3 text-indigo"></i>
              <div>
                <div class="fw-bold fs-3 text-dark">Rekap Presensi</div>
                <div class="small text-muted">Rekapitulasi Kehadiran</div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- RECENT PRESENSI -->
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h3 class="card-title text-dark mb-0"><i class="ti ti-history me-2 text-warning"></i> RIWAYAT PRESENSI TERAKHIR</h3>
        <a href="<?= base_url('tentor/presensi') ?>" class="btn btn-sm btn-primary"><i class="ti ti-plus me-1"></i> Presensi Baru</a>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead class="bg-light">
            <tr>
              <th width="50">No</th>
              <th>Tanggal</th>
              <th>Mapel MBF</th>
              <th class="text-center">Pertemuan Ke</th>
              <th class="text-center">Siswa Hadir</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($stats['recent_presensi'])): ?>
              <?php $no = 1; foreach ($stats['recent_presensi'] as $p): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td class="fw-bold text-dark"><?= date('d-m-Y', strtotime($p['tanggal'])) ?></td>
                  <td class="fw-bold text-primary"><?= html_escape($p['nama_mapel']) ?></td>
                  <td class="text-center"><span class="badge bg-secondary-lt">Ke-<?= $p['pertemuan_ke'] ?></span></td>
                  <td class="text-center"><span class="badge bg-success-lt fs-3 px-3"><?= (int)$p['count_hadir'] ?> Siswa</span></td>
                  <td class="text-center">
                    <a href="<?= base_url('tentor/presensi?mapel_id=' . $p['mapel_mbf_id'] . '&tanggal=' . $p['tanggal']) ?>" class="btn btn-sm btn-outline-primary">
                      <i class="ti ti-edit me-1"></i> Edit Presensi
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat presensi yang diinput.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
