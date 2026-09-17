<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Sistem Validasi Import</div>
      <h2 class="page-title text-indigo"><i class="ti ti-eye me-2"></i>Preview Import Data <?= ucfirst($module) ?></h2>
      <div class="text-muted small mt-1">Harap teliti kembali data sebelum disimpan ke database. Baris yang memiliki error tidak akan disimpan.</div>
    </div>
  </div>
</div>

<div class="row row-cards mb-4">
  <!-- Total Baris -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm shadow-sm border-0" style="border-left: 4px solid #6366f1 !important; border-radius: 8px;">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar avatar-sm bg-indigo-lt text-indigo rounded-3 me-3"><i class="ti ti-list"></i></span>
          <div>
            <div class="font-weight-medium text-muted">Total Baris</div>
            <div class="h2 mb-0 fw-bold"><?= $summary['total'] ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Valid -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm shadow-sm border-0" style="border-left: 4px solid #10b981 !important; border-radius: 8px;">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar avatar-sm bg-success-lt text-success rounded-3 me-3"><i class="ti ti-check"></i></span>
          <div>
            <div class="font-weight-medium text-muted">Siap Di-import</div>
            <div class="h2 mb-0 fw-bold text-success"><?= $summary['valid'] ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Invalid -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm shadow-sm border-0" style="border-left: 4px solid #ef4444 !important; border-radius: 8px;">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar avatar-sm bg-danger-lt text-danger rounded-3 me-3"><i class="ti ti-alert-triangle"></i></span>
          <div>
            <div class="font-weight-medium text-muted">Baris Error (Dilewati)</div>
            <div class="h2 mb-0 fw-bold text-danger"><?= $summary['invalid'] ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Warning / Duplikat -->
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm shadow-sm border-0" style="border-left: 4px solid #f59e0b !important; border-radius: 8px;">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <span class="avatar avatar-sm bg-warning-lt text-warning rounded-3 me-3"><i class="ti ti-copy"></i></span>
          <div>
            <div class="font-weight-medium text-muted">Duplikat Terdeteksi</div>
            <div class="h2 mb-0 fw-bold text-warning"><?= $summary['duplicate'] ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="card-header bg-dark text-white">
    <h3 class="card-title text-white"><i class="ti ti-table me-2"></i>Hasil Analisis File Excel</h3>
  </div>
  <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-vcenter card-table table-striped table-hover">
      <thead>
        <tr>
          <th style="width: 50px;">Baris</th>
          <?php if ($module == 'guru'): ?>
            <th>NIP</th>
            <th>Nama Guru</th>
            <th>Username</th>
            <th>Role</th>
            <th>Mapel Diampu</th>
          <?php else: ?>
            <th>Kode Mapel</th>
            <th>Nama Mata Pelajaran</th>
            <th>Kelas Binaan</th>
            <th>Guru Pengampu</th>
            <th>TP & Semester</th>
          <?php endif; ?>
          <th>Status Validasi</th>
          <th>Keterangan / Alasan</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($preview_rows as $row): 
          $has_err = !empty($row['errors']);
        ?>
          <tr class="<?= $has_err ? 'table-danger' : '' ?>">
            <td class="fw-bold text-muted"><?= $row['row_num'] ?></td>
            
            <?php if ($module == 'guru'): ?>
              <td><code><?= html_escape($row['nip']) ?></code></td>
              <td class="fw-bold"><?= html_escape($row['nama']) ?></td>
              <td><?= html_escape($row['username']) ?></td>
              <td><span class="badge bg-blue-lt"><?= html_escape($row['role_name']) ?></span></td>
              <td>
                <?php if ($row['mapel_codes']): ?>
                  <span class="badge bg-indigo-lt"><?= html_escape($row['mapel_codes']) ?></span>
                <?php else: ?>
                  <span class="text-muted small">-</span>
                <?php endif; ?>
              </td>
            <?php else: ?>
              <td><code><?= html_escape($row['kode_mapel']) ?></code></td>
              <td class="fw-bold"><?= html_escape($row['nama_mapel']) ?></td>
              <td><span class="badge bg-purple-lt"><?= html_escape($row['kode_kelas'] ? $row['kode_kelas'] : '-') ?></span></td>
              <td><?= html_escape($row['nip_guru'] ? $row['nip_guru'] : '-') ?></td>
              <td><?= html_escape($row['tahun_tp'] ? $row['tahun_tp'].' ('.$row['semester'].')' : '-') ?></td>
            <?php endif; ?>

            <td>
              <?php if ($has_err): ?>
                <span class="badge bg-danger text-white fw-bold"><i class="ti ti-x me-1"></i> ERROR</span>
              <?php else: ?>
                <span class="badge bg-success text-white fw-bold"><i class="ti ti-check me-1"></i> VALID</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($has_err): ?>
                <ul class="text-danger mb-0 ps-3 small">
                  <?php foreach ($row['errors'] as $err): ?>
                    <li><?= html_escape($err) ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <span class="text-success small fw-semibold"><i class="ti ti-circle-check-filled me-1"></i>Siap di-import</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  
  <div class="card-footer bg-light d-flex justify-content-between align-items-center">
    <a href="<?= base_url('master/' . $module) ?>" class="btn btn-outline-secondary fw-bold">
      <i class="ti ti-arrow-left me-1"></i> Batalkan Import
    </a>
    
    <form action="<?= base_url('master/confirm_import/' . $module) ?>" method="POST">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
      <input type="hidden" name="file_name" value="<?= html_escape($file_name) ?>">
      
      <button type="submit" class="btn btn-primary fw-bold" <?= ($summary['valid'] == 0) ? 'disabled' : '' ?>>
        <i class="ti ti-database-import me-1"></i> Konfirmasi & Simpan (<?= $summary['valid'] ?> Baris)
      </button>
    </form>
  </div>
</div>
