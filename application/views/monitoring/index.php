<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Pimpinan</div>
      <h2 class="page-title">Monitoring Keterlaksanaan KBM & Presensi Kelas</h2>
      <div class="text-muted small mt-1">Daftar laporan keterlaksanaan pembelajaran secara realtime untuk Kepala Madrasah.</div>
    </div>
  </div>
</div>

<!-- Statistik Cards -->
<div class="row row-cards mb-4">
  <div class="col-6 col-lg-3">
    <div class="card card-sm border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar bg-primary text-white rounded-3 me-3">
            <i class="ti ti-notebook fs-2"></i>
          </span>
          <div>
            <div class="text-muted small">Total Jurnal</div>
            <div class="h2 mb-0 fw-bold"><?= $total_jurnal ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card card-sm border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar bg-success text-white rounded-3 me-3">
            <i class="ti ti-check fs-2"></i>
          </span>
          <div>
            <div class="text-muted small">Terlaksana</div>
            <div class="h2 mb-0 fw-bold text-success"><?= $terlaksana_count ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card card-sm border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar bg-danger text-white rounded-3 me-3">
            <i class="ti ti-x fs-2"></i>
          </span>
          <div>
            <div class="text-muted small">Tidak Terlaksana</div>
            <div class="h2 mb-0 fw-bold text-danger"><?= $tidak_terlaksana_count ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card card-sm border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar bg-indigo text-white rounded-3 me-3">
            <i class="ti ti-users fs-2"></i>
          </span>
          <div>
            <div class="text-muted small">Kehadiran Siswa</div>
            <div class="h2 mb-0 fw-bold text-indigo"><?= $siswa_attendance_rate ?>%</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card mb-4">
  <div class="card-body">
    <form action="<?= base_url('monitoring') ?>" method="GET" class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Kelas</label>
        <select name="kelas_id" class="form-select select2">
          <option value="">-- Semua Kelas --</option>
          <?php foreach ($list_kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= ($filters['kelas_id'] == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Mata Pelajaran</label>
        <select name="mapel_id" class="form-select select2">
          <option value="">-- Semua Mapel --</option>
          <?php foreach ($list_mapel as $m): ?>
            <option value="<?= $m['id'] ?>" <?= ($filters['mapel_id'] == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Guru</label>
        <select name="guru_id" class="form-select select2">
          <option value="">-- Semua Guru --</option>
          <?php foreach ($list_guru as $g): ?>
            <option value="<?= $g['id'] ?>" <?= ($filters['guru_id'] == $g['id']) ? 'selected' : '' ?>><?= html_escape($g['nama_lengkap']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Status Pembelajaran</label>
        <select name="status_pembelajaran" class="form-select">
          <option value="">-- Semua Status --</option>
          <option value="Terlaksana" <?= ($filters['status_pembelajaran'] == 'Terlaksana') ? 'selected' : '' ?>>Terlaksana</option>
          <option value="Tidak Terlaksana" <?= ($filters['status_pembelajaran'] == 'Tidak Terlaksana') ? 'selected' : '' ?>>Tidak Terlaksana</option>
          <option value="Diganti" <?= ($filters['status_pembelajaran'] == 'Diganti') ? 'selected' : '' ?>>Diganti</option>
          <option value="Daring" <?= ($filters['status_pembelajaran'] == 'Daring') ? 'selected' : '' ?>>Daring</option>
          <option value="Luring" <?= ($filters['status_pembelajaran'] == 'Luring') ? 'selected' : '' ?>>Luring</option>
          <option value="Gabungan Kelas" <?= ($filters['status_pembelajaran'] == 'Gabungan Kelas') ? 'selected' : '' ?>>Gabungan Kelas</option>
        </select>
      </div>

      <div class="col-md-2 offset-md-10 text-end">
        <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-1"></i> Cari Laporan</button>
      </div>
    </form>
  </div>
</div>

<!-- Table Data -->
<div class="card">
  <div class="card-header bg-dark text-white">
    <h3 class="card-title text-white"><i class="ti ti-report-analytics me-2"></i>Log Jurnal & Presensi Kelas</h3>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table table-hover table-striped datatable">
      <thead>
        <tr>
          <th>#</th>
          <th>Tanggal</th>
          <th>Kelas & Mapel</th>
          <th>Guru Pengampu</th>
          <th>Keterlaksanaan</th>
          <th>Dokumentasi</th>
          <th>Kehadiran Siswa</th>
          <th>Catatan Guru</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($logs)): ?>
          <tr>
            <td colspan="8" class="text-center text-muted py-4">Tidak ada log presensi kelas ditemukan.</td>
          </tr>
        <?php else: ?>
          <?php $no=1; foreach ($logs as $l): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <div class="fw-bold"><?= format_indo_date($l['tanggal']) ?></div>
                <div class="text-muted small"><?= substr($l['jam_mulai'], 0, 5) ?> - <?= substr($l['jam_selesai'], 0, 5) ?></div>
              </td>
              <td>
                <div class="fw-bold text-indigo"><?= html_escape($l['nama_kelas']) ?></div>
                <div class="text-muted small"><?= html_escape($l['nama_mapel']) ?></div>
              </td>
              <td><?= html_escape($l['nama_guru']) ?></td>
              <td>
                <?php if ($l['status_pembelajaran'] == 'Terlaksana'): ?>
                  <span class="badge bg-success text-white fw-bold">Terlaksana</span>
                <?php elseif ($l['status_pembelajaran'] == 'Tidak Terlaksana'): ?>
                  <span class="badge bg-danger text-white fw-bold" title="Alasan: <?= html_escape($l['alasan_tidak_terlaksana']) ?>">Tidak Terlaksana</span>
                <?php else: ?>
                  <span class="badge bg-indigo text-white fw-bold"><?= html_escape($l['status_pembelajaran']) ?></span>
                <?php endif; ?>
                <?php if ($l['alasan_tidak_terlaksana']): ?>
                  <div class="text-danger small mt-1 italic">Alasan: <?= html_escape($l['alasan_tidak_terlaksana']) ?></div>
                <?php endif; ?>
              </td>
              <td>
                <?php 
                  $doc_file = !empty($l['jurnal_file_dokumentasi']) ? $l['jurnal_file_dokumentasi'] : (!empty($l['file_dokumentasi']) ? $l['file_dokumentasi'] : $l['dokumentasi']);
                ?>
                <?php if (!empty($doc_file)): ?>
                  <a href="<?= gdrive_media_url($doc_file) ?>" target="_blank" class="badge bg-green-lt"><i class="ti ti-photo me-1"></i> Lampiran</a>
                <?php else: ?>
                  <span class="text-muted small">Tidak ada</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($l['status_pembelajaran'] == 'Tidak Terlaksana'): ?>
                  <span class="text-muted small">N/A</span>
                <?php elseif ($l['total_count'] == 0): ?>
                  <span class="badge bg-warning text-white">Belum Diabsen</span>
                <?php else: ?>
                  <div class="small">
                    <span class="badge bg-success-lt" title="Hadir">H: <?= $l['hadir_count'] ?></span>
                    <span class="badge bg-info-lt" title="Sakit">S: <?= $l['sakit_count'] ?></span>
                    <span class="badge bg-warning-lt" title="Izin">I: <?= $l['izin_count'] ?></span>
                    <span class="badge bg-danger-lt" title="Alpa">A: <?= $l['alpa_count'] ?></span>
                  </div>
                <?php endif; ?>
              </td>
              <td>
                <div class="text-muted small text-truncate" style="max-width: 150px;" title="<?= html_escape($l['catatan_guru']) ?>">
                  <?= $l['catatan_guru'] ? html_escape($l['catatan_guru']) : '-' ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
