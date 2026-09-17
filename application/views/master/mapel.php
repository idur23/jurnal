<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Master Mata Pelajaran</h2>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <a href="<?= base_url('master/export_excel/mapel') ?>" class="btn btn-outline-success">
        <i class="ti ti-download me-1"></i> Export Excel
      </a>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        <i class="ti ti-upload me-1"></i> Import Excel
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="ti ti-plus me-1"></i> Tambah Mapel
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
          <th>Kode Mapel</th>
          <th>Nama Mata Pelajaran</th>
          <th>Kelompok</th>
          <th>KKM</th>
          <th>Guru Pengampu</th>
          <th>Kelas</th>
          <th>Semester</th>
          <th>Tahun Pelajaran</th>
          <th>Status</th>
          <th class="text-center" style="width: 130px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_mapel as $m): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><code><?= html_escape($m['kode_mapel']) ?></code></td>
            <td class="fw-bold"><?= html_escape($m['nama_mapel']) ?></td>
            <td><span class="badge bg-blue-lt"><?= html_escape($m['kelompok']) ?></span></td>
            <td><span class="badge bg-green-lt fw-bold"><?= number_format($m['kkm'], 2) ?></span></td>
            <td><?= html_escape($m['nama_guru'] ?? '-') ?></td>
            <td>
              <?php if (!empty($m['list_kelas_nama'])): ?>
                <?php foreach ($m['list_kelas_nama'] as $kname): ?>
                  <span class="badge bg-purple-lt me-1 mb-1"><?= html_escape($kname) ?></span>
                <?php endforeach; ?>
              <?php else: ?>
                <span class="text-muted small italic">-</span>
              <?php endif; ?>
            </td>
            <td><?= html_escape($m['semester'] ?? '-') ?></td>
            <td><?= html_escape($m['tahun_pelajaran'] ?? '-') ?></td>
            <td>
              <?php if (($m['status'] ?? 'Aktif') == 'Aktif'): ?>
                <span class="badge bg-success text-white">Aktif</span>
              <?php else: ?>
                <span class="badge bg-secondary text-white">Non-Aktif</span>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <div class="btn-list flex-nowrap justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit_<?= $m['id'] ?>" title="Edit Mapel">
                  <i class="ti ti-edit"></i>
                </button>
                <form action="<?= base_url('master/mapel') ?>" method="POST" class="d-inline">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $m['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger" data-confirm-msg="Apakah Anda yakin ingin menghapus mata pelajaran <?= html_escape($m['nama_mapel']) ?> ini?" title="Hapus Mapel">
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>

          <!-- Modal Edit Mapel -->
          <div class="modal modal-blur fade" id="modalEdit_<?= $m['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="<?= base_url('master/mapel') ?>" method="POST">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="edit">
                  <input type="hidden" name="id" value="<?= $m['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Mata Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label required">Kode Mapel</label>
                      <input type="text" name="kode_mapel" class="form-control" value="<?= html_escape($m['kode_mapel']) ?>" placeholder="Contoh: MAT-W" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Nama Mapel</label>
                      <input type="text" name="nama_mapel" class="form-control" value="<?= html_escape($m['nama_mapel']) ?>" placeholder="Contoh: Matematika Wajib" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Kelompok</label>
                      <select name="kelompok" class="form-select" required>
                        <option value="Wajib" <?= $m['kelompok'] == 'Wajib' ? 'selected' : '' ?>>Wajib</option>
                        <option value="Peminatan" <?= $m['kelompok'] == 'Peminatan' ? 'selected' : '' ?>>Peminatan</option>
                        <option value="Muatan Lokal" <?= $m['kelompok'] == 'Muatan Lokal' ? 'selected' : '' ?>>Muatan Lokal</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">KKM</label>
                      <input type="number" step="0.01" name="kkm" class="form-control" value="<?= html_escape($m['kkm']) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Guru Pengampu</label>
                      <select name="guru_id" class="form-select">
                        <option value="">-- Pilih Guru --</option>
                        <?php foreach ($list_guru as $g): ?>
                          <option value="<?= $g['id'] ?>" <?= ($m['guru_id'] == $g['id']) ? 'selected' : '' ?>><?= html_escape($g['nama_lengkap']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label fw-bold text-primary"><i class="ti ti-building me-1"></i>Kelas</label>
                      <select name="kelas_ids[]" class="form-select select2" multiple="multiple" data-placeholder="-- Pilih Kelas --">
                        <?php foreach ($list_kelas as $k): ?>
                          <option value="<?= $k['id'] ?>" <?= (in_array($k['id'], $m['kelas_ids'] ?? [])) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
                        <?php endforeach; ?>
                      </select>
                      <span class="text-muted small mt-1 d-block">Admin dapat memilih satu atau beberapa kelas sekaligus.</span>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Semester</label>
                      <select name="semester" class="form-select" required>
                        <option value="Ganjil" <?= $m['semester'] == 'Ganjil' ? 'selected' : '' ?>>Ganjil</option>
                        <option value="Genap" <?= $m['semester'] == 'Genap' ? 'selected' : '' ?>>Genap</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Tahun Pelajaran</label>
                      <select name="tahun_pelajaran_id" class="form-select">
                        <option value="">-- Pilih Tahun Pelajaran --</option>
                        <?php foreach ($list_tp as $tp): ?>
                          <option value="<?= $tp['id'] ?>" <?= ($m['tahun_pelajaran_id'] == $tp['id']) ? 'selected' : '' ?>><?= html_escape($tp['tahun'] . ' (' . $tp['semester'] . ')') ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label required">Status</label>
                      <select name="status" class="form-select" required>
                        <option value="Aktif" <?= ($m['status'] ?? 'Aktif') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Non-Aktif" <?= ($m['status'] ?? 'Aktif') == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Perbarui Mapel</button>
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
      <form action="<?= base_url('master/mapel') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Mata Pelajaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Kode Mapel</label>
            <input type="text" name="kode_mapel" class="form-control" placeholder="Contoh: MAT-W" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Nama Mapel</label>
            <input type="text" name="nama_mapel" class="form-control" placeholder="Contoh: Matematika Wajib" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Kelompok</label>
            <select name="kelompok" class="form-select" required>
              <option value="Wajib">Wajib</option>
              <option value="Peminatan">Peminatan</option>
              <option value="Muatan Lokal">Muatan Lokal</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label required">KKM</label>
            <input type="number" step="0.01" name="kkm" class="form-control" value="75.00" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Guru Pengampu</label>
            <select name="guru_id" class="form-select">
              <option value="">-- Pilih Guru --</option>
              <?php foreach ($list_guru as $g): ?>
                <option value="<?= $g['id'] ?>"><?= html_escape($g['nama_lengkap']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold text-primary"><i class="ti ti-building me-1"></i>Kelas (Bisa Lebih Dari 1)</label>
            <select name="kelas_ids[]" class="form-select select2" multiple="multiple" data-placeholder="-- Pilih Kelas --">
              <?php foreach ($list_kelas as $k): ?>
                <option value="<?= $k['id'] ?>"><?= html_escape($k['nama_kelas']) ?></option>
              <?php endforeach; ?>
            </select>
            <span class="text-muted small mt-1 d-block">Admin dapat memilih satu atau beberapa kelas sekaligus.</span>
          </div>
          <div class="mb-3">
            <label class="form-label required">Semester</label>
            <select name="semester" class="form-select" required>
              <option value="Ganjil">Ganjil</option>
              <option value="Genap">Genap</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Tahun Pelajaran</label>
            <select name="tahun_pelajaran_id" class="form-select">
              <option value="">-- Pilih Tahun Pelajaran --</option>
              <?php foreach ($list_tp as $tp): ?>
                <option value="<?= $tp['id'] ?>" <?= ($tp['is_aktif'] == 1) ? 'selected' : '' ?>><?= html_escape($tp['tahun'] . ' (' . $tp['semester'] . ')') ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label required">Status</label>
            <select name="status" class="form-select" required>
              <option value="Aktif">Aktif</option>
              <option value="Non-Aktif">Non-Aktif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Mapel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/import_excel/mapel') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Import Mapel dari Excel</h5>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
  if (typeof $ !== 'undefined') {
    $('.modal').on('shown.bs.modal', function () {
      $(this).find('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        dropdownParent: $(this)
      });
    });
  }
});
</script>

