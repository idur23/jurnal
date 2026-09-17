<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Poin Keaktifan Siswa</div>
      <h2 class="page-title"><i class="ti ti-star text-warning me-2"></i>Dashboard & Rekapitulasi Poin Keaktifan</h2>
    </div>
    <div class="col-auto ms-auto d-print-none d-flex gap-2">
      <button type="button" class="btn btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#modalSelectJurnal">
        <i class="ti ti-plus me-1"></i> Input Poin per Jurnal
      </button>
      <a href="<?= base_url('poinkeaktifan/print_rekap?' . http_build_query($filters)) ?>" target="_blank" class="btn btn-outline-secondary">
        <i class="ti ti-printer me-1"></i> Cetak
      </a>
      <a href="<?= base_url('poinkeaktifan/export_pdf?' . http_build_query($filters)) ?>" target="_blank" class="btn btn-outline-danger">
        <i class="ti ti-file-type-pdf me-1"></i> Export PDF
      </a>
      <a href="<?= base_url('poinkeaktifan/export_excel?' . http_build_query($filters)) ?>" class="btn btn-outline-success">
        <i class="ti ti-file-spreadsheet me-1"></i> Export Excel
      </a>
    </div>
  </div>
</div>

<!-- Filters Header Card -->
<div class="card mb-4 shadow-sm border-0">
  <div class="card-body bg-light-subtle rounded-3">
    <form method="GET" action="<?= base_url('poinkeaktifan') ?>" class="row g-3 align-items-end">
      <div class="col-md-2 col-6">
        <label class="form-label small fw-bold text-muted">Bulan</label>
        <select name="bulan" class="form-select">
          <?php 
            $months = array(
              1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
              5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
              9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            );
            foreach ($months as $num => $name):
          ?>
            <option value="<?= $num ?>" <?= ($filters['bulan'] == $num) ? 'selected' : '' ?>><?= $name ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-2 col-6">
        <label class="form-label small fw-bold text-muted">Tahun</label>
        <select name="tahun" class="form-select">
          <?php for ($y = date('Y'); $y >= date('Y') - 3; $y--): ?>
            <option value="<?= $y ?>" <?= ($filters['tahun'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="col-md-2 col-6">
        <label class="form-label small fw-bold text-muted">Kelas</label>
        <select name="kelas_id" class="form-select">
          <option value="">-- Semua Kelas --</option>
          <?php foreach ($list_kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= ($filters['kelas_id'] == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-2 col-6">
        <label class="form-label small fw-bold text-muted">Mata Pelajaran</label>
        <select name="mapel_id" class="form-select">
          <option value="">-- Semua Mapel --</option>
          <?php foreach ($list_mapel as $m): ?>
            <option value="<?= $m['id'] ?>" <?= ($filters['mapel_id'] == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'waka', 'kamad'))): ?>
      <div class="col-md-2 col-6">
        <label class="form-label small fw-bold text-muted">Guru</label>
        <select name="guru_id" class="form-select">
          <option value="">-- Semua Guru --</option>
          <?php foreach ($list_guru as $g): ?>
            <option value="<?= $g['id'] ?>" <?= ($filters['guru_id'] == $g['id']) ? 'selected' : '' ?>><?= html_escape($g['nama_lengkap']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php endif; ?>

      <div class="col-md-2 col-12">
        <button type="submit" class="btn btn-primary w-100 fw-bold">
          <i class="ti ti-filter me-1"></i> Terapkan Filter
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Key Performance Indicators / Stats Cards -->
<div class="row row-cards mb-4">
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm shadow-sm border-0">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-primary text-white avatar shadow-sm">
              <i class="ti ti-users fs-2"></i>
            </span>
          </div>
          <div class="col">
            <div class="font-weight-medium text-muted small">Total Siswa Aktif</div>
            <div class="text-dark fw-bold fs-2"><?= number_format($stats['total_siswa']) ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm shadow-sm border-0">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-warning text-white avatar shadow-sm">
              <i class="ti ti-star fs-2"></i>
            </span>
          </div>
          <div class="col">
            <div class="font-weight-medium text-muted small">Total Poin Bulan Ini</div>
            <div class="text-dark fw-bold fs-2"><?= number_format($stats['total_poin_bulan_ini']) ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm shadow-sm border-0">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-success text-white avatar shadow-sm">
              <i class="ti ti-chart-dots fs-2"></i>
            </span>
          </div>
          <div class="col">
            <div class="font-weight-medium text-muted small">Rata-rata Poin / Siswa</div>
            <div class="text-dark fw-bold fs-2"><?= $stats['rata_rata_poin'] ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm shadow-sm border-0">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-indigo text-white avatar shadow-sm">
              <i class="ti ti-trophy fs-2"></i>
            </span>
          </div>
          <div class="col">
            <div class="font-weight-medium text-muted small">Siswa Paling Aktif</div>
            <div class="text-dark fw-bold fs-4 text-truncate" style="max-width: 140px;" title="<?= html_escape($stats['top_siswa']['nama_lengkap'] ?? '-') ?>">
              <?= html_escape($stats['top_siswa']['nama_lengkap'] ?? '-') ?>
            </div>
            <div class="text-success small fw-bold"><?= (int)($stats['top_siswa']['total_poin'] ?? 0) ?> Poin</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main Tabs Section -->
<div class="card shadow-sm border-0">
  <div class="card-header border-bottom">
    <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
      <li class="nav-item">
        <a href="#tab-dashboard" class="nav-link active" data-bs-toggle="tab">
          <i class="ti ti-dashboard me-2"></i>Dashboard Grafik
        </a>
      </li>
      <li class="nav-item">
        <a href="#tab-bulanan" class="nav-link" data-bs-toggle="tab">
          <i class="ti ti-calendar me-2"></i>Rekap Bulanan
        </a>
      </li>
      <li class="nav-item">
        <a href="#tab-kelas" class="nav-link" data-bs-toggle="tab">
          <i class="ti ti-building me-2"></i>Rekap per Kelas
        </a>
      </li>
      <li class="nav-item">
        <a href="#tab-siswa" class="nav-link" data-bs-toggle="tab">
          <i class="ti ti-user me-2"></i>Rekap per Siswa
        </a>
      </li>
      <li class="nav-item">
        <a href="#tab-transaksi" class="nav-link" data-bs-toggle="tab">
          <i class="ti ti-list-check me-2"></i>Detail Transaksi Poin
        </a>
      </li>
    </ul>
  </div>

  <div class="card-body">
    <div class="tab-content">
      
      <!-- Tab 1: Dashboard Grafik -->
      <div class="tab-pane fade show active" id="tab-dashboard">
        <div class="row row-cards">
          <!-- Top 10 Siswa -->
          <div class="col-lg-6 mb-4">
            <div class="card border shadow-none">
              <div class="card-header bg-light">
                <h4 class="card-title mb-0"><i class="ti ti-medal text-warning me-2"></i>Top 10 Siswa Teraktif Bulan Ini</h4>
              </div>
              <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 40px;">#</th>
                      <th>Nama Siswa</th>
                      <th>Kelas</th>
                      <th class="text-end">Total Poin</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($charts['top_10_siswa'])): ?>
                      <tr><td colspan="4" class="text-center text-muted py-3">Belum ada transaksi poin bulan ini.</td></tr>
                    <?php else: ?>
                      <?php $rank = 1; foreach ($charts['top_10_siswa'] as $top): ?>
                        <tr>
                          <td>
                            <?php if ($rank == 1): ?>
                              <span class="badge bg-warning text-dark rounded-circle p-1" style="width: 24px; height: 24px;">1</span>
                            <?php elseif ($rank == 2): ?>
                              <span class="badge bg-secondary text-white rounded-circle p-1" style="width: 24px; height: 24px;">2</span>
                            <?php elseif ($rank == 3): ?>
                              <span class="badge bg-danger text-white rounded-circle p-1" style="width: 24px; height: 24px;">3</span>
                            <?php else: ?>
                              <span class="text-muted"><?= $rank ?></span>
                            <?php endif; ?>
                          </td>
                          <td class="fw-bold text-dark"><?= html_escape($top['nama_lengkap']) ?></td>
                          <td><span class="badge bg-blue-lt"><?= html_escape($top['nama_kelas']) ?></span></td>
                          <td class="text-end fw-bold text-success fs-3">+<?= (int)$top['total_poin'] ?></td>
                        </tr>
                      <?php $rank++; endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Poin per Kelas -->
          <div class="col-lg-6 mb-4">
            <div class="card border shadow-none">
              <div class="card-header bg-light">
                <h4 class="card-title mb-0"><i class="ti ti-chart-bar text-primary me-2"></i>Total Poin per Kelas</h4>
              </div>
              <div class="card-body">
                <div id="chart-poin-kelas" style="height: 300px;"></div>
              </div>
            </div>
          </div>

          <!-- Trend Poin Tahunan -->
          <div class="col-12">
            <div class="card border shadow-none">
              <div class="card-header bg-light">
                <h4 class="card-title mb-0"><i class="ti ti-chart-line text-success me-2"></i>Tren Aktivitas Poin Keaktifan Tahun <?= $filters['tahun'] ?></h4>
              </div>
              <div class="card-body">
                <div id="chart-poin-trend" style="height: 280px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab 2: Rekap Bulanan -->
      <div class="tab-pane fade" id="tab-bulanan">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="mb-0 text-dark">
            Rekapitulasi Poin Keaktifan Bulan <?= $months[$filters['bulan']] ?> <?= $filters['tahun'] ?>
          </h4>
          <span class="badge bg-info-lt"><?= count($rekap_bulanan) ?> Siswa Terdata</span>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter card-table table-hover table-striped border">
            <thead>
              <tr class="bg-light">
                <th style="width: 50px;">Rank</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>JK</th>
                <th>Kelas</th>
                <th class="text-center">Sesi Jurnal Aktif</th>
                <th class="text-end">Total Poin Keaktifan</th>
                <th class="text-center" style="width: 100px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($rekap_bulanan)): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data rekap poin keaktifan untuk periode ini.</td></tr>
              <?php else: ?>
                <?php $r_no = 1; foreach ($rekap_bulanan as $rb): ?>
                  <tr>
                    <td class="fw-bold"><?= $r_no++ ?></td>
                    <td><code><?= html_escape($rb['nis']) ?></code></td>
                    <td class="fw-bold text-dark"><?= html_escape($rb['nama_lengkap']) ?></td>
                    <td><span class="badge bg-secondary-lt"><?= html_escape($rb['jk']) ?></span></td>
                    <td><span class="badge bg-indigo-lt"><?= html_escape($rb['nama_kelas']) ?></span></td>
                    <td class="text-center"><?= (int)$rb['total_sesi_aktif'] ?> Sesi</td>
                    <td class="text-end fw-bold fs-3 text-primary">+<?= (int)$rb['total_poin'] ?></td>
                    <td class="text-center">
                      <a href="<?= base_url('poinkeaktifan?siswa_id=' . $rb['siswa_id'] . '&bulan=' . $filters['bulan'] . '&tahun=' . $filters['tahun']) ?>" class="btn btn-sm btn-outline-primary">
                        <i class="ti ti-eye me-1"></i> Detail
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tab 3: Rekap per Kelas -->
      <div class="tab-pane fade" id="tab-kelas">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="mb-0 text-dark">Ranking Keaktifan Siswa per Kelas</h4>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter card-table table-hover border">
            <thead>
              <tr class="bg-light">
                <th style="width: 50px;">No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>JK</th>
                <th class="text-center">Sesi Terlibat</th>
                <th class="text-end">Total Poin Keaktifan</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($rekap_kelas)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Pilih filter kelas untuk melihat rekapitulasi per kelas.</td></tr>
              <?php else: ?>
                <?php $k_no = 1; foreach ($rekap_kelas as $rk): ?>
                  <tr>
                    <td class="fw-bold"><?= $k_no++ ?></td>
                    <td><code><?= html_escape($rk['nis']) ?></code></td>
                    <td class="fw-bold text-dark"><?= html_escape($rk['nama_lengkap']) ?></td>
                    <td><span class="badge bg-secondary-lt"><?= html_escape($rk['jk']) ?></span></td>
                    <td class="text-center"><?= (int)$rk['sesi_aktif'] ?> Sesi</td>
                    <td class="text-end fw-bold fs-3 text-success">+<?= (int)$rk['total_poin'] ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tab 4: Rekap per Siswa -->
      <div class="tab-pane fade" id="tab-siswa">
        <?php if (!$rekap_siswa): ?>
          <div class="text-center py-5">
            <i class="ti ti-user-search fs-1 text-muted mb-2"></i>
            <p class="text-muted">Silakan pilih siswa melalui filter di atas untuk melihat detail riwayat poin keaktifan.</p>
          </div>
        <?php else: ?>
          <div class="card mb-3 border-0 bg-light-subtle">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-md-8">
                  <h3 class="mb-1 text-dark"><?= html_escape($rekap_siswa['siswa']['nama_lengkap']) ?></h3>
                  <div class="text-muted">
                    NIS: <code><?= html_escape($rekap_siswa['siswa']['nis']) ?></code> | Kelas: <strong><?= html_escape($rekap_siswa['siswa']['nama_kelas']) ?></strong>
                  </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                  <div class="small text-muted">Total Accumulating Poin</div>
                  <div class="fw-bold fs-1 text-primary">+<?= (int)$rekap_siswa['total_poin'] ?> Poin</div>
                </div>
              </div>
            </div>
          </div>

          <h4 class="mb-3">Detail Perolehan Poin per Jurnal Guru</h4>
          <div class="table-responsive">
            <table class="table table-vcenter card-table table-hover border">
              <thead>
                <tr class="bg-light">
                  <th>Tanggal</th>
                  <th>Kode Jurnal</th>
                  <th>Mata Pelajaran</th>
                  <th>Guru Pengampu</th>
                  <th>Materi Pembelajaran</th>
                  <th class="text-end">Poin Keaktifan</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($rekap_siswa['details'])): ?>
                  <tr><td colspan="6" class="text-center text-muted py-4">Belum ada catatan poin untuk siswa ini.</td></tr>
                <?php else: ?>
                  <?php foreach ($rekap_siswa['details'] as $sd): ?>
                    <tr>
                      <td><?= format_indo_date($sd['tanggal']) ?></td>
                      <td>
                        <a href="<?= base_url('jurnal/detail/' . $sd['jurnal_id']) ?>" class="badge bg-secondary text-white text-decoration-none">
                          <?= html_escape($sd['kode_jurnal']) ?>
                        </a>
                      </td>
                      <td class="fw-bold"><?= html_escape($sd['nama_mapel']) ?></td>
                      <td><?= html_escape($sd['nama_guru']) ?></td>
                      <td class="small"><?= html_escape($sd['materi_pembelajaran']) ?></td>
                      <td class="text-end fw-bold text-success fs-3">+<?= (int)$sd['poin'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

      <!-- Tab 5: Detail Transaksi Log -->
      <div class="tab-pane fade" id="tab-transaksi">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="mb-0 text-dark">Audit Trail Transaksi Poin Keaktifan</h4>
          <span class="badge bg-secondary"><?= count($detail_transaksi) ?> Entri Transaksi Terakhir</span>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter card-table table-striped border">
            <thead>
              <tr class="bg-light">
                <th>#</th>
                <th>Tanggal</th>
                <th>Jurnal Referensi</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th class="text-end">Jumlah Poin</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($detail_transaksi)): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada transaksi poin keaktifan recorded.</td></tr>
              <?php else: ?>
                <?php $t_no = 1; foreach ($detail_transaksi as $dt): ?>
                  <tr>
                    <td><?= $t_no++ ?></td>
                    <td><?= format_indo_date($dt['tanggal']) ?></td>
                    <td>
                      <a href="<?= base_url('jurnal/detail/' . $dt['jurnal_id']) ?>" class="badge bg-dark text-white text-decoration-none">
                        <?= html_escape($dt['kode_jurnal']) ?>
                      </a>
                    </td>
                    <td class="fw-bold text-dark"><?= html_escape($dt['nama_siswa']) ?></td>
                    <td><span class="badge bg-indigo-lt"><?= html_escape($dt['nama_kelas']) ?></span></td>
                    <td><?= html_escape($dt['nama_mapel']) ?></td>
                    <td><?= html_escape($dt['nama_guru']) ?></td>
                    <td class="text-end fw-bold text-primary fs-3">+<?= (int)$dt['poin'] ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- ApexCharts Script Initialization -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Chart 1: Poin per Kelas
  const rawKelas = <?= json_encode($charts['poin_per_kelas']) ?>;
  const kelasNames = rawKelas.map(i => i.nama_kelas);
  const kelasPoin = rawKelas.map(i => parseInt(i.total_poin));

  const optionsKelas = {
    series: [{
      name: 'Total Poin',
      data: kelasPoin
    }],
    chart: {
      type: 'bar',
      height: 280,
      toolbar: { show: false }
    },
    colors: ['#206bc4'],
    plotOptions: {
      bar: {
        borderRadius: 4,
        horizontal: false,
        columnWidth: '45%'
      }
    },
    dataLabels: { enabled: true },
    xaxis: { categories: kelasNames },
    yaxis: { title: { text: 'Poin Keaktifan' } }
  };
  new ApexCharts(document.querySelector("#chart-poin-kelas"), optionsKelas).render();

  // Chart 2: Trend Poin per Bulan
  const rawTrend = <?= json_encode($charts['poin_per_bulan']) ?>;
  const trendMonths = rawTrend.map(i => i.bulan_name);
  const trendPoin = rawTrend.map(i => parseInt(i.total_poin));

  const optionsTrend = {
    series: [{
      name: 'Total Poin Bulan Ini',
      data: trendPoin
    }],
    chart: {
      type: 'area',
      height: 260,
      toolbar: { show: false }
    },
    colors: ['#2fb344'],
    stroke: { curve: 'smooth', width: 2 },
    fill: { type: 'gradient', gradient: { opacityFrom: 0.5, opacityTo: 0.1 } },
    xaxis: { categories: trendMonths }
  };
  new ApexCharts(document.querySelector("#chart-poin-trend"), optionsTrend).render();
});
</script>

