<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Sistem Validasi Import Wali Kelas</div>
      <h2 class="page-title text-indigo"><i class="ti ti-eye me-2"></i>Preview Import <?= ($module == 'program_kelas') ? 'Program Kelas' : 'Aktivitas Kokurikuler' ?></h2>
      <div class="text-muted small mt-1">Harap teliti kembali data sebelum disimpan ke database. Baris yang memiliki error tidak akan disimpan.</div>
    </div>
  </div>
</div>

<div class="row row-cards mb-4">
  <!-- Total Baris -->
  <div class="col-sm-6 col-lg-4">
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
  <div class="col-sm-6 col-lg-4">
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
  <div class="col-sm-6 col-lg-4">
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
          <?php if ($module == 'program_kelas'): ?>
            <th>Tanggal</th>
            <th>Program</th>
            <th>Target</th>
            <th>Pelaksanaan</th>
            <th>Status</th>
            <th>Catatan</th>
          <?php else: ?>
            <th>Tanggal</th>
            <th>Tema</th>
            <th>Sub Tema / Judul</th>
            <th>Aktivitas</th>
            <th>Tujuan</th>
            <th>Status</th>
            <th>Catatan</th>
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
            
            <?php if ($module == 'program_kelas'): ?>
              <td><code><?= html_escape($row['tanggal']) ?></code></td>
              <td class="fw-bold"><?= html_escape($row['program']) ?></td>
              <td><?= html_escape($row['target']) ?></td>
              <td><?= html_escape($row['pelaksanaan']) ?></td>
              <td>
                <span class="badge bg-<?= ($row['status'] == 'Terealisasi') ? 'success' : 'warning' ?> text-white">
                  <?= html_escape($row['status']) ?>
                </span>
              </td>
              <td><?= html_escape($row['catatan'] ? $row['catatan'] : '-') ?></td>
            <?php else: ?>
              <td><code><?= html_escape($row['tanggal']) ?></code></td>
              <td class="fw-bold"><?= html_escape($row['tema']) ?></td>
              <td><?= html_escape($row['sub_tema']) ?></td>
              <td><?= html_escape($row['aktivitas']) ?></td>
              <td><?= html_escape($row['tujuan']) ?></td>
              <td>
                <span class="badge bg-<?= ($row['status'] == 'Terlaksana') ? 'success' : 'warning' ?> text-white">
                  <?= html_escape($row['status']) ?>
                </span>
              </td>
              <td><?= html_escape($row['catatan'] ? $row['catatan'] : '-') ?></td>
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
    <a href="<?= base_url('walikelas/' . ($module == 'program_kelas' ? 'program_kelas' : 'kokurikuler')) ?>" class="btn btn-outline-secondary fw-bold">
      <i class="ti ti-arrow-left me-1"></i> Batalkan Import
    </a>
    
    <form action="<?= base_url('walikelas/confirm_import/' . $module) ?>" method="POST">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
      <input type="hidden" name="file_name" value="<?= html_escape($file_name) ?>">
      
      <button type="submit" class="btn btn-primary fw-bold" <?= ($summary['valid'] == 0) ? 'disabled' : '' ?>>
        <i class="ti ti-database-import me-1"></i> Konfirmasi & Simpan (<?= $summary['valid'] ?> Baris)
      </button>
    </form>
  </div>
</div>
