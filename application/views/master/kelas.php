<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Master Data Kelas</h2>
      <div class="text-muted small mt-1">Kelola data kelas, tingkat angkatan, dan penugasan wali kelas.</div>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <a href="<?= base_url('master/export_excel/kelas') ?>" class="btn btn-outline-success">
        <i class="ti ti-download me-1"></i> Export Excel
      </a>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        <i class="ti ti-upload me-1"></i> Import Excel
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="ti ti-plus me-1"></i> Tambah Kelas
      </button>
    </div>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-vcenter card-table datatable">
      <thead>
        <tr>
          <th>#</th>
          <th>Kode Kelas</th>
          <th>Nama Kelas</th>
          <th>Tingkat</th>
          <th>Wali Kelas</th>
          <th class="text-center" style="width: 130px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_kelas as $k): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><code><?= html_escape($k['kode_kelas']) ?></code></td>
            <td class="fw-bold"><?= html_escape($k['nama_kelas']) ?></td>
            <td><span class="badge bg-purple-lt">Tingkat <?= html_escape($k['tingkat']) ?></span></td>
            <td><?= $k['nama_wali_kelas'] ? html_escape($k['nama_wali_kelas']) : '<span class="text-muted italic">Belum diplot</span>' ?></td>
            <td class="text-center">
              <div class="btn-list flex-nowrap justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit_<?= $k['id'] ?>" title="Edit Kelas">
                  <i class="ti ti-edit"></i>
                </button>
                <form action="<?= base_url('master/kelas') ?>" method="POST" class="d-inline">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $k['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger" data-confirm-msg="Apakah Anda yakin ingin menghapus kelas <?= html_escape($k['nama_kelas']) ?> ini?" title="Hapus Kelas">
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>

          <!-- Modal Edit Kelas -->
          <div class="modal modal-blur fade" id="modalEdit_<?= $k['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="<?= base_url('master/kelas') ?>" method="POST">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="edit">
                  <input type="hidden" name="id" value="<?= $k['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Data Kelas: <?= html_escape($k['nama_kelas']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label required">Kode Kelas</label>
                      <input type="text" name="kode_kelas" class="form-control" value="<?= html_escape($k['kode_kelas']) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Nama Kelas</label>
                      <input type="text" name="nama_kelas" class="form-control" value="<?= html_escape($k['nama_kelas']) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Tingkat</label>
                      <select name="tingkat" class="form-select" required>
                        <option value="10" <?= ($k['tingkat'] == '10') ? 'selected' : '' ?>>10</option>
                        <option value="11" <?= ($k['tingkat'] == '11') ? 'selected' : '' ?>>11</option>
                        <option value="12" <?= ($k['tingkat'] == '12') ? 'selected' : '' ?>>12</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Wali Kelas</label>
                      <select name="wali_kelas_id" class="form-select select2">
                        <option value="">-- Pilih Wali Kelas --</option>
                        <?php foreach ($list_guru as $g): ?>
                          <option value="<?= $g['id'] ?>" <?= ($k['wali_kelas_id'] == $g['id']) ? 'selected' : '' ?>><?= html_escape($g['nama_lengkap']) ?> (NIP: <?= html_escape($g['nip']) ?>)</option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold">Update Data Kelas</button>
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

<!-- Modal Add -->
<div class="modal modal-blur fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/kelas') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Kode Kelas</label>
            <input type="text" name="kode_kelas" class="form-control" placeholder="Contoh: X-A" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: X A" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Tingkat</label>
            <select name="tingkat" class="form-select" required>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Wali Kelas</label>
            <select name="wali_kelas_id" class="form-select select2">
              <option value="">-- Pilih Wali Kelas --</option>
              <?php foreach ($list_guru as $g): ?>
                <option value="<?= $g['id'] ?>"><?= html_escape($g['nama_lengkap']) ?> (NIP: <?= html_escape($g['nip']) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold">Simpan Data Kelas</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/import_excel/kelas') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Import Kelas dari Excel</h5>
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
