<div class="page-header d-print-none mb-3 mb-md-4">
  <div class="row align-items-center g-2">
    <div class="col-12 col-sm-auto me-auto">
      <h2 class="page-title">Jurnal Guru & Kegiatan Pembelajaran</h2>
    </div>
    <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
    <div class="col-12 col-sm-auto ms-auto">
      <a href="<?= base_url('jurnal/add') ?>" class="btn btn-primary w-100 w-sm-auto">
        <i class="ti ti-plus me-1"></i> Input Jurnal Baru
      </a>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Filter Card -->
<div class="card mb-4">
  <div class="card-body">
    <form action="<?= base_url('jurnal') ?>" method="GET" class="row g-2 g-md-3">
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
        <label class="form-label">Tanggal Mulai</label>
        <input type="text" name="tanggal_mulai" class="form-control datepicker" value="<?= html_escape($filters['tanggal_mulai']) ?>" placeholder="YYYY-MM-DD">
      </div>

      <div class="col-12 col-sm-6 col-md-2">
        <label class="form-label">Tanggal Selesai</label>
        <input type="text" name="tanggal_selesai" class="form-control datepicker" value="<?= html_escape($filters['tanggal_selesai']) ?>" placeholder="YYYY-MM-DD">
      </div>

      <div class="col-12 col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100"><i class="ti ti-filter me-1"></i> Filter Data</button>
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
          <th>Kode & Tanggal</th>
          <th>Kelas & Jam</th>
          <th>Mapel & Guru</th>
          <th>Materi Pembelajaran</th>
          <th>Status</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_jurnal as $j): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td>
              <div class="fw-bold"><?= html_escape($j['kode_jurnal']) ?></div>
              <div class="text-muted small"><?= format_indo_date($j['tanggal']) ?></div>
            </td>
            <td>
              <div class="fw-bold"><?= html_escape($j['nama_kelas']) ?></div>
              <div class="text-muted small">Jam ke-<?= html_escape($j['jam_ke']) ?></div>
            </td>
            <td>
              <div class="fw-bold"><?= html_escape($j['nama_mapel']) ?></div>
              <div class="text-muted small"><?= html_escape($j['nama_guru']) ?></div>
            </td>
            <td>
              <div class="text-truncate" style="max-width: 250px;" title="<?= html_escape($j['materi_pembelajaran']) ?>">
                <?= html_escape($j['materi_pembelajaran']) ?>
              </div>
            </td>
            <td><?= get_badge_jurnal_status($j['status']) ?></td>
            <td class="text-center">
              <div class="btn-list flex-nowrap justify-content-center">
                <a href="<?= base_url('poinkeaktifan/input/'.$j['id']) ?>" class="btn btn-sm btn-outline-warning" title="Input Poin Keaktifan">
                  <i class="ti ti-star"></i> Poin
                </a>
                <a href="<?= base_url('jurnal/detail/'.$j['id']) ?>" class="btn btn-sm btn-outline-info" title="Detail Jurnal">
                  <i class="ti ti-eye"></i>
                </a>
                <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'kamad', 'waka')) || ($_user['id'] ?? 0) == $j['created_by'] || ($_user['guru_id'] ?? 0) == $j['guru_id']): ?>
                  <a href="<?= base_url('jurnal/edit/'.$j['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit Jurnal">
                    <i class="ti ti-pencil"></i>
                  </a>
                  <a href="<?= base_url('jurnal/delete/'.$j['id']) ?>" class="btn btn-sm btn-outline-danger" data-confirm-msg="Apakah Anda yakin ingin menghapus data Jurnal KBM ini?" title="Hapus Jurnal">
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
