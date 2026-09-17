<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Presensi</div>
      <h2 class="page-title">Buat Presensi Kelas & Keterlaksanaan</h2>
      <div class="text-muted small mt-1">Langkah 2: Isi rincian keterlaksanaan sesi pembelajaran sebelum mencatat kehadiran siswa.</div>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('jurnal') ?>" class="btn btn-secondary">
        <i class="ti ti-arrow-left me-1"></i> Batal
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card mb-4">
      <div class="card-header bg-indigo text-white">
        <h3 class="card-title text-white"><i class="ti ti-building me-2"></i>Form Presensi Kelas</h3>
      </div>
      <div class="card-body">
        <form action="<?= base_url('presensikelas/add/' . $jurnal['id']) ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

          <!-- Row 1: Status & Pertemuan -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Status Pembelajaran</label>
              <select name="status_pembelajaran" id="statusPembelajaran" class="form-select" required>
                <option value="Terlaksana" selected>Terlaksana</option>
                <option value="Daring">Daring (Online)</option>
                <option value="Luring">Luring (Offline)</option>
                <option value="Gabungan Kelas">Gabungan Kelas</option>
                <option value="Diganti">Diganti (Jadwal Lain)</option>
                <option value="Tidak Terlaksana">Tidak Terlaksana</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Pertemuan Ke-</label>
              <input type="number" name="pertemuan_ke" class="form-control" min="1" max="40" value="1" required>
            </div>
          </div>

          <!-- Conditional: Alasan Tidak Terlaksana -->
          <div class="mb-3 d-none" id="boxAlasan">
            <label class="form-label required">Alasan Pembelajaran Tidak Terlaksana</label>
            <textarea name="alasan_tidak_terlaksana" class="form-control" rows="2" placeholder="Tuliskan alasan detail KBM dibatalkan / tidak terlaksana..."></textarea>
          </div>

          <!-- Row 2: Ruangan -->
          <div class="mb-3">
            <label class="form-label">Ruang Kelas / Ruangan KBM
              <?php if (!empty($scheduled_ruangan_id)): ?>
                <span class="badge bg-info-lt ms-1" title="Otomatis dari Jadwal Pelajaran"><i class="ti ti-calendar-check me-1"></i>Dari Jadwal</span>
              <?php endif; ?>
            </label>
            <select name="ruangan_id" id="ruangan_id" class="form-select select2">
              <option value="">-- Pilih Ruangan (Opsional) --</option>
              <?php foreach ($list_ruangan as $r): ?>
                <option value="<?= $r['id'] ?>" <?= (!empty($scheduled_ruangan_id) && $scheduled_ruangan_id == $r['id']) ? 'selected' : '' ?>>
                  <?= html_escape($r['nama_ruangan']) ?> (<?= html_escape($r['kode_ruangan']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (!empty($scheduled_ruangan_id)): ?>
              <small class="text-muted"><i class="ti ti-info-circle me-1"></i>Ruangan terisi otomatis berdasarkan jadwal pelajaran aktif. Anda dapat mengubahnya jika perlu.</small>
            <?php endif; ?>
          </div>

          <!-- Row 3: Catatan Guru -->
          <div class="mb-3">
            <label class="form-label">Catatan Guru / Pembelajaran</label>
            <textarea name="catatan_guru" class="form-control" rows="3" placeholder="Catatan keaktifan kelas, penyampaian materi, atau pesan tambahan untuk wali kelas..."></textarea>
          </div>

          <!-- Row 4: Upload File -->
          <div class="mb-4">
            <label class="form-label">Dokumentasi Foto KBM (Foto Kegiatan)</label>
            <input type="file" name="dokumentasi" class="form-control">
            <small class="text-muted">Format diperbolehkan: jpg, jpeg, png. Maksimal 5MB.</small>
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-indigo fw-bold"><i class="ti ti-device-floppy me-2"></i> Simpan & Lanjutkan Ke Kehadiran Siswa</button>
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
          <div class="fw-bold"><?= html_escape($jurnal['kode_jurnal']) ?></div>
        </div>
        <div class="mb-3">
          <label class="text-muted small">Mata Pelajaran</label>
          <div class="fw-bold"><?= html_escape($jurnal['nama_mapel']) ?></div>
        </div>
        <div class="mb-3">
          <label class="text-muted small">Kelas & Jam Ke-</label>
          <div class="fw-bold"><?= html_escape($jurnal['nama_kelas']) ?> (Jam ke-<?= html_escape($jurnal['jam_ke']) ?>)</div>
        </div>
        <div class="mb-3">
          <label class="text-muted small">Pokok Materi Pembelajaran</label>
          <div class="text-muted small text-dark" style="max-height: 100px; overflow-y: auto;">
            <?= nl2br(html_escape($jurnal['materi_pembelajaran'])) ?>
          </div>
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
