<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Presensi</div>
      <h2 class="page-title">Edit Presensi Kelas</h2>
      <div class="text-muted small mt-1">Ubah rincian keterlaksanaan sesi pembelajaran.</div>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('presensikelas') ?>" class="btn btn-secondary">
        <i class="ti ti-arrow-left me-1"></i> Batal
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card mb-4">
      <div class="card-header bg-indigo text-white">
        <h3 class="card-title text-white"><i class="ti ti-edit me-2"></i>Ubah Detail Presensi Kelas</h3>
      </div>
      <div class="card-body">
        <form action="<?= base_url('presensikelas/edit/' . $pk['id']) ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

          <!-- Row 1: Status & Pertemuan -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Status Pembelajaran</label>
              <select name="status_pembelajaran" id="statusPembelajaran" class="form-select" required>
                <option value="Terlaksana" <?= ($pk['status_pembelajaran'] == 'Terlaksana') ? 'selected' : '' ?>>Terlaksana</option>
                <option value="Daring" <?= ($pk['status_pembelajaran'] == 'Daring') ? 'selected' : '' ?>>Daring (Online)</option>
                <option value="Luring" <?= ($pk['status_pembelajaran'] == 'Luring') ? 'selected' : '' ?>>Luring (Offline)</option>
                <option value="Gabungan Kelas" <?= ($pk['status_pembelajaran'] == 'Gabungan Kelas') ? 'selected' : '' ?>>Gabungan Kelas</option>
                <option value="Diganti" <?= ($pk['status_pembelajaran'] == 'Diganti') ? 'selected' : '' ?>>Diganti (Jadwal Lain)</option>
                <option value="Tidak Terlaksana" <?= ($pk['status_pembelajaran'] == 'Tidak Terlaksana') ? 'selected' : '' ?>>Tidak Terlaksana</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Pertemuan Ke-</label>
              <input type="number" name="pertemuan_ke" class="form-control" min="1" max="40" value="<?= html_escape($pk['pertemuan_ke']) ?>" required>
            </div>
          </div>

          <!-- Conditional: Alasan Tidak Terlaksana -->
          <div class="mb-3 <?= ($pk['status_pembelajaran'] == 'Tidak Terlaksana') ? '' : 'd-none' ?>" id="boxAlasan">
            <label class="form-label required">Alasan Pembelajaran Tidak Terlaksana</label>
            <textarea name="alasan_tidak_terlaksana" class="form-control" rows="2" placeholder="Tuliskan alasan detail KBM dibatalkan / tidak terlaksana..." <?= ($pk['status_pembelajaran'] == 'Tidak Terlaksana') ? 'required' : '' ?>><?= html_escape($pk['alasan_tidak_terlaksana']) ?></textarea>
          </div>

          <!-- Row 2: Ruangan -->
          <div class="mb-3">
            <label class="form-label">Ruang Kelas / Ruangan KBM</label>
            <select name="ruangan_id" class="form-select select2">
              <option value="">-- Pilih Ruangan (Opsional) --</option>
              <?php foreach ($list_ruangan as $r): ?>
                <option value="<?= $r['id'] ?>" <?= ($pk['ruangan_id'] == $r['id']) ? 'selected' : '' ?>><?= html_escape($r['nama_ruangan']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Row 3: Catatan Guru -->
          <div class="mb-3">
            <label class="form-label">Catatan Guru / Pembelajaran</label>
            <textarea name="catatan_guru" class="form-control" rows="3" placeholder="Catatan keaktifan kelas, penyampaian materi..."><?= html_escape($pk['catatan_guru']) ?></textarea>
          </div>

          <!-- Row 4: Upload File -->
          <div class="mb-4">
            <label class="form-label">Ubah Dokumentasi Foto KBM (Opsional)</label>
            <input type="file" name="dokumentasi" class="form-control mb-2">
            <?php if ($pk['dokumentasi']): ?>
              <div class="text-muted small mb-2"><i class="ti ti-paperclip me-1"></i> File saat ini: <a href="<?= base_url($pk['dokumentasi']) ?>" target="_blank" class="badge bg-green-lt">Lihat File</a></div>
            <?php endif; ?>
            <small class="text-muted">Format diperbolehkan: jpg, jpeg, png. Maksimal 5MB.</small>
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-warning fw-bold"><i class="ti ti-device-floppy me-2"></i> Update Presensi Kelas</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Right side: Jurnal Info Summary -->
  <div class="col-md-4">
    <div class="card bg-light">
      <div class="card-body">
        <h4 class="card-title fw-bold text-indigo"><i class="ti ti-info-circle me-1"></i>Ringkasan Jurnal KBM</h4>
        <div class="border-bottom my-2"></div>
        <div class="mb-3">
          <label class="text-muted small">Kode Jurnal</label>
          <div class="fw-bold"><?= html_escape($pk['kode_jurnal']) ?></div>
        </div>
        <div class="mb-3">
          <label class="text-muted small">Mata Pelajaran</label>
          <div class="fw-bold"><?= html_escape($pk['nama_mapel']) ?></div>
        </div>
        <div class="mb-3">
          <label class="text-muted small">Kelas & Jam Ke-</label>
          <div class="fw-bold"><?= html_escape($pk['nama_kelas']) ?> (Jam ke-<?= html_escape($pk['jam_ke']) ?>)</div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#statusPembelajaran').change(function() {
      if ($(this).val() == 'Tidak Terlaksana') {
        $('#boxAlasan').removeClass('d-none');
        $('#boxAlasan textarea').attr('required', true);
      } else {
        $('#boxAlasan').addClass('d-none');
        $('#boxAlasan textarea').removeAttr('required');
      }
    });
  });
</script>