<!-- Modal Select Jurnal for Quick Input -->
<div class="modal fade" id="modalSelectJurnal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title text-white"><i class="ti ti-notebook me-2"></i>Pilih Jurnal Guru untuk Input Poin</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="p-3 bg-light border-bottom">
          <small class="text-muted"><i class="ti ti-info-circle me-1"></i> Pilih jurnal pembelajaran di bawah ini untuk mulai menambahkan/mengurangi poin keaktifan siswa pada jurnal terkait.</small>
        </div>
        <div class="table-responsive" style="max-height: 400px;">
          <table class="table table-vcenter table-hover card-table mb-0">
            <thead>
              <tr class="bg-light">
                <th>Tanggal</th>
                <th>Kode Jurnal</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($recent_jurnal)): ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">Belum ada jurnal pembelajaran yang tersimpan.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($recent_jurnal as $rj): ?>
                  <tr>
                    <td><?= format_indo_date($rj['tanggal']) ?></td>
                    <td><span class="badge bg-secondary text-white"><?= html_escape($rj['kode_jurnal']) ?></span></td>
                    <td><span class="badge bg-blue-lt"><?= html_escape($rj['nama_kelas']) ?></span></td>
                    <td class="fw-bold"><?= html_escape($rj['nama_mapel']) ?></td>
                    <td class="small"><?= html_escape($rj['nama_guru']) ?></td>
                    <td class="text-end">
                      <a href="<?= base_url('poinkeaktifan/input/' . $rj['id']) ?>" class="btn btn-sm btn-warning text-dark fw-bold">
                        <i class="ti ti-plus me-1"></i> Input Poin
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <a href="<?= base_url('jurnal') ?>" class="btn btn-outline-secondary">
          <i class="ti ti-list me-1"></i> Lihat Semua Jurnal
        </a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

