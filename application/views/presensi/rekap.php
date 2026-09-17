<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Presensi</div>
      <h2 class="page-title">Rekapitulasi Presensi Bulanan Siswa</h2>
      <div class="text-muted small mt-1">Laporan persentase kehadiran dan jumlah ketidakhadiran siswa dalam satu bulan.</div>
    </div>
    <div class="col-auto ms-auto">
      <div class="btn-list">
        <?php if ($selected_kelas_id): ?>
          <a href="<?= base_url('presensi/print_rekap?kelas_id=' . $selected_kelas_id . '&bulan=' . $selected_bulan . '&tahun=' . $selected_tahun) ?>" target="_blank" class="btn btn-outline-danger">
            <i class="ti ti-printer me-1"></i> Cetak Laporan
          </a>
          <a href="<?= base_url('presensi/export_excel?kelas_id=' . $selected_kelas_id . '&bulan=' . $selected_bulan . '&tahun=' . $selected_tahun) ?>" class="btn btn-outline-success">
            <i class="ti ti-file-spreadsheet me-1"></i> Export Excel
          </a>
        <?php endif; ?>
        <a href="<?= base_url('presensi') ?>" class="btn btn-secondary">
          <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card mb-4">
  <div class="card-body">
    <form action="<?= base_url('presensi/rekap') ?>" method="GET" class="row g-3">
      <div class="col-md-5">
        <label class="form-label required">Pilih Kelas</label>
        <select name="kelas_id" class="form-select select2" required>
          <option value="">-- Pilih Kelas --</option>
          <?php foreach ($list_kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= (($selected_kelas_id ?? '') == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label required">Bulan</label>
        <select name="bulan" class="form-select">
          <?php 
            $months = array(
              '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
              '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
              '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
            );
            foreach ($months as $m_num => $m_name):
          ?>
            <option value="<?= $m_num ?>" <?= ($selected_bulan == $m_num) ? 'selected' : '' ?>><?= $m_name ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-2">
        <label class="form-label required">Tahun</label>
        <input type="number" name="tahun" class="form-control" value="<?= html_escape($selected_tahun) ?>" required>
      </div>

      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-1"></i> Cari Rekap</button>
      </div>
    </form>
  </div>
</div>

<?php if ($selected_kelas_id): ?>
<div class="card">
  <div class="card-header bg-dark text-white">
    <h3 class="card-title text-white">
      <i class="ti ti-calendar-event me-2"></i>
      Rekap Presensi Kelas Periode: <?= $months[$selected_bulan] ?> <?= $selected_tahun ?>
    </h3>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped table-hover">
      <thead>
        <tr>
          <th style="width: 50px;">#</th>
          <th>NIS</th>
          <th>Nama Lengkap</th>
          <th class="text-center bg-success-lt" style="width: 80px;">Hadir (H)</th>
          <th class="text-center bg-info-lt" style="width: 80px;">Sakit (S)</th>
          <th class="text-center bg-warning-lt" style="width: 80px;">Izin (I)</th>
          <th class="text-center bg-danger-lt" style="width: 80px;">Alpa (A)</th>
          <th class="text-center bg-secondary-lt" style="width: 85px;">Terlambat (T)</th>
          <th class="text-center bg-purple-lt" style="width: 85px;">Dispen (D)</th>
          <th class="text-center" style="width: 130px;">% Kehadiran</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($rekap_presensi)): ?>
          <tr>
            <td colspan="10" class="text-center text-muted py-4">Belum ada data kehadiran siswa dicatat pada periode ini.</td>
          </tr>
        <?php else: ?>
          <?php $no=1; foreach ($rekap_presensi as $r): 
            $total = $r['hadir'] + $r['izin'] + $r['sakit'] + $r['alpa'] + $r['terlambat'] + $r['dispen'];
            $persen = ($total > 0) ? round(($r['hadir'] / $total) * 100, 1) : 0;
            
            // Set badge color based on percentage
            $badge_color = 'bg-danger';
            if ($persen >= 90) $badge_color = 'bg-success';
            elseif ($persen >= 75) $badge_color = 'bg-warning';
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><code><?= html_escape($r['nis']) ?></code></td>
              <td class="fw-bold"><?= html_escape($r['nama_lengkap']) ?></td>
              <td class="text-center fw-bold text-success"><?= $r['hadir'] ?></td>
              <td class="text-center text-info"><?= $r['sakit'] ?></td>
              <td class="text-center text-warning"><?= $r['izin'] ?></td>
              <td class="text-center text-danger fw-bold"><?= $r['alpa'] ?></td>
              <td class="text-center text-secondary"><?= $r['terlambat'] ?></td>
              <td class="text-center text-purple"><?= $r['dispen'] ?></td>
              <td class="text-center">
                <span class="badge <?= $badge_color ?> text-white fw-bold px-3 py-1 rounded-pill"><?= $persen ?>%</span>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
