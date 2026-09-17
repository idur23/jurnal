<style>
.status-btn-group .btn {
  font-weight: bold;
  padding: 10px 14px;
  border-width: 2px;
  transition: all 0.2s ease-in-out;
}
.status-btn-group .btn-check:checked + .btn-outline-success {
  background-color: #2fb344 !important;
  color: #fff !important;
  border-color: #2fb344 !important;
  box-shadow: 0 0 10px rgba(47, 179, 68, 0.4);
}
.status-btn-group .btn-check:checked + .btn-outline-info {
  background-color: #4299e1 !important;
  color: #fff !important;
  border-color: #4299e1 !important;
  box-shadow: 0 0 10px rgba(66, 153, 225, 0.4);
}
.status-btn-group .btn-check:checked + .btn-outline-warning {
  background-color: #f6ad55 !important;
  color: #fff !important;
  border-color: #f6ad55 !important;
  box-shadow: 0 0 10px rgba(246, 173, 85, 0.4);
}
.status-btn-group .btn-check:checked + .btn-outline-danger {
  background-color: #e53e3e !important;
  color: #fff !important;
  border-color: #e53e3e !important;
  box-shadow: 0 0 10px rgba(229, 62, 62, 0.4);
}
.student-presensi-item {
  background-color: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
}
.student-name-text {
  color: #1e293b !important;
  font-weight: 700 !important;
}
@media (max-width: 767px) {
  .status-btn-group {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
  }
  .status-btn-group .btn {
    flex: 1 1 45%;
    font-size: 13px;
    padding: 10px 4px;
  }
}
</style>

