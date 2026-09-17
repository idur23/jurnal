<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL TENTOR MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-users me-2 text-success"></i> PESERTA MAPEL MBF SAYA
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <!-- MAPEL SELECTOR -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <form action="<?= base_url('tentor/peserta') ?>" method="GET" class="row g-3 align-items-center">
          <div class="col-md-6">
            <label class="form-label required">Pilih Mapel MBF</label>
            <select name="mapel_id" class="form-select" onchange="this.form.submit()">
              <?php foreach ($mapel_list as $m): ?>
                <option value="<?= $m['id'] ?>" <?= ($selected_mapel && $selected_mapel['id'] == $m['id']) ? 'selected' : '' ?>>
                  <?= html_escape($m['nama_mapel']) ?> (<?= html_escape($m['kode_mapel']) ?>) — <?= (int)$m['total_peserta'] ?> Siswa
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6 text-end">
            <?php if ($selected_mapel): ?>
              <a href="<?= base_url('tentor/presensi?mapel_id=' . $selected_mapel['id']) ?>" class="btn btn-warning shadow-sm">
                <i class="ti ti-user-check me-1"></i> Presensi Mapel Ini
              </a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>

    <!-- PESERTA TABLE -->
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h3 class="card-title text-dark mb-0">
          DAFTAR SISWA PESERTA: <strong class="text-success"><?= html_escape($selected_mapel['nama_mapel'] ?? '-') ?></strong>
        </h3>
        <span class="badge bg-success-lt fs-3 px-3"><?= count($peserta_list) ?> Siswa Terdaftar</span>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead class="bg-light">
            <tr>
              <th width="50">No</th>
              <th>NIS / NISN</th>
              <th>Nama Lengkap Siswa</th>
              <th>Kelas Reguler</th>
              <th>Jenis Kelamin</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($peserta_list)): ?>
              <?php $no = 1; foreach ($peserta_list as $s): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td>
                    <span class="badge bg-secondary-lt"><?= html_escape($s['nis']) ?></span>
                    <span class="small text-muted ms-1"><?= html_escape($s['nisn']) ?></span>
                  </td>
                  <td class="fw-bold text-dark fs-3"><?= html_escape($s['nama_lengkap']) ?></td>
                  <td><span class="badge bg-info-lt"><?= html_escape($s['nama_kelas']) ?></span></td>
                  <td>
                    <?php if ($s['jk'] == 'L'): ?>
                      <span class="badge bg-primary-lt">Laki-laki</span>
                    <?php else: ?>
                      <span class="badge bg-danger-lt">Perempuan</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">Belum ada siswa terdaftar pada mapel ini.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
