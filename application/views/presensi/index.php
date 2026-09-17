<div class="page-header d-print-none mb-3 mb-md-4">
  <div class="row align-items-center g-2">
    <div class="col-12 col-sm-auto me-auto">
      <h2 class="page-title">Pencatatan Kehadiran Siswa</h2>
      <div class="text-muted small mt-1">Isi dan edit kehadiran harian siswa untuk masing-masing sesi KBM kelas.</div>
    </div>
    <div class="col-12 col-sm-auto ms-auto d-print-none">
      <a href="<?= base_url('presensi/rekap') ?>" class="btn btn-outline-success w-100 w-sm-auto">
        <i class="ti ti-file-spreadsheet me-1"></i> Rekap Bulanan Siswa
      </a>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card mb-4">
  <div class="card-body">
    <form action="<?= base_url('presensi') ?>" method="GET" class="row g-2 g-md-3">
      <div class="col-12 col-sm-6 col-md-4">
        <label class="form-label">Kelas</label>
        <select name="kelas_id" class="form-select select2">
          <option value="">-- Semua Kelas --</option>
          <?php foreach ($list_kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= ($filters['kelas_id'] == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12 col-sm-6 col-md-4">
        <label class="form-label">Mata Pelajaran</label>
        <select name="mapel_id" class="form-select select2">
          <option value="">-- Semua Mapel --</option>
          <?php foreach ($list_mapel as $m): ?>
            <option value="<?= $m['id'] ?>" <?= ($filters['mapel_id'] == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12 col-sm-6 col-md-2">
        <label class="form-label">Dari Tanggal</label>
        <input type="text" name="tanggal_mulai" class="form-control datepicker" value="<?= html_escape($filters['tanggal_mulai']) ?>" placeholder="YYYY-MM-DD">
      </div>

      <div class="col-12 col-sm-6 col-md-2 text-end d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-1"></i> Cari Sesi</button>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header bg-dark text-white">
    <h3 class="card-title text-white"><i class="ti ti-users-group me-2"></i>Sesi Presensi Kelas & Kehadiran Siswa</h3>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table table-hover table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Tanggal & Jam</th>
          <th>Kelas & Mapel</th>
          <th>Guru Pengampu</th>
          <th>Status Pembelajaran</th>
          <th>Statistik Kehadiran Siswa</th>
          <th class="text-center" style="width: 200px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_sessions as $s): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <div class="fw-bold"><?= format_indo_date($s['tanggal']) ?></div>
                <div class="text-muted small"><?= substr($s['jam_mulai'], 0, 5) ?> - <?= substr($s['jam_selesai'], 0, 5) ?></div>
              </td>
              <td>
                <div class="fw-bold text-indigo"><?= html_escape($s['nama_kelas']) ?></div>
                <div class="text-muted small"><?= html_escape($s['nama_mapel']) ?></div>
              </td>
              <td><?= html_escape($s['nama_guru']) ?></td>
              <td>
                <?php if ($s['status_pembelajaran'] == 'Terlaksana'): ?>
                  <span class="badge bg-success-lt fw-bold">Terlaksana</span>
                <?php elseif ($s['status_pembelajaran'] == 'Tidak Terlaksana'): ?>
                  <span class="badge bg-danger-lt fw-bold">Tidak Terlaksana</span>
                <?php else: ?>
                  <span class="badge bg-indigo-lt fw-bold"><?= html_escape($s['status_pembelajaran']) ?></span>
                <?php endif; ?>
              </td>
              <td>
                <div class="fw-bold text-success text-center">
                  <?= $s['hadir_count'] ?> / <?= $s['total_count'] ?>
                </div>
              </td>
              <td class="text-center">
                <?php if ($s['status_pembelajaran'] == 'Tidak Terlaksana'): ?>
                  <button class="btn btn-sm btn-secondary" disabled>Tidak Diperlukan</button>
                <?php else: ?>
                  <a href="<?= base_url('presensi/input/' . $s['id']) ?>" class="btn btn-sm btn-indigo text-white fw-bold">
                    <i class="ti <?= ($s['total_count'] > 0) ? 'ti-edit' : 'ti-plus' ?> me-1"></i>
                    <?= ($s['total_count'] > 0) ? 'Ubah Presensi' : 'Isi Presensi Siswa' ?>
                  </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
