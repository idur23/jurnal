<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL TENTOR MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-books me-2 text-info"></i> MAPEL MBF SAYA
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title text-dark mb-0"><i class="ti ti-list me-2"></i> MATA PELAJARAN YANG DIAMPU</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead class="bg-light">
            <tr>
              <th width="50">No</th>
              <th>Kode Mapel</th>
              <th>Nama Mapel MBF</th>
              <th>Tahun Pelajaran</th>
              <th class="text-center">Jumlah Peserta</th>
              <th class="text-center">Aksi Quick Presensi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($list_mapel)): ?>
              <?php $no = 1; foreach ($list_mapel as $m): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><span class="badge bg-secondary-lt fs-3"><?= html_escape($m['kode_mapel']) ?></span></td>
                  <td class="fw-bold text-dark fs-3"><?= html_escape($m['nama_mapel']) ?></td>
                  <td><?= html_escape($m['tahun']) ?> (<?= html_escape($m['semester']) ?>)</td>
                  <td class="text-center">
                    <span class="badge bg-success-lt fs-3 px-3"><?= (int)$m['total_peserta'] ?> Siswa</span>
                  </td>
                  <td class="text-center">
                    <a href="<?= base_url('tentor/presensi?mapel_id=' . $m['id']) ?>" class="btn btn-sm btn-warning me-1">
                      <i class="ti ti-user-check me-1"></i> Presensi Hari Ini
                    </a>
                    <a href="<?= base_url('tentor/peserta?mapel_id=' . $m['id']) ?>" class="btn btn-sm btn-outline-info">
                      <i class="ti ti-users me-1"></i> Lihat Peserta
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-4">Anda belum memiliki Mapel MBF yang diampu. Silakan hubungi Administrator.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
