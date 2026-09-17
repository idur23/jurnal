<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Jadwal Mengajar</div>
      <h2 class="page-title text-indigo"><i class="ti ti-calendar-event me-2"></i>Jadwal Mengajar Mingguan</h2>
    </div>
  </div>
</div>

<div class="card shadow-sm" style="border-radius: 12px;">
  <div class="card-header bg-light">
    <h3 class="card-title text-indigo"><i class="ti ti-calendar me-2"></i>Daftar Plotting Jadwal Anda</h3>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter table-striped card-table">
      <thead>
        <tr>
          <th>Hari</th>
          <th>Jam Ke-</th>
          <th>Mata Pelajaran</th>
          <th>Kelas</th>
          <th>Ruangan</th>
          <th class="w-1">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($schedules)): ?>
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">Belum ada plotting jadwal pelajaran untuk Anda pada Semester ini.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($schedules as $s): ?>
            <tr>
              <td><span class="badge bg-indigo-lt fw-bold"><?= $s['hari'] ?></span></td>
              <td>Jam <?= $s['jam_mulai_ke'] ?> - <?= $s['jam_selesai_ke'] ?></td>
              <td><strong><?= html_escape($s['nama_mapel']) ?></strong></td>
              <td><span class="badge bg-blue-lt text-blue fw-bold fs-4 px-2.5 py-1"><?= html_escape($s['nama_kelas']) ?></span></td>
              <td><?= $s['nama_ruangan'] ? html_escape($s['nama_ruangan']) : '-' ?></td>
              <td>
                <button type="button" class="btn btn-indigo btn-sm btn-mulai-kbm" 
                        data-kelas-id="<?= $s['kelas_id'] ?>" 
                        data-mapel-id="<?= $s['mapel_id'] ?>"
                        data-guru-id="<?= $s['guru_id'] ?>"
                        data-kelas-nama="<?= html_escape($s['nama_kelas']) ?>"
                        data-mapel-nama="<?= html_escape($s['nama_mapel']) ?>"
                        data-jam-mulai="<?= $s['jam_mulai_ke'] ?>"
                        data-jam-selesai="<?= $s['jam_selesai_ke'] ?>">
                  <i class="ti ti-player-play me-1"></i> Mulai KBM
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Meeting Selector Modal -->
<div class="modal modal-blur fade" id="modalPertemuan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-indigo"><i class="ti ti-help"></i> Mulai Pembelajaran Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3 text-center">
          <div class="text-muted small">Mata Pelajaran & Kelas:</div>
          <div class="h3 text-indigo" id="modalDetailMapel">Matematika Wajib - X IPA 1</div>
        </div>
        <div class="mb-3">
          <label class="form-label required fw-bold">Pertemuan Ke-</label>
          <input type="number" id="inputPertemuan" class="form-control" min="1" max="32" value="1" required>
          <small class="text-muted">Masukkan nomor pertemuan KBM hari ini untuk mencocokkan Perangkat Ajar.</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-indigo" id="btnConfirmMulai"><i class="ti ti-arrow-right me-1"></i> Lanjut ke Jurnal</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var selectedData = {};

    $('.btn-mulai-kbm').on('click', function() {
      selectedData = {
        kelas_id: $(this).data('kelas-id'),
        mapel_id: $(this).data('mapel-id'),
        guru_id: $(this).data('guru-id'),
        kelas_nama: $(this).data('kelas-nama'),
        mapel_nama: $(this).data('mapel-nama'),
        jam_mulai_ke: $(this).data('jam-mulai'),
        jam_selesai_ke: $(this).data('jam-selesai')
      };

      $('#modalDetailMapel').text(selectedData.mapel_name + ' (' + selectedData.kelas_nama + ')');
      $('#modalDetailMapel').text(selectedData.mapel_nama + ' - ' + selectedData.kelas_nama);
      $('#inputPertemuan').val(1);
      $('#modalPertemuan').modal('show');
    });

    $('#btnConfirmMulai').on('click', function() {
      var pertemuan = $('#inputPertemuan').val();
      if (!pertemuan || pertemuan < 1) {
        alert('Nomor pertemuan wajib diisi dan minimal 1.');
        return;
      }

      var url = "<?= base_url('jurnal/add') ?>?kelas_id=" + selectedData.kelas_id + 
                "&mapel_id=" + selectedData.mapel_id + 
                "&guru_id=" + selectedData.guru_id +
                "&pertemuan_ke=" + pertemuan + 
                "&jam_mulai_ke=" + selectedData.jam_mulai_ke + 
                "&jam_selesai_ke=" + selectedData.jam_selesai_ke;
      
      $('#modalPertemuan').modal('hide');
      window.location.href = url;
    });
  });
</script>
