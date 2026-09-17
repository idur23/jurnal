<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Perangkat Ajar</div>
      <h2 class="page-title text-indigo"><i class="ti ti-history me-2"></i>Riwayat Revisi Perangkat Ajar</h2>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('perangkat_ajar/index') ?>" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i> Dashboard</a>
    </div>
  </div>
</div>

<div class="card shadow-sm" style="border-radius: 12px;">
  <div class="table-responsive">
    <table class="table table-vcenter table-striped card-table">
      <thead>
        <tr>
          <th>Jenis Perangkat</th>
          <th>Mata Pelajaran</th>
          <th>Kelas</th>
          <th>Guru Pengampu</th>
          <th>Versi Hasil Revisi</th>
          <th>Tanggal Revisi</th>
          <th>Status Saat Ini</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($revisions)): ?>
          <tr>
            <td colspan="8" class="text-center py-4 text-muted">Belum ada riwayat revisi perangkat ajar.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($revisions as $r): ?>
            <tr>
              <td><span class="fw-bold"><?= $r['jenis_perangkat'] ?></span></td>
              <td><?= html_escape($r['nama_mapel']) ?></td>
              <td><?= html_escape($r['nama_kelas']) ?></td>
              <td><?= html_escape($r['nama_guru']) ?></td>
              <td><span class="badge bg-indigo-lt">v<?= $r['version'] ?></span></td>
              <td><?= date('d M Y H:i', strtotime($r['created_at'])) ?></td>
              <td>
                <?php if ($r['is_active'] == 1): ?>
                  <span class="badge bg-success">Aktif (Terkini)</span>
                <?php else: ?>
                  <span class="badge bg-secondary">Riwayat Lama</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="<?= base_url('perangkat_ajar/detail/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary">
                  <i class="ti ti-eye me-1"></i> Lihat Detail
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
