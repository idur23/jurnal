<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Jadwal Pelajaran Sekolah</h2>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <a href="<?= base_url('master/export_excel/jadwal') ?>" class="btn btn-outline-success">
        <i class="ti ti-download me-1"></i> Export Excel
      </a>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        <i class="ti ti-upload me-1"></i> Import Excel
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="ti ti-plus me-1"></i> Ploting Jadwal Pelajaran
      </button>
    </div>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-vcenter card-table datatable">
      <thead>
        <tr>
          <th>Hari</th>
          <th>Jam ke-</th>
          <th>Kelas</th>
          <th>Mata Pelajaran</th>
          <th>Guru Pengampu</th>
          <th>Ruangan</th>
          <th class="text-center" style="width: 120px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($list_jadwal as $jd): ?>
          <tr>
            <td><span class="badge bg-purple-lt fw-bold"><?= html_escape($jd['hari']) ?></span></td>
            <td><code>Jam <?= $jd['jam_mulai_ke'] ?> - <?= $jd['jam_selesai_ke'] ?></code></td>
            <td class="fw-bold"><?= html_escape($jd['nama_kelas']) ?></td>
            <td><?= html_escape($jd['nama_mapel']) ?></td>
            <td><?= html_escape($jd['nama_guru']) ?></td>
            <td><span class="badge bg-secondary-lt"><?= html_escape($jd['nama_ruangan'] ?? '-') ?></span></td>
            <td class="text-center">
              <div class="btn-list flex-nowrap justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit_<?= $jd['id'] ?>" title="Edit Jadwal Pelajaran">
                  <i class="ti ti-edit"></i>
                </button>
                <form action="<?= base_url('master/jadwal') ?>" method="POST" class="d-inline">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $jd['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger" data-confirm-msg="Apakah Anda yakin ingin menghapus jadwal pelajaran ini?" title="Hapus Jadwal Pelajaran">
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>

          <!-- Modal Edit Jadwal Pelajaran -->
          <div class="modal modal-blur fade" id="modalEdit_<?= $jd['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="<?= base_url('master/jadwal') ?>" method="POST">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="edit">
                  <input type="hidden" name="id" value="<?= $jd['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Ploting Jadwal Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-6 mb-3">
                        <label class="form-label required">Hari</label>
                        <select name="hari" class="form-select" required>
                          <?php foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h): ?>
                            <option value="<?= $h ?>" <?= ($jd['hari'] == $h) ? 'selected' : '' ?>><?= $h ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-lg-3 mb-3">
                        <label class="form-label required">Jam Mulai (Ke-)</label>
                        <input type="number" name="jam_mulai_ke" class="form-control" value="<?= html_escape($jd['jam_mulai_ke']) ?>" required>
                      </div>
                      <div class="col-lg-3 mb-3">
                        <label class="form-label required">Jam Selesai (Ke-)</label>
                        <input type="number" name="jam_selesai_ke" class="form-control" value="<?= html_escape($jd['jam_selesai_ke']) ?>" required>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label required">Kelas</label>
                        <select name="kelas_id" class="form-select" required>
                          <option value="">-- Pilih Kelas --</option>
                          <?php foreach ($list_kelas as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= ($jd['kelas_id'] == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label required">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-select" required>
                          <option value="">-- Pilih Mapel --</option>
                          <?php foreach ($list_mapel as $m): ?>
                            <option value="<?= $m['id'] ?>" <?= ($jd['mapel_id'] == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label required">Guru Pengampu</label>
                        <select name="guru_id" class="form-select" required>
                          <option value="">-- Pilih Guru --</option>
                          <?php foreach ($list_guru as $g): ?>
                            <option value="<?= $g['id'] ?>" <?= ($jd['guru_id'] == $g['id']) ? 'selected' : '' ?>><?= html_escape($g['nama_lengkap']) ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label">Ruangan</label>
                        <select name="ruangan_id" class="form-select">
                          <option value="">-- Pilih Ruangan --</option>
                          <?php foreach ($list_ruangan as $r): ?>
                            <option value="<?= $r['id'] ?>" <?= ($jd['ruangan_id'] == $r['id']) ? 'selected' : '' ?>><?= html_escape($r['nama_ruangan']) ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
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
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/jadwal') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h5 class="modal-title">Ploting Jadwal Pelajaran Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Hari</label>
              <select name="hari" class="form-select" required>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
              </select>
            </div>
            <div class="col-lg-3 mb-3">
              <label class="form-label required">Jam Mulai (Ke-)</label>
              <input type="number" name="jam_mulai_ke" class="form-control" value="1" required>
            </div>
            <div class="col-lg-3 mb-3">
              <label class="form-label required">Jam Selesai (Ke-)</label>
              <input type="number" name="jam_selesai_ke" class="form-control" value="2" required>
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Kelas</label>
              <select name="kelas_id" class="form-select select2" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($list_kelas as $k): ?>
                  <option value="<?= $k['id'] ?>"><?= html_escape($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Mata Pelajaran</label>
              <select name="mapel_id" class="form-select select2" required>
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($list_mapel as $m): ?>
                  <option value="<?= $m['id'] ?>"><?= html_escape($m['nama_mapel']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Guru Pengampu</label>
              <select name="guru_id" class="form-select select2" required>
                <option value="">-- Pilih Guru --</option>
                <?php foreach ($list_guru as $g): ?>
                  <option value="<?= $g['id'] ?>"><?= html_escape($g['nama_lengkap']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label">Ruangan</label>
              <select name="ruangan_id" class="form-select select2">
                <option value="">-- Pilih Ruangan --</option>
                <?php foreach ($list_ruangan as $r): ?>
                  <option value="<?= $r['id'] ?>"><?= html_escape($r['nama_ruangan']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/import_excel/jadwal') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Import Jadwal dari Excel</h5>
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
