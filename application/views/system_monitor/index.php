<div class="container-xl">
  <!-- Page Header -->
  <div class="page-header d-print-none mb-3">
    <div class="row align-items-center">
      <div class="col">
        <h2 class="page-title text-indigo">
          <i class="ti ti-dashboard me-2"></i> System Performance & Scalability Monitor
        </h2>
        <div class="text-muted mt-1">Real-time resource utilization, database size, slow queries, and execution logs.</div>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <a href="<?= base_url('database_monitor') ?>" class="btn btn-purple me-2">
          <i class="ti ti-database-import me-2"></i> Monitoring & Backup DB
        </a>
        <button onclick="window.location.reload();" class="btn btn-primary">
          <i class="ti ti-refresh me-2"></i> Refresh Data
        </button>
      </div>
    </div>
  </div>

  <!-- Metric Overview Cards -->
  <div class="row row-cards mb-4">
    <!-- Active Users -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-blue text-white avatar">
                <i class="ti ti-users"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium">
                <?= count($active_users) ?> Pengguna Aktif
              </div>
              <div class="text-muted small">
                (Login dalam 15 menit terakhir)
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Avg Response Time -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <?php
                $avg_t = $perf_summary['avg_time'];
                $color_class = ($avg_t > 2.0) ? 'bg-danger' : (($avg_t > 1.0) ? 'bg-warning' : 'bg-success');
              ?>
              <span class="<?= $color_class ?> text-white avatar">
                <i class="ti ti-clock"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium">
                <?= $avg_t ?> Detik
              </div>
              <div class="text-muted small">
                Rata-rata Respon (Target <= 2.0s)
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Memory Peak -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-orange text-white avatar">
                <i class="ti ti-cpu"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium">
                <?= $perf_summary['peak_memory'] ?> MB
              </div>
              <div class="text-muted small">
                Peak Memory (Rata-rata: <?= $perf_summary['avg_memory'] ?>MB)
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Database Total Size -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-purple text-white avatar">
                <i class="ti ti-database"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium">
                <?= $db_stats['total_size_mb'] ?> MB
              </div>
              <div class="text-muted small">
                Total Size (Data: <?= $db_stats['data_size_mb'] ?>MB, Index: <?= $db_stats['index_size_mb'] ?>MB)
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row row-cards mb-4">
    <!-- Performance Chart -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Statistik Beban Kerja Sistem (12 Jam Terakhir)</h3>
        </div>
        <div class="card-body">
          <div style="height: 250px;">
            <canvas id="performanceChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Database Table Stats Summary -->
    <div class="col-lg-4">
      <div class="card" style="max-height: 310px; overflow-y: auto;">
        <div class="card-header">
          <h3 class="card-title">Skema Database</h3>
        </div>
        <div class="card-body p-0">
          <table class="table table-vcenter card-table table-striped">
            <tbody>
              <tr>
                <td>Jumlah Tabel</td>
                <td class="text-end fw-bold"><?= $db_stats['tables_count'] ?> Tabel</td>
              </tr>
              <tr>
                <td>Total Baris Data</td>
                <td class="text-end fw-bold"><?= number_format($db_stats['rows_count']) ?> Baris</td>
              </tr>
              <tr>
                <td>Ukuran Data</td>
                <td class="text-end text-muted"><?= $db_stats['data_size_mb'] ?> MB</td>
              </tr>
              <tr>
                <td>Ukuran Index</td>
                <td class="text-end text-muted"><?= $db_stats['index_size_mb'] ?> MB</td>
              </tr>
              <tr>
                <td>Rata-rata Query / Page</td>
                <td class="text-end text-indigo fw-bold"><?= $perf_summary['avg_queries'] ?> Query</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row row-cards mb-4">
    <!-- Slow Queries Log -->
    <div class="col-md-6">
      <div class="card" style="height: 400px; overflow-y: auto;">
        <div class="card-header bg-danger-lt">
          <h3 class="card-title text-danger fw-bold"><i class="ti ti-alert-triangle me-2"></i> Log Query Lambat (> 0.5s)</h3>
        </div>
        <div class="card-body p-0">
          <?php if (empty($slow_queries)): ?>
            <div class="text-center p-4 text-muted">
              <i class="ti ti-circle-check fs-1 text-success mb-2"></i>
              <div>Luar biasa! Tidak ada query lambat terdeteksi.</div>
            </div>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-vcenter card-table">
                <thead>
                  <tr>
                    <th>Query</th>
                    <th style="width: 80px;">Waktu</th>
                    <th>URL</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($slow_queries as $sq): ?>
                    <tr>
                      <td class="text-truncate" style="max-width: 250px;" title="<?= html_escape($sq['query_text']) ?>">
                        <code><?= html_escape($sq['query_text']) ?></code>
                      </td>
                      <td class="text-danger fw-bold"><?= round($sq['execution_time'], 3) ?>s</td>
                      <td class="text-muted small"><?= html_escape($sq['url']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Login Activity Log -->
    <div class="col-md-6">
      <div class="card" style="height: 400px; overflow-y: auto;">
        <div class="card-header">
          <h3 class="card-title"><i class="ti ti-login me-2"></i> Log Aktivitas Akses & Login Terkini</h3>
        </div>
        <div class="card-body p-0">
          <?php if (empty($login_activities)): ?>
            <div class="text-center p-4 text-muted">Belum ada riwayat masuk terdaftar.</div>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-vcenter card-table">
                <thead>
                  <tr>
                    <th>Pengguna</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($login_activities as $la): ?>
                    <tr>
                      <td>
                        <div class="font-weight-medium"><?= html_escape($la['full_name'] ?? 'Guest') ?></div>
                        <div class="text-muted small">@<?= html_escape($la['username'] ?? 'unknown') ?> (IP: <?= $la['ip_address'] ?>)</div>
                      </td>
                      <td>
                        <?php if ($la['action'] == 'LOGIN_SUCCESS'): ?>
                          <span class="badge bg-success-lt">LOGIN BERHASIL</span>
                        <?php elseif ($la['action'] == 'LOGIN_FAILED'): ?>
                          <span class="badge bg-danger-lt">LOGIN GAGAL</span>
                        <?php else: ?>
                          <span class="badge bg-secondary-lt">LOGOUT</span>
                        <?php endif; ?>
                        <div class="text-muted small mt-1"><?= html_escape($la['description']) ?></div>
                      </td>
                      <td class="text-muted small"><?= date('d/m H:i:s', strtotime($la['created_at'])) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- System Error Log -->
  <div class="card mb-4">
    <div class="card-header bg-warning-lt">
      <h3 class="card-title text-warning fw-bold"><i class="ti ti-file-text me-2"></i> Log System Errors (application/logs/)</h3>
    </div>
    <div class="card-body">
      <div class="bg-dark text-white p-3 rounded" style="max-height: 250px; overflow-y: auto; font-family: monospace; font-size: 12px; line-height: 1.5;">
        <?php foreach ($error_logs as $log_line): ?>
          <div class="mb-1 <?= (strpos($log_line, 'ERROR') !== FALSE) ? 'text-danger' : ((strpos($log_line, 'DEBUG') !== FALSE) ? 'text-info' : 'text-warning') ?>">
            <?= html_escape($log_line) ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Load chart data
    $.ajax({
      url: '<?= base_url("system_monitor/get_performance_stats_ajax") ?>',
      method: 'GET',
      success: function(response) {
        if (response.status && response.data) {
          var labels = [];
          var requestData = [];
          var timeData = [];

          response.data.forEach(function(row) {
            labels.push(row.hour + ':00');
            requestData.push(row.requests);
            timeData.push(parseFloat(row.time).toFixed(3));
          });

          var ctx = document.getElementById('performanceChart').getContext('2d');
          new Chart(ctx, {
            type: 'line',
            data: {
              labels: labels,
              datasets: [
                {
                  label: 'Rata-rata Respon (Detik)',
                  data: timeData,
                  borderColor: '#6366f1',
                  backgroundColor: 'rgba(99, 102, 241, 0.1)',
                  yAxisID: 'yTime',
                  tension: 0.3,
                  fill: true
                },
                {
                  label: 'Total Request',
                  data: requestData,
                  borderColor: '#2fb344',
                  backgroundColor: 'transparent',
                  yAxisID: 'yReq',
                  tension: 0.3,
                  borderDash: [5, 5]
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                yTime: {
                  type: 'linear',
                  position: 'left',
                  title: {
                    display: true,
                    text: 'Respon (s)'
                  },
                  min: 0
                },
                yReq: {
                  type: 'linear',
                  position: 'right',
                  title: {
                    display: true,
                    text: 'Requests'
                  },
                  min: 0,
                  grid: {
                    drawOnChartArea: false
                  }
                }
              }
            }
          });
        }
      }
    });
  });
</script>
