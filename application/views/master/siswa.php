<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Master Data Siswa</h2>
      <div class="text-muted small mt-1">Kelola data siswa, filter per angkatan & kelas, serta import & export data.</div>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <?php
        $export_params = array();
        if (!empty($selected_tingkat)) $export_params['tingkat'] = $selected_tingkat;
        if (!empty($selected_kelas))   $export_params['kelas_id'] = $selected_kelas;
        $export_qs = !empty($export_params) ? '?' . http_build_query($export_params) : '';
      ?>
      <a href="<?= base_url('master/export_siswa_pdf' . $export_qs) ?>" target="_blank" class="btn btn-outline-danger">
        <i class="ti ti-file-pdf me-1"></i> PDF
      </a>
      <a href="<?= base_url('master/export_siswa_excel' . $export_qs) ?>" class="btn btn-outline-success">
        <i class="ti ti-file-spreadsheet me-1"></i> Excel
      </a>
      <a href="<?= base_url('master/export_siswa' . $export_qs) ?>" class="btn btn-outline-secondary">
        <i class="ti ti-file-text me-1"></i> CSV
      </a>
      <a href="<?= base_url('master/print_siswa' . $export_qs) ?>" target="_blank" class="btn btn-outline-primary">
        <i class="ti ti-printer me-1"></i> Print
      </a>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        <i class="ti ti-upload me-1"></i> Import Excel
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="ti ti-plus me-1"></i> Tambah Siswa
      </button>
    </div>
  </div>
</div>

