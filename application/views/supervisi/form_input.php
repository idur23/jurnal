<div class="container-xl pb-5">

  <!-- Alert Notifications -->
  <div id="alertContainer"></div>

  <?php if (!empty($supervisi) && $supervisi['status'] == 'SELESAI'): ?>
    <div class="alert alert-success d-flex align-items-center mb-4 shadow-sm" role="alert">
      <i class="ti ti-lock fs-2 me-2"></i>
      <div>
        <strong>Supervisi Telah Selesai & Dikunci!</strong> Data supervisi ini telah dikirim pada <?= date('d/m/Y H:i', strtotime($supervisi['updated_at'])) ?> oleh <?= html_escape($supervisi['nama_supervisor'] ?? 'Supervisor') ?>.
        <a href="<?= base_url('supervisi/export_pdf/' . $supervisi['id']) ?>" target="_blank" class="btn btn-sm btn-outline-success ms-3"><i class="ti ti-file-pdf me-1"></i> Cetak PDF</a>
      </div>
    </div>
  <?php endif; ?>

  <!-- Header Header Section -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
      <div class="row align-items-center">
        <div class="col-md-8">
          <div class="badge bg-indigo-lt mb-2 fw-bold"><?= html_escape($form_info['kode_form']) ?></div>
          <h2 class="fw-bold text-dark mb-1"><?= html_escape($form_info['nama_form']) ?></h2>
          <div class="text-muted small"><?= html_escape($form_info['deskripsi']) ?></div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
          <!-- Real-Time Progress Bar -->
          <div class="text-muted small mb-1">Progress Penilaian: <span id="progressText" class="fw-bold text-primary">0 / <?= count($indikators) ?></span></div>
          <div class="progress progress-sm rounded-pill mb-2">
            <div id="progressBar" class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
          </div>
          <div class="h3 mb-0 text-success fw-bold">
            Nilai: <span id="displayNilai">0.00</span> <span class="fs-6 text-muted">/ 100</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Form Supervisi Main Container -->
  <form id="formSupervisi" method="POST" action="<?= base_url('supervisi/save') ?>">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="supervisi_id" id="supervisi_id" value="<?= $supervisi_id ?>">
    <input type="hidden" name="form_id" value="<?= $form_id ?>">
    <input type="hidden" name="tahun_pelajaran_id" value="<?= $active_tp['id'] ?? 0 ?>">
    <input type="hidden" name="semester" value="<?= $active_tp['semester'] ?? 'Ganjil' ?>">

    <!-- Section 1: Identitas Supervisi -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-transparent">
        <h4 class="card-title fw-bold text-dark mb-0">I. Identitas Supervisi</h4>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <!-- Nama Madrasah -->
          <div class="col-md-6">
            <label class="form-label required">Nama Madrasah</label>
            <input type="text" class="form-control bg-light" value="MA DARUL FAQIH INDONESIA" readonly>
          </div>

          <!-- Nama Guru -->
          <div class="col-md-6">
            <label class="form-label required">Nama Guru</label>
            <select name="guru_id" id="selectGuru" class="form-select" required <?= ($supervisi && $supervisi['status'] == 'SELESAI') ? 'disabled' : '' ?>>
              <option value="">-- Pilih Guru --</option>
              <?php foreach ($guru_list as $g): ?>
                <option value="<?= $g['id'] ?>" <?= ($selected_guru_id == $g['id']) ? 'selected' : '' ?>>
                  <?= html_escape($g['nama_lengkap']) ?> (NIP: <?= html_escape($g['nip'] ? $g['nip'] : '-') ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Mata Pelajaran -->
          <div class="col-md-4">
            <label class="form-label required">Mata Pelajaran</label>
            <select name="mapel_id" id="selectMapel" class="form-select" required <?= ($supervisi && $supervisi['status'] == 'SELESAI') ? 'disabled' : '' ?>>
              <option value="">-- Pilih Mata Pelajaran --</option>
              <?php foreach ($mapel_list as $m): ?>
                <option value="<?= $m['id'] ?>" <?= ($selected_mapel_id == $m['id']) ? 'selected' : '' ?>>
                  <?= html_escape($m['nama_mapel']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Kelas -->
          <div class="col-md-4">
            <label class="form-label required">Kelas</label>
            <select name="kelas_id" id="selectKelas" class="form-select" required <?= ($supervisi && $supervisi['status'] == 'SELESAI') ? 'disabled' : '' ?>>
              <option value="">-- Pilih Kelas --</option>
              <?php foreach ($kelas_list as $k): ?>
                <option value="<?= $k['id'] ?>" <?= ($selected_kelas_id == $k['id']) ? 'selected' : '' ?>>
                  <?= html_escape($k['nama_kelas']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Tahap Supervisi -->
          <div class="col-md-4">
            <label class="form-label required">Tahap Supervisi</label>
            <select name="tahap" class="form-select" <?= ($supervisi && $supervisi['status'] == 'SELESAI') ? 'disabled' : '' ?>>
              <option value="Tahap 1" <?= ($selected_tahap == 'Tahap 1') ? 'selected' : '' ?>>Tahap 1</option>
              <option value="Tahap 2" <?= ($selected_tahap == 'Tahap 2') ? 'selected' : '' ?>>Tahap 2</option>
              <option value="Tahap 3" <?= ($selected_tahap == 'Tahap 3') ? 'selected' : '' ?>>Tahap 3</option>
            </select>
          </div>

          <!-- Tanggal Supervisi -->
          <div class="col-md-4">
            <label class="form-label required">Tanggal Supervisi</label>
            <input type="date" name="tanggal_supervisi" class="form-control" value="<?= $supervisi['tanggal_supervisi'] ?? date('Y-m-d') ?>" required <?= ($supervisi && $supervisi['status'] == 'SELESAI') ? 'disabled' : '' ?>>
          </div>

          <!-- Supervisor -->
          <div class="col-md-4">
            <label class="form-label">Supervisor (Otomatis User Login)</label>
            <input type="text" class="form-control bg-light" value="<?= html_escape($supervisor_name) ?> (<?= html_escape($supervisor_role) ?>)" readonly>
            <input type="hidden" name="supervisor_id" value="<?= $supervisor_id ?>">
            <input type="hidden" name="supervisor_role" value="<?= $supervisor_role ?>">
          </div>

          <!-- Form 3 Mode Observasi Timer (Khusus Form 3) -->
          <?php if ($form_id == 3): ?>
            <div class="col-md-4">
              <label class="form-label">Waktu Observasi Kelas</label>
              <div class="d-flex gap-2 align-items-center">
                <input type="text" name="jam_mulai" id="jamMulai" class="form-control text-center bg-light" placeholder="Jam Mulai" value="<?= $supervisi['jam_mulai'] ?? '' ?>" readonly>
                <span>-</span>
                <input type="text" name="jam_selesai" id="jamSelesai" class="form-control text-center bg-light" placeholder="Jam Selesai" value="<?= $supervisi['jam_selesai'] ?? '' ?>" readonly>
              </div>
              <?php if (empty($supervisi) || $supervisi['status'] != 'SELESAI'): ?>
                <div class="mt-2 d-flex gap-2">
                  <button type="button" id="btnStartObs" class="btn btn-sm btn-success flex-fill"><i class="ti ti-play me-1"></i> Mulai Observasi</button>
                  <button type="button" id="btnFinishObs" class="btn btn-sm btn-danger flex-fill"><i class="ti ti-square me-1"></i> Selesaikan Observasi</button>
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Integrated Teacher Document Notice -->
        <?php if (!empty($teacher_docs)): ?>
          <div class="alert alert-info mt-3 mb-0 d-flex align-items-center justify-content-between">
            <div>
              <i class="ti ti-file-check me-2"></i> Guru terdeteksi telah mengunggah <strong><?= count($teacher_docs) ?> Perangkat Ajar</strong> di sistem.
            </div>
            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalDocsPreview">
              <i class="ti ti-eye me-1"></i> Lihat Dokumen Guru
            </button>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Section 2: Tabel Penilaian Instrumen -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-transparent d-flex align-items-center justify-content-between">
        <h4 class="card-title fw-bold text-dark mb-0">II. Penilaian Instrumen</h4>
        <div class="small text-muted">Pilihan Skor: <span class="badge bg-secondary">0: Tidak Ada</span> <span class="badge bg-danger">1: Kurang</span> <span class="badge bg-warning">2: Cukup</span> <span class="badge bg-primary">3: Baik</span> <span class="badge bg-success">4: Sangat Baik</span></div>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter card-table align-middle">
          <thead>
            <tr class="bg-light">
              <th class="w-1 text-center">No</th>
              <th>Fokus Pengamatan / Indikator Penilaian</th>
              <th class="text-center" style="width: 320px;">Opsi Nilai</th>
            </tr>
          </thead>
          <tbody>
            <?php $item_no = 1; foreach ($grouped_indikators as $sub_title => $group): ?>
              <?php if ($sub_title != 'Umum' && count($grouped_indikators) > 1): ?>
                <tr class="bg-light-lt">
                  <td colspan="3" class="fw-bold text-primary py-2"><i class="ti ti-chevron-right me-1"></i><?= html_escape($sub_title) ?></td>
                </tr>
              <?php endif; ?>

              <?php foreach ($group as $ind): ?>
                <?php 
                  $current_val = isset($details_map[$ind['id']]) ? (int)$details_map[$ind['id']]['skor'] : null;
                  $is_disabled = ($supervisi && $supervisi['status'] == 'SELESAI') ? 'disabled' : '';
                ?>
                <tr class="item-row" id="row_ind_<?= $ind['id'] ?>">
                  <td class="text-center fw-bold text-muted"><?= $ind['nomor_urut'] ?></td>
                  <td>
                    <div class="fw-semibold text-dark"><?= html_escape($ind['nama_indikator']) ?></div>
                    <?php if (!empty($ind['kode_indikator'])): ?>
                      <div class="small text-muted"><code class="text-secondary"><?= html_escape($ind['kode_indikator']) ?></code></div>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <div class="btn-group w-100" role="group" aria-label="Skor Indikator <?= $ind['id'] ?>">
                      <!-- 0: Tidak Ada -->
                      <input type="radio" class="btn-check score-radio" name="skor[<?= $ind['id'] ?>][skor]" id="skor_<?= $ind['id'] ?>_0" value="0" autocomplete="off" <?= ($current_val === 0) ? 'checked' : '' ?> <?= $is_disabled ?> required>
                      <label class="btn btn-outline-secondary btn-sm" for="skor_<?= $ind['id'] ?>_0" title="Tidak Ada">0</label>

                      <!-- 1 -->
                      <input type="radio" class="btn-check score-radio" name="skor[<?= $ind['id'] ?>][skor]" id="skor_<?= $ind['id'] ?>_1" value="1" autocomplete="off" <?= ($current_val === 1) ? 'checked' : '' ?> <?= $is_disabled ?>>
                      <label class="btn btn-outline-danger btn-sm" for="skor_<?= $ind['id'] ?>_1" title="Kurang (1)">1</label>

                      <!-- 2 -->
                      <input type="radio" class="btn-check score-radio" name="skor[<?= $ind['id'] ?>][skor]" id="skor_<?= $ind['id'] ?>_2" value="2" autocomplete="off" <?= ($current_val === 2) ? 'checked' : '' ?> <?= $is_disabled ?>>
                      <label class="btn btn-outline-warning btn-sm" for="skor_<?= $ind['id'] ?>_2" title="Cukup (2)">2</label>

                      <!-- 3 -->
                      <input type="radio" class="btn-check score-radio" name="skor[<?= $ind['id'] ?>][skor]" id="skor_<?= $ind['id'] ?>_3" value="3" autocomplete="off" <?= ($current_val === 3) ? 'checked' : '' ?> <?= $is_disabled ?>>
                      <label class="btn btn-outline-primary btn-sm" for="skor_<?= $ind['id'] ?>_3" title="Baik (3)">3</label>

                      <!-- 4 -->
                      <input type="radio" class="btn-check score-radio" name="skor[<?= $ind['id'] ?>][skor]" id="skor_<?= $ind['id'] ?>_4" value="4" autocomplete="off" <?= ($current_val === 4) ? 'checked' : '' ?> <?= $is_disabled ?>>
                      <label class="btn btn-outline-success btn-sm" for="skor_<?= $ind['id'] ?>_4" title="Sangat Baik (4)">4</label>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Live Calculation Footer Summary -->
      <div class="card-footer bg-light p-3">
        <div class="row text-center">
          <div class="col-md-4 border-end">
            <div class="text-muted small">Jumlah Skor Terkumpul</div>
            <div class="h2 fw-bold text-dark mb-0" id="displayJumlahSkor">0</div>
          </div>
          <div class="col-md-4 border-end">
            <div class="text-muted small">Skor Maksimal (<?= count($indikators) ?> x 4)</div>
            <div class="h2 fw-bold text-dark mb-0" id="displaySkorMaksimal"><?= count($indikators) * 4 ?></div>
          </div>
          <div class="col-md-4">
            <div class="text-muted small">Nilai Akhir (Skor / Maks x 100)</div>
            <div class="h1 fw-bold text-success mb-0" id="displayNilaiFooter">0.00</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section 3: Catatan, Tindak Lanjut & Saran Supervisor -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-transparent">
        <h4 class="card-title fw-bold text-dark mb-0">III. Catatan & Rekomendasi Supervisor</h4>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <!-- Catatan Analisis -->
          <div class="col-md-12">
            <label class="form-label fw-bold text-dark">Catatan (Analisis Kekuatan dan Kelemahan Hasil Supervisi)</label>
            <textarea name="catatan_analisis" class="form-control" rows="3" placeholder="Tuliskan analisis kekuatan dan kelemahan hasil supervisi..." <?= ($supervisi && $supervisi['status'] == 'SELESAI') ? 'disabled' : '' ?>><?= html_escape($supervisi['catatan_analisis'] ?? '') ?></textarea>
          </div>

          <!-- Tindak Lanjut -->
          <div class="col-md-6">
            <label class="form-label fw-bold text-dark">Tindak Lanjut</label>
            <textarea name="tindak_lanjut" class="form-control" rows="3" placeholder="Rencana tindak lanjut perbaikan..." <?= ($supervisi && $supervisi['status'] == 'SELESAI') ? 'disabled' : '' ?>><?= html_escape($supervisi['tindak_lanjut'] ?? '') ?></textarea>
          </div>

          <!-- Saran -->
          <div class="col-md-6">
            <label class="form-label fw-bold text-dark">Saran</label>
            <textarea name="saran" class="form-control" rows="3" placeholder="Saran pengembangan profesionalisme guru..." <?= ($supervisi && $supervisi['status'] == 'SELESAI') ? 'disabled' : '' ?>><?= html_escape($supervisi['saran'] ?? '') ?></textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- Section 4: Signature Space -->
    <div class="card border-0 shadow-sm mb-5">
      <div class="card-body p-4">
        <div class="row text-center mt-3">
          <div class="col-md-6 mb-4 mb-md-0">
            <div class="text-muted small mb-1">Mengetahui,</div>
            <div class="fw-bold text-dark">Supervisor</div>
            <div style="height: 70px;"></div>
            <div class="fw-bold text-dark text-decoration-underline" id="sigSupervisorName"><?= html_escape($supervisor_name) ?></div>
            <div class="small text-muted"><?= html_escape($supervisor_role) ?></div>
          </div>
          <div class="col-md-6">
            <div class="text-muted small mb-1">Malang, <span id="sigDate"><?= date('d F Y') ?></span></div>
            <div class="fw-bold text-dark">Guru Ter-supervisi</div>
            <div style="height: 70px;"></div>
            <div class="fw-bold text-dark text-decoration-underline" id="sigGuruName">[Nama Guru]</div>
            <div class="small text-muted" id="sigGuruNip">NIP: -</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sticky Bottom Action Bar -->
    <div class="fixed-bottom bg-white border-top shadow-lg py-3 d-print-none">
      <div class="container-xl d-flex align-items-center justify-content-between">
        <a href="<?= base_url('supervisi/rekap') ?>" class="btn btn-outline-secondary">
          <i class="ti ti-arrow-left me-1"></i> Batal / Kembali
        </a>
        <div class="btn-list">
          <?php if (!empty($supervisi_id) && $supervisi_id > 0 && in_array($this->current_user['role_code'] ?? '', array('admin', 'superadmin', 'kamad', 'waka'))): ?>
            <button type="button" class="btn btn-outline-danger btn-delete-supervisi px-3" data-id="<?= $supervisi_id ?>" data-name="Supervisi <?= html_escape($form_info['nama_form']) ?>">
              <i class="ti ti-trash me-1"></i> Hapus Supervisi
            </button>
          <?php endif; ?>

          <?php if (empty($supervisi) || $supervisi['status'] != 'SELESAI' || in_array($this->current_user['role_code'] ?? '', array('admin', 'superadmin'))): ?>
            <button type="button" id="btnSaveDraft" class="btn btn-warning px-4">
              <i class="ti ti-device-floppy me-1"></i> Simpan Draft
            </button>
            <button type="button" id="btnSubmitSupervisi" class="btn btn-success px-4">
              <i class="ti ti-send me-1"></i> Submit & Selesaikan Supervisi
            </button>
          <?php else: ?>
            <a href="<?= base_url('supervisi/print_form/' . $supervisi_id) ?>" target="_blank" class="btn btn-outline-primary">
              <i class="ti ti-printer me-1"></i> Cetak Fisik
            </a>
            <a href="<?= base_url('supervisi/export_pdf/' . $supervisi_id) ?>" target="_blank" class="btn btn-outline-danger">
              <i class="ti ti-file-pdf me-1"></i> Export PDF
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- Modal Teacher Documents Preview -->
<?php if (!empty($teacher_docs)): ?>
<div class="modal fade" id="modalDocsPreview" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><i class="ti ti-file-text me-2 text-primary"></i>Dokumen Perangkat Ajar Guru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="list-group list-group-flush">
          <?php foreach ($teacher_docs as $doc): ?>
            <div class="list-group-item d-flex align-items-center justify-content-between p-3">
              <div>
                <div class="fw-bold text-dark"><?= html_escape($doc['jenis_perangkat']) ?> - <?= html_escape($doc['nama_mapel']) ?></div>
                <div class="small text-muted">Kelas: <?= html_escape($doc['nama_kelas']) ?> | Versi: <?= $doc['version'] ?></div>
              </div>
              <a href="<?= base_url('uploads/perangkat_ajar/' . $doc['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="ti ti-download me-1"></i> Lihat Dokumen
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- JavaScript Form Logic & Real-time Auto Calculator -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const totalIndicators = <?= count($indikators) ?>;
  const maxScore = totalIndicators * 4;

  // Real-time Score Calculation
  function calculateScore() {
    let jumlahSkor = 0;
    let scoredCount = 0;

    document.querySelectorAll('.score-radio:checked').forEach(function(radio) {
      jumlahSkor += parseInt(radio.value);
      scoredCount++;
    });

    let nilaiFinal = (maxScore > 0) ? ((jumlahSkor / maxScore) * 100).toFixed(2) : "0.00";
    let progressPercent = (totalIndicators > 0) ? Math.round((scoredCount / totalIndicators) * 100) : 0;

    document.getElementById('displayJumlahSkor').textContent = jumlahSkor;
    document.getElementById('displaySkorMaksimal').textContent = maxScore;
    document.getElementById('displayNilai').textContent = nilaiFinal;
    document.getElementById('displayNilaiFooter').textContent = nilaiFinal;

    document.getElementById('progressText').textContent = scoredCount + ' / ' + totalIndicators + ' (' + progressPercent + '%)';
    document.getElementById('progressBar').style.width = progressPercent + '%';

    if (progressPercent === 100) {
      document.getElementById('progressBar').className = 'progress-bar bg-success';
    } else {
      document.getElementById('progressBar').className = 'progress-bar bg-primary';
    }
  }

  // Bind change listeners to radio inputs
  document.querySelectorAll('.score-radio').forEach(function(radio) {
    radio.addEventListener('change', calculateScore);
  });

  // Calculate initially
  calculateScore();

  // Signature Name Syncing & Dynamic Mapel/Kelas Loading
  const selectGuru = document.getElementById('selectGuru');
  const selectMapel = document.getElementById('selectMapel');
  const selectKelas = document.getElementById('selectKelas');

  if (selectGuru) {
    selectGuru.addEventListener('change', function() {
      let guruId = selectGuru.value;
      if (selectGuru.selectedIndex > 0) {
        let selectedText = selectGuru.options[selectGuru.selectedIndex].text;
        document.getElementById('sigGuruName').textContent = selectedText.split(' (NIP:')[0];
      }

      if (guruId) {
        fetch('<?= base_url("supervisi/get_guru_options") ?>?guru_id=' + guruId, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
          if (data.status === 'success') {
            // Update Mapel options
            let currMapel = selectMapel.value;
            selectMapel.innerHTML = '<option value="">-- Pilih Mata Pelajaran --</option>';
            data.mapel.forEach(m => {
              let opt = document.createElement('option');
              opt.value = m.id;
              opt.textContent = m.nama_mapel;
              if (m.id == currMapel) opt.selected = true;
              selectMapel.appendChild(opt);
            });

            // Update Kelas options
            let currKelas = selectKelas.value;
            selectKelas.innerHTML = '<option value="">-- Pilih Kelas --</option>';
            data.kelas.forEach(k => {
              let opt = document.createElement('option');
              opt.value = k.id;
              opt.textContent = k.nama_kelas;
              if (k.id == currKelas) opt.selected = true;
              selectKelas.appendChild(opt);
            });
          }
        });
      }
    });
    if (selectGuru.selectedIndex > 0) {
      document.getElementById('sigGuruName').textContent = selectGuru.options[selectGuru.selectedIndex].text.split(' (NIP:')[0];
    }
  }

  // Form 3 Timer Handlers
  const btnStartObs = document.getElementById('btnStartObs');
  const btnFinishObs = document.getElementById('btnFinishObs');

  if (btnStartObs) {
    btnStartObs.addEventListener('click', function() {
      let supId = document.getElementById('supervisi_id').value;
      fetch('<?= base_url("supervisi/start_observation") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'supervisi_id=' + supId
      })
      .then(r => r.json())
      .then(res => {
        if (res.status === 'success') {
          document.getElementById('jamMulai').value = res.jam_mulai;
        }
      });
    });
  }

  if (btnFinishObs) {
    btnFinishObs.addEventListener('click', function() {
      let supId = document.getElementById('supervisi_id').value;
      fetch('<?= base_url("supervisi/finish_observation") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'supervisi_id=' + supId
      })
      .then(r => r.json())
      .then(res => {
        if (res.status === 'success') {
          document.getElementById('jamSelesai').value = res.jam_selesai;
        }
      });
    });
  }

  // AJAX Form Submission (Draft vs Submit)
  function submitFormAJAX(actionType) {
    const form = document.getElementById('formSupervisi');
    const formData = new FormData(form);
    formData.append('action_type', actionType);

    $.ajax({
      url: form.action,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(data) {
        const container = document.getElementById('alertContainer');
        if (data.status === 'success') {
          container.innerHTML = `<div class="alert alert-success alert-dismissible fade show shadow-sm mb-4"><i class="ti ti-check me-2"></i>${data.message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
          if (data.supervisi_id) {
            document.getElementById('supervisi_id').value = data.supervisi_id;
          }
          if (actionType === 'submit') {
            setTimeout(() => { window.location.href = '<?= base_url("supervisi/rekap") ?>'; }, 1200);
          }
        } else if (data.status === 'validation_error') {
          let listHtml = '<ul>';
          if (data.unscored) {
            data.unscored.forEach(item => { listHtml += `<li>${item}</li>`; });
          }
          listHtml += '</ul>';
          container.innerHTML = `<div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4"><i class="ti ti-alert-triangle me-2"></i><strong>${data.message}</strong>${listHtml}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
          window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
          container.innerHTML = `<div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4"><i class="ti ti-alert-circle me-2"></i>${data.message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
          window.scrollTo({ top: 0, behavior: 'smooth' });
        }
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        let errorMsg = 'Terjadi kesalahan koneksi server.';
        try {
          let errJson = JSON.parse(xhr.responseText);
          if (errJson.message) errorMsg = errJson.message;
        } catch(e) {}
        const container = document.getElementById('alertContainer');
        container.innerHTML = `<div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4"><i class="ti ti-alert-circle me-2"></i>${errorMsg}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });
  }

  const btnDraft = document.getElementById('btnSaveDraft');
  const btnSubmit = document.getElementById('btnSubmitSupervisi');

  if (btnDraft) {
    btnDraft.addEventListener('click', function() { submitFormAJAX('draft'); });
  }
  if (btnSubmit) {
    btnSubmit.addEventListener('click', function() {
      if (confirm('Apakah Anda yakin ingin menyelesaikan supervisi ini? Setelah disubmit data akan dikunci.')) {
        submitFormAJAX('submit');
      }
    });
  }
});
</script>
