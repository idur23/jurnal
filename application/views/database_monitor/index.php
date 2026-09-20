<div class="container-xl">
  <!-- Page Header -->
  <div class="page-header d-print-none mb-3">
    <div class="row align-items-center">
      <div class="col">
        <h2 class="page-title text-purple">
          <i class="ti ti-database-import me-2"></i> Monitoring & Backup Database
        </h2>
        <div class="text-muted mt-1">Modul Terpadu Pemantauan Performa, Kesehatan Skema, serta Pembuatan & Pemulihan Backup Database MySQL.</div>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="<?= base_url('database_monitor/optimize/all') ?>" class="btn btn-outline-warning" onclick="return confirm('Apakah Anda yakin ingin melakukan optimasi pada seluruh tabel database?');">
            <i class="ti ti-wand me-1"></i> Optimize All Tables
          </a>
          <button type="button" class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#modalCreateBackup">
            <i class="ti ti-database-export me-1"></i> Buat Backup DB Baru
          </button>
          <button onclick="window.location.reload();" class="btn btn-primary">
            <i class="ti ti-refresh me-1"></i> Refresh Data
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Flash Messages -->
  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
      <div class="d-flex">
        <div><i class="ti ti-circle-check fs-2 me-2"></i></div>
        <div><?= $this->session->flashdata('success') ?></div>
      </div>
      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
      <div class="d-flex">
        <div><i class="ti ti-alert-triangle fs-2 me-2"></i></div>
        <div><?= $this->session->flashdata('error') ?></div>
      </div>
      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
  <?php endif; ?>

  <!-- Summary Metric Cards -->
  <div class="row row-cards mb-4">
    <!-- Card 1: Total Size -->
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
              <div class="font-weight-medium fs-3">
                <?= $capacity['total_size_mb'] ?> MB
              </div>
              <div class="text-muted small">
                Ukuran DB (Data: <?= $capacity['data_size_mb'] ?>MB, Index: <?= $capacity['index_size_mb'] ?>MB)
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2: Tables & Rows -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-blue text-white avatar">
                <i class="ti ti-table"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium fs-3">
                <?= $capacity['tables_count'] ?> Tabel
              </div>
              <div class="text-muted small">
                Total Baris: <?= number_format($capacity['total_rows']) ?> Baris
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3: Server Status & Threads -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-green text-white avatar">
                <i class="ti ti-server"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium fs-3">
                MySQL <?= html_escape(explode('-', $server_status['version'])[0]) ?>
              </div>
              <div class="text-muted small">
                Uptime: <?= $server_status['uptime'] ?> | Thread: <?= $server_status['threads_connected'] ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 4: Backup Status -->
    <div class="col-sm-6 col-lg-3">
      <div class="card card-sm">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="bg-indigo text-white avatar">
                <i class="ti ti-folder-check"></i>
              </span>
            </div>
            <div class="col">
              <div class="font-weight-medium fs-3">
                <?= count($backup_files) ?> Backup File
              </div>
              <div class="text-muted small">
                Terakhir: <?= !empty($backup_files) ? date('d/m/Y H:i', $backup_files[0]['timestamp']) : 'Belum ada' ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Unified Navigation Tabs -->
  <div class="card mb-4">
    <div class="card-header p-0">
      <ul class="nav nav-tabs card-header-tabs m-0" data-bs-toggle="tabs">
        <li class="nav-item">
          <a href="#tab-monitoring" class="nav-link active fw-bold text-indigo" data-bs-toggle="tab">
            <i class="ti ti-activity me-2"></i> 1. Monitoring & Skema Database
          </a>
        </li>
        <li class="nav-item">
          <a href="#tab-backups" class="nav-link fw-bold text-purple" data-bs-toggle="tab">
            <i class="ti ti-database-export me-2"></i> 2. Backup & Restore Database
          </a>
        </li>
        <li class="nav-item">
          <a href="#tab-maintenance" class="nav-link fw-bold text-warning" data-bs-toggle="tab">
            <i class="ti ti-tools me-2"></i> 3. Perawatan & Fragmentasi (<?= $capacity['fragmented_tables_count'] ?>)
          </a>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <div class="tab-content">
        
        <!-- ========================================== -->
        <!-- TAB 1: MONITORING & SKEMA DATABASE -->
        <!-- ========================================== -->
        <div class="tab-pane fade show active" id="tab-monitoring">
          
          <!-- Server Status Header Detail -->
          <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
              <div class="card border">
                <div class="card-header bg-light">
                  <h4 class="card-title m-0"><i class="ti ti-info-circle me-2 text-indigo"></i> Informasi Koneksi & Server MySQL</h4>
                </div>
                <div class="card-body p-0">
                  <table class="table table-vcenter table-striped card-table">
                    <tbody>
                      <tr>
                        <td class="text-muted">Nama Database</td>
                        <td class="fw-bold text-end"><code><?= html_escape($server_status['database_name']) ?></code></td>
                      </tr>
                      <tr>
                        <td class="text-muted">Host Server / IP</td>
                        <td class="fw-bold text-end"><?= html_escape($server_status['hostname']) ?></td>
                      </tr>
                      <tr>
                        <td class="text-muted">Versi MySQL / MariaDB</td>
                        <td class="fw-bold text-end"><?= html_escape($server_status['version']) ?></td>
                      </tr>
                      <tr>
                        <td class="text-muted">Character Set / Collation</td>
                        <td class="fw-bold text-end"><?= html_escape($server_status['charset']) ?> / <?= html_escape($server_status['collation']) ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card border">
                <div class="card-header bg-light">
                  <h4 class="card-title m-0"><i class="ti ti-gauge me-2 text-success"></i> Indikator Performa & Beban</h4>
                </div>
                <div class="card-body p-0">
                  <table class="table table-vcenter table-striped card-table">
                    <tbody>
                      <tr>
                        <td class="text-muted">Koneksi Aktif (Threads)</td>
                        <td class="fw-bold text-end"><span class="badge bg-green-lt fs-4"><?= $server_status['threads_connected'] ?> Client</span></td>
                      </tr>
                      <tr>
                        <td class="text-muted">Max Peak Connections</td>
                        <td class="fw-bold text-end"><?= $server_status['max_used_connections'] ?> Client</td>
                      </tr>
                      <tr>
                        <td class="text-muted">Total Kueri Terproses</td>
                        <td class="fw-bold text-end"><?= number_format($server_status['queries_total']) ?> Kueri</td>
                      </tr>
                      <tr>
                        <td class="text-muted">Overhead / Space Terbuang</td>
                        <td class="fw-bold text-end">
                          <?php if ($capacity['overhead_mb'] > 0): ?>
                            <span class="badge bg-warning text-dark fw-bold"><?= $capacity['overhead_mb'] ?> MB (Needs Optimize)</span>
                          <?php else: ?>
                            <span class="badge bg-success-lt">0 MB (Optimal)</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Table Schema Breakdown -->
          <div class="card border mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title m-0"><i class="ti ti-table me-2 text-indigo"></i> Detail Rincian Tabel Database (<?= count($tables) ?> Tabel)</h3>
              <input type="text" id="searchTableInput" class="form-control form-control-sm w-auto" placeholder="Cari nama tabel...">
            </div>
            <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
              <table class="table table-vcenter card-table table-hover table-striped" id="tablesListTable">
                <thead class="sticky-top bg-white">
                  <tr>
                    <th>Nama Tabel</th>
                    <th>Engine</th>
                    <th class="text-end">Jumlah Baris</th>
                    <th class="text-end">Ukuran Data</th>
                    <th class="text-end">Ukuran Index</th>
                    <th class="text-end">Total Ukuran</th>
                    <th>Overhead</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($tables as $t): ?>
                    <tr>
                      <td class="fw-bold text-indigo">
                        <code><?= html_escape($t['name']) ?></code>
                      </td>
                      <td><span class="badge bg-blue-lt"><?= html_escape($t['engine']) ?></span></td>
                      <td class="text-end fw-bold"><?= number_format($t['rows']) ?></td>
                      <td class="text-end text-muted"><?= $t['data_size'] ?></td>
                      <td class="text-end text-muted"><?= $t['index_size'] ?></td>
                      <td class="text-end fw-bold text-purple"><?= $t['total_size'] ?></td>
                      <td>
                        <?php if ($t['has_overhead']): ?>
                          <span class="badge bg-warning text-dark"><?= $t['data_free'] ?></span>
                        <?php else: ?>
                          <span class="text-muted small">0 B</span>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <div class="btn-group btn-group-sm">
                          <a href="<?= base_url('database_monitor/optimize/' . $t['name']) ?>" class="btn btn-outline-warning" title="Optimize Table">
                            <i class="ti ti-wand"></i>
                          </a>
                          <button type="button" class="btn btn-outline-info" onclick="checkTable('<?= $t['name'] ?>')" title="Check Integrity">
                            <i class="ti ti-search"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <!-- Active MySQL Processlist -->
            <div class="col-md-6 mb-4">
              <div class="card border" style="height: 350px; overflow-y: auto;">
                <div class="card-header bg-light">
                  <h4 class="card-title m-0 text-indigo"><i class="ti ti-list-check me-2"></i> MySQL Processlist (Proses Aktif)</h4>
                </div>
                <div class="card-body p-0">
                  <?php if (empty($process_list)): ?>
                    <div class="p-3 text-center text-muted">Tidak ada proses MySQL aktif.</div>
                  <?php else: ?>
                    <div class="table-responsive">
                      <table class="table table-vcenter card-table small">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>User</th>
                            <th>Command</th>
                            <th>Time</th>
                            <th>State/Info</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($process_list as $proc): ?>
                            <tr>
                              <td><?= $proc['Id'] ?></td>
                              <td><?= html_escape($proc['User']) ?></td>
                              <td><span class="badge bg-info-lt"><?= html_escape($proc['Command']) ?></span></td>
                              <td><?= $proc['Time'] ?>s</td>
                              <td class="text-truncate" style="max-width: 180px;" title="<?= html_escape($proc['Info'] ?? $proc['State']) ?>">
                                <code><?= html_escape($proc['Info'] ?? $proc['State'] ?? '-') ?></code>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Slow Queries Log -->
            <div class="col-md-6 mb-4">
              <div class="card border" style="height: 350px; overflow-y: auto;">
                <div class="card-header bg-danger-lt">
                  <h4 class="card-title m-0 text-danger"><i class="ti ti-alert-triangle me-2"></i> Log Query Lambat (> 0.5s)</h4>
                </div>
                <div class="card-body p-0">
                  <?php if (empty($slow_queries)): ?>
                    <div class="p-4 text-center text-muted">
                      <i class="ti ti-circle-check fs-1 text-success mb-2 d-block"></i>
                      Semua kueri berjalan lancar & cepat!
                    </div>
                  <?php else: ?>
                    <div class="table-responsive">
                      <table class="table table-vcenter card-table small">
                        <thead>
                          <tr>
                            <th>Kueri</th>
                            <th>Waktu</th>
                            <th>Tanggal</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($slow_queries as $sq): ?>
                            <tr>
                              <td class="text-truncate" style="max-width: 220px;" title="<?= html_escape($sq['query_text']) ?>">
                                <code><?= html_escape($sq['query_text']) ?></code>
                              </td>
                              <td class="text-danger fw-bold"><?= round($sq['execution_time'], 3) ?>s</td>
                              <td class="text-muted small"><?= date('d/m H:i', strtotime($sq['created_at'])) ?></td>
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

        </div>

        <!-- ========================================== -->
        <!-- TAB 2: BACKUP & RESTORE DATABASE -->
        <!-- ========================================== -->
        <div class="tab-pane fade" id="tab-backups">
          
          <div class="row mb-4">
            <!-- Create Backup Form Card -->
            <div class="col-md-6 mb-3 mb-md-0">
              <div class="card border border-purple-lt shadow-sm">
                <div class="card-header bg-purple-lt">
                  <h4 class="card-title m-0 text-purple"><i class="ti ti-database-export me-2"></i> Buat Backup Database Baru</h4>
                </div>
                <div class="card-body">
                  <form action="<?= base_url('database_monitor/do_backup') ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <p class="text-muted small mb-3">Buat salinan cadangan (*backup dump*) dari skema dan data database MySQL saat ini ke dalam folder server <code>database/backups/</code>.</p>
                    
                    <div class="mb-3">
                      <label class="form-label font-weight-bold">Isi Kandungan Backup:</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="include_data" id="inc_all" value="1" checked>
                        <label class="form-check-label" for="inc_all">
                          Struktur Tabel & Data Lengkap (Disarankan)
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="include_data" id="inc_struct" value="0">
                        <label class="form-check-label" for="inc_struct">
                          Hanya Struktur Skema Tabel (Tanpa Data)
                        </label>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label font-weight-bold">Format File Kompresi:</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="compress_zip" id="fmt_sql" value="0" checked>
                        <label class="form-check-label" for="fmt_sql">
                          Teks Mentah SQL (.sql)
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="compress_zip" id="fmt_zip" value="1">
                        <label class="form-check-label" for="fmt_zip">
                          File Kompresi ZIP (.zip)
                        </label>
                      </div>
                    <div class="mb-3">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="download_direct" id="dl_direct1" value="1" checked>
                        <label class="form-check-label fw-bold" for="dl_direct1">
                          Langsung Unduh File ke Komputer Setelah Dibuat
                        </label>
                      </div>
                      <div class="text-muted small">File juga akan tetap tersimpan secara aman di direktori backup server.</div>
                    </div>

                    <button type="submit" class="btn btn-purple w-100">
                      <i class="ti ti-download me-2"></i> Proses & Unduh Backup
                    </button>
                  </form>
                </div>
              </div>
            </div>

            <!-- Upload External SQL Card -->
            <div class="col-md-6">
              <div class="card border border-info-lt shadow-sm">
                <div class="card-header bg-info-lt">
                  <h4 class="card-title m-0 text-info"><i class="ti ti-cloud-upload me-2"></i> Upload & Restore Backup SQL External</h4>
                </div>
                <div class="card-body">
                  <form action="<?= base_url('database_monitor/restore') ?>" method="POST" enctype="multipart/form-data" onsubmit="return confirm('PERINGATAN: Memulihkan database dari file SQL eksternal dapat memperbarui atau menimpa data yang ada! Apakah Anda benar-benar yakin?');">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="restore_source" value="upload">
                    <p class="text-muted small mb-3">Unggah file backup SQL/ZIP dari komputer Anda untuk dipulihkan ke dalam database sistem ini.</p>
                    
                    <div class="mb-3">
                      <label class="form-label font-weight-bold">Pilih File SQL / ZIP (.sql, .zip):</label>
                      <input type="file" name="sql_file" class="form-control" accept=".sql,.zip" required>
                    </div>

                    <div class="alert alert-warning small p-2 mb-3">
                      <i class="ti ti-shield-alert me-1"></i> Sistem secara otomatis menonaktifkan <code>FOREIGN_KEY_CHECKS</code> selama proses pemulihan untuk menjamin integritas.
                    </div>

                    <button type="submit" class="btn btn-info w-100">
                      <i class="ti ti-rotate-clockwise me-2"></i> Unggah & Restore Sekarang
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Stored Backup Files History Table -->
          <div class="card border">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
              <h3 class="card-title m-0 text-purple"><i class="ti ti-files me-2"></i> Daftar Riwayat File Backup Tersimpan</h3>
              <span class="badge bg-purple-lt fs-4"><?= count($backup_files) ?> File Ditemukan</span>
            </div>
            <div class="card-body p-0">
              <?php if (empty($backup_files)): ?>
                <div class="p-5 text-center text-muted">
                  <i class="ti ti-folder-off fs-1 mb-2 text-secondary d-block"></i>
                  Belum ada file backup database yang dibuat atau tersimpan di server.
                </div>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-vcenter card-table table-hover table-striped">
                    <thead>
                      <tr>
                        <th>Nama File Backup</th>
                        <th>Ukuran</th>
                        <th>Tipe</th>
                        <th>Waktu Pembuatan</th>
                        <th class="text-center">Aksi / Kontrol</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($backup_files as $bf): ?>
                        <tr>
                          <td>
                            <i class="ti ti-file-code me-2 text-purple"></i>
                            <span class="fw-bold font-monospace"><?= html_escape($bf['filename']) ?></span>
                          </td>
                          <td class="fw-bold text-muted"><?= $bf['size_formatted'] ?></td>
                          <td>
                            <span class="badge <?= ($bf['extension'] == 'ZIP') ? 'bg-success-lt' : 'bg-purple-lt' ?>">
                              <?= $bf['extension'] ?>
                            </span>
                          </td>
                          <td class="text-muted small"><?= date('d F Y, H:i:s', $bf['timestamp']) ?></td>
                          <td class="text-center">
                            <div class="btn-list justify-content-center">
                              <!-- Download -->
                              <a href="<?= base_url('database_monitor/download/' . urlencode($bf['filename'])) ?>" class="btn btn-sm btn-outline-primary" title="Download File">
                                <i class="ti ti-download me-1"></i> Download
                              </a>
                              
                              <!-- Restore Button Modal Trigger -->
                              <button type="button" class="btn btn-sm btn-outline-warning" onclick="promptRestore('<?= html_escape($bf['filename']) ?>')" title="Restore Database">
                                <i class="ti ti-rotate-clockwise me-1"></i> Restore
                              </button>

                              <!-- Delete -->
                              <a href="<?= base_url('database_monitor/delete/' . urlencode($bf['filename'])) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus file backup \'<?= html_escape($bf['filename']) ?>\'?');" title="Hapus Backup">
                                <i class="ti ti-trash me-1"></i> Hapus
                              </a>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php endif; ?>
            </div>
          </div>

        </div>

        <!-- ========================================== -->
        <!-- TAB 3: PERAWATAN DATABASE -->
        <!-- ========================================== -->
        <div class="tab-pane fade" id="tab-maintenance">
          <div class="row">
            <div class="col-md-8">
              <div class="card border">
                <div class="card-header bg-warning-lt">
                  <h3 class="card-title text-dark fw-bold m-0"><i class="ti ti-wand me-2"></i> Perawatan & Optimasi Ukuran Tabel (*Table Defragmentation*)</h3>
                </div>
                <div class="card-body">
                  <p>Seiring berjalannya waktu dan aktivitas modifikasi data (INSERT/UPDATE/DELETE), tabel MySQL dapat mengalami fragmentasi (*data free / overhead*) yang memakan ruang penyimpanan dan memperlambat kueri.</p>
                  
                  <?php if ($capacity['fragmented_tables_count'] > 0): ?>
                    <div class="alert alert-warning d-flex align-items-center mb-3">
                      <i class="ti ti-alert-triangle fs-2 me-3"></i>
                      <div>
                        <strong>Terdeteksi <?= $capacity['fragmented_tables_count'] ?> tabel terfragmentasi!</strong> Total ruang yang dapat dihemat melalui optimasi: <strong><?= $capacity['overhead_mb'] ?> MB</strong>.
                      </div>
                    </div>
                  <?php else: ?>
                    <div class="alert alert-success d-flex align-items-center mb-3">
                      <i class="ti ti-circle-check fs-2 me-3"></i>
                      <div>Seluruh tabel berada dalam kondisi optimal! Tidak ada ruang overhead yang perlu di-optimize saat ini.</div>
                    </div>
                  <?php endif; ?>

                  <div class="d-flex gap-2">
                    <a href="<?= base_url('database_monitor/optimize/all') ?>" class="btn btn-warning" onclick="return confirm('Jalankan optimasi pada semua tabel?');">
                      <i class="ti ti-sparkles me-2"></i> Jalankan Optimasi Massal (Optimize All)
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card border">
                <div class="card-header bg-light">
                  <h4 class="card-title m-0"><i class="ti ti-help-circle me-2"></i> Panduan Perawatan</h4>
                </div>
                <div class="card-body small text-muted">
                  <ul class="ps-3 mb-0">
                    <li class="mb-2"><strong>Optimize Table</strong> merapikan indeks dan mengembalikan ruang kosong akibat penghapusan data.</li>
                    <li class="mb-2"><strong>Check Table</strong> memeriksa integritas struktur data tabel dari kerusakan (*corruption*).</li>
                    <li class="mb-2"><strong>Backup Rutin</strong> disarankan dilakukan secara berkala sebelum melakukan pembaruan sistem besar.</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Modal Create Backup -->