<!-- Dual Filter Box: Angkatan/Tingkat & Kelas -->
<div class="card mb-4">
  <div class="card-body py-3">
    <form action="<?= base_url('master/siswa') ?>" method="GET" class="row g-2 align-items-center">
      <div class="col-auto">
        <label class="form-label mb-0 fw-bold"><i class="ti ti-filter me-1"></i>Filter Data:</label>
      </div>
      
      <!-- Filter Angkatan / Tingkat -->
      <div class="col-md-3">
        <select name="tingkat" class="form-select select2" onchange="this.form.submit()">
          <option value="">-- Semua Angkatan / Tingkat --</option>
          <option value="10" <?= ($selected_tingkat == '10') ? 'selected' : '' ?>>Kelas 10 (X)</option>
          <option value="11" <?= ($selected_tingkat == '11') ? 'selected' : '' ?>>Kelas 11 (XI)</option>
          <option value="12" <?= ($selected_tingkat == '12') ? 'selected' : '' ?>>Kelas 12 (XII)</option>
        </select>
      </div>

      <!-- Filter Spesifik Kelas -->
      <div class="col-md-3">
        <select name="kelas_id" class="form-select select2" onchange="this.form.submit()">
          <option value="">-- Semua Kelas --</option>
          <?php foreach ($list_kelas as $k): ?>
            <?php if (empty($selected_tingkat) || $k['tingkat'] == $selected_tingkat): ?>
              <option value="<?= $k['id'] ?>" <?= ($selected_kelas == $k['id']) ? 'selected' : '' ?>>
                <?= html_escape($k['nama_kelas']) ?>
              </option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>

      <?php if ($selected_tingkat || $selected_kelas): ?>
        <div class="col-auto">
          <a href="<?= base_url('master/siswa') ?>" class="btn btn-ghost-secondary"><i class="ti ti-rotate-clockwise me-1"></i> Reset Filter</a>
        </div>
      <?php endif; ?>
    </form>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-vcenter card-table datatable">
      <thead>
        <tr>
          <th>#</th>
          <th>NIS / NISN</th>
          <th>Nama Lengkap</th>
          <th>JK</th>
          <th>Angkatan</th>
          <th>Kelas</th>
          <th>Status</th>
          <th class="text-center" style="width: 130px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_siswa as $s): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td>
              <div class="fw-bold"><?= html_escape($s['nis']) ?></div>
              <div class="text-muted small">NISN: <?= html_escape($s['nisn']) ?></div>
            </td>
            <td class="fw-bold"><?= html_escape($s['nama_lengkap']) ?></td>
            <td><span class="badge bg-secondary-lt"><?= html_escape($s['jk']) ?></span></td>
            <td><span class="badge bg-purple-lt fw-bold">Kelas <?= html_escape($s['tingkat']) ?></span></td>
            <td><span class="badge bg-blue-lt fw-bold"><?= html_escape($s['nama_kelas']) ?></span></td>
            <td>
              <?php if ($s['status_aktif'] == 1): ?>
                <span class="badge bg-success-lt">Aktif</span>
              <?php else: ?>
                <span class="badge bg-danger-lt">Non-Aktif</span>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <div class="btn-list flex-nowrap justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEditSiswa_<?= $s['id'] ?>" title="Edit Siswa">
                  <i class="ti ti-edit"></i>
                </button>
                <?php 
                  $del_url_params = array();
                  if (!empty($selected_tingkat)) $del_url_params['tingkat'] = $selected_tingkat;
                  if (!empty($selected_kelas)) $del_url_params['kelas_id'] = $selected_kelas;
                  $action_url = base_url('master/siswa' . (!empty($del_url_params) ? '?' . http_build_query($del_url_params) : ''));
                ?>
                <form action="<?= $action_url ?>" method="POST" class="d-inline">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $s['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger" data-confirm-msg="Apakah Anda yakin ingin menghapus data Siswa <?= html_escape($s['nama_lengkap']) ?> ini?" title="Hapus Siswa">
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>

          <!-- Modal Edit Siswa -->
          <div class="modal modal-blur fade" id="modalEditSiswa_<?= $s['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="<?= $action_url ?>" method="POST">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="edit">
                  <input type="hidden" name="id" value="<?= $s['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Siswa: <?= html_escape($s['nama_lengkap']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label required">NIS</label>
                      <input type="text" name="nis" class="form-control" value="<?= html_escape($s['nis']) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">NISN</label>
                      <input type="text" name="nisn" class="form-control" value="<?= html_escape($s['nisn']) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Nama Lengkap Siswa</label>
                      <input type="text" name="nama_lengkap" class="form-control" value="<?= html_escape($s['nama_lengkap']) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Jenis Kelamin</label>
                      <select name="jk" class="form-select" required>
                        <option value="L" <?= ($s['jk'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= ($s['jk'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Kelas</label>
                      <select name="kelas_id" class="form-select" required>
                        <?php foreach ($list_kelas as $k): ?>
                          <option value="<?= $k['id'] ?>" <?= ($s['kelas_id'] == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Status Siswa</label>
                      <select name="status_aktif" class="form-select" required>
                        <option value="1" <?= ($s['status_aktif'] == 1) ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= ($s['status_aktif'] == 0) ? 'selected' : '' ?>>Non-Aktif / Pindah</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold">Update Data Siswa</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/import_excel/siswa') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Import Siswa dari Excel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">File Excel (.xlsx, .xls)</label>
            <input type="file" name="excel_file" class="form-control" accept=".xlsx, .xls" required>
            <small class="text-muted mt-1 d-block">Unduh data terlebih dahulu sebagai template untuk melihat format kolom yang benar.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold"><i class="ti ti-upload me-1"></i> Unggah & Import</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal modal-blur fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= $action_url ?? base_url('master/siswa') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">NIS</label>
            <input type="text" name="nis" class="form-control" placeholder="Nomor Induk Siswa" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">NISN</label>
            <input type="text" name="nisn" class="form-control" placeholder="NISN Nasional" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Nama Lengkap Siswa</label>
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Jenis Kelamin</label>
            <select name="jk" class="form-select" required>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label required">Kelas</label>
            <select name="kelas_id" class="form-select" required>
              <option value="">-- Pilih Kelas --</option>
              <?php foreach ($list_kelas as $k): ?>
                <option value="<?= $k['id'] ?>" <?= ($selected_kelas == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold">Simpan Data Siswa</button>
        </div>
      </form>
    </div>
  </div>
</div>
