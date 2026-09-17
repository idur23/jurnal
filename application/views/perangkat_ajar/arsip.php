<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Perangkat Ajar</div>
      <h2 class="page-title text-indigo"><i class="ti ti-archive me-2"></i>Arsip & Versi Lama Perangkat Ajar</h2>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('perangkat_ajar/daftar') ?>" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar</a>
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
          <th>Semester / Pertemuan</th>
          <th>Versi</th>
          <th>Status Berkas</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($archive_list)): ?>
          <tr>
            <td colspan="8" class="text-center py-4 text-muted">Tidak ada berkas perangkat ajar yang diarsipkan.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($archive_list as $a): ?>
            <tr>
              <td><span class="fw-bold"><?= $a['jenis_perangkat'] ?></span></td>
              <td><?= html_escape($a['nama_mapel']) ?></td>
              <td><?= html_escape($a['nama_kelas']) ?></td>
              <td><?= html_escape($a['nama_guru']) ?></td>
              <td>Semester <?= $a['semester'] ?> (P. <?= $a['pertemuan_ke'] ?>)</td>
              <td><span class="badge bg-indigo-lt">v<?= $a['version'] ?></span></td>
              <td>
                <?php if ($a['is_archived'] == 1): ?>
                  <span class="badge bg-danger">Diarsipkan</span>
                <?php elseif ($a['is_active'] == 0): ?>
                  <span class="badge bg-secondary">Versi Lama (Historis)</span>
                <?php endif; ?>
              </td>
              <td>
                <div class="btn-list">
                  <a href="<?= base_url('perangkat_ajar/detail/' . $a['id']) ?>" class="btn btn-sm btn-outline-primary" title="Tinjau"><i class="ti ti-eye"></i></a>
                  <?php if ($a['is_archived'] == 1): ?>
                    <a href="<?= base_url('perangkat_ajar/do_restore/' . $a['id']) ?>" class="btn btn-sm btn-outline-success" title="Pulihkan"><i class="ti ti-rotate"></i></a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
