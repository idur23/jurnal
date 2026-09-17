<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-chart-bar me-2 text-indigo"></i> REKAPITULASI PRESENSI MBF
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <!-- TABS MENU -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white border-bottom">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
          <li class="nav-item">
            <a href="<?= base_url('mbf/rekap?type=mapel') ?>" class="nav-link <?= ($type == 'mapel') ? 'active fw-bold text-primary' : 'text-muted' ?>">
              <i class="ti ti-books me-1"></i> Rekap Per Mapel
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('mbf/rekap?type=siswa') ?>" class="nav-link <?= ($type == 'siswa') ? 'active fw-bold text-primary' : 'text-muted' ?>">
              <i class="ti ti-user me-1"></i> Rekap Per Siswa
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('mbf/rekap?type=tentor') ?>" class="nav-link <?= ($type == 'tentor') ? 'active fw-bold text-primary' : 'text-muted' ?>">
              <i class="ti ti-user-check me-1"></i> Rekap Per Tentor
            </a>
          </li>
        </ul>
      </div>

      <div class="card-body">
        <form action="<?= base_url('mbf/rekap') ?>" method="GET" class="row g-3">
          <input type="hidden" name="type" value="<?= html_escape($type) ?>">

          <?php if ($type == 'mapel'): ?>
            <div class="col-md-5">
              <label class="form-label required">Pilih Mapel MBF</label>
              <select name="mapel_id" class="form-select" required>
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($list_mapel as $m): ?>
                  <option value="<?= $m['id'] ?>" <?= (isset($filters['mapel_id']) && $filters['mapel_id'] == $m['id']) ? 'selected' : '' ?>>
                    <?= html_escape($m['nama_mapel']) ?> (Tentor: <?= html_escape($m['nama_tentor']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          <?php elseif ($type == 'siswa'): ?>
            <div class="col-md-5">
              <label class="form-label required">Pilih Siswa</label>
              <select name="siswa_id" class="form-select" required>
                <option value="">-- Pilih Siswa --</option>
                <?php foreach ($list_siswa as $s): ?>
                  <option value="<?= $s['id'] ?>" <?= (isset($filters['siswa_id']) && $filters['siswa_id'] == $s['id']) ? 'selected' : '' ?>>
                    <?= html_escape($s['nama_lengkap']) ?> (NIS: <?= html_escape($s['nis']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          <?php elseif ($type == 'tentor'): ?>
            <div class="col-md-5">
              <label class="form-label required">Pilih Tentor</label>
              <select name="tentor_id" class="form-select" required>
                <option value="">-- Pilih Tentor --</option>
                <?php foreach ($list_tentor as $t): ?>
                  <option value="<?= $t['id'] ?>" <?= (isset($filters['tentor_id']) && $filters['tentor_id'] == $t['id']) ? 'selected' : '' ?>>
                    <?= html_escape($t['nama_lengkap']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          <?php endif; ?>

          <div class="col-md-3">
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-select">
              <option value="">-- Semua Bulan --</option>
              <?php 
              $months = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
              foreach ($months as $num => $m_name): ?>
                <option value="<?= $num ?>" <?= (isset($filters['bulan']) && $filters['bulan'] == $num) ? 'selected' : '' ?>><?= $m_name ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4 text-end d-flex gap-2 align-items-end">
            <button type="submit" class="btn btn-primary flex-fill"><i class="ti ti-filter me-1"></i> Tampilkan Rekap</button>
            <?php if ($type == 'mapel' && !empty($filters['mapel_id'])): ?>
              <a href="<?= base_url('mbf/export_pdf?mapel_id=' . $filters['mapel_id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="ti ti-file-type-pdf"></i> PDF</a>
              <a href="<?= base_url('mbf/export_excel?mapel_id=' . $filters['mapel_id']) ?>" class="btn btn-outline-success"><i class="ti ti-file-spreadsheet"></i> Excel</a>
              <a href="<?= base_url('mbf/print_rekap?mapel_id=' . $filters['mapel_id']) ?>" target="_blank" class="btn btn-outline-info"><i class="ti ti-printer"></i> Print</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>

    <!-- REKAP RESULT TABLE -->
    <?php if ($type == 'mapel' && !empty($selected_mapel)): ?>
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h3 class="card-title text-dark mb-0">
            REKAP PRESENSI MAPEL: <strong class="text-success"><?= html_escape($selected_mapel['nama_mapel']) ?></strong>
            <span class="small text-muted ms-2">(Tentor: <?= html_escape($selected_mapel['nama_tentor']) ?>)</span>
          </h3>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter table-hover card-table">
            <thead class="bg-light">
              <tr>
                <th width="50">No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas Reguler</th>
                <th class="text-center text-success">Hadir</th>
                <th class="text-center text-info">Izin</th>
                <th class="text-center text-warning">Sakit</th>
                <th class="text-center text-danger">Alpa</th>
                <th class="text-center">Total</th>
                <th class="text-center">% Kehadiran</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($rekap_data)): ?>
                <?php $no = 1; foreach ($rekap_data as $r): $s = $r['siswa']; ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><span class="badge bg-secondary-lt"><?= html_escape($s['nis']) ?></span></td>
                    <td class="fw-bold text-dark fs-3"><?= html_escape($s['nama_lengkap']) ?></td>
                    <td><span class="badge bg-info-lt"><?= html_escape($s['nama_kelas']) ?></span></td>
                    <td class="text-center fw-bold text-success fs-3"><?= $r['Hadir'] ?></td>
                    <td class="text-center fw-bold text-info fs-3"><?= $r['Izin'] ?></td>
                    <td class="text-center fw-bold text-warning fs-3"><?= $r['Sakit'] ?></td>
                    <td class="text-center fw-bold text-danger fs-3"><?= $r['Alpa'] ?></td>
                    <td class="text-center fw-bold fs-3"><?= $r['total'] ?></td>
                    <td class="text-center">
                      <span class="badge <?= ($r['persentase'] >= 85) ? 'bg-success-lt' : (($r['persentase'] >= 75) ? 'bg-warning-lt' : 'bg-danger-lt') ?> fs-3 px-3">
                        <?= $r['persentase'] ?>%
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="10" class="text-center text-muted py-4">Belum ada data presensi untuk mapel ini.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php elseif ($type == 'siswa' && !empty($selected_siswa)): ?>
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h3 class="card-title text-dark mb-0">
            REKAP PRESENSI SISWA: <strong class="text-success"><?= html_escape($selected_siswa['nama_lengkap']) ?></strong>
            <span class="small text-muted ms-2">(NIS: <?= html_escape($selected_siswa['nis']) ?>)</span>
          </h3>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter table-hover card-table">
            <thead class="bg-light">
              <tr>
                <th width="50">No</th>
                <th>Mapel MBF</th>
                <th>Tentor Pengajar</th>
                <th class="text-center text-success">Hadir</th>
                <th class="text-center text-info">Izin</th>
                <th class="text-center text-warning">Sakit</th>
                <th class="text-center text-danger">Alpa</th>
                <th class="text-center">Total</th>
                <th class="text-center">% Kehadiran</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($rekap_data)): ?>
                <?php $no = 1; foreach ($rekap_data as $r): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td class="fw-bold text-success fs-3"><?= html_escape($r['nama_mapel']) ?></td>
                    <td><i class="ti ti-user-check me-1 text-info"></i> <?= html_escape($r['nama_tentor']) ?></td>
                    <td class="text-center fw-bold text-success fs-3"><?= $r['Hadir'] ?></td>
                    <td class="text-center fw-bold text-info fs-3"><?= $r['Izin'] ?></td>
                    <td class="text-center fw-bold text-warning fs-3"><?= $r['Sakit'] ?></td>
                    <td class="text-center fw-bold text-danger fs-3"><?= $r['Alpa'] ?></td>
                    <td class="text-center fw-bold fs-3"><?= $r['total'] ?></td>
                    <td class="text-center">
                      <span class="badge <?= ($r['persentase'] >= 85) ? 'bg-success-lt' : 'bg-warning-lt' ?> fs-3 px-3">
                        <?= $r['persentase'] ?>%
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="9" class="text-center text-muted py-4">Belum ada data presensi untuk siswa ini.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php elseif ($type == 'tentor' && !empty($selected_tentor)): ?>
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h3 class="card-title text-dark mb-0">
            REKAP PRESENSI TENTOR: <strong class="text-success"><?= html_escape($selected_tentor['nama_lengkap']) ?></strong>
          </h3>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter table-hover card-table">
            <thead class="bg-light">
              <tr>
                <th width="50">No</th>
                <th>Mapel MBF Diampu</th>
                <th class="text-center">Total Siswa</th>
                <th class="text-center text-success">Total Hadir</th>
                <th class="text-center text-info">Total Izin</th>
                <th class="text-center text-warning">Total Sakit</th>
                <th class="text-center text-danger">Total Alpa</th>
                <th class="text-center">Rata-rata %</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($rekap_data)): ?>
                <?php $no = 1; foreach ($rekap_data as $r): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td class="fw-bold text-success fs-3"><?= html_escape($r['mapel']['nama_mapel']) ?></td>
                    <td class="text-center"><span class="badge bg-info-lt"><?= $r['total_siswa'] ?> Siswa</span></td>
                    <td class="text-center fw-bold text-success fs-3"><?= $r['total_hadir'] ?></td>
                    <td class="text-center fw-bold text-info fs-3"><?= $r['total_izin'] ?></td>
                    <td class="text-center fw-bold text-warning fs-3"><?= $r['total_sakit'] ?></td>
                    <td class="text-center fw-bold text-danger fs-3"><?= $r['total_alpa'] ?></td>
                    <td class="text-center">
                      <span class="badge bg-success-lt fs-3 px-3"><?= $r['avg_persentase'] ?>%</span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center text-muted py-4">Belum ada data presensi untuk tentor ini.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php else: ?>
      <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
          <i class="ti ti-chart-bar fs-1 text-muted mb-2"></i>
          <p class="text-muted">Silakan pilih filter di atas untuk melihat Rekapitulasi Presensi MBF.</p>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>
