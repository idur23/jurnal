<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Master Jam Pelajaran</h2>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <a href="<?= base_url('master/export_excel/jam_pelajaran') ?>" class="btn btn-outline-success">
        <i class="ti ti-download me-1"></i> Export Excel
      </a>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        <i class="ti ti-upload me-1"></i> Import Excel
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="ti ti-plus me-1"></i> Tambah Jam Pelajaran
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
          <th>Jam Ke-</th>
          <th>Jam Mulai</th>
          <th>Jam Selesai</th>
          <th>Durasi</th>
          <th class="text-center" style="width: 130px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_jam as $j): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><span class="badge bg-purple-lt fw-bold">Jam ke-<?= $j['jam_ke'] ?></span></td>
            <td class="fw-bold text-success"><?= $j['jam_mulai'] ?></td>
            <td class="fw-bold text-danger"><?= $j['jam_selesai'] ?></td>
            <td>
              <?php
                $start = strtotime($j['jam_mulai']);
                $end = strtotime($j['jam_selesai']);
                $duration = round(($end - $start) / 60);
              ?>
              <span class="badge bg-secondary-lt"><?= $duration ?> Menit</span>
            </td>
            <td class="text-center">
              <div class="btn-list flex-nowrap justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit_<?= $j['id'] ?>" title="Edit Jam Pelajaran">
                  <i class="ti ti-edit"></i>
                </button>
                <form action="<?= base_url('master/jam_pelajaran') ?>" method="POST" class="d-inline">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $j['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger" data-confirm-msg="Apakah Anda yakin ingin menghapus jam pelajaran ke-<?= html_escape($j['jam_ke']) ?> ini?" title="Hapus Jam Pelajaran">
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>

          <!-- Modal Edit Jam Pelajaran -->
          <div class="modal modal-blur fade" id="modalEdit_<?= $j['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="<?= base_url('master/jam_pelajaran') ?>" method="POST">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="edit">
                  <input type="hidden" name="id" value="<?= $j['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Jam Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label required">Jam Ke-</label>
                      <input type="number" name="jam_ke" class="form-control" value="<?= html_escape($j['jam_ke']) ?>" placeholder="1 / 2 / 3" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Jam Mulai</label>
                      <input type="time" name="jam_mulai" class="form-control" value="<?= date('H:i', strtotime($j['jam_mulai'])) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Jam Selesai</label>
                      <input type="time" name="jam_selesai" class="form-control" value="<?= date('H:i', strtotime($j['jam_selesai'])) ?>" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Perbarui Jam</button>
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
      <form action="<?= base_url('master/jam_pelajaran') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Jam Pelajaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Jam Ke-</label>
            <input type="number" name="jam_ke" class="form-control" placeholder="1 / 2 / 3" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Jam Selesai</label>
            <input type="time" name="jam_selesai" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Jam</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/import_excel/jam_pelajaran') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Import Jam Pelajaran dari Excel</h5>
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
