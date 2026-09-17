<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Master Data Ruangan</h2>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <a href="<?= base_url('master/export_excel/ruangan') ?>" class="btn btn-outline-success">
        <i class="ti ti-download me-1"></i> Export Excel
      </a>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        <i class="ti ti-upload me-1"></i> Import Excel
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="ti ti-plus me-1"></i> Tambah Ruangan
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
          <th>Kode Ruangan</th>
          <th>Nama Ruangan</th>
          <th>Kapasitas Siswa</th>
          <th class="text-center" style="width: 130px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_ruangan as $r): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><code><?= html_escape($r['kode_ruangan']) ?></code></td>
            <td class="fw-bold"><?= html_escape($r['nama_ruangan']) ?></td>
            <td><span class="badge bg-blue-lt"><?= $r['kapasitas'] ?> Orang</span></td>
            <td class="text-center">
              <div class="btn-list flex-nowrap justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit_<?= $r['id'] ?>" title="Edit Ruangan">
                  <i class="ti ti-edit"></i>
                </button>
                <form action="<?= base_url('master/ruangan') ?>" method="POST" class="d-inline">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $r['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger" data-confirm-msg="Apakah Anda yakin ingin menghapus ruangan <?= html_escape($r['nama_ruangan']) ?> ini?" title="Hapus Ruangan">
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>

          <!-- Modal Edit Ruangan -->
          <div class="modal modal-blur fade" id="modalEdit_<?= $r['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="<?= base_url('master/ruangan') ?>" method="POST">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="edit">
                  <input type="hidden" name="id" value="<?= $r['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label required">Kode Ruangan</label>
                      <input type="text" name="kode_ruangan" class="form-control" value="<?= html_escape($r['kode_ruangan']) ?>" placeholder="Contoh: R-101" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Nama Ruangan</label>
                      <input type="text" name="nama_ruangan" class="form-control" value="<?= html_escape($r['nama_ruangan']) ?>" placeholder="Contoh: Ruang Kelas X A" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Kapasitas</label>
                      <input type="number" name="kapasitas" class="form-control" value="<?= html_escape($r['kapasitas']) ?>" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Perbarui Ruangan</button>
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

<div class="modal modal-blur fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/ruangan') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Ruangan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Kode Ruangan</label>
            <input type="text" name="kode_ruangan" class="form-control" placeholder="Contoh: R-101" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Nama Ruangan</label>
            <input type="text" name="nama_ruangan" class="form-control" placeholder="Contoh: Ruang Kelas X IPA 1" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Kapasitas</label>
            <input type="number" name="kapasitas" class="form-control" value="36" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Ruangan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/import_excel/ruangan') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Import Ruangan dari Excel</h5>
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
