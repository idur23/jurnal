<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title text-indigo"><i class="ti ti-notebook me-2"></i>Input Jurnal Pembelajaran Baru</h2>
      <div class="text-muted small mt-1">Langkah 1: Isi detail jurnal kegiatan pembelajaran KBM hari ini. Data perangkat ajar akan dimuat otomatis jika tersedia.</div>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('jurnal') ?>" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i> Kembali</a>
    </div>
  </div>
</div>

<!-- Notification Placeholder -->
<div id="deviceNotification" class="d-none mb-3"></div>

<form action="<?= base_url('jurnal/add') ?>" method="POST" id="formJurnal" enctype="multipart/form-data">
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
  <input type="hidden" name="perangkat_ajar_id" id="perangkatAjarId" value="">

  <div class="row row-cards justify-content-center">
    <!-- Left Panel: Core Details (Auto Filled) -->
    <div class="col-lg-8">
      <div class="card mb-4 border-indigo shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-indigo text-white d-flex justify-content-between align-items-center">
          <h3 class="card-title text-white"><i class="ti ti-device-laptop me-2"></i>Detail Pembelajaran (Otomatis dari Perangkat)</h3>
          <button type="button" class="btn btn-sm btn-light d-none" id="btnPreviewPerangkat"><i class="ti ti-eye me-1"></i> Preview Perangkat</button>
        </div>
        <div class="card-body">
          <div class="row">
            
            <!-- Dropdown Rencana Pelaksanaan (Perangkat Ajar) -->
            <div class="col-md-12 mb-4">
              <div class="bg-indigo-lt p-3 rounded-3 border border-indigo shadow-sm">
                <label class="form-label text-indigo fw-bold fs-3 mb-1">
                  <i class="ti ti-clipboard-list me-1"></i> Pilih Rencana Pelaksanaan (Dapat memilih lebih dari 1)
                </label>
                <select id="selectRencanaPelaksanaan" class="form-select select2" multiple="multiple" data-placeholder="-- Pilih Satu atau Beberapa Rencana Pelaksanaan --">
                </select>
                <div class="form-text text-muted">Anda dapat memilih 1 atau lebih Rencana Pelaksanaan untuk mengisi otomatis CP, TP, Metode, Model, Media, Sumber, dan Penilaian.</div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label required">Tanggal KBM</label>
              <input type="text" name="tanggal" class="form-control datepicker" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label required">Kelas</label>
              <select name="kelas_id" id="selectKelas" class="form-select select2" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($list_kelas as $k): ?>
                  <option value="<?= $k['id'] ?>" <?= ($pre_kelas_id == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label required">Mata Pelajaran</label>
              <select name="mapel_id" id="selectMapel" class="form-select select2" required>
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($list_mapel as $m): ?>
                  <option value="<?= $m['id'] ?>" <?= ($pre_mapel_id == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label required">Pertemuan Ke-</label>
              <input type="number" name="pertemuan_ke" id="pertemuanKe" class="form-control" min="1" value="<?= $pre_pertemuan_ke ? $pre_pertemuan_ke : '1' ?>" required>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label required">Jam Pelajaran</label>
              <div class="row g-1">
                <div class="col-6">
                  <select name="jam_mulai_ke" id="jamMulai" class="form-select select2" required>
                    <?php for ($i=1; $i<=10; $i++): ?>
                      <option value="<?= $i ?>" <?= ($pre_jam_mulai_ke == $i) ? 'selected' : '' ?>>Jam ke-<?= $i ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
                <div class="col-6">
                  <select name="jam_selesai_ke" id="jamSelesai" class="form-select select2" required>
                    <?php for ($i=1; $i<=12; $i++): ?>
                      <option value="<?= $i ?>" <?= ($pre_jam_selesai_ke == $i || (!$pre_jam_selesai_ke && $i == 2)) ? 'selected' : '' ?>>s/d Jam ke-<?= $i ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3 d-none" id="divVersionSelector">
              <label class="form-label text-indigo fw-bold">Versi Perangkat Ajar</label>
              <select id="versionSelector" class="form-select select2"></select>
            </div>

            <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'waka', 'kamad'))): ?>
            <div class="col-md-12 mb-3">
              <label class="form-label required">Guru Pengampu</label>
              <select name="guru_id" id="selectGuru" class="form-select select2" required>
                <option value="">-- Pilih Guru --</option>
                <?php foreach ($list_guru as $g): ?>
                  <option value="<?= $g['id'] ?>" <?= ($guru_id == $g['id']) ? 'selected' : '' ?>><?= html_escape($g['nama_lengkap']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <?php else: ?>
              <input type="hidden" name="guru_id" id="selectGuru" value="<?= $guru_id ?>">
            <?php endif; ?>

            <div class="col-md-12 mb-3">
              <label class="form-label required">Materi Pembelajaran</label>
              <input type="text" name="materi_pembelajaran" id="materiPembelajaran" class="form-control" placeholder="Tuliskan materi pokok..." required>
            </div>

            <div class="col-md-12 mb-3">
              <label class="form-label">Sub Materi</label>
              <textarea name="sub_materi" id="subMateri" class="form-control" rows="2" placeholder="Sub materi pokok..."></textarea>
            </div>

            <div class="col-md-12 mb-3">
              <label class="form-label">Capaian Pembelajaran (CP)</label>
              <textarea name="capaian_pembelajaran" id="capaianPembelajaran" class="form-control" rows="2" placeholder="Capaian Pembelajaran..."></textarea>
            </div>

            <div class="col-md-12 mb-3">
              <label class="form-label">Tujuan Pembelajaran (TP)</label>
              <textarea name="tujuan_pembelajaran" id="tujuanPembelajaran" class="form-control" rows="2" placeholder="Tujuan Pembelajaran..."></textarea>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Metode Pembelajaran</label>
              <input type="text" name="metode_pembelajaran" id="metodePembelajaran" class="form-control" placeholder="Metode...">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Model Pembelajaran</label>
              <input type="text" name="model_pembelajaran" id="modelPembelajaran" class="form-control" placeholder="Model...">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Media Pembelajaran</label>
              <input type="text" name="media_pembelajaran" id="mediaPembelajaran" class="form-control" placeholder="Media...">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Sumber Belajar</label>
              <input type="text" name="sumber_belajar" id="sumberBelajar" class="form-control" placeholder="Sumber...">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Bentuk Penilaian</label>
              <input type="text" name="bentuk_penilaian" id="bentukPenilaian" class="form-control" placeholder="Asesmen...">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Alokasi Waktu</label>
              <input type="text" name="alokasi_waktu" id="alokasiWaktu" class="form-control" placeholder="Alokasi...">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Panel: Teacher Input -->
    <div class="col-lg-4">
      <div class="card mb-4 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-light">
          <h3 class="card-title text-indigo"><i class="ti ti-edit me-2"></i>Input Guru Hari Ini</h3>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Catatan Pembelajaran</label>
            <textarea name="catatan_pembelajaran" class="form-control" rows="3" placeholder="Tuliskan catatan pelaksanaan KBM hari ini..."></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Refleksi Pembelajaran</label>
            <textarea name="refleksi_pembelajaran" class="form-control" rows="3" placeholder="Tuliskan refleksi hasil belajar mengajar guru..."></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Kendala KBM</label>
            <textarea name="kendala" class="form-control" rows="2" placeholder="Kendala atau hambatan siswa/guru..."></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Solusi / Tindak Lanjut</label>
            <textarea name="solusi" class="form-control" rows="2" placeholder="Rencana pemecahan kendala..."></textarea>
          </div>


        </div>
        <div class="card-footer bg-light" style="border-radius: 0 0 12px 12px;">
          <button type="submit" class="btn btn-indigo w-100 fw-bold py-2"><i class="ti ti-device-floppy me-2"></i> Simpan & Presensi Kelas</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Preview Modal -->
<div class="modal modal-blur fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-indigo text-white">
        <h5 class="modal-title text-white"><i class="ti ti-eye"></i> Detail Perangkat Ajar</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="previewModalBody">
        <!-- Filled by JS -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-indigo" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var deviceList = [];
    var currentDevice = null;

    // Trigger lookup on field change
    $('#selectKelas, #selectMapel, #pertemuanKe, #selectGuru').on('change', function() {
      fetchPerangkat();
      loadRencanaDropdown();
    });

    // Load list of Rencana Pelaksanaan for dropdown
    function loadRencanaDropdown() {
      var mapel_id = $('#selectMapel').val();
      var guru_id  = $('#selectGuru').val();
      var kelas_id = $('#selectKelas').val();

      $.ajax({
        url: "<?= base_url('perangkat_ajar/get_rencana_list_ajax') ?>",
        type: "GET",
        data: { mapel_id: mapel_id, guru_id: guru_id, kelas_id: kelas_id },
        dataType: "json",
        success: function(res) {
          if (res.success && res.data && res.data.length > 0) {
            $('#selectRencanaPelaksanaan').empty();
            $.each(res.data, function(i, d) {
              var title = (d.materi_pembelajaran ? d.materi_pembelajaran : 'Rencana #' + d.id) + 
                          (d.nama_mapel ? ' [' + d.nama_mapel + ']' : '') +
                          (d.nama_kelas ? ' - ' + d.nama_kelas : '');
              $('#selectRencanaPelaksanaan').append('<option value="' + d.id + '">' + title + '</option>');
            });
          } else {
            $('#selectRencanaPelaksanaan').empty();
          }
        }
      });
    }

    // Auto-fill form when Rencana Pelaksanaan options are chosen (supports multi-select)
    $('#selectRencanaPelaksanaan').on('change', function() {
      var selectedVal = $(this).val();
      if (!selectedVal || (Array.isArray(selectedVal) && selectedVal.length === 0)) {
        clearFields();
        $('#deviceNotification').addClass('d-none');
        return;
      }

      var idsParam = Array.isArray(selectedVal) ? selectedVal.join(',') : selectedVal;

      $.ajax({
        url: "<?= base_url('jurnal/get_rencana_detail_ajax') ?>",
        type: "GET",
        data: { ids: idsParam },
        dataType: "json",
        success: function(res) {
          if (res.success && res.data) {
            populateFields(res.data);
            currentDevice = res.data;
            var count = res.items ? res.items.length : 1;
            $('#deviceNotification').html(
              '<div class="alert alert-success border-success shadow-sm mb-3">' +
              '<i class="ti ti-circle-check me-2"></i> ' + count + ' Data Rencana Pelaksanaan berhasil dimuat otomatis ke form Jurnal.' +
              '</div>'
            ).removeClass('d-none');
            $('#btnPreviewPerangkat').removeClass('d-none');
          }
        }
      });
    });

    loadRencanaDropdown();

    // Run on load in case fields are pre-populated
    if ($('#selectKelas').val() && $('#selectMapel').val() && $('#pertemuanKe').val()) {
      fetchPerangkat();
    }

    function fetchPerangkat() {
      var kelas_id = $('#selectKelas').val();
      var mapel_id = $('#selectMapel').val();
      var pertemuan_ke = $('#pertemuanKe').val();
      var guru_id = $('#selectGuru').val();

      if (!kelas_id || !mapel_id || !pertemuan_ke || !guru_id) {
        return;
      }

      $.ajax({
        url: "<?= base_url('jurnal/get_perangkat_ajax') ?>",
        type: "GET",
        data: {
          kelas_id: kelas_id,
          mapel_id: mapel_id,
          pertemuan_ke: pertemuan_ke,
          guru_id: guru_id
        },
        dataType: "json",
        success: function(res) {
          if (res.status) {
            currentDevice = res.data.device;
            deviceList = res.data.versions;
            
            // Populates fields
            populateFields(currentDevice);

            // Version selector handling
            if (deviceList.length > 1) {
              $('#divVersionSelector').removeClass('d-none');
              $('#versionSelector').empty();
              $.each(deviceList, function(i, d) {
                var selected = (d.id == currentDevice.id) ? 'selected' : '';
                $('#versionSelector').append('<option value="' + d.id + '" ' + selected + '>Versi ' + d.version + ' (' + d.status_verifikasi + ')</option>');
              });
            } else {
              $('#divVersionSelector').addClass('d-none');
            }

            // Notification handling
            if (res.data.warning) {
              $('#deviceNotification').html(
                '<div class="alert alert-warning border-warning shadow-sm mb-3">' +
                '<i class="ti ti-alert-triangle me-2"></i>' + res.data.warning +
                '</div>'
              ).removeClass('d-none');
            } else {
              $('#deviceNotification').html(
                '<div class="alert alert-success border-success shadow-sm mb-3">' +
                '<i class="ti ti-circle-check me-2"></i> Perangkat Ajar ditemukan dan disetujui (Versi ' + currentDevice.version + ').' +
                '</div>'
              ).removeClass('d-none');
            }

            $('#btnPreviewPerangkat').removeClass('d-none');
          } else {
            // Not found
            clearFields();
            $('#deviceNotification').html(
              '<div class="alert alert-danger border-danger shadow-sm mb-3">' +
              '<i class="ti ti-info-circle me-2"></i> ' + res.message +
              '</div>'
            ).removeClass('d-none');
            $('#divVersionSelector').addClass('d-none');
            $('#btnPreviewPerangkat').addClass('d-none');
            currentDevice = null;
          }
        },
        error: function() {
          clearFields();
          $('#btnPreviewPerangkat').addClass('d-none');
        }
      });
    }

    // Populate versions select change
    $('#versionSelector').on('change', function() {
      var selectedId = $(this).val();
      var selectedDevice = deviceList.find(function(item) {
        return item.id == selectedId;
      });
      if (selectedDevice) {
        populateFields(selectedDevice);
        currentDevice = selectedDevice;
      }
    });

    function populateFields(d) {
      $('#perangkatAjarId').val(d.id);
      $('#materiPembelajaran').val(d.materi_pembelajaran);
      $('#subMateri').val(d.sub_materi);
      $('#capaianPembelajaran').val(d.capaian_pembelajaran);
      $('#tujuanPembelajaran').val(d.tujuan_pembelajaran);
      $('#metodePembelajaran').val(d.metode_pembelajaran);
      $('#modelPembelajaran').val(d.model_pembelajaran);
      $('#mediaPembelajaran').val(d.media_pembelajaran);
      $('#sumberBelajar').val(d.sumber_belajar);
      $('#bentukPenilaian').val(d.bentuk_penilaian);
      $('#alokasiWaktu').val(d.alokasi_waktu);
    }

    function clearFields() {
      $('#perangkatAjarId').val('');
      $('#materiPembelajaran').val('');
      $('#subMateri').val('');
      $('#capaianPembelajaran').val('');
      $('#tujuanPembelajaran').val('');
      $('#metodePembelajaran').val('');
      $('#modelPembelajaran').val('');
      $('#mediaPembelajaran').val('');
      $('#sumberBelajar').val('');
      $('#bentukPenilaian').val('');
      $('#alokasiWaktu').val('');
    }

    // Modal Preview click
    $('#btnPreviewPerangkat').on('click', function() {
      if (!currentDevice) return;

      var html = '<div class="row">' +
        '<div class="col-md-6 mb-3"><strong>Jenis Perangkat:</strong><br>' + currentDevice.jenis_perangkat + '</div>' +
        '<div class="col-md-6 mb-3"><strong>Fase / Pertemuan:</strong><br>Fase ' + (currentDevice.fase || '-') + ' / Pertemuan Ke-' + currentDevice.pertemuan_ke + '</div>' +
        '<div class="col-md-12 mb-3"><strong>Materi Pembelajaran:</strong><br>' + (currentDevice.materi_pembelajaran || '-') + '</div>' +
        '<div class="col-md-12 mb-3"><strong>Tujuan Pembelajaran (TP):</strong><br>' + (currentDevice.tujuan_pembelajaran || '-') + '</div>' +
        '<div class="col-md-6 mb-3"><strong>Metode:</strong><br>' + (currentDevice.metode_pembelajaran || '-') + '</div>' +
        '<div class="col-md-6 mb-3"><strong>Model:</strong><br>' + (currentDevice.model_pembelajaran || '-') + '</div>' +
        '<div class="col-md-12 mb-3"><strong>Sumber Belajar:</strong><br>' + (currentDevice.sumber_belajar || '-') + '</div>' +
        '</div>';

      if (currentDevice.file_path && currentDevice.file_path.toLowerCase().endsWith('.pdf')) {
        html += '<hr><iframe src="<?= base_url() ?>' + currentDevice.file_path + '" width="100%" height="400px" style="border:none;"></iframe>';
      } else if (currentDevice.file_path) {
        html += '<hr><div class="alert alert-info"><i class="ti ti-file me-2"></i>Lampiran file: <a href="<?= base_url() ?>' + currentDevice.file_path + '" target="_blank">Unduh berkas</a></div>';
      }

      $('#previewModalBody').html(html);
      $('#modalPreview').modal('show');
    });
  });
</script>
