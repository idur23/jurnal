<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Riwayat Import Nilai Excel</h2>
      <div class="text-muted small mt-1">Daftar unggah massal nilai akademik beserta fitur pembatalan (rollback) jika terjadi kesalahan data.</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header bg-dark text-white">
    <h3 class="card-title text-white"><i class="ti ti-history me-2"></i>Log Unggah Nilai Massal</h3>
  </div>
  <?php if (empty($history)): ?>
    <div class="card-body text-center py-5 text-muted">
      <i class="ti ti-history fs-1 text-secondary mb-2"></i>
      <h3 class="mt-2">Belum ada riwayat import nilai.</h3>
      <p class="mb-0">Daftar riwayat import nilai akan muncul setelah Anda mengunggah nilai menggunakan Excel.</p>
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-vcenter card-table datatable table-striped">
        <thead>
          <tr>
            <th>Sesi / Kode Sesi</th>
            <th>Waktu Import</th>
            <th>Kelas</th>
            <th>Mata Pelajaran</th>
            <th>Kategori RDM</th>
            <th>Nama Penilaian</th>
            <th class="text-center">Total Nilai</th>
            <th>Pengunggah</th>
            <th class="text-center" style="width: 150px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($history as $h): ?>
            <tr>
              <td>
                <div class="font-monospace fw-bold text-indigo"><?= html_escape($h['import_code']) ?></div>
                <div class="text-muted small"><?= html_escape(basename($h['file_name'])) ?></div>
              </td>
              <td><?= date('d M Y H:i:s', strtotime($h['created_at'])) ?></td>
              <td class="fw-bold"><?= html_escape($h['nama_kelas']) ?></td>
              <td><?= html_escape($h['nama_mapel']) ?></td>
              <td><span class="badge bg-purple-lt"><?= html_escape(ucfirst(str_replace('_', ' ', $h['jenis_penilaian']))) ?></span></td>
              <td class="fw-bold"><?= html_escape($h['nama_penilaian']) ?></td>
              <td class="text-center"><span class="badge bg-blue text-white fw-bold"><?= html_escape($h['total_records']) ?> Siswa</span></td>
              <td><?= html_escape($h['nama_pengunggah']) ?></td>
              <td class="text-center">
                <a href="<?= base_url('penilaian/rollback/' . $h['import_code']) ?>" 
                   class="btn btn-sm btn-danger fw-bold btn-rollback" 
                   data-code="<?= html_escape($h['import_code']) ?>"
                   data-info="<?= html_escape($h['nama_kelas'] . ' - ' . $h['nama_penilaian']) ?>">
                  <i class="ti ti-rotate-clockwise me-1"></i> Rollback
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<script>
$(document).on('click', '.btn-rollback', function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  var code = $(this).data('code');
  var info = $(this).data('info');

  Swal.fire({
    title: 'Batalkan Sesi Import?',
    text: 'Sesi: ' + code + ' (' + info + '). Tindakan ini akan menghapus permanen semua nilai yang di-import pada sesi ini. Nilai sebelum import tidak terpengaruh.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Lakukan Rollback!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
});
</script>
