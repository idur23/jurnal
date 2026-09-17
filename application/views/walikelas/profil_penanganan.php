<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Wali Kelas</div>
      <h2 class="page-title">Profil Histori Penanganan Siswa</h2>
      <div class="text-muted small mt-1">Rekapitulasi lengkap seluruh riwayat kasus, pembinaan, dan penanganan siswa secara kronologis.</div>
    </div>
    <div class="col-auto ms-auto">
      <div class="btn-list">
        <a href="<?= base_url('laporan/penanganan_pdf?siswa_id=' . $siswa['id']) ?>" target="_blank" class="btn btn-outline-danger">
          <i class="ti ti-file-pdf me-1"></i> Cetak PDF
        </a>
        <a href="<?= base_url('laporan/penanganan_excel?siswa_id=' . $siswa['id']) ?>" class="btn btn-outline-success">
          <i class="ti ti-file-spreadsheet me-1"></i> Export Excel
        </a>
        <a href="<?= base_url('walikelas/penanganan_siswa') ?>" class="btn btn-secondary">
          <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row row-cards">
  <!-- Student Biodata Card -->
  <div class="col-md-4">
    <div class="card mb-3">
      <div class="card-body text-center py-4">
        <span class="avatar avatar-xl rounded-circle mb-3 bg-indigo text-white shadow-sm" style="font-size: 2.2rem; font-weight: 700;">
          <?= strtoupper(substr($siswa['nama_lengkap'], 0, 1)) ?>
        </span>
        <h3 class="card-title mb-1 text-indigo fw-bold"><?= html_escape($siswa['nama_lengkap']) ?></h3>
        <p class="text-muted mb-3">NIS: <?= html_escape($siswa['nis']) ?> | NISN: <?= html_escape($siswa['nisn']) ?></p>
        <span class="badge bg-indigo-lt px-3 py-2 rounded-pill fw-bold fs-5">Kelas: <?= html_escape($siswa['nama_kelas']) ?></span>
      </div>
      <div class="card-footer p-0">
        <div class="list-group list-group-flush">
          <div class="list-group-item d-flex justify-content-between py-3">
            <span class="text-muted"><i class="ti ti-user me-2"></i>Wali Kelas</span>
            <span class="fw-bold"><?= html_escape($siswa['nama_wali'] ?? '-') ?></span>
          </div>
          <div class="list-group-item d-flex justify-content-between py-3">
            <span class="text-muted"><i class="ti ti-alert-triangle me-2"></i>Total Kasus</span>
            <span class="badge bg-danger text-white fw-bold"><?= count($history) ?></span>
          </div>
          <?php 
            // Calculate active status counts
            $solved = 0; $monitoring = 0; $proses = 0;
            foreach ($history as $h) {
                if ($h['status'] == 'Selesai') $solved++;
                elseif ($h['status'] == 'Monitoring') $monitoring++;
                else $proses++;
            }
          ?>
          <div class="list-group-item d-flex justify-content-between py-3">
            <span class="text-muted"><i class="ti ti-circle-check me-2"></i>Selesai / Teratasi</span>
            <span class="badge bg-success text-white fw-bold"><?= $solved ?></span>
          </div>
          <div class="list-group-item d-flex justify-content-between py-3">
            <span class="text-muted"><i class="ti ti-eye me-2"></i>Dalam Monitoring</span>
            <span class="badge bg-warning text-white fw-bold"><?= $monitoring ?></span>
          </div>
          <div class="list-group-item d-flex justify-content-between py-3">
            <span class="text-muted"><i class="ti ti-clock me-2"></i>Masih Proses</span>
            <span class="badge bg-danger text-white fw-bold"><?= $proses ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Analytical Charts -->
  <div class="col-md-8">
    <div class="card mb-3" style="min-height: 380px;">
      <div class="card-header bg-dark text-white">
        <h3 class="card-title text-white"><i class="ti ti-chart-bar me-2"></i>Analisis Kasus & Permasalahan</h3>
      </div>
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-md-6 text-center">
            <h4 class="fw-bold mb-3">Kategori Kasus Terbanyak</h4>
            <div class="d-flex justify-content-center" style="max-height: 220px;">
              <canvas id="kategoriPieChart"></canvas>
            </div>
          </div>
          <div class="col-md-6">
            <h4 class="fw-bold mb-3 text-center">Tren Perkembangan Penanganan (Bulanan)</h4>
            <div style="max-height: 220px;">
              <canvas id="trendLineChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row row-cards mt-1">
  <!-- Timeline / History Penanganan -->
  <div class="col-md-8">
    <div class="card">
      <div class="card-header bg-indigo text-white">
        <h3 class="card-title text-white"><i class="ti ti-history me-2"></i>Riwayat Kasus & Tindakan (Kronologis)</h3>
      </div>
      <div class="card-body">
        <?php if (empty($history)): ?>
          <div class="text-center py-5 text-muted">
            <i class="ti ti-mood-smile fs-1 text-success mb-2"></i>
            <h3>Siswa ini tidak memiliki riwayat kasus / pembinaan khusus.</h3>
            <p class="mb-0">Perkembangan siswa berada dalam kondisi sangat baik secara umum.</p>
          </div>
        <?php else: ?>
          <ul class="list list-timeline">
            <?php foreach ($history as $h): ?>
              <li>
                <div class="list-timeline-time fw-bold text-indigo" style="width: 90px;"><?= date('d M Y', strtotime($h['tanggal'])) ?></div>
                <div class="list-timeline-icon bg-indigo text-white"><i class="ti ti-alert-circle"></i></div>
                <div class="list-timeline-content">
                  <div class="list-timeline-title d-flex align-items-center justify-content-between">
                    <span class="h4 fw-bold mb-0 text-indigo"><?= html_escape($h['kategori']) ?></span>
                    <?php if ($h['status'] == 'Selesai'): ?>
                      <span class="badge bg-success text-white fw-bold">Selesai</span>
                    <?php elseif ($h['status'] == 'Monitoring'): ?>
                      <span class="badge bg-warning text-white fw-bold">Monitoring</span>
                    <?php else: ?>
                      <span class="badge bg-danger text-white fw-bold">Proses</span>
                    <?php endif; ?>
                  </div>
                  <div class="card card-sm mt-2 border-dashed bg-light-lt">
                    <div class="card-body p-3">
                      <p class="mb-2"><strong>Permasalahan:</strong><br><span class="text-muted"><?= html_escape($h['permasalahan']) ?></span></p>
                      <p class="mb-2"><strong>Tindakan / RTL:</strong><br><span class="text-muted"><?= html_escape($h['tindakan'] ? $h['tindakan'] : '-') ?></span></p>
                      <p class="mb-2"><strong>Hasil Penanganan:</strong><br><span class="text-muted"><?= html_escape($h['hasil'] ? $h['hasil'] : '-') ?></span></p>
                      <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-secondary border-opacity-10 text-muted small">
                        <span><i class="ti ti-user-edit me-1"></i>Petugas: <strong><?= html_escape($h['nama_guru']) ?></strong></span>
                        <?php if ($h['dokumentasi']): ?>
                          <a href="<?= base_url($h['dokumentasi']) ?>" target="_blank" class="btn btn-xs btn-outline-info"><i class="ti ti-paperclip"></i> Lihat Lampiran</a>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Summary, Status, & Rekomendasi Card -->
  <div class="col-md-4">
    <div class="card mb-3">
      <div class="card-header bg-dark text-white">
        <h3 class="card-title text-white"><i class="ti ti-clipboard-list me-2"></i>Kesimpulan & Rekomendasi</h3>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label fw-bold text-indigo">Status Penanganan Terakhir</label>
          <div class="p-3 rounded border text-center fw-bold" style="background: linear-gradient(135deg, #eff6ff 0%, #f5f3ff 100%);">
            <?php 
              $latest_case = !empty($history) ? end($history) : null;
              $status_akhir = $latest_case ? $latest_case['status'] : 'Selesai';
              if ($status_akhir == 'Selesai'):
            ?>
              <span class="text-success fs-3"><i class="ti ti-checkbox me-1"></i> SELESAI / TERATASI</span>
            <?php elseif ($status_akhir == 'Monitoring'): ?>
              <span class="text-warning fs-3"><i class="ti ti-eye me-1"></i> DALAM MONITORING</span>
            <?php else: ?>
              <span class="text-danger fs-3"><i class="ti ti-alert-triangle me-1"></i> PERLU TINDAKAN</span>
            <?php endif; ?>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold text-indigo">Kesimpulan Historis</label>
          <div class="text-muted" style="line-height: 1.5; text-align: justify;">
            <?php if (empty($history)): ?>
              Siswa tidak memiliki catatan pelanggaran atau masalah khusus. Karakter dan adaptasi siswa tergolong sangat baik.
            <?php else: ?>
              Berdasarkan riwayat penanganan, siswa ini telah melalui <?= count($history) ?> proses pembinaan terkait aspek 
              <strong><?= implode(', ', array_unique(array_column($history, 'kategori'))) ?></strong>. 
              Kasus penanganan terakhir bertanggal <?= date('d M Y', strtotime($latest_case['tanggal'])) ?> menunjukkan status 
              <strong><?= $status_akhir ?></strong>.
            <?php endif; ?>
          </div>
        </div>

        <div>
          <label class="form-label fw-bold text-indigo">Rekomendasi Tindak Lanjut</label>
          <div class="alert alert-info border-info mb-0">
            <ul class="mb-0 ps-3">
              <?php if (empty($history)): ?>
                <li>Pertahankan prestasi dan perilaku terpuji siswa.</li>
                <li>Berikan apresiasi secara berkala untuk memotivasi siswa.</li>
              <?php else: ?>
                <?php if ($status_akhir != 'Selesai'): ?>
                  <li>Lakukan pemanggilan berkala untuk konseling individu.</li>
                  <li>Lakukan koordinasi erat dengan orang tua siswa untuk pendampingan.</li>
                <?php else: ?>
                  <li>Tetap pantau kedisiplinan dan perilakunya di kelas secara pasif.</li>
                  <li>Apresiasi keberhasilan siswa dalam mengatasi permasalahannya.</li>
                <?php endif; ?>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart Script -->
