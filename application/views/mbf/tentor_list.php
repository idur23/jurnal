<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-user-check me-2 text-primary"></i> KELOLA DATA TENTOR MBF
        </h2>
      </div>
      <div class="col-auto ms-auto">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddTentor">
          <i class="ti ti-plus me-1"></i> Tambah Tentor Baru
        </button>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check me-2 fs-2"></i> <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ti ti-alert-circle me-2 fs-2"></i> <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title text-dark mb-0"><i class="ti ti-list me-2"></i> DAFTAR TENTOR MBF</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead class="bg-light">
            <tr>
              <th width="50">No</th>
              <th>Nama Lengkap Tentor</th>
              <th>NIP / ID</th>
              <th>No. HP</th>
              <th>Username Account</th>
              <th class="text-center">Mapel Diampu</th>
              <th class="text-center">Status</th>
              <th class="text-center" width="150">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($list_tentor)): ?>
              <?php $no = 1; foreach ($list_tentor as $t): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td class="fw-bold text-dark fs-3">
                    <?= html_escape($t['nama_lengkap']) ?>
                    <?php if (!empty($t['guru_id'])): ?>
                      <span class="badge bg-primary-lt ms-1" title="Diambil dari Data Guru">Guru Existing</span>
                    <?php endif; ?>
                  </td>
                  <td><?= html_escape($t['nip'] ? $t['nip'] : '-') ?></td>
                  <td><?= html_escape($t['no_hp'] ? $t['no_hp'] : '-') ?></td>
                  <td><span class="badge bg-indigo-lt fs-3"><?= html_escape($t['username'] ? $t['username'] : '-') ?></span></td>
                  <td class="text-center">
                    <span class="badge bg-info-lt fs-3"><?= (int)$t['total_mapel'] ?> Mapel</span>
                  </td>
                  <td class="text-center">
                    <?php if ($t['is_active'] == 1): ?>
                      <span class="badge bg-success-lt">Aktif</span>
                    <?php else: ?>
                      <span class="badge bg-danger-lt">Nonaktif</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-primary me-1" 
                            onclick="editTentor(<?= html_escape(json_encode($t)) ?>)">
                      <i class="ti ti-edit"></i> Edit
                    </button>
                    <form action="<?= base_url('mbf/tentor') ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus Tentor ini?');">
                      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="<?= $t['id'] ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center text-muted py-4">Belum ada data Tentor. Silakan tambahkan data Tentor baru.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- MODAL ADD TENTOR -->