<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL TENTOR MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-user-check me-2 text-warning"></i> PRESENSI SISWA MBF
        </h2>
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

    <!-- SELECTION HEADER FORM -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <form action="<?= base_url('tentor/presensi') ?>" method="GET" class="row g-3 align-items-center">
          <div class="col-md-6">
            <label class="form-label required">Mapel MBF</label>
            <select name="mapel_id" class="form-select fs-3" onchange="this.form.submit()">
              <?php foreach ($mapel_list as $m): ?>
                <option value="<?= $m['id'] ?>" <?= ($selected_mapel && $selected_mapel['id'] == $m['id']) ? 'selected' : '' ?>>
                  <?= html_escape($m['nama_mapel']) ?> (<?= html_escape($m['kode_mapel']) ?>) — <?= (int)$m['total_peserta'] ?> Peserta
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label required">Tanggal Presensi</label>
            <input type="date" name="tanggal" class="form-control fs-3" value="<?= html_escape($tanggal) ?>" onchange="this.form.submit()">
          </div>

          <div class="col-md-2 text-end pt-md-4">
            <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-1"></i> Muat Data</button>
          </div>
        </form>
      </div>
    </div>

    <!-- MAIN PRESENSI & JURNAL FORM -->
    <?php if ($selected_mapel && !empty($peserta)): ?>
      <form action="<?= base_url('tentor/presensi') ?>" method="POST" id="formSavePresensi" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="mapel_mbf_id" value="<?= $selected_mapel['id'] ?>">
        <input type="hidden" name="tanggal" value="<?= html_escape($tanggal) ?>">

        <!-- HIDDEN SYNC INPUTS FOR JURNAL MBF -->
        <input type="hidden" name="pertemuan_ke" id="hid_pertemuan_ke" value="<?= html_escape($presensi_header['pertemuan_ke'] ?? 1) ?>">
        <input type="hidden" name="status_sesi" id="hid_status_sesi" value="<?= html_escape($presensi_header['status_sesi'] ?? 'Selesai') ?>">
        <input type="hidden" name="nama_mapel_custom" id="hid_nama_mapel_custom" value="<?= html_escape($presensi_header['nama_mapel_custom'] ?? $selected_mapel['nama_mapel']) ?>">
        <input type="hidden" name="ruangan" id="hid_ruangan" value="<?= html_escape($presensi_header['ruangan'] ?? '') ?>">
        <input type="hidden" name="jam_mulai" id="hid_jam_mulai" value="<?= html_escape($presensi_header['jam_mulai'] ?? '12:35') ?>">
        <input type="hidden" name="jam_selesai" id="hid_jam_selesai" value="<?= html_escape($presensi_header['jam_selesai'] ?? '14:05') ?>">
        <input type="hidden" name="materi_pembahasan" id="hid_materi_pembahasan" value="<?= html_escape($presensi_header['materi_pembahasan'] ?? '') ?>">
        <input type="hidden" name="catatan_tentor" id="hid_catatan_tentor" value="<?= html_escape($presensi_header['catatan_tentor'] ?? '') ?>">
        <input type="file" name="foto_dokumentasi" id="hid_foto_dokumentasi" class="d-none">

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
              <h3 class="card-title text-dark mb-0">
                PRESENSI & JURNAL: <strong class="text-primary"><?= html_escape($selected_mapel['nama_mapel']) ?></strong>
              </h3>
              <div class="small text-muted mt-1">
                Tanggal: <strong><?= date('d F Y', strtotime($tanggal)) ?></strong> | Tentor: <strong><?= html_escape($selected_mapel['nama_tentor']) ?></strong>
                <?php if (!empty($presensi_header['pertemuan_ke'])): ?>
                  <span class="badge bg-info-lt ms-2">Pertemuan Ke-<?= $presensi_header['pertemuan_ke'] ?> (<?= html_escape($presensi_header['status_sesi'] ?? 'Terjadwal') ?>)</span>
                <?php else: ?>
                  <span class="badge bg-success-lt ms-2">Presensi Baru</span>
                <?php endif; ?>
              </div>
            </div>

            <div class="d-flex flex-wrap gap-2">
              <button type="button" class="btn btn-warning btn-md shadow-sm" data-bs-toggle="modal" data-bs-target="#modalInputJurnal">
                <i class="ti ti-notebook me-1"></i> Input Jurnal MBF
              </button>
              <button type="button" class="btn btn-outline-success btn-sm shadow-sm" id="btnMarkAllHadir">
                <i class="ti ti-checks me-1"></i> Tandai Semua Hadir
              </button>
              <button type="submit" class="btn btn-success btn-md shadow-sm px-4">
                <i class="ti ti-device-floppy me-1"></i> Simpan Jurnal & Presensi
              </button>
            </div>
          </div>

          <!-- JURNAL SUMMARY BAR -->
          <?php if (!empty($presensi_header)): ?>
            <div class="card-body bg-light border-bottom py-3">
              <div class="row g-2 align-items-center text-dark">
                <div class="col-md-3">
                  <span class="text-muted small d-block">Ruangan / Kelas:</span>
                  <strong class="text-primary"><i class="ti ti-building me-1"></i> <?= html_escape($presensi_header['ruangan'] ?? 'Ruang KBM MBF') ?></strong>
                </div>
                <div class="col-md-3">
                  <span class="text-muted small d-block">Waktu Sesi:</span>
                  <strong><i class="ti ti-clock me-1"></i> <?= html_escape($presensi_header['jam_mulai'] ?? '-') ?> - <?= html_escape($presensi_header['jam_selesai'] ?? '-') ?></strong>
                </div>
                <div class="col-md-4">
                  <span class="text-muted small d-block">Materi Pembahasan:</span>
                  <span class="text-truncate d-block fw-semibold"><?= html_escape($presensi_header['materi_pembahasan'] ?? 'Belum ada materi diisi') ?></span>
                </div>
                <div class="col-md-2 text-end">
                  <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalInputJurnal">
                    <i class="ti ti-edit me-1"></i> Edit Jurnal
                  </button>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <!-- OPTIONAL HEADER NOTES -->
          <div class="card-body bg-light border-bottom py-2">
            <div class="row align-items-center">
              <div class="col-md-2 text-muted fw-bold">Catatan Pertemuan:</div>
              <div class="col-md-10">
                <input type="text" name="catatan_header" class="form-control form-control-sm" 
                       placeholder="Catatan umum pertemuan (materi/kejadian khusus)..." 
                       value="<?= html_escape($presensi_header['catatan'] ?? '') ?>">
              </div>
            </div>
          </div>

          <!-- TOUCH-FRIENDLY STUDENT LIST -->
          <div class="card-body bg-light p-2 p-md-3">
            <div class="list-group list-group-flush">
              <?php $no = 1; foreach ($peserta as $s): ?>
                <?php 
                  $ex_status = isset($presensi_details[$s['id']]) ? $presensi_details[$s['id']]['status'] : 'Hadir';
                  $ex_catatan = isset($presensi_details[$s['id']]) ? $presensi_details[$s['id']]['catatan'] : '';
                ?>
                <div class="list-group-item student-presensi-item rounded-3 mb-2 p-3 shadow-sm">
                  <div class="row align-items-center g-3">
                    
                    <!-- STUDENT INFO -->
                    <div class="col-md-5">
                      <div class="d-flex align-items-center">
                        <span class="avatar avatar-md bg-secondary-lt text-dark me-3 fw-bold rounded-circle flex-shrink-0">
                          <?= $no++ ?>
                        </span>
                        <div class="overflow-hidden">
                          <div class="student-name-text fs-2 text-truncate"><?= html_escape($s['nama_lengkap']) ?></div>
                          <div class="small text-secondary mt-1">
                            <span class="badge bg-info-lt me-1"><?= html_escape($s['nama_kelas']) ?></span>
                            NIS: <?= html_escape($s['nis']) ?>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- TOUCH-FRIENDLY STATUS BUTTONS -->
                    <div class="col-md-7">
                      <div class="status-btn-group btn-group w-100" role="group">
                        
                        <!-- HADIR -->
                        <input type="radio" class="btn-check chk-status-hadir" name="presensi[<?= $s['id'] ?>]" id="status_hadir_<?= $s['id'] ?>" value="Hadir" <?= ($ex_status == 'Hadir') ? 'checked' : '' ?>>
                        <label class="btn btn-outline-success" for="status_hadir_<?= $s['id'] ?>">
                          <i class="ti ti-check me-1"></i> HADIR
                        </label>

                        <!-- IZIN -->
                        <input type="radio" class="btn-check" name="presensi[<?= $s['id'] ?>]" id="status_izin_<?= $s['id'] ?>" value="Izin" <?= ($ex_status == 'Izin') ? 'checked' : '' ?>>
                        <label class="btn btn-outline-info" for="status_izin_<?= $s['id'] ?>">
                          <i class="ti ti-info-circle me-1"></i> IZIN
                        </label>

                        <!-- SAKIT -->
                        <input type="radio" class="btn-check" name="presensi[<?= $s['id'] ?>]" id="status_sakit_<?= $s['id'] ?>" value="Sakit" <?= ($ex_status == 'Sakit') ? 'checked' : '' ?>>
                        <label class="btn btn-outline-warning" for="status_sakit_<?= $s['id'] ?>">
                          <i class="ti ti-first-aid-kit me-1"></i> SAKIT
                        </label>

                        <!-- ALPA -->
                        <input type="radio" class="btn-check" name="presensi[<?= $s['id'] ?>]" id="status_alpa_<?= $s['id'] ?>" value="Alpa" <?= ($ex_status == 'Alpa') ? 'checked' : '' ?>>
                        <label class="btn btn-outline-danger" for="status_alpa_<?= $s['id'] ?>">
                          <i class="ti ti-x me-1"></i> ALPA
                        </label>

                      </div>

                      <div class="mt-2">
                        <input type="text" name="catatan_siswa[<?= $s['id'] ?>]" class="form-control form-control-sm" 
                               placeholder="Catatan khusus siswa (opsional)..." value="<?= html_escape($ex_catatan) ?>">
                      </div>
                    </div>

                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- MODAL INPUT JURNAL KELAS & SESI (TABLER THEME MATCHING APP) -->
          <?php if ($selected_mapel): ?>
          <div class="modal modal-blur fade" id="modalInputJurnal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-white border-bottom py-3">
                  <h5 class="modal-title text-dark fw-bold"><i class="ti ti-notebook me-2 text-warning"></i> Jurnal Kelas & Sesi MBF</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                  
                  <div class="row g-3 mb-3">
                    <div class="col-md-6">
                      <label class="form-label required fw-bold text-dark fs-3">Pertemuan Ke- *</label>
                      <input type="number" id="input_pertemuan_ke" class="form-control fs-3" 
                             value="<?= html_escape($presensi_header['pertemuan_ke'] ?? 1) ?>" min="1" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label required fw-bold text-dark fs-3">Status *</label>
                      <select id="input_status_sesi" class="form-select fs-3">
                        <option value="Terjadwal" <?= (isset($presensi_header['status_sesi']) && $presensi_header['status_sesi'] == 'Terjadwal') ? 'selected' : '' ?>>Terjadwal</option>
                        <option value="Selesai" <?= (!isset($presensi_header['status_sesi']) || $presensi_header['status_sesi'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                        <option value="Batal" <?= (isset($presensi_header['status_sesi']) && $presensi_header['status_sesi'] == 'Batal') ? 'selected' : '' ?>>Batal</option>
                      </select>
                    </div>
                  </div>

                  <div class="row g-3 mb-3">
                    <div class="col-md-6">
                      <label class="form-label text-dark fw-bold fs-3">Mata Pelajaran (Master)</label>
                      <select class="form-select fs-3 bg-light text-muted" disabled>
                        <option selected>-- <?= html_escape($selected_mapel['nama_mapel']) ?> --</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label required fw-bold text-dark fs-3">Nama Mata Pelajaran *</label>
                      <input type="text" id="input_nama_mapel_custom" class="form-control fs-3" 
                             placeholder="Misal: Matematika UTBK & SNBT" 
                             value="<?= html_escape($presensi_header['nama_mapel_custom'] ?? $selected_mapel['nama_mapel']) ?>">
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label required fw-bold text-dark fs-3">Ruangan / Kelas *</label>
                    <input type="text" id="input_ruangan" class="form-control fs-3" 
                           placeholder="Misal: 12 IPA 1 atau Ruang 101" 
                           value="<?= html_escape($presensi_header['ruangan'] ?? '') ?>">
                  </div>

                  <div class="row g-3 mb-3">
                    <div class="col-md-4">
                      <label class="form-label required fw-bold text-dark fs-3">Tanggal *</label>
                      <input type="date" class="form-control fs-3 bg-light" value="<?= html_escape($tanggal) ?>" readonly>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label required fw-bold text-dark fs-3">Jam Mulai *</label>
                      <input type="time" id="input_jam_mulai" class="form-control fs-3" 
                             value="<?= html_escape($presensi_header['jam_mulai'] ?? '12:35') ?>">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label required fw-bold text-dark fs-3">Jam Selesai *</label>
                      <input type="time" id="input_jam_selesai" class="form-control fs-3" 
                             value="<?= html_escape($presensi_header['jam_selesai'] ?? '14:05') ?>">
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-bold text-dark fs-3">Materi Pembahasan</label>
                    <textarea id="input_materi_pembahasan" class="form-control" rows="3" 
                              placeholder="Tuliskan materi yang diajarkan pada sesi ini..."><?= html_escape($presensi_header['materi_pembahasan'] ?? '') ?></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-bold text-dark fs-3">Catatan Tambahan Tentor</label>
                    <textarea id="input_catatan_tentor" class="form-control" rows="2" 
                              placeholder="Catatan keaktifan/kendala santri..."><?= html_escape($presensi_header['catatan_tentor'] ?? '') ?></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-bold text-dark fs-3">Foto Dokumentasi Sesi</label>
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border">
                      <div class="text-center p-2 rounded bg-white border shadow-sm" style="width: 90px; height: 75px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <?php if (!empty($presensi_header['foto_dokumentasi']) && file_exists('./' . $presensi_header['foto_dokumentasi'])): ?>
                          <img src="<?= base_url($presensi_header['foto_dokumentasi']) ?>" style="max-width: 100%; max-height: 100%; object-fit: cover;" class="rounded">
                        <?php else: ?>
                          <i class="ti ti-photo fs-1 text-muted"></i>
                          <span class="small text-muted" style="font-size: 10px;">No Photo</span>
                        <?php endif; ?>
                      </div>
                      <div class="flex-fill">
                        <input type="file" id="input_foto_dokumentasi" class="form-control form-control-sm" accept="image/*">
                        <div class="small text-muted mt-1" style="font-size: 11px;">Upload foto kegiatan/suasana KBM (JPG, PNG, WEBP max 3MB)</div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer bg-white border-top py-3">
                  <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-warning px-4 shadow-sm" data-bs-dismiss="modal" onclick="syncModalToForm()"><i class="ti ti-check me-1"></i> Simpan Detail Jurnal</button>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <div class="card-footer bg-white border-top text-end py-3">
            <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
              <i class="ti ti-device-floppy me-1"></i> Simpan Jurnal & Presensi
            </button>
          </div>
        </div>

      </form>
    <?php elseif ($selected_mapel): ?>
      <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
          <i class="ti ti-users fs-1 text-muted mb-2"></i>
          <h3 class="text-muted">Belum ada siswa terdaftar pada mapel ini.</h3>
          <p class="text-muted">Silakan minta Administrator MBF untuk memasukkan peserta pada Mapel <strong><?= html_escape($selected_mapel['nama_mapel']) ?></strong>.</p>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>

<script>
function syncModalToForm() {
  const p = document.getElementById('input_pertemuan_ke'); if (p && document.getElementById('hid_pertemuan_ke')) document.getElementById('hid_pertemuan_ke').value = p.value;
  const st = document.getElementById('input_status_sesi'); if (st && document.getElementById('hid_status_sesi')) document.getElementById('hid_status_sesi').value = st.value;
  const n = document.getElementById('input_nama_mapel_custom'); if (n && document.getElementById('hid_nama_mapel_custom')) document.getElementById('hid_nama_mapel_custom').value = n.value;
  const r = document.getElementById('input_ruangan'); if (r && document.getElementById('hid_ruangan')) document.getElementById('hid_ruangan').value = r.value;
  const jm = document.getElementById('input_jam_mulai'); if (jm && document.getElementById('hid_jam_mulai')) document.getElementById('hid_jam_mulai').value = jm.value;
  const js = document.getElementById('input_jam_selesai'); if (js && document.getElementById('hid_jam_selesai')) document.getElementById('hid_jam_selesai').value = js.value;
  const m = document.getElementById('input_materi_pembahasan'); if (m && document.getElementById('hid_materi_pembahasan')) document.getElementById('hid_materi_pembahasan').value = m.value;
  const c = document.getElementById('input_catatan_tentor'); if (c && document.getElementById('hid_catatan_tentor')) document.getElementById('hid_catatan_tentor').value = c.value;
}

document.addEventListener('DOMContentLoaded', function() {
  const btnMarkAll = document.getElementById('btnMarkAllHadir');
  if (btnMarkAll) {
    btnMarkAll.addEventListener('click', function() {
      const hadirCheckboxes = document.querySelectorAll('.chk-status-hadir');
      hadirCheckboxes.forEach(chk => {
        chk.checked = true;
      });
    });
  }

  // DataTransfer File Sync from Modal to Hidden Main Form Input
  const modalFoto = document.getElementById('input_foto_dokumentasi');
  const hidFoto = document.getElementById('hid_foto_dokumentasi');
  if (modalFoto && hidFoto) {
    modalFoto.addEventListener('change', function() {
      if (this.files && this.files.length > 0) {
        try {
          const dt = new DataTransfer();
          dt.items.add(this.files[0]);
          hidFoto.files = dt.files;
        } catch (e) {
          console.error("DataTransfer file sync error:", e);
        }
      }
    });
  }

  const formSave = document.getElementById('formSavePresensi');
  if (formSave) {
    formSave.addEventListener('submit', function() {
      syncModalToForm();
    });
  }
});
</script>