<script>
  $(document).ready(function() {
    // 1. Kategori Pie Chart
    var katCtx = document.getElementById('kategoriPieChart').getContext('2d');
    var katChart = new Chart(katCtx, {
      type: 'doughnut',
      data: {
        labels: ['Akademik', 'Disiplin', 'Perilaku', 'Kesehatan', 'Sosial'],
        datasets: [{
          data: [
            <?= $kategori_stats['Akademik'] ?>,
            <?= $kategori_stats['Disiplin'] ?>,
            <?= $kategori_stats['Perilaku'] ?>,
            <?= $kategori_stats['Kesehatan'] ?>,
            <?= $kategori_stats['Sosial'] ?>
          ],
          backgroundColor: ['#3b82f6', '#ef4444', '#f59e0b', '#10b981', '#6366f1'],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 12,
              font: { size: 10 }
            }
          }
        }
      }
    });

    // 2. Trend Line Chart
    <?php 
      $months = array();
      $counts = array();
      foreach ($trend_stats as $m => $c) {
          $months[] = date('M Y', strtotime($m . '-01'));
          $counts[] = $c;
      }
    ?>
    var trendCtx = document.getElementById('trendLineChart').getContext('2d');
    var trendChart = new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
          label: 'Jumlah Kasus',
          data: <?= json_encode($counts) ?>,
          borderColor: '#6366f1',
          backgroundColor: 'rgba(99, 102, 241, 0.1)',
          tension: 0.3,
          fill: true,
          pointRadius: 4,
          pointBackgroundColor: '#6366f1'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1,
              font: { size: 9 }
            }
          },
          x: {
            ticks: { font: { size: 9 } }
          }
        }
      }
    });
  });
</script>
