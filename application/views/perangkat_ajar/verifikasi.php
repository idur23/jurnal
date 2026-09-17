<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Perangkat Ajar</div>
      <h2 class="page-title text-indigo"><i class="ti ti-check-double me-2"></i>Verifikasi Perangkat Ajar</h2>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('perangkat_ajar/index') ?>" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i> Dashboard</a>
    </div>
  </div>
</div>

<!-- Pending List Card -->
<div class="card shadow-sm" style="border-radius: 12px;">
  <div class="card-header bg-light">
    <h3 class="card-title text-indigo"><i class="ti ti-hourglass me-2"></i>Menunggu Verifikasi (<?= count($pending_list) ?>)</h3>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter table-striped card-table">
      <thead>
        <tr>
          <th>Jenis Perangkat</th>
          <th>Mata Pelajaran</th>
          <th>Kelas</th>
          <th>Guru Pengampu</th>
          <th>Semester / Pertemuan</th>
          <th>Versi</th>
          <th>Tanggal Unggah</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($pending_list)): ?>
          <tr>
            <td colspan="8" class="text-center py-4 text-muted">Tidak ada perangkat ajar yang sedang menunggu verifikasi.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($pending_list as $p): ?>
            <tr>
              <td><span class="fw-bold"><?= $p['jenis_perangkat'] ?></span></td>
              <td><?= html_escape($p['nama_mapel']) ?></td>
              <td><?= html_escape($p['nama_kelas']) ?></td>
              <td><?= html_escape($p['nama_guru']) ?></td>
              <td>Semester <?= $p['semester'] ?> (P. <?= $p['pertemuan_ke'] ?>)</td>
              <td><span class="badge bg-indigo-lt">v<?= $p['version'] ?></span></td>
              <td><?= date('d M Y H:i', strtotime($p['created_at'])) ?></td>
              <td>
                <a href="<?= base_url('perangkat_ajar/verifikasi/' . $p['id']) ?>" class="btn btn-sm btn-indigo">
                  <i class="ti ti-check-double me-1"></i> Tinjau & Verifikasi
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
