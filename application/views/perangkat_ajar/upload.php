<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Perangkat Ajar</div>
      <h2 class="page-title text-indigo"><i class="ti ti-upload me-2"></i><?= $edit_mode ? 'Revisi / Perbarui' : 'Unggah' ?> Informasi Utama Perangkat</h2>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('perangkat_ajar/rencana') ?>" class="btn btn-indigo me-2">
        <i class="ti ti-article me-1"></i> Ke Menu Rencana Pelaksanaan
      </a>
      <a href="<?= base_url('perangkat_ajar/daftar') ?>" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar</a>
    </div>
  </div>
</div>

<form action="<?= current_url() ?>" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-indigo text-white">
          <h3 class="card-title text-white"><i class="ti ti-file-text me-2"></i>Form Informasi Utama & Berkas Perangkat</h3>
        </div>

        <div class="card-body p-4">
          <div class="row g-3">
            
            <div class="col-md-6">
              <label class="form-label fw-bold">Tahun Pelajaran</label>
              <input type="text" class="form-control" value="<?= html_escape($active_tp['tahun'] . ' - ' . $active_tp['semester']) ?>" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold required">Semester</label>
              <select name="semester" class="form-select select2" required>
                <option value="Ganjil" <?= ($edit_mode && $device['semester'] == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                <option value="Genap" <?= ($edit_mode && $device['semester'] == 'Genap') ? 'selected' : '' ?>>Genap</option>
              </select>
            </div>

            <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin'))): ?>
              <div class="col-md-6">
                <label class="form-label fw-bold required">Guru Pengampu</label>
                <select name="guru_id" class="form-select select2" required>
                  <option value="">-- Pilih Guru --</option>
                  <?php foreach ($list_guru as $g): ?>
                    <option value="<?= $g['id'] ?>" <?= ($edit_mode && $device['guru_id'] == $g['id']) ? 'selected' : '' ?>><?= html_escape($g['nama_lengkap']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            <?php endif; ?>

            <div class="col-md-6">
              <label class="form-label fw-bold required">Mata Pelajaran</label>
              <select name="mapel_id" class="form-select select2" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                <?php foreach ($list_mapel as $m): ?>
                  <option value="<?= $m['id'] ?>" <?= ($edit_mode && $device['mapel_id'] == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Multi-Select Kelas (Dapat Memilih Lebih Dari 2 Kelas) -->
            <div class="col-md-12">
              <label class="form-label fw-bold required">Kelas (Dapat memilih lebih dari 1 kelas)</label>
              <?php 
                $selected_kelas_ids = array();
                if ($edit_mode && !empty($device['kelas_ids'])) {
                    $selected_kelas_ids = json_decode($device['kelas_ids'], true) ?: array($device['kelas_id']);
                } elseif ($edit_mode && !empty($device['kelas_id'])) {
                    $selected_kelas_ids = array($device['kelas_id']);
                }
              ?>
              <select name="kelas_ids[]" class="form-select select2" multiple="multiple" data-placeholder="-- Pilih Satu atau Beberapa Kelas --" required>
                <?php foreach ($list_kelas as $k): ?>
                  <option value="<?= $k['id'] ?>" <?= (in_array($k['id'], $selected_kelas_ids)) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
              </select>
              <div class="form-text text-muted">Anda dapat memilih 1, 2, atau lebih kelas pengampu sekaligus.</div>
            </div>

            <div class="col-md-12">
              <label class="form-label fw-bold">Fase Pembelajaran</label>
              <select name="fase" class="form-select select2">
                <option value="">-- Pilih Fase (Opsional) --</option>
                <?php foreach (array('A', 'B', 'C', 'D', 'E', 'F') as $f): ?>
                  <option value="<?= $f ?>" <?= ($edit_mode && $device['fase'] == $f) ? 'selected' : '' ?>><?= $f ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Multi-Select Rencana Pelaksanaan -->
            <div class="col-md-12">
              <label class="form-label fw-bold text-indigo"><i class="ti ti-clipboard-list me-1"></i> Rencana Pelaksanaan (Dapat memilih lebih dari 1 Rencana Pelaksanaan)</label>
              <?php 
                $selected_rencana_ids = array();
                if ($edit_mode && !empty($device['rencana_ids'])) {
                    $selected_rencana_ids = json_decode($device['rencana_ids'], true) ?: array();
                }
              ?>
              <select name="rencana_ids[]" id="selectRencanaIds" class="form-select select2" multiple="multiple" data-placeholder="-- Pilih Satu atau Beberapa Rencana Pelaksanaan (Opsional) --">
                <?php foreach ($list_rencana as $r): ?>
                  <option value="<?= $r['id'] ?>" <?= (in_array($r['id'], $selected_rencana_ids)) ? 'selected' : '' ?>>
                    <?= html_escape($r['materi_pembelajaran']) ?> <?= !empty($r['nama_mapel']) ? '[' . html_escape($r['nama_mapel']) . ']' : '' ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="form-text text-muted">Pilih 1 atau beberapa Rencana Pelaksanaan yang terkait dengan dokumen perangkat ajar ini.</div>
            </div>

            <div class="col-md-12">
              <label class="form-label fw-bold <?= $edit_mode ? '' : 'required' ?>">Unggah Berkas Perangkat Ajar (PDF, DOCX, XLSX, PPTX)</label>
              <input type="file" name="file_perangkat" class="form-control" <?= $edit_mode ? '' : 'required' ?>>
              <small class="text-muted d-block mt-1">Maksimal ukuran file: 10MB.</small>
              <?php if ($edit_mode && $device['file_path']): ?>
                <div class="mt-2 alert alert-info py-2 px-3 small border-0">
                  <i class="ti ti-file-text me-1"></i> File terunggah saat ini:<br>
                  <a href="<?= base_url('perangkat_ajar/download/' . $device['id']) ?>" target="_blank" class="fw-bold text-decoration-none">
                    <?= basename($device['file_path']) ?>
                  </a>
                </div>
              <?php endif; ?>
            </div>

            <div class="col-md-12 text-end mt-4">
              <button type="submit" class="btn btn-indigo btn-lg fw-bold px-5 py-2">
                <i class="ti ti-device-floppy me-2"></i> <?= $edit_mode ? 'Simpan Perubahan' : 'Unggah Informasi Utama & Berkas' ?>
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</form>
