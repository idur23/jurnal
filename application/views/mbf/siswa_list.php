<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-users me-2 text-success"></i> DAFTAR SISWA MBF
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <!-- FILTER CARD -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title text-dark mb-0"><i class="ti ti-filter me-2 text-info"></i> FILTER DATA SISWA MBF</h3>
      </div>
      <div class="card-body">
        <form action="<?= base_url('mbf/siswa') ?>" method="GET" class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Tahun Pelajaran</label>
            <select name="tahun_pelajaran_id" class="form-select">
              <option value="">-- Semua TP --</option>
              <?php foreach ($list_tp as $tp): ?>
                <option value="<?= $tp['id'] ?>" <?= (isset($filters['tahun_pelajaran_id']) && $filters['tahun_pelajaran_id'] == $tp['id']) ? 'selected' : '' ?>>
                  <?= html_escape($tp['tahun']) ?> (<?= html_escape($tp['semester']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Kelas Siswa</label>
            <select name="kelas_id" class="form-select">
              <option value="">-- Semua Kelas --</option>
              <?php foreach ($list_kelas as $k): ?>
                <option value="<?= $k['id'] ?>" <?= (isset($filters['kelas_id']) && $filters['kelas_id'] == $k['id']) ? 'selected' : '' ?>>
                  <?= html_escape($k['nama_kelas']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Mapel MBF</label>
            <select name="mapel_id" class="form-select">
              <option value="">-- Semua Mapel MBF --</option>
              <?php foreach ($list_mapel as $m): ?>
                <option value="<?= $m['id'] ?>" <?= (isset($filters['mapel_mbf_id']) && $filters['mapel_mbf_id'] == $m['id']) ? 'selected' : '' ?>>
                  <?= html_escape($m['nama_mapel']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Tentor Pengajar</label>
            <select name="tentor_id" class="form-select">
              <option value="">-- Semua Tentor --</option>
              <?php foreach ($list_tentor as $t): ?>
                <option value="<?= $t['id'] ?>" <?= (isset($filters['tentor_id']) && $filters['tentor_id'] == $t['id']) ? 'selected' : '' ?>>
                  <?= html_escape($t['nama_lengkap']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-9">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama Siswa / NIS / NISN..." value="<?= html_escape($filters['search'] ?? '') ?>">
          </div>

          <div class="col-md-3 text-end d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-fill"><i class="ti ti-search me-1"></i> Filter</button>
            <a href="<?= base_url('mbf/siswa') ?>" class="btn btn-outline-secondary"><i class="ti ti-refresh"></i> Reset</a>
          </div>
        </form>
      </div>
    </div>

    <!-- ROSTER TABLE -->
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h3 class="card-title text-dark mb-0"><i class="ti ti-list me-2"></i> ROSTER SISWA PESERTA MBF</h3>
        <span class="badge bg-success-lt fs-3 px-3"><?= count($list_siswa) ?> Siswa Ditemukan</span>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead class="bg-light">
            <tr>
              <th width="50">No</th>
              <th>NIS / NISN</th>
              <th>Nama Lengkap Siswa</th>
              <th>Kelas Reguler</th>
              <th>Mapel MBF Diikuti</th>
              <th>Tentor Pengajar</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($list_siswa)): ?>
              <?php $no = 1; foreach ($list_siswa as $s): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td>
                    <span class="badge bg-secondary-lt"><?= html_escape($s['nis']) ?></span>
                    <span class="small text-muted ms-1"><?= html_escape($s['nisn']) ?></span>
                  </td>
                  <td class="fw-bold text-dark fs-3"><?= html_escape($s['nama_lengkap']) ?></td>
                  <td><span class="badge bg-info-lt"><?= html_escape($s['nama_kelas']) ?></span></td>
                  <td><span class="text-success fw-bold"><?= html_escape($s['daftar_mapel']) ?></span></td>
                  <td><span class="text-info"><?= html_escape($s['daftar_tentor']) ?></span></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-4">Tidak ada data siswa MBF yang sesuai dengan filter.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
