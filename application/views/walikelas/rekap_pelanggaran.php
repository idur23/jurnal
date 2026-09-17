<?php if (isset($kelas['is_admin_mode']) && $kelas['is_admin_mode']): ?>
<div class="card mb-4 d-print-none border-0 shadow-sm overflow-hidden position-relative" style="border-radius: 12px; background: linear-gradient(135deg, #eff6ff 0%, #f5f3ff 100%); border-left: 5px solid #6366f1 !important;">
  <div class="card-body py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div class="d-flex align-items-center gap-2">
      <span class="avatar avatar-sm bg-indigo text-white rounded-3">
        <i class="ti ti-shield-check fs-3"></i>
      </span>
      <div>
        <h4 class="mb-0 fw-bold text-indigo">Simulasi Wali Kelas (Mode Admin)</h4>
        <p class="text-muted small mb-0">Anda sedang mengakses halaman khusus wali kelas. Silakan pilih kelas binaan:</p>
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <span class="text-muted small fw-semibold"><i class="ti ti-building me-1"></i>Pilih Kelas:</span>
      <div style="width: 200px;">
        <select class="form-select form-select-sm fw-bold border-indigo" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(99, 102, 241, 0.1);" onchange="location = '<?= base_url($this->uri->uri_string()) ?>?kelas_id=' + this.value;">
          <?php foreach ($kelas['list_kelas_all'] as $k): ?>
            <option value="<?= $k['id'] ?>" <?= ($kelas['id'] == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Wali Kelas</div>
      <h2 class="page-title text-indigo"><i class="ti ti-alert-triangle me-2"></i>Rekap Pelanggaran Siswa</h2>
      <div class="text-muted small mt-1">Pantau akumulasi poin kasus pelanggaran siswa kelas <?= html_escape($kelas['nama_kelas']) ?>.</div>
    </div>
    <div class="col-auto ms-auto d-flex gap-2">
      <a href="<?= base_url('walikelas/rekap_pelanggaran_export/excel?kelas_id=' . $kelas['id']) ?>" class="btn btn-outline-success">
        <i class="ti ti-file-spreadsheet me-1"></i> Export Excel
      </a>
      <a href="<?= base_url('walikelas/rekap_pelanggaran_export/pdf?kelas_id=' . $kelas['id']) ?>" target="_blank" class="btn btn-outline-danger">
        <i class="ti ti-file-text me-1"></i> Export PDF
      </a>
      <a href="<?= base_url('walikelas/rekap_pelanggaran_export/print?kelas_id=' . $kelas['id']) ?>" target="_blank" class="btn btn-outline-secondary">
        <i class="ti ti-printer me-1"></i> Print / Cetak
      </a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header bg-dark text-white">
    <h3 class="card-title text-white"><i class="ti ti-users me-2"></i>Daftar Siswa Kelas <?= html_escape($kelas['nama_kelas']) ?></h3>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped table-hover datatable">
      <thead>
        <tr>
          <th style="width: 50px;">#</th>
          <th>NIS</th>
          <th>Nama Lengkap</th>
          <th>Jenis Kelamin</th>
          <th class="text-center">Total Kasus</th>
          <th class="text-center">Akumulasi Poin</th>
          <th class="text-center" style="width: 100px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($list_siswa as $s): 
          $poin = $s['total_poin'];
          if ($poin == 0) {
            $badge_color = 'bg-success-lt';
          } elseif ($poin <= 10) {
            $badge_color = 'bg-info-lt';
          } elseif ($poin <= 30) {
            $badge_color = 'bg-warning-lt';
          } else {
            $badge_color = 'bg-danger-lt fw-bold';
          }
        ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><code><?= html_escape($s['nis']) ?></code></td>
            <td class="fw-bold">
              <a href="<?= base_url('walikelas/rekap_pelanggaran_detail/' . $s['id'] . '?kelas_id=' . $kelas['id']) ?>" class="text-indigo">
                <?= html_escape($s['nama_lengkap']) ?>
              </a>
            </td>
            <td><?= $s['jk'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
            <td class="text-center">
              <span class="badge bg-blue-lt"><?= $s['total_kasus'] ?> Kasus</span>
            </td>
            <td class="text-center">
              <span class="badge <?= $badge_color ?> px-2 py-1" style="font-size: 0.9rem;">
                <?= $poin ?> Poin
              </span>
            </td>
            <td class="text-center">
              <a href="<?= base_url('walikelas/rekap_pelanggaran_detail/' . $s['id'] . '?kelas_id=' . $kelas['id']) ?>" class="btn btn-sm btn-outline-indigo fw-bold">
                <i class="ti ti-eye me-1"></i> Detail Profil
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
