<?php if (isset($kelas['is_admin_mode']) && $kelas['is_admin_mode']): ?>
<div class="card mb-4 d-print-none border-0 shadow-sm overflow-hidden position-relative" style="border-radius: 12px; background: linear-gradient(135deg, #eff6ff 0%, #f5f3ff 100%); border-left: 5px solid #6366f1 !important;">
  <div class="card-body py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div class="d-flex align-items-center gap-2">
      <span class="avatar avatar-sm bg-indigo text-white rounded-3">
        <i class="ti ti-shield-check fs-3"></i>
      </span>
      <div>
        <h4 class="mb-0 fw-bold text-indigo">Simulasi Wali Kelas (Mode Admin)</h4>
        <p class="text-muted small mb-0">Anda sedang mengakses halaman khusus wali kelas. Silakan pilih kelas binaan:</p>
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <span class="text-muted small fw-semibold"><i class="ti ti-building me-1"></i>Pilih Kelas:</span>
      <div style="width: 200px;">
        <select class="form-select form-select-sm fw-bold border-indigo" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(99, 102, 241, 0.1);" onchange="location = '<?= base_url($this->uri->uri_string()) ?>?kelas_id=' + this.value;">
          <?php foreach ($kelas['list_kelas_all'] as $k): ?>
            <option value="<?= $k['id'] ?>" <?= ($kelas['id'] == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Wali Kelas</div>
      <h2 class="page-title">Program Kerja & Jurnal Wali Kelas</h2>
      <div class="text-muted small mt-1">Kelola agenda kegiatan pembinaan kelas dan program kerja wali kelas.</div>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <a href="<?= base_url('walikelas/download_template/program_kelas') ?>" class="btn btn-outline-success">
        <i class="ti ti-download me-1"></i> Template Excel
      </a>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        <i class="ti ti-upload me-1"></i> Import Excel
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddProgram">
        <i class="ti ti-plus me-1"></i> Tambah Program Baru
      </button>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header bg-dark text-white">
    <h3 class="card-title text-white"><i class="ti ti-checklist me-2"></i>Agenda Program Kelas: Kelas <?= html_escape($kelas['nama_kelas']) ?></h3>
  </div>
  <?php if (empty($programs)): ?>
    <div class="card-body text-center py-5 text-muted">
      <i class="ti ti-checklist fs-1 text-indigo mb-2"></i>
      <h3 class="mt-2">Belum ada rencana program kelas yang dicatat.</h3>
      <p class="mb-0">Klik tombol <strong>Tambah Program Baru</strong> di kanan atas untuk memulai.</p>
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-vcenter card-table table-striped datatable">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Tanggal</th>
            <th>Nama Program</th>
            <th>Target & Pelaksanaan</th>
            <th>Status</th>
            <th>Catatan</th>
            <th>Dokumentasi</th>
            <th class="text-center" style="width: 130px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; foreach ($programs as $p): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= date('d M Y', strtotime($p['tanggal'])) ?></td>
              <td class="fw-bold text-indigo"><?= html_escape($p['program']) ?></td>
              <td>
                <div class="small"><strong>Target:</strong> <?= html_escape($p['target'] ? $p['target'] : '-') ?></div>
                <div class="small text-muted"><strong>Pelaksanaan:</strong> <?= html_escape($p['pelaksanaan'] ? $p['pelaksanaan'] : '-') ?></div>
              </td>
              <td>
                <?php if ($p['status'] == 'Terealisasi'): ?>
                  <span class="badge bg-success text-white fw-bold">Terealisasi</span>
                <?php else: ?>
                  <span class="badge bg-warning text-white fw-bold">Belum</span>
                <?php endif; ?>
              </td>
              <td class="small"><?= html_escape($p['catatan'] ? $p['catatan'] : '-') ?></td>
              <td>
                <?php if ($p['dokumentasi']): ?>
                  <a href="<?= base_url($p['dokumentasi']) ?>" target="_blank" class="badge bg-green-lt"><i class="ti ti-file me-1"></i> File Lampiran</a>
                <?php else: ?>
                  <span class="text-muted small">Tidak ada</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <div class="btn-list flex-nowrap justify-content-center">
                  <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEditProgram_<?= $p['id'] ?>" title="Edit Program">
                    <i class="ti ti-edit"></i>
                  </button>
                  <form action="<?= base_url('walikelas/program_kelas') ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kelas ini?')">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Program">
                      <i class="ti ti-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>

            <!-- Modal Edit Program -->
            <div class="modal modal-blur fade" id="modalEditProgram_<?= $p['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <form action="<?= base_url('walikelas/program_kelas') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">

                    <div class="modal-header">
                      <h5 class="modal-title">Edit Program Kelas</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label required">Tanggal</label>
                          <input type="date" name="tanggal" class="form-control" value="<?= html_escape($p['tanggal']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label required">Status Realisasi</label>
                          <select name="status" class="form-select" required>
                            <option value="Belum" <?= $p['status'] == 'Belum' ? 'selected' : '' ?>>Belum Terealisasi</option>
                            <option value="Terealisasi" <?= $p['status'] == 'Terealisasi' ? 'selected' : '' ?>>Terealisasi</option>
                          </select>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label required">Nama Program / Kegiatan</label>
                        <input type="text" name="program" class="form-control" value="<?= html_escape($p['program']) ?>" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Target Pencapaian</label>
                        <input type="text" name="target" class="form-control" value="<?= html_escape($p['target']) ?>">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Detail Pelaksanaan</label>
                        <textarea name="pelaksanaan" class="form-control" rows="2"><?= html_escape($p['pelaksanaan']) ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Catatan Hasil & Evaluasi</label>
                        <textarea name="catatan" class="form-control" rows="2"><?= html_escape($p['catatan']) ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Ganti Dokumentasi / Lampiran File</label>
                        <input type="file" name="dokumentasi" class="form-control">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-warning fw-bold">Update Program</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<!-- Modal Add Program -->
<div class="modal modal-blur fade" id="modalAddProgram" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('walikelas/program_kelas') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">

        <div class="modal-header">
          <h5 class="modal-title">Tambah Program Kelas Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Tanggal</label>
              <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Status Realisasi</label>
              <select name="status" class="form-select" required>
                <option value="Belum">Belum Terealisasi</option>
                <option value="Terealisasi">Terealisasi</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Nama Program / Kegiatan</label>
            <input type="text" name="program" class="form-control" placeholder="Contoh: Pembentukan Kepengurusan Kelas" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Target Pencapaian</label>
            <input type="text" name="target" class="form-control" placeholder="Contoh: Terpilih pengurus kelas yang sah">
          </div>
          <div class="mb-3">
            <label class="form-label">Detail Pelaksanaan</label>
            <textarea name="pelaksanaan" class="form-control" rows="2" placeholder="Contoh: Musyawarah kelas dipimpin oleh wali kelas..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Catatan Hasil & Evaluasi</label>
            <textarea name="catatan" class="form-control" rows="2" placeholder="Tuliskan catatan hasil jika program telah dilaksanakan..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Dokumentasi / Lampiran File</label>
            <input type="file" name="dokumentasi" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold">Simpan Program</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('walikelas/import/program_kelas') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Import Program Kelas dari Excel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">File Excel (.xlsx, .xls)</label>
            <input type="file" name="excel_file" class="form-control" accept=".xlsx, .xls" required>
            <small class="text-muted mt-1 d-block">Gunakan file template Excel untuk mengunggah agar format kolom benar.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold"><i class="ti ti-upload me-1"></i> Unggah & Validasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
