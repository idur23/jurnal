<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Master Data Guru & Akun Login</h2>
      <div class="text-muted small mt-1">Kelola profil guru, akun login, dan mata pelajaran yang diampu.</div>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <a href="<?= base_url('master/export_excel/guru') ?>" class="btn btn-outline-success">
        <i class="ti ti-download me-1"></i> Export Excel
      </a>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        <i class="ti ti-upload me-1"></i> Import Excel
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="ti ti-plus me-1"></i> Tambah Data Guru
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
          <th>NIP</th>
          <th>Nama Lengkap</th>
          <th>Mapel Diampu</th>
          <th>Status Kepegawaian</th>
          <th>Email & Username</th>
          <th>Status Akun</th>
          <th class="text-center" style="width: 130px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_guru as $g): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><code><?= html_escape($g['nip']) ?></code></td>
            <td class="fw-bold"><?= html_escape(($g['gelar_depan'] ? $g['gelar_depan'].' ' : '').$g['nama_lengkap'].($g['gelar_belakang'] ? ', '.$g['gelar_belakang'] : '')) ?></td>
            <td>
              <?php if (!empty($g['list_mapel_nama'])): ?>
                <?php foreach ($g['list_mapel_nama'] as $mname): ?>
                  <span class="badge bg-indigo-lt me-1 mb-1"><?= html_escape($mname) ?></span>
                <?php endforeach; ?>
              <?php else: ?>
                <span class="text-muted small italic">Belum di-set</span>
              <?php endif; ?>
            </td>
            <td><span class="badge bg-purple-lt"><?= html_escape($g['status_kepegawaian']) ?></span></td>
            <td>
              <div><?= html_escape($g['email']) ?></div>
              <div class="text-muted small">
                User: <strong><?= html_escape($g['username'] ?? '-') ?></strong> | 
                Role: <span class="badge bg-blue-lt"><?= html_escape($g['role_name'] ?? 'Guru') ?></span>
              </div>
            </td>
            <td>
              <?php if ($g['is_active'] == 1): ?>
                <span class="badge bg-success-lt">Aktif</span>
              <?php else: ?>
                <span class="badge bg-danger-lt">Non-Aktif</span>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <div class="btn-list flex-nowrap justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit_<?= $g['id'] ?>" title="Edit Data Guru & Mapel">
                  <i class="ti ti-edit"></i>
                </button>
                <form action="<?= base_url('master/guru') ?>" method="POST" class="d-inline">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $g['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger" data-confirm-msg="Apakah Anda yakin ingin menghapus data Guru <?= html_escape($g['nama_lengkap']) ?> ini? Akun login terkait juga akan dihapus." title="Hapus Guru">
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>

          <!-- Modal Edit Guru -->
          <div class="modal modal-blur fade" id="modalEdit_<?= $g['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="<?= base_url('master/guru') ?>" method="POST">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="edit">
                  <input type="hidden" name="id" value="<?= $g['id'] ?>">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Data Guru: <?= html_escape($g['nama_lengkap']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-6 mb-3">
                        <label class="form-label required">NIP</label>
                        <input type="text" name="nip" class="form-control" value="<?= html_escape($g['nip']) ?>" required>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label required">Nama Lengkap (Tanpa Gelar)</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= html_escape($g['nama_lengkap']) ?>" required>
                      </div>
                      <div class="col-lg-3 mb-3">
                        <label class="form-label">Gelar Depan</label>
                        <input type="text" name="gelar_depan" class="form-control" value="<?= html_escape($g['gelar_depan']) ?>">
                      </div>
                      <div class="col-lg-3 mb-3">
                        <label class="form-label">Gelar Belakang</label>
                        <input type="text" name="gelar_belakang" class="form-control" value="<?= html_escape($g['gelar_belakang']) ?>">
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label required">Jenis Kelamin</label>
                        <select name="jk" class="form-select" required>
                          <option value="L" <?= ($g['jk'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                          <option value="P" <?= ($g['jk'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                      </div>
                      
                      <!-- Multi-Select Mata Pelajaran Diampu -->
                      <div class="col-lg-12 mb-3">
                        <label class="form-label fw-bold text-primary"><i class="ti ti-book me-1"></i>Mata Pelajaran Yang Diampu (Bisa Lebih Dari 1)</label>
                        <select name="mapel_ids[]" class="form-select select2" multiple="multiple" data-placeholder="-- Pilih Mapel yang Diampu --">
                          <?php foreach ($list_mapel as $mp): ?>
                            <option value="<?= $mp['id'] ?>" <?= (in_array($mp['id'], $g['mapel_ids'])) ? 'selected' : '' ?>>
                              <?= html_escape($mp['nama_mapel']) ?> (Kode: <?= html_escape($mp['kode_mapel']) ?>)
                            </option>
                          <?php endforeach; ?>
                        </select>
                        <span class="text-muted small mt-1 d-block">Admin dapat menentukan mata pelajaran yang dapat diajarkan oleh guru ini.</span>
                      </div>

                      <div class="col-lg-6 mb-3">
                        <label class="form-label">No. Telepon / WA</label>
                        <input type="text" name="no_hp" class="form-control" value="<?= html_escape($g['no_hp']) ?>">
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= html_escape($g['email']) ?>" required>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label required">Status Kepegawaian</label>
                        <select name="status_kepegawaian" class="form-select" required>
                          <option value="PNS" <?= ($g['status_kepegawaian'] == 'PNS') ? 'selected' : '' ?>>PNS (Pegawai Negeri Sipil)</option>
                          <option value="PPPK" <?= ($g['status_kepegawaian'] == 'PPPK') ? 'selected' : '' ?>>PPPK (Pegawai Pemerintah Perjanjian Kerja)</option>
                          <option value="GTY" <?= ($g['status_kepegawaian'] == 'GTY') ? 'selected' : '' ?>>GTY (Guru Tetap Yayasan)</option>
                          <option value="GTT" <?= ($g['status_kepegawaian'] == 'GTT') ? 'selected' : '' ?>>GTT (Guru Tidak Tetap)</option>
                          <option value="Honorer" <?= ($g['status_kepegawaian'] == 'Honorer') ? 'selected' : '' ?>>Honorer</option>
                        </select>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label">Username Login</label>
                        <input type="text" name="username" class="form-control" value="<?= html_escape($g['username'] ?? '') ?>" placeholder="Username login...">
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label">Password Login <?= empty($g['user_id']) ? '(Kosongkan jika ingin auto default)' : '(Kosongkan jika tidak diganti)' ?></label>
                        <input type="password" name="password" class="form-control" placeholder="Password login...">
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label">Status Akun Login</label>
                        <select name="is_active" class="form-select">
                          <option value="1" <?= ($g['is_active'] == 1) ? 'selected' : '' ?>>Aktif</option>
                          <option value="0" <?= ($g['is_active'] == 0 || empty($g['user_id'])) ? 'selected' : '' ?>>Non-Aktif</option>
                        </select>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label required">Role Akses Login</label>
                        <select name="role_id" class="form-select" required>
                          <?php foreach ($list_roles as $role): ?>
                            <option value="<?= $role['id'] ?>" <?= (($g['role_id'] ?? 2) == $role['id']) ? 'selected' : '' ?>><?= html_escape($role['role_name']) ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold">Update Data Guru & Mapel</button>
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

<!-- Modal Tambah Guru -->
<div class="modal modal-blur fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/guru') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Guru & Buat Akun Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6 mb-3">
              <label class="form-label required">NIP</label>
              <input type="text" name="nip" class="form-control" placeholder="NIP / NUPTK" required>
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Nama Lengkap (Tanpa Gelar)</label>
              <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Guru" required>
            </div>
            <div class="col-lg-3 mb-3">
              <label class="form-label">Gelar Depan</label>
              <input type="text" name="gelar_depan" class="form-control" placeholder="Drs. / Dr.">
            </div>
            <div class="col-lg-3 mb-3">
              <label class="form-label">Gelar Belakang</label>
              <input type="text" name="gelar_belakang" class="form-control" placeholder="S.Pd. / M.Pd.">
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Jenis Kelamin</label>
              <select name="jk" class="form-select" required>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>

            <!-- Multi-Select Mata Pelajaran Diampu -->
            <div class="col-lg-12 mb-3">
              <label class="form-label fw-bold text-primary"><i class="ti ti-book me-1"></i>Mata Pelajaran Yang Diampu (Bisa Lebih Dari 1)</label>
              <select name="mapel_ids[]" class="form-select select2" multiple="multiple" data-placeholder="-- Pilih Mapel yang Diampu --">
                <?php foreach ($list_mapel as $mp): ?>
                  <option value="<?= $mp['id'] ?>"><?= html_escape($mp['nama_mapel']) ?> (Kode: <?= html_escape($mp['kode_mapel']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-lg-6 mb-3">
              <label class="form-label">No. Telepon / WA</label>
              <input type="text" name="no_hp" class="form-control" placeholder="0812...">
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Email</label>
              <input type="email" name="email" class="form-control" placeholder="guru@sekolah.sch.id" required>
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Status Kepegawaian</label>
              <select name="status_kepegawaian" class="form-select" required>
                <option value="PNS">PNS (Pegawai Negeri Sipil)</option>
                <option value="PPPK">PPPK (Pegawai Pemerintah Perjanjian Kerja)</option>
                <option value="GTY">GTY (Guru Tetap Yayasan)</option>
                <option value="GTT">GTT (Guru Tidak Tetap)</option>
                <option value="Honorer">Honorer</option>
              </select>
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Role Akses Login</label>
              <select name="role_id" class="form-select" required>
                <?php foreach ($list_roles as $role): ?>
                  <option value="<?= $role['id'] ?>" <?= ($role['role_code'] == 'guru') ? 'selected' : '' ?>><?= html_escape($role['role_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Username Login</label>
              <input type="text" name="username" class="form-control" placeholder="username_guru" required>
            </div>
            <div class="col-lg-6 mb-3">
              <label class="form-label required">Password Login</label>
              <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold">Simpan Guru & Mapel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('master/import_excel/guru') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Import Guru dari Excel</h5>
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
