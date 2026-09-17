<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Master Tahun Pelajaran</h2>
      <div class="text-muted small mt-1">Kelola data tahun pelajaran, semester aktif, serta aktivasi periode akademik.</div>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <a href="<?= base_url('master/export_excel/tahun_pelajaran') ?>" class="btn btn-outline-success">
        <i class="ti ti-download me-1"></i> Export Excel
      </a>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        <i class="ti ti-upload me-1"></i> Import Excel
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="ti ti-plus me-1"></i> Tambah Tahun Pelajaran
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
          <th>Tahun Pelajaran</th>
          <th>Semester</th>
          <th>Status</th>
          <th class="text-center" style="width: 200px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_tp as $tp): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td class="fw-bold"><?= html_escape($tp['tahun']) ?></td>
            <td><span class="badge bg-blue-lt"><?= html_escape($tp['semester']) ?></span></td>
            <td>
              <?php if ($tp['is_active'] == 1): ?>
                <span class="badge bg-success-lt text-success fw-bold"><i class="ti ti-check me-1"></i>AKTIF</span>
              <?php else: ?>
                <span class="badge bg-secondary-lt">Tidak Aktif</span>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <div class="btn-list flex-nowrap justify-content-center">
                <!-- Activate Button -->
                <?php if ($tp['is_active'] == 0): ?>
                  <form action="<?= base_url('master/tahun_pelajaran') ?>" method="POST" class="d-inline">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" value="set_active">
                    <input type="hidden" name="id" value="<?= $tp['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-success" title="Aktifkan TP Ini">
                      <i class="ti ti-check me-1"></i> Aktifkan
                    </button>
                  </form>
                <?php else: ?>
                  <button class="btn btn-sm btn-success disabled" disabled><i class="ti ti-check me-1"></i> Aktif</button>
                <?php endif; ?>

                <!-- Edit Button -->
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit_<?= $tp['id'] ?>" title="Edit Tahun Pelajaran">
                  <i class="ti ti-edit"></i>
                </button>

                <!-- Delete Button -->
                <form action="<?= base_url('master/tahun_pelajaran') ?>" method="POST" class="d-inline">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $tp['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger" data-confirm-msg="Apakah Anda yakin ingin menghapus Tahun Pelajaran <?= html_escape($tp['tahun']) ?> (<?= html_escape($tp['semester']) ?>) ini?" title="Hapus Tahun Pelajaran" <?= ($tp['is_active'] == 1) ? 'disabled title="TP Aktif Tidak Bisa Dihapus"' : '' ?>>
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>

          <!-- Modal Edit TP -->
          <div class="modal modal-blur fade" id="modalEdit_<?= $tp['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="<?= base_url('master/tahun_pelajaran') ?>" method="POST">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="edit">
                  <input type="hidden" name="id" value="<?= $tp['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Tahun Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label required">Tahun Pelajaran</label>
                      <input type="text" name="tahun" class="form-control" value="<?= html_escape($tp['tahun']) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Semester</label>
                      <select name="semester" class="form-select" required>
                        <option value="Ganjil" <?= ($tp['semester'] == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                        <option value="Genap" <?= ($tp['semester'] == 'Genap') ? 'selected' : '' ?>>Genap</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold">Update TP</button>
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
      <form action="<?= base_url('master/tahun_pelajaran') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Tahun Pelajaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Tahun Pelajaran</label>
            <input type="text" name="tahun" class="form-control" placeholder="Contoh: 2025/2026" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Semester</label>
            <select name="semester" class="form-select" required>
              <option value="Ganjil">Ganjil</option>
              <option value="Genap">Genap</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold">Simpan TP</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/import_excel/tahun_pelajaran') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Import Tahun Pelajaran dari Excel</h5>
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
