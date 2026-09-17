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
      <h2 class="page-title">Aktivitas Kokurikuler</h2>
      <div class="text-muted small mt-1">Kelola dan susun rencana serta realisasi proyek kokurikuler tingkat kelas.</div>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <a href="<?= base_url('walikelas/download_template/kokurikuler') ?>" class="btn btn-outline-success">
        <i class="ti ti-download me-1"></i> Template Excel
      </a>
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
        <i class="ti ti-upload me-1"></i> Import Excel
      </button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddKokurikuler">
        <i class="ti ti-plus me-1"></i> Tambah Kokurikuler
      </button>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header bg-dark text-white">
    <h3 class="card-title text-white"><i class="ti ti-briefcase me-2"></i>Daftar Aktivitas Kokurikuler Kelas: <?= html_escape($kelas['nama_kelas']) ?></h3>
  </div>
  <?php if (empty($kokurikuler_list)): ?>
    <div class="card-body text-center py-5 text-muted">
      <i class="ti ti-briefcase fs-1 text-warning mb-2"></i>
      <h3 class="mt-2">Belum ada kegiatan atau proyek kokurikuler yang dicatat.</h3>
      <p class="mb-0">Klik tombol <strong>Tambah Kokurikuler</strong> di kanan atas untuk memulai.</p>
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-vcenter card-table table-striped datatable">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Tanggal</th>
            <th>Tema & Sub-Tema</th>
            <th>Aktivitas & Tujuan</th>
            <th>Pendamping</th>
            <th>Output / Produk</th>
            <th>Status</th>
            <th>Dokumentasi</th>
            <th class="text-center" style="width: 130px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; foreach ($kokurikuler_list as $k): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= date('d M Y', strtotime($k['tanggal'])) ?></td>
              <td>
                <div class="fw-bold text-indigo"><?= html_escape($k['tema']) ?></div>
                <div class="text-muted small"><?= html_escape($k['sub_tema']) ?></div>
              </td>
              <td>
                <div class="small"><strong>Aktivitas:</strong> <?= html_escape($k['aktivitas']) ?></div>
                <div class="small text-muted"><strong>Tujuan:</strong> <?= html_escape($k['tujuan']) ?></div>
              </td>
              <td>
                <div class="small fw-bold"><i class="ti ti-user me-1"></i><?= html_escape($k['nama_guru_pendamping']) ?></div>
              </td>
              <td class="small fw-bold text-success"><?= html_escape($k['output'] ? $k['output'] : '-') ?></td>
              <td>
                <?php if ($k['status'] == 'Terlaksana'): ?>
                  <span class="badge bg-success text-white fw-bold">Terlaksana</span>
                <?php else: ?>
                  <span class="badge bg-warning text-white fw-bold">Rencana / Draft</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($k['dokumentasi']): ?>
                  <a href="<?= base_url($k['dokumentasi']) ?>" target="_blank" class="badge bg-green-lt"><i class="ti ti-photo me-1"></i> Lihat Media</a>
                <?php else: ?>
                  <span class="text-muted small">Tidak ada</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <div class="btn-list flex-nowrap justify-content-center">
                  <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEditKokurikuler_<?= $k['id'] ?>" title="Edit Kegiatan">
                    <i class="ti ti-edit"></i>
                  </button>
                  <form action="<?= base_url('walikelas/kokurikuler') ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rencana kokurikuler ini?')">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $k['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Kegiatan">
                      <i class="ti ti-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>

            <!-- Modal Edit Kokurikuler -->
            <div class="modal modal-blur fade" id="modalEditKokurikuler_<?= $k['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <form action="<?= base_url('walikelas/kokurikuler') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= $k['id'] ?>">

                    <div class="modal-header">
                      <h5 class="modal-title">Edit Kegiatan Kokurikuler</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label required">Tanggal</label>
                          <input type="date" name="tanggal" class="form-control" value="<?= html_escape($k['tanggal']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label required">Status Kegiatan</label>
                          <select name="status" class="form-select" required>
                            <option value="Draft" <?= $k['status'] == 'Draft' ? 'selected' : '' ?>>Rencana / Draft</option>
                            <option value="Terlaksana" <?= $k['status'] == 'Terlaksana' ? 'selected' : '' ?>>Terlaksana</option>
                          </select>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label required">Tema Projek / Kegiatan</label>
                        <?php 
                          $predefined_themes = array(
                            'Gaya Hidup Berkelanjutan (Cinta Bumi, Daur Ulang)',
                            'Kearifan Lokal (Budaya)',
                            'Bhinneka Tunggal Ika (Anti-Perundungan)',
                            'Kewirausahaan (Hidup Hemat/Produktif)',
                            'Bangunlah Jiwa Raganya (Generasi Sehat)',
                            'Aku Cinta Indonesia'
                          );
                        ?>
                        <select name="tema" class="form-select" required>
                          <option value="">-- Pilih Tema Kokurikuler --</option>
                          <?php foreach ($predefined_themes as $pt): ?>
                            <option value="<?= $pt ?>" <?= ($k['tema'] == $pt) ? 'selected' : '' ?>><?= $pt ?></option>
                          <?php endforeach; ?>
                          <?php if ($k['tema'] && !in_array($k['tema'], $predefined_themes)): ?>
                            <option value="<?= html_escape($k['tema']) ?>" selected><?= html_escape($k['tema']) ?></option>
                          <?php endif; ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label required">Sub-Tema / Judul Kegiatan</label>
                        <input type="text" name="sub_tema" class="form-control" value="<?= html_escape($k['sub_tema']) ?>" placeholder="Misal: Pengolahan Sampah Organik Kelas" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label required">Aktivitas</label>
                        <textarea name="aktivitas" class="form-control" rows="2" required><?= html_escape($k['aktivitas']) ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label required">Tujuan Kegiatan</label>
                        <textarea name="tujuan" class="form-control" rows="2" required><?= html_escape($k['tujuan']) ?></textarea>
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label required">Guru Pendamping</label>
                          <select name="guru_id" class="form-select" required>
                            <?php foreach ($list_guru as $g): ?>
                              <option value="<?= $g['id'] ?>" <?= $k['guru_id'] == $g['id'] ? 'selected' : '' ?>><?= html_escape($g['nama_lengkap']) ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Output / Hasil Akhir</label>
                          <input type="text" name="output" class="form-control" value="<?= html_escape($k['output']) ?>" placeholder="Contoh: Pupuk Kompos Cair">
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Ganti Dokumentasi Media</label>
                        <input type="file" name="dokumentasi" class="form-control">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-warning fw-bold">Update Kegiatan</button>
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

<!-- Modal Add Kokurikuler -->
<div class="modal modal-blur fade" id="modalAddKokurikuler" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('walikelas/kokurikuler') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">

        <div class="modal-header">
          <h5 class="modal-title">Tambah Kegiatan Kokurikuler Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Tanggal</label>
              <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Status Kegiatan</label>
              <select name="status" class="form-select" required>
                <option value="Draft">Rencana / Draft</option>
                <option value="Terlaksana">Terlaksana</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Tema Projek / Kegiatan</label>
            <select name="tema" class="form-select" required>
              <option value="">-- Pilih Tema Kokurikuler --</option>
              <option value="Gaya Hidup Berkelanjutan (Cinta Bumi, Daur Ulang)">Gaya Hidup Berkelanjutan (Cinta Bumi, Daur Ulang)</option>
              <option value="Kearifan Lokal (Budaya)">Kearifan Lokal (Budaya)</option>
              <option value="Bhinneka Tunggal Ika (Anti-Perundungan)">Bhinneka Tunggal Ika (Anti-Perundungan)</option>
              <option value="Kewirausahaan (Hidup Hemat/Produktif)">Kewirausahaan (Hidup Hemat/Produktif)</option>
              <option value="Bangunlah Jiwa Raganya (Generasi Sehat)">Bangunlah Jiwa Raganya (Generasi Sehat)</option>
              <option value="Aku Cinta Indonesia">Aku Cinta Indonesia</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label required">Sub-Tema / Judul Kegiatan</label>
            <input type="text" name="sub_tema" class="form-control" placeholder="Contoh: Pembuatan Sabun Organik Ramah Lingkungan" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Aktivitas Kegiatan</label>
            <textarea name="aktivitas" class="form-control" rows="2" placeholder="Tuliskan gambaran pelaksanaan kegiatan kokurikuler..." required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label required">Tujuan / Target Kompetensi</label>
            <textarea name="tujuan" class="form-control" rows="2" placeholder="Tuliskan tujuan / kompetensi profil pelajar pancasila yang disasar..." required></textarea>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Guru Pendamping</label>
              <select name="guru_id" class="form-select select2" required>
                <option value="">-- Pilih Pendamping --</option>
                <?php foreach ($list_guru as $g): ?>
                  <option value="<?= $g['id'] ?>"><?= html_escape($g['nama_lengkap']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Output / Produk Akhir</label>
              <input type="text" name="output" class="form-control" placeholder="Contoh: Laporan Projek & Produk Sabun">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Dokumentasi Media (Foto / Video)</label>
            <input type="file" name="dokumentasi" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold">Simpan Kegiatan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('walikelas/import/kokurikuler') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Import Kokurikuler dari Excel</h5>
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