<div class="modal fade" id="modalCreateBackup" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('database_monitor/do_backup') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header bg-purple text-white">
          <h5 class="modal-title"><i class="ti ti-database-export me-2"></i> Buat Backup Database Baru</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-content-body p-3">
          <div class="mb-3">
            <label class="form-label font-weight-bold">Format File Output:</label>
            <select name="compress_zip" class="form-select">
              <option value="0">Mentah SQL (.sql)</option>
              <option value="1">Kompresi ZIP (.zip)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-weight-bold">Tipe Konten:</label>
            <select name="include_data" class="form-select">
              <option value="1">Struktur & Data Lengkap</option>
              <option value="0">Struktur Skema Saja</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-weight-bold">Aksi Setelah Pembuatan:</label>
            <select name="download_direct" class="form-select">
              <option value="1">Langsung Unduh ke Komputer & Simpan di Server</option>
              <option value="0">Hanya Simpan di Server (Tanpa Langsung Unduh)</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-purple"><i class="ti ti-check me-1"></i> Proses Backup</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Confirm Restore Stored File -->
<div class="modal fade" id="modalRestoreConfirm" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('database_monitor/restore') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="restore_source" value="stored">
        <input type="hidden" name="backup_file" id="restore_target_file" value="">
        
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title fw-bold"><i class="ti ti-alert-triangle me-2"></i> Konfirmasi Restore Database</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-3">
            <i class="ti ti-rotate-clockwise text-warning fs-1"></i>
          </div>
          <p>Anda akan memulihkan database dari file backup berikut:</p>
          <div class="alert alert-dark font-monospace fw-bold text-center" id="restore_filename_display">
            -
          </div>
          <p class="text-danger small fw-bold">
            <i class="ti ti-info-circle me-1"></i> PERINGATAN: Tindakan ini akan menimpa data dan skema tabel saat ini dengan data yang ada di dalam file backup!
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="ti ti-rotate-clockwise me-1"></i> Ya, Pulihkan Database</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Table Check Result -->
<div class="modal fade" id="modalCheckResult" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="checkModalTitle"><i class="ti ti-search me-2"></i> Hasil Pemeriksaan Tabel</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <table class="table table-vcenter card-table" id="checkResultTable">
          <thead>
            <tr>
              <th>Table</th>
              <th>Op</th>
              <th>Msg_type</th>
              <th>Msg_text</th>
            </tr>
          </thead>
          <tbody>
            <!-- Dynamic content -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Search table filter
    $("#searchTableInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tablesListTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

  function promptRestore(filename) {
    $('#restore_target_file').val(filename);
    $('#restore_filename_display').text(filename);
    var modal = new bootstrap.Modal(document.getElementById('modalRestoreConfirm'));
    modal.show();
  }

  function checkTable(tableName) {
    $.ajax({
      url: '<?= base_url("database_monitor/check_table/") ?>' + tableName,
      method: 'GET',
      success: function(response) {
        if (response.status && response.data) {
          var html = '';
          response.data.forEach(function(row) {
            var statusBadge = (row.Msg_text === 'OK') ? '<span class="badge bg-success">OK</span>' : '<span class="badge bg-warning">' + row.Msg_text + '</span>';
            html += '<tr>';
            html += '<td><code>' + row.Table + '</code></td>';
            html += '<td>' + row.Op + '</td>';
            html += '<td>' + row.Msg_type + '</td>';
            html += '<td>' + statusBadge + '</td>';
            html += '</tr>';
          });
          $('#checkResultTable tbody').html(html);
          $('#checkModalTitle').html('<i class="ti ti-search me-2"></i> Hasil Pemeriksaan Tabel: ' + tableName);
          var modal = new bootstrap.Modal(document.getElementById('modalCheckResult'));
          modal.show();
        }
      }
    });
  }
</script>
