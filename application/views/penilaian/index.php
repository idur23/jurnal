<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Penilaian Akademik Siswa</h2>
      <div class="text-muted small mt-1">Input nilai akademik berdasarkan kategori Rapor Digital Madrasah (RDM) dan ekspor nilai secara efisien.</div>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card mb-4">
  <div class="card-body">
    <form action="<?= base_url('penilaian') ?>" method="GET" class="row g-3">
      <div class="col-md-4">
        <label class="form-label required">Kelas</label>
        <select name="kelas_id" class="form-select select2" required>
          <option value="">-- Pilih Kelas --</option>
          <?php foreach ($list_kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= (($selected_kelas_id ?? $selected_kelas ?? '') == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label required">Mata Pelajaran</label>
        <select name="mapel_id" class="form-select select2" required>
          <option value="">-- Pilih Mapel --</option>
          <?php foreach ($list_mapel as $m): ?>
            <option value="<?= $m['id'] ?>" <?= (($selected_mapel_id ?? $selected_mapel ?? '') == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label required">Jenis Penilaian</label>
        <select name="jenis_penilaian" class="form-select">
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['kode_kategori'] ?>" <?= (($selected_jenis ?? '') == $cat['kode_kategori']) ? 'selected' : '' ?>><?= html_escape($cat['nama_kategori']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-1 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-1"></i> Cari</button>
      </div>
    </form>
  </div>
</div>
<?php if ($selected_kelas_id && $selected_mapel_id): ?>
  <?php if (isset($presensi_error) && !empty($presensi_error)): ?>
    <div class="alert alert-danger border-danger border-left-5 py-3 shadow-sm" role="alert">
      <div class="d-flex align-items-center gap-2">
        <i class="ti ti-alert-triangle fs-2 text-danger"></i>
        <div>
          <h4 class="alert-title mb-1 fw-bold">Alur Penginputan Terkunci!</h4>
          <div class="text-muted"><?= $presensi_error ?></div>
        </div>
      </div>
      <div class="mt-3">
        <a href="<?= base_url('presensikelas') ?>" class="btn btn-danger fw-bold"><i class="ti ti-plus me-1"></i> Buat Presensi Kelas Sekarang</a>
      </div>
    </div>
  <?php else: ?>
    <div class="d-flex gap-2 justify-content-end mb-3">
      <!-- Template & Import actions -->
  <a href="<?= base_url("penilaian/download_template?kelas_id=$selected_kelas_id&mapel_id=$selected_mapel_id&jenis_penilaian=$selected_jenis") ?>" class="btn btn-outline-success">
    <i class="ti ti-download me-1"></i> Unduh Template Excel
  </a>
  <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
    <i class="ti ti-upload me-1"></i> Import Nilai Excel
  </button>
</div>

<form action="<?= base_url('penilaian') ?>" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
  <input type="hidden" name="action" value="save_nilai">
  <input type="hidden" name="kelas_id" value="<?= $selected_kelas_id ?>">
  <input type="hidden" name="mapel_id" value="<?= $selected_mapel_id ?>">
  <input type="hidden" name="jenis_penilaian" value="<?= $selected_jenis ?>">

  <div class="card mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h3 class="card-title text-white">
        <i class="ti ti-edit me-2"></i>Form Entry Nilai: <?= html_escape(ucfirst(str_replace('_', ' ', $selected_jenis))) ?>
      </h3>
      <div>
        <span class="badge bg-white text-primary fw-bold">Skala Nilai: 0.00 s/d 100.00</span>
      </div>
    </div>
    <div class="card-body">
      <div class="row mb-3 g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label fw-bold">Pilih Penilaian / Tugas</label>
          <select id="selectNamaPenilaian" class="form-select select2">
            <option value="new" <?= ($selected_nama_penilaian === 'new' || empty($selected_nama_penilaian)) ? 'selected' : '' ?>>+ Tambah Penilaian Baru</option>
            <?php foreach ($list_nama_penilaian as $nama): ?>
              <option value="<?= html_escape($nama) ?>" <?= ($selected_nama_penilaian === $nama) ? 'selected' : '' ?>><?= html_escape($nama) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6" id="inputNamaPenilaianWrapper" style="display: <?= ($selected_nama_penilaian && $selected_nama_penilaian !== 'new') ? 'none' : 'block' ?>;">
          <label class="form-label required fw-bold">Nama / Judul Penilaian Baru</label>
          <input type="text" id="inputNamaPenilaian" name="nama_penilaian" class="form-control" placeholder="Misal: Penilaian Harian Bab 1" <?= ($selected_nama_penilaian && $selected_nama_penilaian !== 'new') ? '' : 'required' ?> value="">
        </div>
        <?php if ($selected_nama_penilaian && $selected_nama_penilaian !== 'new'): ?>
          <div class="col-md-6">
            <label class="form-label fw-bold text-success"><i class="ti ti-edit me-1"></i>Nama / Judul Penilaian (Sedang Diedit)</label>
            <div class="input-group">
              <input type="text" name="nama_penilaian" class="form-control bg-light fw-bold" value="<?= html_escape($selected_nama_penilaian) ?>" readonly>
              <button type="button" class="btn btn-outline-danger fw-bold" data-bs-toggle="modal" data-bs-target="#modalDeletePenilaian" title="Hapus Penilaian Ini">
                <i class="ti ti-trash me-1"></i> Hapus Penilaian
              </button>
            </div>
          </div>

          <!-- Modal Delete Penilaian -->
          <div class="modal modal-blur fade" id="modalDeletePenilaian" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                  <h5 class="modal-title text-white"><i class="ti ti-alert-triangle me-2"></i>Konfirmasi Hapus Penilaian</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                  <i class="ti ti-trash text-danger icon-lg mb-2" style="font-size: 3rem;"></i>
                  <h3>Hapus Penilaian ini?</h3>
                  <p class="text-muted">Apakah Anda yakin ingin menghapus penilaian <strong>"<?= html_escape($selected_nama_penilaian) ?>"</strong>? Seluruh nilai dan dokumen siswa terkait penilaian ini akan terhapus secara permanen.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                  <form action="<?= base_url('penilaian') ?>" method="POST" class="d-inline">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" value="delete_penilaian">
                    <input type="hidden" name="kelas_id" value="<?= $kelas_id ?>">
                    <input type="hidden" name="mapel_id" value="<?= $mapel_id ?>">
                    <input type="hidden" name="jenis_penilaian" value="<?= html_escape($selected_jenis) ?>">
                    <input type="hidden" name="nama_penilaian" value="<?= html_escape($selected_nama_penilaian) ?>">
                    <button type="submit" class="btn btn-danger fw-bold"><i class="ti ti-trash me-1"></i> Ya, Hapus Sekarang</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <div class="table-responsive">
        <table class="table table-vcenter table-striped card-table">
          <thead>
            <tr>
              <th style="width: 50px;">#</th>
              <th>NIS / NISN</th>
              <th>Nama Siswa</th>
              <th style="width: 200px;">
                <div>Nilai (0 - 100)</div>
                <!-- Quick Fill Score Control -->
                <div class="input-group input-group-sm mt-1">
                  <input type="number" id="quickScoreInput" class="form-control form-control-sm" placeholder="Isi..." min="0" max="100" step="0.01">
                  <button type="button" class="btn btn-sm btn-success text-white fw-bold" id="btnSetAllScore">
                    <i class="ti ti-arrow-down"></i>
                  </button>
                </div>
              </th>
              <?php if ($selected_jenis == 'portofolio'): ?>
                <th>Upload Dokumen/Karya</th>
              <?php elseif ($selected_jenis == 'praktik'): ?>
                <th>Rubrik Penilaian (Keterampilan)</th>
              <?php endif; ?>
              <th>Catatan / Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($siswa)): ?>
              <tr>
                <td colspan="<?= ($selected_jenis == 'portofolio' || $selected_jenis == 'praktik') ? '6' : '5' ?>" class="text-center text-muted py-4">Tidak ada data siswa di kelas ini.</td>
              </tr>
            <?php else: ?>
              <?php $no=1; foreach ($siswa as $s): ?>
                <?php 
                  $current_val = isset($existing_nilai[$s['id']]['nilai']) ? $existing_nilai[$s['id']]['nilai'] : '';
                  $current_catatan = isset($existing_nilai[$s['id']]['catatan']) ? $existing_nilai[$s['id']]['catatan'] : '';
                  $current_file = isset($existing_nilai[$s['id']]['file_portofolio']) ? $existing_nilai[$s['id']]['file_portofolio'] : '';
                  $current_rubrik = isset($existing_nilai[$s['id']]['rubrik_penilaian']) ? $existing_nilai[$s['id']]['rubrik_penilaian'] : '';
                ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><code><?= html_escape($s['nis']) ?></code></td>
                  <td class="fw-bold"><?= html_escape($s['nama_lengkap']) ?></td>
                  <td>
                    <input type="number" 
                           step="0.01" 
                           min="0" 
                           max="100" 
                           name="nilai[<?= $s['id'] ?>]" 
                           class="form-control form-control-sm fw-bold input-score" 
                           value="<?= html_escape($current_val) ?>" 
                           placeholder="0 - 100" 
                           oninput="validateScore(this)"
                           required>
                  </td>
                  
                  <?php if ($selected_jenis == 'portofolio'): ?>
                    <td>
                      <input type="file" name="file_portofolio_<?= $s['id'] ?>" class="form-control form-control-sm">
                      <?php if ($current_file): ?>
                        <div class="mt-1">
                          <a href="<?= base_url($current_file) ?>" target="_blank" class="badge bg-green-lt"><i class="ti ti-file me-1"></i> Lihat Karya</a>
                        </div>
                      <?php endif; ?>
                    </td>
                  <?php elseif ($selected_jenis == 'praktik'): ?>
                    <td>
                      <input type="text" name="rubrik_penilaian[<?= $s['id'] ?>]" class="form-control form-control-sm" value="<?= html_escape($current_rubrik) ?>" placeholder="Contoh: Kerapian, Akurasi, Kreativitas">
                    </td>
                  <?php endif; ?>

                  <td>
                    <input type="text" 
                           name="catatan[<?= $s['id'] ?>]" 
                           class="form-control form-control-sm" 
                           value="<?= html_escape($current_catatan) ?>" 
                           placeholder="Evaluasi...">
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer text-end">
      <button type="submit" class="btn btn-primary btn-lg fw-bold"><i class="ti ti-device-floppy me-2"></i> Simpan Penilaian Akademik</button>
    </div>
  </div>
</form>

<!-- Modal Import Excel -->
<div class="modal modal-blur fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('penilaian/import') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="preview">
        <input type="hidden" name="kelas_id" value="<?= $selected_kelas_id ?>">
        <input type="hidden" name="mapel_id" value="<?= $selected_mapel_id ?>">
        <input type="hidden" name="jenis_penilaian" value="<?= $selected_jenis ?>">

        <div class="modal-header">
          <h5 class="modal-title">Import Nilai dari Excel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Nama / Judul Penilaian</label>
            <input type="text" name="nama_penilaian" class="form-control" placeholder="Misal: Penilaian Harian Bab 1" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">File Excel (.xlsx, .xls)</label>
            <input type="file" name="excel_file" class="form-control" accept=".xlsx, .xls" required>
            <small class="text-muted mt-1 d-block">Gunakan template Excel yang diunduh untuk menghindari kesalahan format data.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold"><i class="ti ti-upload me-1"></i> Preview dan Validasi</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function validateScore(input) {
  var val = parseFloat(input.value);
  if (isNaN(val)) return;
  if (val > 100) {
    input.value = 100;
  } else if (val < 0) {
    input.value = 0;
  }
}

$(document).on('click', '#btnSetAllScore', function() {
  var scoreVal = $('#quickScoreInput').val();
  if (scoreVal !== '') {
    var num = parseFloat(scoreVal);
    if (!isNaN(num)) {
      var cleanVal = Math.max(0, Math.min(100, num));
      $('.input-score').val(cleanVal);
    }
  }
});

$(document).on('change', '#selectNamaPenilaian', function() {
  var val = $(this).val();
  var url = new URL(window.location.href);
  url.searchParams.set('nama_penilaian', val);
  window.location.href = url.toString();
});
<?php endif; // End of presensi_error check ?>
</script>
<?php else: ?>
  <div class="card card-body text-center text-muted py-5 mb-4">
    <i class="ti ti-info-circle fs-1 text-primary mb-2"></i>
    <h3>Silakan pilih Kelas dan Mata Pelajaran terlebih dahulu.</h3>
    <p class="mb-0">Pilih Kelas dan Mata Pelajaran pada form filter di atas lalu klik tombol <strong>Cari</strong> untuk memuat daftar siswa.</p>
  </div>
<?php endif; ?>
