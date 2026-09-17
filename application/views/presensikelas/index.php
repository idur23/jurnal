<div class="page-header d-print-none mb-3 mb-md-4">
  <div class="row align-items-center g-2">
    <div class="col-12 col-sm-auto me-auto">
      <h2 class="page-title">Monitoring Presensi Kelas & KBM</h2>
      <div class="text-muted small mt-1">Daftar keterlaksanaan pembelajaran kelas dan verifikasi status kehadiran mengajar guru.</div>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card mb-4">
  <div class="card-body">
    <form action="<?= base_url('presensikelas') ?>" method="GET" class="row g-2 g-md-3">
      <div class="col-12 col-sm-6 col-md-3">
        <label class="form-label">Kelas</label>
        <select name="kelas_id" class="form-select select2">
          <option value="">-- Semua Kelas --</option>
          <?php foreach ($list_kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= ($filters['kelas_id'] == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12 col-sm-6 col-md-3">
        <label class="form-label">Mata Pelajaran</label>
        <select name="mapel_id" class="form-select select2">
          <option value="">-- Semua Mapel --</option>
          <?php foreach ($list_mapel as $m): ?>
            <option value="<?= $m['id'] ?>" <?= ($filters['mapel_id'] == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12 col-sm-6 col-md-2">
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

      <div class="col-12 col-sm-6 col-md-2">
        <label class="form-label">Tanggal Mulai</label>
        <input type="text" name="tanggal_mulai" class="form-control datepicker" value="<?= html_escape($filters['tanggal_mulai']) ?>" placeholder="YYYY-MM-DD">
      </div>

      <div class="col-12 col-sm-6 col-md-2">
        <label class="form-label">Tanggal Selesai</label>
        <input type="text" name="tanggal_selesai" class="form-control datepicker" value="<?= html_escape($filters['tanggal_selesai']) ?>" placeholder="YYYY-MM-DD">
      </div>

      <div class="col-12 d-flex justify-content-end mt-2">
        <button type="submit" class="btn btn-primary"><i class="ti ti-filter me-1"></i> Filter Data</button>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-vcenter card-table datatable">
      <thead>
        <tr>
          <th>#</th>
          <th>Tanggal</th>
          <th>Kelas & Mapel</th>
          <th>Guru Pengampu</th>
          <th>Pertemuan</th>
          <th>Status KBM</th>
          <th>Dokumentasi</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_presensi_kelas as $pk): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <div class="fw-bold"><?= format_indo_date($pk['tanggal']) ?></div>
                <div class="text-muted small"><?= substr($pk['jam_mulai'], 0, 5) ?> - <?= substr($pk['jam_selesai'], 0, 5) ?></div>
              </td>
              <td>
                <div class="fw-bold text-indigo"><?= html_escape($pk['nama_kelas']) ?></div>
                <div class="text-muted small"><?= html_escape($pk['nama_mapel']) ?></div>
              </td>
              <td><?= html_escape($pk['nama_guru']) ?></td>
              <td>Pertemuan ke-<?= html_escape($pk['pertemuan_ke']) ?></td>
              <td>
                <?php if ($pk['status_pembelajaran'] == 'Terlaksana'): ?>
                  <span class="badge bg-success text-white fw-bold">Terlaksana</span>
                <?php elseif ($pk['status_pembelajaran'] == 'Tidak Terlaksana'): ?>
                  <span class="badge bg-danger text-white fw-bold" title="Alasan: <?= html_escape($pk['alasan_tidak_terlaksana']) ?>">Tidak Terlaksana</span>
                <?php else: ?>
                  <span class="badge bg-indigo text-white fw-bold"><?= html_escape($pk['status_pembelajaran']) ?></span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($pk['dokumentasi']): ?>
                  <a href="<?= gdrive_media_url($pk['dokumentasi']) ?>" target="_blank" class="badge bg-green-lt"><i class="ti ti-photo me-1"></i> Lampiran</a>
                <?php else: ?>
                  <span class="text-muted small">Tidak ada</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <div class="btn-list flex-nowrap justify-content-center">
                  <?php if ($pk['status_pembelajaran'] != 'Tidak Terlaksana'): ?>
                    <a href="<?= base_url('presensi/input/' . $pk['id']) ?>" class="btn btn-sm btn-indigo text-white" title="Input Presensi Siswa">
                      <i class="ti ti-users-group me-1"></i> Kehadiran Siswa
                    </a>
                  <?php endif; ?>
                  <a href="<?= base_url('presensikelas/edit/' . $pk['id']) ?>" class="btn btn-sm btn-outline-warning" title="Edit Detail">
                    <i class="ti ti-edit"></i>
                  </a>
                  <?php if (($_user['role_code'] ?? '') == 'admin'): ?>
                    <a href="<?= base_url('presensikelas/delete/' . $pk['id']) ?>" class="btn btn-sm btn-outline-danger" data-confirm-msg="Apakah Anda yakin ingin menghapus data Presensi Kelas ini? Seluruh data kehadiran siswa terkait juga akan ikut terhapus." title="Hapus">
                      <i class="ti ti-trash"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
