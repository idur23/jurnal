<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL TENTOR MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-chart-bar me-2 text-indigo"></i> REKAP PRESENSI MAPEL SAYA
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <!-- FILTER -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <form action="<?= base_url('tentor/rekap') ?>" method="GET" class="row g-3">
          <div class="col-md-5">
            <label class="form-label required">Mapel MBF</label>
            <select name="mapel_id" class="form-select" required>
              <?php foreach ($mapel_list as $m): ?>
                <option value="<?= $m['id'] ?>" <?= ($selected_mapel && $selected_mapel['id'] == $m['id']) ? 'selected' : '' ?>>
                  <?= html_escape($m['nama_mapel']) ?> (<?= html_escape($m['kode_mapel']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-select">
              <option value="">-- Semua Bulan --</option>
              <?php 
              $months = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
              foreach ($months as $num => $m_name): ?>
                <option value="<?= $num ?>" <?= (isset($bulan) && $bulan == $num) ? 'selected' : '' ?>><?= $m_name ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4 text-end d-flex gap-2 align-items-end">
            <button type="submit" class="btn btn-primary flex-fill"><i class="ti ti-filter me-1"></i> Tampilkan Rekap</button>
            <?php if (!empty($selected_mapel)): ?>
              <a href="<?= base_url('tentor/export_pdf?mapel_id=' . $selected_mapel['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="ti ti-file-type-pdf"></i> PDF</a>
              <a href="<?= base_url('tentor/export_excel?mapel_id=' . $selected_mapel['id']) ?>" class="btn btn-outline-success"><i class="ti ti-file-spreadsheet"></i> Excel</a>
              <a href="<?= base_url('tentor/print_rekap?mapel_id=' . $selected_mapel['id']) ?>" target="_blank" class="btn btn-outline-info"><i class="ti ti-printer"></i> Print</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>

    <!-- REKAP TABLE -->
    <?php if ($selected_mapel): ?>
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
          <h3 class="card-title text-dark mb-0">
            REKAP PRESENSI: <strong class="text-success"><?= html_escape($selected_mapel['nama_mapel']) ?></strong>
          </h3>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter table-hover card-table">
            <thead class="bg-light">
              <tr>
                <th width="50">No</th>
                <th>NIS</th>
                <th>Nama Lengkap Siswa</th>
                <th>Kelas Reguler</th>
                <th class="text-center text-success">Hadir</th>
                <th class="text-center text-info">Izin</th>
                <th class="text-center text-warning">Sakit</th>
                <th class="text-center text-danger">Alpa</th>
                <th class="text-center">Total Pertemuan</th>
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
                  <td colspan="10" class="text-center text-muted py-4">Belum ada data presensi pada mapel ini.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>
