<div class="container-xl">
  <!-- Page Header -->
  <div class="page-header d-print-none mb-4">
    <div class="row align-items-center">
      <div class="col">
        <div class="page-pretitle">Modul Supervisi Akademik</div>
        <h2 class="page-title text-primary fw-bold">
          <i class="ti ti-list-check me-2"></i>Daftar Guru Supervisi Akademik
        </h2>
        <div class="text-muted small mt-1">
          Daftar seluruh guru yang dapat disupervisi (Tahun Pelajaran <?= html_escape($active_tp['tahun'] ?? '-') ?> - Semester <?= html_escape($active_tp['semester'] ?? 'Ganjil') ?>)
        </div>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <a href="<?= base_url('supervisi/dashboard') ?>" class="btn btn-outline-secondary">
          <i class="ti ti-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
      </div>
    </div>
  </div>

  <!-- Teachers Table Card -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent d-flex align-items-center justify-content-between">
      <h3 class="card-title fw-bold text-dark mb-0">Master Guru & Progress Form Supervisi</h3>
      <div class="w-25">
        <input type="text" id="searchGuru" class="form-control form-control-sm" placeholder="Cari nama guru / NIP / mapel...">
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-vcenter card-table table-hover" id="tableGuru">
        <thead>
          <tr class="bg-light">
            <th class="w-1">No</th>
            <th>Nama Guru</th>
            <th>NIP / ID</th>
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            <th class="text-center">Form 1</th>
            <th class="text-center">Form 2</th>
            <th class="text-center">Form 3</th>
            <th class="text-center">Form 4</th>
            <th class="text-center">Status</th>
            <th class="text-end">Aksi Supervisi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($gurus)): ?>
            <tr>
              <td colspan="11" class="text-center py-4 text-muted">Belum ada data guru.</td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($gurus as $g): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <div class="fw-bold text-dark"><?= html_escape($g['nama_guru']) ?></div>
                </td>
                <td><code class="text-muted"><?= html_escape($g['nip'] ? $g['nip'] : '-') ?></code></td>
                <td>
                  <?php if (!empty($g['mapels'])): ?>
                    <span class="badge bg-blue-lt"><?= html_escape(implode(', ', $g['mapels'])) ?></span>
                  <?php else: ?>
                    <span class="text-muted small">-</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($g['kelas'])): ?>
                    <span class="badge bg-gray-lt"><?= html_escape(implode(', ', $g['kelas'])) ?></span>
                  <?php else: ?>
                    <span class="text-muted small">Semua Kelas</span>
                  <?php endif; ?>
                </td>

                <!-- Form 1 Status -->
                <td class="text-center">
                  <?php if ($g['form_status'][1] == 'SELESAI'): ?>
                    <span class="badge bg-success-lt" title="Form 1 Selesai"><i class="ti ti-check fs-2 text-success"></i></span>
                  <?php elseif ($g['form_status'][1] == 'DRAFT' || $g['form_status'][1] == 'DALAM PROSES'): ?>
                    <span class="badge bg-warning-lt" title="Form 1 Dalam Proses"><i class="ti ti-clock text-warning"></i></span>
                  <?php else: ?>
                    <span class="text-muted fw-bold">-</span>
                  <?php endif; ?>
                </td>

                <!-- Form 2 Status -->
                <td class="text-center">
                  <?php if ($g['form_status'][2] == 'SELESAI'): ?>
                    <span class="badge bg-success-lt" title="Form 2 Selesai"><i class="ti ti-check fs-2 text-success"></i></span>
                  <?php elseif ($g['form_status'][2] == 'DRAFT' || $g['form_status'][2] == 'DALAM PROSES'): ?>
                    <span class="badge bg-warning-lt" title="Form 2 Dalam Proses"><i class="ti ti-clock text-warning"></i></span>
                  <?php else: ?>
                    <span class="text-muted fw-bold">-</span>
                  <?php endif; ?>
                </td>

                <!-- Form 3 Status -->
                <td class="text-center">
                  <?php if ($g['form_status'][3] == 'SELESAI'): ?>
                    <span class="badge bg-success-lt" title="Form 3 Selesai"><i class="ti ti-check fs-2 text-success"></i></span>
                  <?php elseif ($g['form_status'][3] == 'DRAFT' || $g['form_status'][3] == 'DALAM PROSES'): ?>
                    <span class="badge bg-warning-lt" title="Form 3 Dalam Proses"><i class="ti ti-clock text-warning"></i></span>
                  <?php else: ?>
                    <span class="text-muted fw-bold">-</span>
                  <?php endif; ?>
                </td>

                <!-- Form 4 Status -->
                <td class="text-center">
                  <?php if ($g['form_status'][4] == 'SELESAI'): ?>
                    <span class="badge bg-success-lt" title="Form 4 Selesai"><i class="ti ti-check fs-2 text-success"></i></span>
                  <?php elseif ($g['form_status'][4] == 'DRAFT' || $g['form_status'][4] == 'DALAM PROSES'): ?>
                    <span class="badge bg-warning-lt" title="Form 4 Dalam Proses"><i class="ti ti-clock text-warning"></i></span>
                  <?php else: ?>
                    <span class="text-muted fw-bold">-</span>
                  <?php endif; ?>
                </td>

                <!-- Overall Status Badge -->
                <td class="text-center">
                  <?php if ($g['overall_status'] == 'Selesai'): ?>
                    <span class="badge bg-success">Selesai</span>
                  <?php elseif ($g['overall_status'] == 'Dalam Proses'): ?>
                    <span class="badge bg-warning">Dalam Proses</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">Belum</span>
                  <?php endif; ?>
                </td>

                <!-- Actions -->
                <td class="text-end">
                  <div class="dropdown">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Pilih Form Supervisi
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                      <li><h6 class="dropdown-header">Instrumen Supervisi</h6></li>
                      <li><a class="dropdown-item" href="<?= base_url('supervisi/form1?guru_id=' . $g['guru_id']) ?>"><i class="ti ti-file-text me-2 text-indigo"></i>Form 1: Administrasi Guru</a></li>
                      <li><a class="dropdown-item" href="<?= base_url('supervisi/form2?guru_id=' . $g['guru_id']) ?>"><i class="ti ti-file-description me-2 text-teal"></i>Form 2: RPP / Modul Ajar</a></li>
                      <li><a class="dropdown-item" href="<?= base_url('supervisi/form3?guru_id=' . $g['guru_id']) ?>"><i class="ti ti-video me-2 text-purple"></i>Form 3: Observasi Kelas</a></li>
                      <li><a class="dropdown-item" href="<?= base_url('supervisi/form4?guru_id=' . $g['guru_id']) ?>"><i class="ti ti-chart-bar me-2 text-pink"></i>Form 4: Penilaian Siswa</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="<?= base_url('supervisi/detail_guru/' . $g['guru_id']) ?>"><i class="ti ti-user me-2 text-info"></i>Lihat Riwayat & Detail Guru</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
document.getElementById('searchGuru').addEventListener('keyup', function() {
  var filter = this.value.toLowerCase();
  var rows = document.querySelectorAll('#tableGuru tbody tr');
  rows.forEach(function(row) {
    var text = row.textContent.toLowerCase();
    row.style.display = text.indexOf(filter) > -1 ? '' : 'none';
  });
});
</script>
