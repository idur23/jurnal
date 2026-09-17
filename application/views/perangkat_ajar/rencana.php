<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Perangkat Ajar</div>
      <h2 class="page-title text-indigo"><i class="ti ti-article me-2"></i>Kelola Rencana Pelaksanaan Pembelajaran</h2>
      <div class="text-muted small mt-1">Input, kelola, atau impor rencana pelaksanaan KBM dari file Excel.</div>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('perangkat_ajar/download_template_rencana') ?>" class="btn btn-outline-success me-2">
        <i class="ti ti-file-spreadsheet me-1"></i> Unduh Template Excel
      </a>
      <button type="button" class="btn btn-success me-2 fw-bold" id="btnTriggerImportExcel">
        <i class="ti ti-file-upload me-1"></i> Unggah Excel Rencana Pelaksanaan
      </button>
      <input type="file" id="inputImportExcelRencana" name="file_excel" accept=".xlsx, .xls" class="d-none">
      <a href="<?= base_url('perangkat_ajar/upload') ?>" class="btn btn-indigo me-2"><i class="ti ti-upload me-1"></i> Informasi Utama (Upload)</a>
      <a href="<?= base_url('perangkat_ajar/daftar') ?>" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar</a>
    </div>
  </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-success shadow-sm mb-4" role="alert">
    <i class="ti ti-circle-check me-2"></i><?= $this->session->flashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show border-danger shadow-sm mb-4" role="alert">
    <i class="ti ti-alert-circle me-2"></i><?= $this->session->flashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row g-4">
  <!-- Left Side: Form Input / Edit Rencana Pelaksanaan -->
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm rounded-3">
      <div class="card-header bg-indigo text-white">
        <h3 class="card-title text-white">
          <i class="ti ti-edit me-2"></i><?= $edit_mode ? 'Edit Rencana Pelaksanaan #' . $edit_item['id'] : 'Form Tambah Rencana Pelaksanaan' ?>
        </h3>
      </div>
      <div class="card-body p-4">

        <!-- Notification placeholder when importing Excel -->
        <div id="excelImportNotice" class="d-none"></div>

        <form action="<?= base_url('perangkat_ajar/save_rencana') ?>" method="POST" id="formRencana">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <?php if ($edit_mode): ?>
            <input type="hidden" name="id" value="<?= $edit_item['id'] ?>">
          <?php endif; ?>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Tahun Pelajaran / Semester</label>
              <input type="text" class="form-control" value="<?= html_escape($active_tp['tahun'] . ' - ' . $active_tp['semester']) ?>" readonly>
            </div>

            <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin'))): ?>
              <div class="col-md-6">
                <label class="form-label fw-bold required">Guru Pengampu</label>
                <select name="guru_id" class="form-select select2" required>
                  <option value="">-- Pilih Guru --</option>
                  <?php foreach ($list_guru as $g): ?>
                    <option value="<?= $g['id'] ?>" <?= ($edit_mode && $edit_item['guru_id'] == $g['id']) ? 'selected' : '' ?>><?= html_escape($g['nama_lengkap']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            <?php endif; ?>

            <div class="col-md-6">
              <label class="form-label fw-bold required">Mata Pelajaran</label>
              <select name="mapel_id" class="form-select select2" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                <?php foreach ($list_mapel as $m): ?>
                  <option value="<?= $m['id'] ?>" <?= ($edit_mode && $edit_item['mapel_id'] == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Multi-Select Kelas -->
            <div class="col-md-12">
              <label class="form-label fw-bold required">Kelas (Dapat memilih lebih dari 1 kelas)</label>
              <?php 
                $selected_kelas_ids = array();
                if ($edit_mode && !empty($edit_item['kelas_ids'])) {
                    $selected_kelas_ids = json_decode($edit_item['kelas_ids'], true) ?: array($edit_item['kelas_id']);
                } elseif ($edit_mode && !empty($edit_item['kelas_id'])) {
                    $selected_kelas_ids = array($edit_item['kelas_id']);
                }
              ?>
              <select name="kelas_ids[]" class="form-select select2" multiple="multiple" data-placeholder="-- Pilih Satu atau Beberapa Kelas --" required>
                <?php foreach ($list_kelas as $k): ?>
                  <option value="<?= $k['id'] ?>" <?= (in_array($k['id'], $selected_kelas_ids)) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-12">
              <label class="form-label fw-bold">Elemen Mapel</label>
              <input type="text" name="elemen" class="form-control" placeholder="Contoh: Pemahaman Al-Qur'an, Pemodelan..." value="<?= $edit_mode ? html_escape($edit_item['elemen']) : '' ?>">
            </div>

            <div class="col-md-12">
              <label class="form-label fw-bold required">Materi Pembelajaran / Pokok Bahasan</label>
              <input type="text" name="materi_pembelajaran" class="form-control" placeholder="Materi pokok..." value="<?= $edit_mode ? html_escape($edit_item['materi_pembelajaran']) : '' ?>" required>
            </div>

            <div class="col-md-12">
              <label class="form-label fw-bold">Sub Materi Pembelajaran</label>
              <textarea name="sub_materi" class="form-control" rows="2" placeholder="Sub-bab / Sub materi pokok..."><?= $edit_mode ? html_escape($edit_item['sub_materi']) : '' ?></textarea>
            </div>

            <div class="col-md-12">
              <label class="form-label fw-bold">Capaian Pembelajaran (CP)</label>
              <textarea name="capaian_pembelajaran" class="form-control" rows="3" placeholder="Tuliskan Capaian Pembelajaran..."><?= $edit_mode ? html_escape($edit_item['capaian_pembelajaran']) : '' ?></textarea>
            </div>

            <div class="col-md-12">
              <label class="form-label fw-bold text-indigo required">Tujuan Pembelajaran (TP)</label>
              <textarea name="tujuan_pembelajaran" class="form-control" rows="3" placeholder="Tuliskan Tujuan Pembelajaran yang ingin dicapai..." required><?= $edit_mode ? html_escape($edit_item['tujuan_pembelajaran']) : '' ?></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Metode Pembelajaran (Bisa Dipilih Lebih dari 1)</label>
              <?php 
                $metode_opts = array('Ceramah', 'Diskusi Kelompok', 'Tanya Jawab', 'Demonstrasi', 'Eksperimen / Praktikum', 'Drill / Latihan', 'Presentasi Siswa', 'Studi Kasus');
                $selected_metode = array_map('trim', explode(',', $edit_mode ? ($edit_item['metode_pembelajaran'] ?? '') : ''));
              ?>
              <select name="metode_pembelajaran[]" class="form-select select2-tags" multiple="multiple" data-placeholder="Pilih atau ketik metode...">
                <?php foreach ($metode_opts as $m_opt): ?>
                  <option value="<?= $m_opt ?>" <?= in_array($m_opt, $selected_metode) ? 'selected' : '' ?>><?= $m_opt ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Model Pembelajaran (Bisa Dipilih Lebih dari 1)</label>
              <?php 
                $model_opts = array('Problem Based Learning (PBL)', 'Project Based Learning (PjBL)', 'Discovery Learning', 'Inquiry Learning', 'Cooperative Learning', 'Direct Instruction', 'Contextual Teaching and Learning (CTL)');
                $selected_model = array_map('trim', explode(',', $edit_mode ? ($edit_item['model_pembelajaran'] ?? '') : ''));
              ?>
              <select name="model_pembelajaran[]" class="form-select select2-tags" multiple="multiple" data-placeholder="Pilih atau ketik model...">
                <?php foreach ($model_opts as $md_opt): ?>
                  <option value="<?= $md_opt ?>" <?= in_array($md_opt, $selected_model) ? 'selected' : '' ?>><?= $md_opt ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Media Pembelajaran (Bisa Dipilih Lebih dari 1)</label>
              <?php 
                $media_opts = array('LCD Proyektor', 'Slide Presentasi (PPT)', 'Papan Tulis / Whiteboard', 'Video Pembelajaran', 'LKPD / Lembar Kerja', 'Alat Peraga Praktikum', 'Aplikasi Online / LMS');
                $selected_media = array_map('trim', explode(',', $edit_mode ? ($edit_item['media_pembelajaran'] ?? '') : ''));
              ?>
              <select name="media_pembelajaran[]" class="form-select select2-tags" multiple="multiple" data-placeholder="Pilih atau ketik media...">
                <?php foreach ($media_opts as $med_opt): ?>
                  <option value="<?= $med_opt ?>" <?= in_array($med_opt, $selected_media) ? 'selected' : '' ?>><?= $med_opt ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Sumber Belajar (Bisa Dipilih Lebih dari 1)</label>
              <?php 
                $sumber_opts = array('Buku Paket Kemenag / Kemendikbud', 'Modul Ajar Guru', 'Jurnal / Artikel Ilmiah', 'Website / Internet', 'Video YouTube Educational', 'Lingkungan Sekitar');
                $selected_sumber = array_map('trim', explode(',', $edit_mode ? ($edit_item['sumber_belajar'] ?? '') : ''));
              ?>
              <select name="sumber_belajar[]" class="form-select select2-tags" multiple="multiple" data-placeholder="Pilih atau ketik sumber belajar...">
                <?php foreach ($sumber_opts as $s_opt): ?>
                  <option value="<?= $s_opt ?>" <?= in_array($s_opt, $selected_sumber) ? 'selected' : '' ?>><?= $s_opt ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-12">
              <label class="form-label fw-bold">Bentuk Penilaian / Asesmen (Bisa Dipilih Lebih dari 1)</label>
              <?php 
                $penilaian_opts = array('Penilaian Sikap (Observasi)', 'Penilaian Kinerja / Praktik', 'Penilaian Produk / Proyek', 'Tes Tertulis Pilihan Ganda', 'Tes Tertulis Uraian / Essay', 'Kuis Lisan', 'Portofolio Siswa');
                $selected_penilaian = array_map('trim', explode(',', $edit_mode ? ($edit_item['bentuk_penilaian'] ?? '') : ''));
              ?>
              <select name="bentuk_penilaian[]" class="form-select select2-tags" multiple="multiple" data-placeholder="Pilih atau ketik bentuk penilaian...">
                <?php foreach ($penilaian_opts as $p_opt): ?>
                  <option value="<?= $p_opt ?>" <?= in_array($p_opt, $selected_penilaian) ? 'selected' : '' ?>><?= $p_opt ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-12 text-end mt-4">
              <button type="submit" class="btn btn-indigo btn-lg fw-bold px-5 py-2">
                <i class="ti ti-device-floppy me-2"></i> <?= $edit_mode ? 'Perbarui Rencana Pelaksanaan' : 'Simpan Rencana Pelaksanaan' ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Right Side: Daftar Rencana Pelaksanaan Terdaftar -->
  <div class="col-lg-5">
    <div class="card border-0 shadow-sm rounded-3">
      <div class="card-header bg-dark text-white">
        <h3 class="card-title text-white"><i class="ti ti-list me-2"></i>Daftar Rencana Pelaksanaan</h3>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-vcenter card-table table-hover table-striped">
            <thead>
              <tr>
                <th>Mapel / Kelas</th>
                <th>Materi Pembelajaran</th>
                <th class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($rencana_list)): ?>
                <tr>
                  <td colspan="3" class="text-center text-muted py-4">Belum ada data Rencana Pelaksanaan.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($rencana_list as $rp): ?>
                  <tr>
                    <td>
                      <div class="fw-bold text-indigo"><?= html_escape($rp['nama_mapel']) ?></div>
                      <div class="text-muted small"><?= html_escape($rp['nama_kelas'] ?? 'Multi-Kelas') ?></div>
                    </td>
                    <td>
                      <div class="fw-bold small"><?= html_escape($rp['materi_pembelajaran']) ?></div>
                      <div class="text-muted extra-small text-truncate" style="max-width: 180px;"><?= html_escape($rp['tujuan_pembelajaran']) ?></div>
                    </td>
                    <td class="text-end">
                      <a href="<?= base_url('perangkat_ajar/rencana/' . $rp['id']) ?>" class="btn btn-sm btn-icon btn-outline-warning" title="Edit"><i class="ti ti-edit"></i></a>
                      <a href="<?= base_url('perangkat_ajar/delete_rencana/' . $rp['id']) ?>" class="btn btn-sm btn-icon btn-outline-danger" onclick="return confirm('Hapus rencana pelaksanaan ini?')" title="Hapus"><i class="ti ti-trash"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
        jQuery('.select2-tags').select2({
            tags: true,
            tokenSeparators: [','],
            width: '100%'
        });
    }

    var btnImport = document.getElementById('btnTriggerImportExcel');
    var inputExcel = document.getElementById('inputImportExcelRencana');

    if (btnImport && inputExcel) {
        btnImport.addEventListener('click', function() {
            var mapelId = jQuery('select[name="mapel_id"]').val();
            var kelasIds = jQuery('select[name="kelas_ids[]"]').val();
            var guruElem = jQuery('select[name="guru_id"]');
            var guruId = guruElem.length ? guruElem.val() : '1';

            if (!mapelId || !kelasIds || !kelasIds.length || (guruElem.length && !guruId)) {
                alert('⚠️ Silakan pilih Mata Pelajaran dan Kelas pada form terlebih dahulu, agar data dari berkas Excel yang diunggah langsung tersimpan otomatis ke Daftar Rencana Pelaksanaan!');
                var formElem = document.getElementById('formRencana');
                if (formElem) formElem.scrollIntoView({ behavior: 'smooth' });
                return;
            }

            inputExcel.click();
        });

        inputExcel.addEventListener('change', function() {
            if (!this.files || !this.files[0]) return;

            var formData = new FormData();
            formData.append('file_excel', this.files[0]);
            formData.append('<?= $this->security->get_csrf_token_name(); ?>', '<?= $this->security->get_csrf_hash(); ?>');

            // Pass currently selected form values for direct DB auto-save
            var guruId = jQuery('select[name="guru_id"]').val();
            var mapelId = jQuery('select[name="mapel_id"]').val();
            var kelasIds = jQuery('select[name="kelas_ids[]"]').val();

            if (guruId) formData.append('guru_id', guruId);
            if (mapelId) formData.append('mapel_id', mapelId);
            if (kelasIds && kelasIds.length) {
                kelasIds.forEach(function(kId) {
                    formData.append('kelas_ids[]', kId);
                });
            }

            fetch('<?= base_url("perangkat_ajar/import_excel_rencana_ajax") ?>', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    if (res.auto_saved) {
                        alert('🎉 ' + res.message);
                        window.location.reload();
                    } else {
                        var d = res.data;
                        if (d.elemen) document.querySelector('input[name="elemen"]').value = d.elemen;
                        if (d.materi_pembelajaran) document.querySelector('input[name="materi_pembelajaran"]').value = d.materi_pembelajaran;
                        if (d.sub_materi) document.querySelector('textarea[name="sub_materi"]').value = d.sub_materi;
                        if (d.capaian_pembelajaran) document.querySelector('textarea[name="capaian_pembelajaran"]').value = d.capaian_pembelajaran;
                        if (d.tujuan_pembelajaran) document.querySelector('textarea[name="tujuan_pembelajaran"]').value = d.tujuan_pembelajaran;

                        ['metode_pembelajaran', 'model_pembelajaran', 'media_pembelajaran', 'sumber_belajar', 'bentuk_penilaian'].forEach(function(field) {
                            if (d[field]) {
                                var items = d[field].split(',').map(function(s) { return s.trim(); }).filter(Boolean);
                                var selectElem = jQuery('select[name="' + field + '[]"]');
                                if (selectElem.length) {
                                    items.forEach(function(item) {
                                        if (!selectElem.find('option[value="' + item + '"]').length) {
                                            selectElem.append(new Option(item, item, true, true));
                                        }
                                    });
                                    selectElem.val(items).trigger('change');
                                }
                            }
                        });

                        var noticeHtml = '<div class="alert alert-important alert-info border-info shadow-sm mb-3 text-white">' +
                          '<div class="d-flex align-items-center">' +
                          '<i class="ti ti-info-circle fs-1 me-3"></i>' +
                          '<div>' +
                          '<h4 class="mb-1 text-white"><i class="ti ti-circle-check me-1"></i> Data Excel Berhasil Diisikan ke Form!</h4>' +
                          '<p class="mb-0 text-white-50">Silakan tentukan <strong>Mata Pelajaran</strong> & <strong>Kelas</strong> di bawah, lalu tekan tombol <strong>"Simpan Rencana Pelaksanaan"</strong> untuk menyimpannya ke database.</p>' +
                          '</div>' +
                          '</div>' +
                          '</div>';

                        jQuery('#excelImportNotice').html(noticeHtml).removeClass('d-none');
                        var formElem = document.getElementById('formRencana');
                        if (formElem) formElem.scrollIntoView({ behavior: 'smooth' });
                    }
                } else {
                    alert('⚠️ ' + (res.message || 'Gagal membaca file Excel.'));
                }
                inputExcel.value = '';
            })
            .catch(err => {
                alert('⚠️ Error: ' + err.message);
                inputExcel.value = '';
            });
        });
    }
});
</script>
