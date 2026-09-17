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
      <h2 class="page-title">Jurnal Penanganan & Pembinaan Siswa</h2>
      <div class="text-muted small mt-1">Catat dan monitor penanganan kasus atau pembinaan khusus siswa di kelas Anda.</div>
    </div>
    <div class="col-auto ms-auto">
      <div class="btn-list">
        <button class="btn btn-outline-indigo" data-bs-toggle="modal" data-bs-target="#modalExportCase">
          <i class="ti ti-download me-1"></i> Export Data
        </button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCase">
          <i class="ti ti-plus me-1"></i> Tambah Log Kasus
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Dashboard Analitik Jurnal Penanganan Siswa -->
<div class="row row-cards mb-4 d-print-none">
  <!-- Card 1: Kategori Masalah Terbanyak -->
  <div class="col-md-3">
    <div class="card shadow-sm border-0" style="height: 240px; border-radius: 12px;">
      <div class="card-body p-3 text-center">
        <h4 class="fw-bold mb-2 text-indigo">Kategori Masalah</h4>
        <div class="d-flex justify-content-center" style="height: 160px; position: relative;">
          <canvas id="chartKategori" style="max-height: 150px;"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 2: Status Penanganan -->
  <div class="col-md-3">
    <div class="card shadow-sm border-0" style="height: 240px; border-radius: 12px;">
      <div class="card-body p-3 text-center">
        <h4 class="fw-bold mb-2 text-indigo">Status Penanganan</h4>
        <div class="d-flex justify-content-center" style="height: 160px; position: relative;">
          <canvas id="chartStatus" style="max-height: 150px;"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 3: Kasus per Siswa (Top 4) -->
  <div class="col-md-3">
    <div class="card shadow-sm border-0" style="height: 240px; border-radius: 12px;">
      <div class="card-body p-3">
        <h4 class="fw-bold mb-3 text-center text-indigo">Kasus Terbanyak</h4>
        <div class="table-responsive" style="max-height: 160px; overflow-y: auto;">
          <table class="table table-sm table-vcenter">
            <tbody>
              <?php if (empty($stats_siswa)): ?>
                <tr><td class="text-muted text-center py-4">Belum ada data</td></tr>
              <?php else: ?>
                <?php foreach (array_slice($stats_siswa, 0, 4) as $ss): ?>
                  <tr>
                    <td><div class="small fw-bold text-truncate" style="max-width: 100px;"><?= html_escape($ss['nama_lengkap']) ?></div></td>
                    <td class="text-end"><span class="badge bg-danger text-white"><?= $ss['total'] ?> kasus</span></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 4: Tren Kasus Bulanan -->
  <div class="col-md-3">
    <div class="card shadow-sm border-0" style="height: 240px; border-radius: 12px;">
      <div class="card-body p-3 text-center">
        <h4 class="fw-bold mb-2 text-indigo">Tren Bulanan</h4>
        <div class="d-flex justify-content-center" style="height: 160px; position: relative;">
          <canvas id="chartTren" style="max-height: 150px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header bg-dark text-white">
    <h3 class="card-title text-white"><i class="ti ti-user-exclamation me-2"></i>Daftar Kasus & Pembinaan Siswa</h3>
  </div>
  <?php if (empty($cases)): ?>
    <div class="card-body text-center py-5 text-muted">
      <i class="ti ti-user-exclamation fs-1 text-danger mb-2"></i>
      <h3 class="mt-2">Belum ada kasus atau pembinaan siswa yang dicatat.</h3>
      <p class="mb-0">Klik tombol <strong>Tambah Log Kasus</strong> di kanan atas untuk memulai.</p>
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-vcenter card-table table-striped datatable">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Tanggal</th>
            <th>Nama Siswa</th>
            <th>Permasalahan & Kategori</th>
            <th>Tindakan & RTL</th>
            <th>Hasil & Catatan</th>
            <th>Status</th>
            <th>Dokumentasi</th>
            <th class="text-center" style="width: 130px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; foreach ($cases as $c): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= date('d M Y', strtotime($c['tanggal'])) ?></td>
              <td>
                <a href="<?= base_url('walikelas/profil_penanganan/' . $c['siswa_id']) ?>" class="fw-bold text-indigo" title="Lihat Profil Histori Penanganan Siswa">
                  <?= html_escape($c['nama_siswa']) ?> <i class="ti ti-external-link small text-muted"></i>
                </a>
                <div class="text-muted small">NIS: <?= html_escape($c['nis']) ?></div>
              </td>
              <td>
                <div class="fw-bold text-wrap" style="max-width: 200px;"><?= html_escape($c['permasalahan']) ?></div>
                <span class="badge bg-secondary-lt mt-1"><?= html_escape($c['kategori']) ?></span>
              </td>
              <td>
                <div class="small"><strong>Tindakan:</strong> <?= html_escape($c['tindakan'] ? $c['tindakan'] : '-') ?></div>
                <div class="small text-muted"><strong>RTL:</strong> <?= html_escape($c['rencana_tindak_lanjut'] ? $c['rencana_tindak_lanjut'] : '-') ?></div>
              </td>
              <td>
                <div class="small text-wrap" style="max-width: 200px;"><?= html_escape($c['hasil'] ? $c['hasil'] : '-') ?></div>
              </td>
              <td>
                <?php if ($c['status'] == 'Selesai'): ?>
                  <span class="badge bg-success text-white fw-bold">Selesai</span>
                <?php elseif ($c['status'] == 'Monitoring'): ?>
                  <span class="badge bg-warning text-white fw-bold">Monitoring</span>
                <?php else: ?>
                  <span class="badge bg-danger text-white fw-bold">Proses</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($c['dokumentasi']): ?>
                  <a href="<?= base_url($c['dokumentasi']) ?>" target="_blank" class="badge bg-green-lt"><i class="ti ti-file me-1"></i> Lampiran</a>
                <?php else: ?>
                  <span class="text-muted small">Tidak ada</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <div class="btn-list flex-nowrap justify-content-center">
                  <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEditCase_<?= $c['id'] ?>" title="Edit Log">
                    <i class="ti ti-edit"></i>
                  </button>
                  <form action="<?= base_url('walikelas/penanganan_siswa') ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan penanganan ini?')">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Log">
                      <i class="ti ti-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>

            <!-- Modal Edit Case -->
            <div class="modal modal-blur fade" id="modalEditCase_<?= $c['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <form action="<?= base_url('walikelas/penanganan_siswa') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">

                    <div class="modal-header">
                      <h5 class="modal-title">Edit Log Penanganan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label required">Siswa</label>
                          <select name="siswa_id" class="form-select" required>
                            <?php foreach ($siswa_list as $s): ?>
                              <option value="<?= $s['id'] ?>" <?= $c['siswa_id'] == $s['id'] ? 'selected' : '' ?>><?= html_escape($s['nama_lengkap']) ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label required">Tanggal</label>
                          <input type="date" name="tanggal" class="form-control" value="<?= html_escape($c['tanggal']) ?>" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label required">Kategori</label>
                          <select name="kategori" class="form-select" required>
                            <?php foreach (array('Akademik', 'Disiplin', 'Perilaku', 'Kesehatan', 'Sosial') as $kat): ?>
                              <option value="<?= $kat ?>" <?= $c['kategori'] == $kat ? 'selected' : '' ?>><?= $kat ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label required">Status Penanganan</label>
                          <select name="status" class="form-select" required>
                            <option value="Proses" <?= $c['status'] == 'Proses' ? 'selected' : '' ?>>Proses Tindakan</option>
                            <option value="Monitoring" <?= $c['status'] == 'Monitoring' ? 'selected' : '' ?>>Dalam Monitoring</option>
                            <option value="Selesai" <?= $c['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai / Teratasi</option>
                          </select>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label required">Deskripsi Permasalahan</label>
                        <textarea name="permasalahan" class="form-control" rows="2" required><?= html_escape($c['permasalahan']) ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Tindakan Wali Kelas</label>
                        <textarea name="tindakan" class="form-control" rows="2"><?= html_escape($c['tindakan']) ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Hasil Pembinaan</label>
                        <textarea name="hasil" class="form-control" rows="2"><?= html_escape($c['hasil']) ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Rencana Tindak Lanjut (RTL)</label>
                        <textarea name="rencana_tindak_lanjut" class="form-control" rows="2"><?= html_escape($c['rencana_tindak_lanjut']) ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Ganti Dokumentasi / File</label>
                        <input type="file" name="dokumentasi" class="form-control">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-warning fw-bold">Update Catatan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<!-- Modal Add Case -->
<div class="modal modal-blur fade" id="modalAddCase" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('walikelas/penanganan_siswa') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">

        <div class="modal-header">
          <h5 class="modal-title">Tambah Catatan Kasus Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Pilih Siswa</label>
              <select name="siswa_id" class="form-select select2" required>
                <option value="">-- Pilih Siswa --</option>
                <?php foreach ($siswa_list as $s): ?>
                  <option value="<?= $s['id'] ?>"><?= html_escape($s['nama_lengkap']) ?> (NIS: <?= html_escape($s['nis']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Tanggal Kejadian / Log</label>
              <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Kategori Masalah</label>
              <select name="kategori" class="form-select" required>
                <option value="Akademik">Akademik (Nilai Rendah / Tugas Kurang)</option>
                <option value="Disiplin">Disiplin (Terlambat / Bolos / Atribut)</option>
                <option value="Perilaku">Perilaku (Sikap / Berkelahi / Perkataan)</option>
                <option value="Kesehatan">Kesehatan (Sakit Menahun / Fisik)</option>
                <option value="Sosial">Sosial (Kesulitan Adaptasi / Bullying)</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Status Awal</label>
              <select name="status" class="form-select" required>
                <option value="Proses">Proses Tindakan</option>
                <option value="Monitoring">Dalam Monitoring</option>
                <option value="Selesai">Selesai / Teratasi</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Deskripsi Permasalahan</label>
            <textarea name="permasalahan" class="form-control" rows="2" placeholder="Tuliskan detail permasalahan siswa..." required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Tindakan Wali Kelas / Pembinaan</label>
            <textarea name="tindakan" class="form-control" rows="2" placeholder="Tuliskan tindakan awal yang diambil (panggilan/nasihat/sp)..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Hasil Pembinaan</label>
            <textarea name="hasil" class="form-control" rows="2" placeholder="Tuliskan hasil atau komitmen siswa setelah pembinaan..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Rencana Tindak Lanjut (RTL)</label>
            <textarea name="rencana_tindak_lanjut" class="form-control" rows="2" placeholder="Tindakan lanjutan ke depan atau monitoring mingguan..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Dokumentasi / Lampiran File Pendukung</label>
            <input type="file" name="dokumentasi" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold">Simpan Log Kasus</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Export Filtered Case -->
<div class="modal modal-blur fade" id="modalExportCase" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-indigo text-white">
        <h5 class="modal-title text-white"><i class="ti ti-download me-2"></i>Export Laporan Penanganan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formExport" method="GET" target="_blank">
          <input type="hidden" name="kelas_id" value="<?= $kelas['id'] ?>">
          
          <div class="mb-3">
            <label class="form-label">Pilih Siswa (Opsional)</label>
            <select name="siswa_id" class="form-select">
              <option value="">-- Semua Siswa Binaan --</option>
              <?php foreach ($siswa_list as $s): ?>
                <option value="<?= $s['id'] ?>"><?= html_escape($s['nama_lengkap']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Kategori Masalah</label>
              <select name="kategori" class="form-select">
                <option value="">-- Semua Kategori --</option>
                <option value="Akademik">Akademik</option>
                <option value="Disiplin">Disiplin</option>
                <option value="Perilaku">Perilaku</option>
                <option value="Kesehatan">Kesehatan</option>
                <option value="Sosial">Sosial</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Semester</label>
              <select name="semester" class="form-select">
                <option value="">-- Semua Semester --</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Rentang Mulai Tanggal</label>
              <input type="date" name="tanggal_mulai" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Rentang Sampai Tanggal</label>
              <input type="date" name="tanggal_selesai" class="form-control">
            </div>
          </div>

          <div class="text-center py-3">
            <span class="text-muted small">Pilih salah satu format ekspor di bawah ini:</span>
          </div>

          <div class="row g-2">
            <div class="col-6">
              <button type="submit" onclick="this.form.action='<?= base_url('laporan/penanganan_pdf') ?>'" class="btn btn-danger w-100 fw-bold">
                <i class="ti ti-file-pdf me-2"></i> Download PDF
              </button>
            </div>
            <div class="col-6">
              <button type="submit" onclick="this.form.action='<?= base_url('laporan/penanganan_excel') ?>'; this.form.target='_self'" class="btn btn-success w-100 fw-bold">
                <i class="ti ti-file-spreadsheet me-2"></i> Download Excel
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Chart Script for Dashboard -->
<script>
  $(document).ready(function() {
    // 1. Kategori Chart
    var katCtx = document.getElementById('chartKategori').getContext('2d');
    var chartKategori = new Chart(katCtx, {
      type: 'doughnut',
      data: {
        labels: ['Akademik', 'Disiplin', 'Perilaku', 'Kesehatan', 'Sosial'],
        datasets: [{
          data: [
            <?= isset($stats_kategori) ? (int)($stats_kategori[array_search('Akademik', array_column($stats_kategori, 'kategori'))]['total'] ?? 0) : 0 ?>,
            <?= isset($stats_kategori) ? (int)($stats_kategori[array_search('Disiplin', array_column($stats_kategori, 'kategori'))]['total'] ?? 0) : 0 ?>,
            <?= isset($stats_kategori) ? (int)($stats_kategori[array_search('Perilaku', array_column($stats_kategori, 'kategori'))]['total'] ?? 0) : 0 ?>,
            <?= isset($stats_kategori) ? (int)($stats_kategori[array_search('Kesehatan', array_column($stats_kategori, 'kategori'))]['total'] ?? 0) : 0 ?>,
            <?= isset($stats_kategori) ? (int)($stats_kategori[array_search('Sosial', array_column($stats_kategori, 'kategori'))]['total'] ?? 0) : 0 ?>
          ],
          backgroundColor: ['#3b82f6', '#ef4444', '#f59e0b', '#10b981', '#6366f1'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { boxWidth: 8, font: { size: 9 } }
          }
        }
      }
    });

    // 2. Status Chart
    var statCtx = document.getElementById('chartStatus').getContext('2d');
    var chartStatus = new Chart(statCtx, {
      type: 'pie',
      data: {
        labels: ['Proses', 'Monitoring', 'Selesai'],
        datasets: [{
          data: [
            <?= isset($stats_status) ? (int)($stats_status[array_search('Proses', array_column($stats_status, 'status'))]['total'] ?? 0) : 0 ?>,
            <?= isset($stats_status) ? (int)($stats_status[array_search('Monitoring', array_column($stats_status, 'status'))]['total'] ?? 0) : 0 ?>,
            <?= isset($stats_status) ? (int)($stats_status[array_search('Selesai', array_column($stats_status, 'status'))]['total'] ?? 0) : 0 ?>
          ],
          backgroundColor: ['#ef4444', '#f59e0b', '#10b981'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { boxWidth: 8, font: { size: 9 } }
          }
        }
      }
    });

    // 3. Tren Chart
    <?php 
      $months = array();
      $totals = array();
      if (!empty($stats_tren)) {
          foreach ($stats_tren as $t) {
              $months[] = date('M Y', strtotime($t['bulan'] . '-01'));
              $totals[] = (int)$t['total'];
          }
      }
    ?>
    var trenCtx = document.getElementById('chartTren').getContext('2d');
    var chartTren = new Chart(trenCtx, {
      type: 'line',
      data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
          data: <?= json_encode($totals) ?>,
          borderColor: '#6366f1',
          backgroundColor: 'rgba(99, 102, 241, 0.1)',
          fill: true,
          tension: 0.3,
          borderWidth: 2,
          pointRadius: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { font: { size: 8 }, stepSize: 1 }
          },
          x: { ticks: { font: { size: 8 } } }
        }
      }
    });
  });
</script>
