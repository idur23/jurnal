<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-books me-2 text-info"></i> KELOLA MAPEL MBF
        </h2>
      </div>
      <div class="col-auto ms-auto">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddMapel">
          <i class="ti ti-plus me-1"></i> Tambah Mapel MBF
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
        <h3 class="card-title text-dark mb-0"><i class="ti ti-list me-2"></i> DAFTAR MATA PELAJARAN MBF</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead class="bg-light">
            <tr>
              <th width="50">No</th>
              <th>Kode Mapel</th>
              <th>Nama Mapel MBF</th>
              <th>Tentor / Pengajar</th>
              <th>Tahun Pelajaran</th>
              <th class="text-center">Jumlah Peserta</th>
              <th class="text-center">Status</th>
              <th class="text-center" width="220">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($list_mapel)): ?>
              <?php $no = 1; foreach ($list_mapel as $m): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><span class="badge bg-secondary-lt fs-3"><?= html_escape($m['kode_mapel']) ?></span></td>
                  <td class="fw-bold text-dark fs-3"><?= html_escape($m['nama_mapel']) ?></td>
                  <td><i class="ti ti-user-check me-1 text-info"></i> <?= html_escape($m['nama_tentor']) ?></td>
                  <td><?= html_escape($m['tahun']) ?> (<?= html_escape($m['semester']) ?>)</td>
                  <td class="text-center">
                    <span class="badge bg-success-lt fs-3 px-3"><?= (int)$m['total_peserta'] ?> Siswa</span>
                  </td>
                  <td class="text-center">
                    <?php if ($m['status'] == 1): ?>
                      <span class="badge bg-success-lt">Aktif</span>
                    <?php else: ?>
                      <span class="badge bg-danger-lt">Nonaktif</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <a href="<?= base_url('mbf/peserta/' . $m['id']) ?>" class="btn btn-sm btn-success me-1">
                      <i class="ti ti-users me-1"></i> Kelola Peserta
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-primary me-1" onclick="editMapel(<?= html_escape(json_encode($m)) ?>)">
                      <i class="ti ti-edit"></i>
                    </button>
                    <form action="<?= base_url('mbf/mapel') ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus Mapel MBF ini?');">
                      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="<?= $m['id'] ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center text-muted py-4">Belum ada data Mapel MBF. Silakan tambahkan Mapel MBF baru.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- MODAL ADD MAPEL -->
<div class="modal modal-blur fade" id="modalAddMapel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('mbf/mapel') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h5 class="modal-title"><i class="ti ti-plus me-2 text-primary"></i> Tambah Mapel MBF Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Kode Mapel MBF</label>
            <input type="text" name="kode_mapel" class="form-control" required placeholder="Contoh: MBF-THF-01">
          </div>
          <div class="mb-3">
            <label class="form-label required">Nama Mapel MBF</label>
            <input type="text" name="nama_mapel" class="form-control" required placeholder="Contoh: Tahfidz / Bahasa Arab">
          </div>
          <div class="mb-3">
            <label class="form-label required">Tentor Pengajar</label>
            <select name="tentor_id" class="form-select" required>
              <option value="">-- Pilih Tentor MBF --</option>
              <?php foreach ($list_tentor as $t): ?>
                <option value="<?= $t['id'] ?>"><?= html_escape($t['nama_lengkap']) ?> (<?= html_escape($t['username'] ?? '-') ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Tahun Pelajaran</label>
              <select name="tahun_pelajaran_id" class="form-select" required>
                <?php foreach ($list_tp as $tp): ?>
                  <option value="<?= $tp['id'] ?>" <?= ($active_tp && $active_tp['id'] == $tp['id']) ? 'selected' : '' ?>>
                    <?= html_escape($tp['tahun']) ?> (<?= html_escape($tp['semester']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Semester</label>
              <select name="semester" class="form-select" required>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary ms-auto"><i class="ti ti-device-floppy me-1"></i> Simpan Mapel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT MAPEL -->
<div class="modal modal-blur fade" id="modalEditMapel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('mbf/mapel') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" id="edit_mapel_id">
        <div class="modal-header">
          <h5 class="modal-title"><i class="ti ti-edit me-2 text-primary"></i> Edit Mapel MBF</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Kode Mapel MBF</label>
            <input type="text" name="kode_mapel" id="edit_kode_mapel" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Nama Mapel MBF</label>
            <input type="text" name="nama_mapel" id="edit_nama_mapel" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Tentor Pengajar</label>
            <select name="tentor_id" id="edit_tentor_id" class="form-select" required>
              <option value="">-- Pilih Tentor MBF --</option>
              <?php foreach ($list_tentor as $t): ?>
                <option value="<?= $t['id'] ?>"><?= html_escape($t['nama_lengkap']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Tahun Pelajaran</label>
              <select name="tahun_pelajaran_id" id="edit_tahun_pelajaran_id" class="form-select" required>
                <?php foreach ($list_tp as $tp): ?>
                  <option value="<?= $tp['id'] ?>"><?= html_escape($tp['tahun']) ?> (<?= html_escape($tp['semester']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Semester</label>
              <select name="semester" id="edit_semester" class="form-select" required>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" id="edit_status" class="form-select">
              <option value="1">Aktif</option>
              <option value="0">Nonaktif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary ms-auto"><i class="ti ti-device-floppy me-1"></i> Update Mapel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function editMapel(data) {
  document.getElementById('edit_mapel_id').value = data.id;
  document.getElementById('edit_kode_mapel').value = data.kode_mapel || '';
  document.getElementById('edit_nama_mapel').value = data.nama_mapel || '';
  document.getElementById('edit_tentor_id').value = data.tentor_id || '';
  document.getElementById('edit_tahun_pelajaran_id').value = data.tahun_pelajaran_id || '';
  document.getElementById('edit_semester').value = data.semester || 'Ganjil';
  document.getElementById('edit_status').value = data.status || '1';

  var modal = new bootstrap.Modal(document.getElementById('modalEditMapel'));
  modal.show();
}
</script>