<div class="modal modal-blur fade" id="modalAddTentor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('mbf/tentor') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h5 class="modal-title"><i class="ti ti-user-plus me-2 text-primary"></i> Tambah Tentor MBF</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- SUMBER DATA TENTOR -->
          <div class="mb-3">
            <label class="form-label required">Sumber Data Tentor</label>
            <div class="form-selectgroup form-selectgroup-boxes d-flex gap-2">
              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="source_type" value="from_guru" class="form-selectgroup-input" checked onclick="toggleSourceType('from_guru')">
                <span class="form-selectgroup-label d-flex align-items-center p-3">
                  <i class="ti ti-user-check fs-2 me-2 text-primary"></i>
                  <span class="text-start">
                    <span class="fw-bold d-block">Pilih dari Data Guru</span>
                    <span class="small text-muted">Ambil dari Guru Existing</span>
                  </span>
                </span>
              </label>

              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="source_type" value="new" class="form-selectgroup-input" onclick="toggleSourceType('new')">
                <span class="form-selectgroup-label d-flex align-items-center p-3">
                  <i class="ti ti-user-plus fs-2 me-2 text-success"></i>
                  <span class="text-start">
                    <span class="fw-bold d-block">Tentor Baru</span>
                    <span class="small text-muted">Input Tentor Non-Guru</span>
                  </span>
                </span>
              </label>
            </div>
          </div>

          <!-- SECTION: DARI DATA GURU -->
          <div id="sectionFromGuru" class="mb-3">
            <label class="form-label required">Pilih Guru Existing</label>
            <select name="guru_id" class="form-select fs-3">
              <option value="">-- Pilih Guru Existing --</option>
              <?php foreach ($list_guru as $g): ?>
                <option value="<?= $g['id'] ?>">
                  <?= html_escape($g['nama_lengkap']) ?> (NIP: <?= html_escape($g['nip'] ? $g['nip'] : '-') ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <div class="form-text text-muted">Guru yang dipilih akan otomatis didaftarkan sebagai Tentor MBF. Akun login guru tetap menggunakan akun existing.</div>
          </div>

          <!-- SECTION: INPUT TENTOR BARU -->
          <div id="sectionNewTentor" style="display: none;">
            <div class="mb-3">
              <label class="form-label required">Nama Lengkap Tentor</label>
              <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Ustadz Ahmad, S.Pd.I">
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">NIP / ID Tentor</label>
                <input type="text" name="nip" class="form-control" placeholder="Opsional">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">No. HP / WhatsApp</label>
                <input type="text" name="no_hp" class="form-control" placeholder="08123456789">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" placeholder="tentor@mbf.sch.id">
            </div>
            <hr>
            <div class="mb-3">
              <label class="form-label required">Username Login</label>
              <input type="text" name="username" class="form-control" placeholder="username_tentor">
            </div>
            <div class="mb-3">
              <label class="form-label required">Password Login</label>
              <input type="password" name="password" class="form-control" placeholder="******">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary ms-auto"><i class="ti ti-device-floppy me-1"></i> Simpan Tentor</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT TENTOR -->
<div class="modal modal-blur fade" id="modalEditTentor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('mbf/tentor') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" id="edit_id">
        <div class="modal-header">
          <h5 class="modal-title"><i class="ti ti-edit me-2 text-primary"></i> Edit Data Tentor MBF</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Nama Lengkap Tentor</label>
            <input type="text" name="nama_lengkap" id="edit_nama_lengkap" class="form-control" required>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">NIP / ID Tentor</label>
              <input type="text" name="nip" id="edit_nip" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">No. HP / WhatsApp</label>
              <input type="text" name="no_hp" id="edit_no_hp" class="form-control">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" id="edit_email" class="form-control">
          </div>
          <hr>
          <div class="mb-3">
            <label class="form-label required">Username Login</label>
            <input type="text" name="username" id="edit_username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password Baru <span class="text-muted small">(Kosongkan jika tidak ingin mengubah)</span></label>
            <input type="password" name="password" class="form-control" placeholder="******">
          </div>
          <div class="mb-3">
            <label class="form-label">Status Akun</label>
            <select name="is_active" id="edit_is_active" class="form-select">
              <option value="1">Aktif</option>
              <option value="0">Nonaktif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary ms-auto"><i class="ti ti-device-floppy me-1"></i> Update Tentor</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function toggleSourceType(type) {
  if (type === 'from_guru') {
    document.getElementById('sectionFromGuru').style.display = 'block';
    document.getElementById('sectionNewTentor').style.display = 'none';
  } else {
    document.getElementById('sectionFromGuru').style.display = 'none';
    document.getElementById('sectionNewTentor').style.display = 'block';
  }
}

function editTentor(data) {
  document.getElementById('edit_id').value = data.id;
  document.getElementById('edit_nama_lengkap').value = data.nama_lengkap || '';
  document.getElementById('edit_nip').value = data.nip || '';
  document.getElementById('edit_no_hp').value = data.no_hp || '';
  document.getElementById('edit_email').value = data.email || '';
  document.getElementById('edit_username').value = data.username || '';
  document.getElementById('edit_is_active').value = data.is_active || '1';

  var modal = new bootstrap.Modal(document.getElementById('modalEditTentor'));
  modal.show();
}
</script>
