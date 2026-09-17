<?php 
  $gdrive_token_url = (strpos($_SERVER['HTTP_HOST'] ?? '', '.test') !== false) 
      ? 'http://localhost/jg/get_refresh_token.php' 
      : base_url('get_refresh_token.php');
?>

<style>
  .gdrive-header-icon {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .card-custom-status {
    background: #f4fbf7;
    border: 1px solid #d1fae5;
    border-radius: 12px;
  }
  .card-custom-capacity {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
  }
  .dropzone-upload-area {
    border: 2px dashed #94a3b8;
    background: #f8fafc;
    border-radius: 12px;
    padding: 24px 15px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
  }
  .dropzone-upload-area:hover {
    border-color: #3b82f6;
    background: #eff6ff;
  }
  .btn-pill-custom {
    border-radius: 50rem !important;
    padding-left: 1.25rem !important;
    padding-right: 1.25rem !important;
  }
  .bg-teal-lt {
    background-color: #e6fffa !important;
    color: #0d9488 !important;
  }
</style>

<!-- Header Section -->
<div class="page-header d-print-none mb-4">
  <div class="container-fluid">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title text-dark fw-bold d-flex align-items-center">
          <span class="gdrive-header-icon me-2">
            <svg width="32" height="32" viewBox="0 0 87.3 78" xmlns="http://www.w3.org/2000/svg">
              <path d="m6.6 66.85 3.85 6.65c.8 1.4 1.95 2.5 3.3 3.3l13.75-23.8h-27.5c0 1.55.4 3.1 1.2 4.5z" fill="#0066da"/>
              <path d="m43.65 25-13.75-23.8c-1.35.8-2.5 1.9-3.3 3.3l-25.4 44a9.06 9.06 0 0 0 -1.2 4.5h27.5z" fill="#00ac47"/>
              <path d="m73.55 76.8c1.35-.8 2.5-1.9 3.3-3.3l1.6-2.75 7.65-13.25c.8-1.4 1.2-2.95 1.2-4.5h-27.505l5.855 10.15z" fill="#ea4335"/>
              <path d="m43.65 25 13.75-23.8c-1.35-.8-2.9-1.2-4.5-1.2h-18.5c-1.6 0-3.15.45-4.5 1.2z" fill="#00832d"/>
              <path d="m59.8 50h27.5c0-1.55-.4-3.1-1.2-4.5l-25.4-44c-.8-1.4-1.95-2.5-3.3-3.3l-13.75 23.8z" fill="#ffba00"/>
              <path d="m73.55 76.8c1.35-.8 2.5-1.95 3.3-3.35l-49.35-48.45-13.75 23.8 46.05 27.2c1.35.8 2.9 1.25 4.5 1.25z" fill="#2684fc"/>
            </svg>
          </span>
          Integrasi Google Drive & Status Upload
        </h2>
        <div class="text-muted small mt-1">Kelola koneksi OAuth 2.0 / Service Account dan pantau status foto di Google Drive.</div>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="<?= $gdrive_token_url ?>" target="_blank" class="btn btn-success btn-pill-custom shadow-sm font-weight-bold">
            <i class="ti ti-key me-1"></i> Dapatkan Refresh Token Baru
          </a>
          <button id="btn-verify" class="btn btn-primary btn-pill-custom shadow-sm font-weight-bold ms-1">
            <i class="ti ti-refresh me-1"></i> Uji Koneksi & Status Token
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Banner Alert Uji Koneksi -->
<div id="connection-test-area"></div>

<!-- Top Status Cards Row -->
<div class="row g-3 mb-4">
  <!-- Status Koneksi Drive -->
  <div class="col-md-6">
    <div class="card card-custom-status h-100 shadow-sm">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-uppercase text-muted fw-bold small tracking-wide">STATUS KONEKSI DRIVE</span>
          <?php if ($folder_val['success']): ?>
            <span class="badge bg-success text-white rounded-pill px-3 py-1"><i class="ti ti-check me-1"></i> Terhubung</span>
          <?php else: ?>
            <span class="badge bg-danger text-white rounded-pill px-3 py-1"><i class="ti ti-x me-1"></i> Terputus</span>
          <?php endif; ?>
        </div>
        <div class="d-flex align-items-center mt-2">
          <div class="me-3">
            <div class="bg-success-lt p-2 rounded-circle">
              <svg width="28" height="28" viewBox="0 0 87.3 78" xmlns="http://www.w3.org/2000/svg">
                <path d="m6.6 66.85 3.85 6.65c.8 1.4 1.95 2.5 3.3 3.3l13.75-23.8h-27.5c0 1.55.4 3.1 1.2 4.5z" fill="#0066da"/>
                <path d="m43.65 25-13.75-23.8c-1.35.8-2.5 1.9-3.3 3.3l-25.4 44a9.06 9.06 0 0 0 -1.2 4.5h27.5z" fill="#00ac47"/>
                <path d="m73.55 76.8c1.35-.8 2.5-1.9 3.3-3.3l1.6-2.75 7.65-13.25c.8-1.4 1.2-2.95 1.2-4.5h-27.505l5.855 10.15z" fill="#ea4335"/>
              </svg>
            </div>
          </div>
          <div>
            <h4 class="mb-0 fw-bold text-dark">
              <?= $folder_val['success'] ? 'OAuth API Aktif' : 'Otorisasi Gagal' ?>
            </h4>
            <div class="text-muted small">
              <?= $folder_val['success'] ? 'Siap melakukan upload & download foto.' : html_escape($folder_val['message']) ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Kapasitas Google Drive -->
  <div class="col-md-6">
    <div class="card card-custom-capacity h-100 shadow-sm">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-uppercase text-muted fw-bold small tracking-wide">KAPASITAS GOOGLE DRIVE</span>
          <span class="badge bg-teal-lt rounded-pill px-3 py-1"><i class="ti ti-database me-1"></i> Storage Quota</span>
        </div>
        <div class="d-flex align-items-center justify-content-between text-muted small mt-2 mb-1">
          <div><i class="ti ti-mail me-1"></i> <strong><?= html_escape($storage_info['email'] ?? 'mas.dafndo@gmail.com') ?></strong></div>
          <div class="fw-bold text-dark"><?= html_escape($storage_info['text'] ?? '584.81 GB / 5120 GB') ?></div>
        </div>
        <div class="progress progress-sm rounded-pill mt-2" style="height: 6px;">
          <div class="progress-bar bg-success rounded-pill" style="width: <?= max(5, intval($storage_info['percent'] ?? 12)) ?>%" role="progressbar"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- OAuth Credentials Settings Form Card -->
<div class="card mb-4 border-0 shadow-sm rounded-3">
  <div class="card-header bg-transparent border-0 pt-3 pb-0">
    <h3 class="card-title text-primary fw-bold d-flex align-items-center">
      <i class="ti ti-adjustments-horizontal text-primary me-2 fs-2"></i> Pengaturan Kredensial OAuth 2.0 & Refresh Token
    </h3>
  </div>
  <div class="card-body">
    <form id="form-gdrive-config">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
      
      <div class="row g-3">
        <!-- Client ID -->
        <div class="col-md-6">
          <label class="form-label fw-bold text-dark small">Client ID</label>
          <input type="text" name="client_id" class="form-control rounded-2" placeholder="Masukkan Client ID Google Cloud" value="<?= html_escape($client_id) ?>" required>
        </div>

        <!-- Client Secret -->
        <div class="col-md-6">
          <label class="form-label fw-bold text-dark small">Client Secret</label>
          <input type="password" name="client_secret" class="form-control rounded-2" placeholder="Masukkan Client Secret" value="<?= html_escape($client_secret) ?>" required>
        </div>

        <!-- Refresh Token -->
        <div class="col-12">
          <label class="form-label fw-bold text-dark small">Refresh Token</label>
          <textarea name="refresh_token" class="form-control rounded-2" rows="2" placeholder="1//0xxxx..." required><?= html_escape($refresh_token) ?></textarea>
        </div>

        <!-- Root Folder ID -->
        <div class="col-md-6">
          <label class="form-label fw-bold text-dark small">Root Folder ID (Google Drive)</label>
          <input type="text" name="folder_id" class="form-control rounded-2" placeholder="1aEhBZKmLu..." value="<?= html_escape($folder_id) ?>" required>
        </div>

        <!-- Service Account JSON (Opsional) -->
        <div class="col-md-6">
          <label class="form-label fw-bold text-dark small">Service Account JSON (Opsional)</label>
          <div class="dropzone-upload-area" id="dropzone-area" onclick="document.getElementById('input-sa-json').click();">
            <div class="avatar bg-primary text-white rounded-circle mx-auto mb-2" style="width: 42px; height: 42px;">
              <i class="ti ti-cloud-upload fs-2"></i>
            </div>
            <div class="fw-bold text-dark small" id="dropzone-text">Tarik & lepas file di sini atau klik untuk memilih</div>
            <div class="text-muted extra-small">Kamera / Galeri didukung (.json)</div>
            <input type="file" id="input-sa-json" accept=".json" class="d-none">
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="mt-4">
        <button type="submit" id="btn-save-config" class="btn btn-primary btn-pill-custom shadow-sm font-weight-bold">
          <i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Recursive Sync & Compression Actions Bar -->
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body">
    <div class="row align-items-center g-2">
      <div class="col">
        <h4 class="mb-0 fw-bold text-dark"><i class="ti ti-cloud-upload text-success me-1"></i> Eksekusi & Otomatisasi Sinkronisasi File</h4>
        <div class="text-muted small">Kelola sinkronisasi otomatis seluruh berkas di <code>assets/uploads/</code> ke Google Drive API v3.</div>
      </div>
      <div class="col-auto">
        <button id="btn-compress-existing" class="btn btn-outline-warning shadow-sm me-1" title="Kompresi otomatis foto yang sudah ada di assets/uploads/ menjadi ~50%">
          <i class="ti ti-photo-check me-1"></i> Kompres Foto Existing (~50%)
        </button>
        <button id="btn-sync-all" class="btn btn-success font-weight-bold shadow-sm me-1">
          <i class="ti ti-refresh me-1"></i> Sync All Uploads Now
        </button>
        <button id="btn-verify-sec" class="btn btn-outline-info shadow-sm">
          <i class="ti ti-search me-1"></i> Verifikasi Drive
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Summary Widgets -->
<div class="row row-cards mb-3">
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm border-0 shadow-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-primary text-white avatar"><i class="ti ti-files"></i></span>
          </div>
          <div class="col">
            <div class="font-weight-medium fs-2"><?= number_format($report['total_records']) ?></div>
            <div class="text-muted">Total File Terdaftar</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm border-0 shadow-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-success text-white avatar"><i class="ti ti-cloud-upload"></i></span>
          </div>
          <div class="col">
            <div class="font-weight-medium fs-2 text-success"><?= number_format($report['synchronized']) ?></div>
            <div class="text-muted">Tersinkronisasi</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm border-0 shadow-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-warning text-white avatar"><i class="ti ti-photo-check"></i></span>
          </div>
          <div class="col">
            <div class="font-weight-medium fs-2 text-warning">~50%</div>
            <div class="text-muted">Auto-Compress Target</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card card-sm border-0 shadow-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-danger text-white avatar"><i class="ti ti-alert-triangle"></i></span>
          </div>
          <div class="col">
            <div class="font-weight-medium fs-2 text-danger"><?= number_format($report['failed'] + $report['local_missing']) ?></div>
            <div class="text-muted">Gagal / Local Missing</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="sync-alert-area"></div>

<?php if ($report['failed'] > 0): ?>
  <div class="alert alert-danger d-flex align-items-center justify-content-between mb-3">
    <div>
      <i class="ti ti-alert-circle me-2"></i> Terdapat <strong><?= $report['failed'] ?> file</strong> gagal diunggah.
    </div>
    <button id="btn-retry-failed" class="btn btn-danger btn-sm">
      <i class="ti ti-reload me-1"></i> Retry Failed Files
    </button>
  </div>
<?php endif; ?>

<!-- Datatable Card -->
<div class="card border-0 shadow-sm">
  <div class="card-header">
    <h3 class="card-title"><i class="ti ti-list me-2 text-primary"></i> Daftar Berkas di assets/uploads/</h3>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table table-hover" id="table-sync">
      <thead>
        <tr>
          <th style="width: 40px;">#</th>
          <th>Nama File</th>
          <th>Relative Path</th>
          <th>Ukuran File</th>
          <th>Kompresi (~50%)</th>
          <th>MIME Type</th>
          <th>Status</th>
          <th>Tautan Google Drive</th>
          <th>Terakhir Sync</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; foreach ($records as $r): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td class="fw-bold"><?= html_escape($r['file_name']) ?></td>
            <td><code><?= html_escape($r['relative_path']) ?></code></td>
            <td><?= number_format($r['file_size'] / 1024, 1) ?> KB</td>
            <td>
              <?php if (!empty($r['is_compressed'])): ?>
                <span class="badge bg-green-lt text-success" title="Original: <?= number_format(($r['original_file_size'] ?? $r['file_size'])/1024, 1) ?> KB | Quality: <?= $r['compression_quality'] ?? 80 ?>">
                  <i class="ti ti-arrow-down-right me-1"></i> -<?= number_format($r['compression_ratio'] ?? 0, 1) ?>%
                </span>
              <?php else: ?>
                <span class="text-muted small">Asli</span>
              <?php endif; ?>
            </td>
            <td><span class="badge bg-secondary-lt"><?= html_escape($r['mime_type']) ?></span></td>
            <td>
              <?php if ($r['status'] === 'SYNCHRONIZED'): ?>
                <span class="badge bg-success-lt text-success"><i class="ti ti-check me-1"></i> SYNCHRONIZED</span>
              <?php elseif ($r['status'] === 'PENDING'): ?>
                <span class="badge bg-warning-lt text-warning"><i class="ti ti-clock me-1"></i> PENDING</span>
              <?php elseif ($r['status'] === 'LOCAL_MISSING'): ?>
                <span class="badge bg-secondary-lt text-secondary"><i class="ti ti-file-off me-1"></i> LOCAL MISSING</span>
              <?php else: ?>
                <span class="badge bg-danger-lt text-danger" title="<?= html_escape($r['error_message'] ?? '') ?>"><i class="ti ti-x me-1"></i> FAILED</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($r['drive_file_id']): ?>
                <a href="https://drive.google.com/file/d/<?= html_escape($r['drive_file_id']) ?>/view" target="_blank" class="badge bg-blue-lt">
                  <i class="ti ti-brand-google-drive me-1"></i> Buka File Drive
                </a>
              <?php else: ?>
                <span class="text-muted small">-</span>
              <?php endif; ?>
            </td>
            <td class="small text-muted"><?= $r['last_synced_at'] ? date('d/m/Y H:i', strtotime($r['last_synced_at'])) : '-' ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const formConfig = document.getElementById('form-gdrive-config');
    const btnSaveConfig = document.getElementById('btn-save-config');
    const btnSync = document.getElementById('btn-sync-all');
    const btnVerify = document.getElementById('btn-verify');
    const btnVerifySec = document.getElementById('btn-verify-sec');
    const btnRetry = document.getElementById('btn-retry-failed');
    const alertArea = document.getElementById('sync-alert-area');
    const saInput = document.getElementById('input-sa-json');
    const dropzoneText = document.getElementById('dropzone-text');

    // Service Account File Drag & Drop Feedback
    if (saInput) {
        saInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                dropzoneText.innerHTML = '📄 File Terpilih: <strong>' + this.files[0].name + '</strong>';
            }
        });
    }

    // Submit Handler: Simpan Konfigurasi Kredensial
    if (formConfig) {
        formConfig.addEventListener('submit', function(e) {
            e.preventDefault();
            btnSaveConfig.disabled = true;
            btnSaveConfig.innerHTML = '<i class="ti ti-loader rotate me-1"></i> Menyimpan...';

            const formData = new FormData(formConfig);

            fetch('<?= site_url("google_drive_sync/save_config") ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.text())
            .then(text => {
                btnSaveConfig.disabled = false;
                btnSaveConfig.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi';

                let data;
                try {
                    data = JSON.parse(text);
                } catch(e) {
                    alertArea.innerHTML = `<div class="alert alert-danger">⚠️ Respon Server Non-JSON: ${text.substring(0, 300)}</div>`;
                    return;
                }

                if (data.success) {
                    alertArea.innerHTML = `<div class="alert alert-success">🎉 <strong>${data.message}</strong></div>`;
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alertArea.innerHTML = `<div class="alert alert-danger">⚠️ ${data.message}</div>`;
                }
            })
            .catch(err => {
                btnSaveConfig.disabled = false;
                btnSaveConfig.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi';
                alertArea.innerHTML = `<div class="alert alert-danger">⚠️ Error: ${err.message}</div>`;
            });
        });
    }

    // Action: Uji Koneksi Drive
    function runVerify() {
        const connArea = document.getElementById('connection-test-area');
        const targetBtn = btnVerify || btnVerifySec;
        if (targetBtn) {
            targetBtn.disabled = true;
            targetBtn.innerHTML = '<i class="ti ti-loader rotate me-1"></i> Menguji Koneksi...';
            if (connArea) {
                connArea.innerHTML = `<div class="alert alert-info border-0 shadow-sm p-3 mb-4 rounded-3 d-flex align-items-center">
                    <i class="ti ti-loader rotate me-2 fs-3 text-info"></i>
                    <span>Sedang menguji koneksi OAuth 2.0 ke Google Drive API... Mohon tunggu.</span>
                </div>`;
            }

            const csrfTokenName = '<?= $this->security->get_csrf_token_name() ?>';
            const csrfTokenHash = '<?= $this->security->get_csrf_hash() ?>';

            fetch('<?= site_url("google_drive_sync/process_verify") ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: csrfTokenName + '=' + csrfTokenHash
            })
            .then(res => res.text())
            .then(text => {
                if (btnVerify) btnVerify.disabled = false;
                if (btnVerify) btnVerify.innerHTML = '<i class="ti ti-refresh me-1"></i> Uji Koneksi & Status Token';
                if (btnVerifySec) btnVerifySec.disabled = false;
                if (btnVerifySec) btnVerifySec.innerHTML = '<i class="ti ti-search me-1"></i> Verifikasi Drive';

                let data;
                try {
                    data = JSON.parse(text);
                } catch(e) {
                    if (connArea) {
                        connArea.innerHTML = `<div class="alert alert-danger border-0 shadow-sm p-3 mb-4 rounded-3 d-flex align-items-center">
                            <i class="ti ti-circle-x-filled me-2 fs-2 text-danger"></i>
                            <span><strong>Gagal Terhubung!</strong> &bull; Respon Server (Non-JSON): ${text.substring(0, 300)}</span>
                        </div>`;
                    }
                    return;
                }

                if (connArea) {
                    if (data.connected) {
                        connArea.innerHTML = `<div class="alert border-0 shadow-sm p-3 mb-4 rounded-3 d-flex align-items-center" style="background-color: #d1e7dd; color: #0f5132; font-weight: 500;">
                            <i class="ti ti-circle-check-filled me-2 fs-2 text-success"></i>
                            <span><strong>Terhubung ke Google Drive!</strong> &bull; Akun: <strong>${data.email}</strong> &bull; Kuota: <strong>${data.storage_text}</strong></span>
                        </div>`;
                    } else {
                        connArea.innerHTML = `<div class="alert alert-danger border-0 shadow-sm p-3 mb-4 rounded-3 d-flex align-items-center">
                            <i class="ti ti-circle-x-filled me-2 fs-2 text-danger"></i>
                            <span><strong>Gagal Terhubung ke Google Drive!</strong> &bull; ${data.message}</span>
                        </div>`;
                    }
                }

                alertArea.innerHTML = `<div class="alert alert-info">
                    🔍 <strong>Hasil Verifikasi File Google Drive API (Sampel 10 File):</strong><br>
                    Terverifikasi Ada di Drive: <strong>${data.verified}</strong> file.<br>
                    File Belum / Hilang di Drive: <strong>${data.unverified}</strong> file.<br>
                    Total File Tersinkron di DB: <strong>${data.total_synced || 0}</strong> file.
                </div>`;
            })
            .catch(err => {
                if (btnVerify) btnVerify.disabled = false;
                if (btnVerify) btnVerify.innerHTML = '<i class="ti ti-refresh me-1"></i> Uji Koneksi & Status Token';
                if (connArea) {
                    connArea.innerHTML = `<div class="alert alert-danger border-0 shadow-sm p-3 mb-4 rounded-3 d-flex align-items-center">
                        <i class="ti ti-circle-x-filled me-2 fs-2 text-danger"></i>
                        <span><strong>Gagal Terhubung!</strong> &bull; Error: ${err.message}</span>
                    </div>`;
                }
            });
        }
    }

    if (btnVerify) btnVerify.addEventListener('click', runVerify);
    if (btnVerifySec) btnVerifySec.addEventListener('click', runVerify);

    // Sync All Uploads Handler
    if (btnSync) {
        btnSync.addEventListener('click', function() {
            btnSync.disabled = true;
            btnSync.innerHTML = '<i class="ti ti-loader rotate me-1"></i> Syncing...';
            alertArea.innerHTML = '<div class="alert alert-info"><i class="ti ti-loader rotate me-2"></i> Melakukan recursive scan & upload seluruh file di <code>assets/uploads/</code> ke Google Drive... Mohon tunggu.</div>';

            const csrfTokenName = '<?= $this->security->get_csrf_token_name() ?>';
            const csrfTokenHash = '<?= $this->security->get_csrf_hash() ?>';

            fetch('<?= site_url("google_drive_sync/process_sync_all") ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: csrfTokenName + '=' + csrfTokenHash + '&force=false'
            })
            .then(res => res.text())
            .then(text => {
                btnSync.disabled = false;
                btnSync.innerHTML = '<i class="ti ti-refresh me-1"></i> Sync All Uploads Now';

                let data;
                try {
                    data = JSON.parse(text);
                } catch(e) {
                    alertArea.innerHTML = `<div class="alert alert-danger">⚠️ Respon Server Non-JSON: ${text.substring(0, 300)}</div>`;
                    return;
                }

                let alertClass = data.success ? 'alert-success' : 'alert-warning';
                let html = `<div class="alert ${alertClass}">
                    <h4 class="alert-title mb-2">🎉 Sinkronisasi Selesai!</h4>
                    <ul class="mb-0">
                        <li><strong>Total File Lokal:</strong> ${data.total_local_files}</li>
                        <li><strong>Total Subfolder:</strong> ${data.total_local_folders}</li>
                        <li><strong>Berhasil Diunggah Baru:</strong> ${data.uploaded}</li>
                        <li><strong>Berhasil Diperbarui:</strong> ${data.updated}</li>
                        <li><strong>Dilewati (Sudah Sama):</strong> ${data.skipped}</li>
                        <li><strong>Gagal:</strong> ${data.failed}</li>
                    </ul>
                </div>`;
                alertArea.innerHTML = html;
                setTimeout(() => location.reload(), 2500);
            })
            .catch(err => {
                btnSync.disabled = false;
                btnSync.innerHTML = '<i class="ti ti-refresh me-1"></i> Sync All Uploads Now';
                alertArea.innerHTML = `<div class="alert alert-danger">⚠️ Request Error: ${err.message}</div>`;
            });
        });
    }

    if (btnRetry) {
        btnRetry.addEventListener('click', function() {
            btnRetry.disabled = true;
            btnRetry.innerHTML = '<i class="ti ti-loader rotate me-1"></i> Retrying...';

            const csrfTokenName = '<?= $this->security->get_csrf_token_name() ?>';
            const csrfTokenHash = '<?= $this->security->get_csrf_hash() ?>';

            fetch('<?= site_url("google_drive_sync/retry_failed") ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: csrfTokenName + '=' + csrfTokenHash
            })
            .then(res => res.json())
            .then(data => {
                alertArea.innerHTML = `<div class="alert alert-success">🚀 ${data.message}</div>`;
                setTimeout(() => location.reload(), 2000);
            });
        });
    }

    const btnCompressExisting = document.getElementById('btn-compress-existing');
    if (btnCompressExisting) {
        btnCompressExisting.addEventListener('click', function() {
            btnCompressExisting.disabled = true;
            btnCompressExisting.innerHTML = '<i class="ti ti-loader rotate me-1"></i> Compressing...';
            alertArea.innerHTML = '<div class="alert alert-info"><i class="ti ti-loader rotate me-2"></i> Mengompresi seluruh foto existing di <code>assets/uploads/</code> menjadi ~50%... Mohon tunggu.</div>';

            const csrfTokenName = '<?= $this->security->get_csrf_token_name() ?>';
            const csrfTokenHash = '<?= $this->security->get_csrf_hash() ?>';

            fetch('<?= site_url("google_drive_sync/process_compress_existing") ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: csrfTokenName + '=' + csrfTokenHash
            })
            .then(res => res.json())
            .then(data => {
                btnCompressExisting.disabled = false;
                btnCompressExisting.innerHTML = '<i class="ti ti-photo-check me-1"></i> Kompres Foto Existing (~50%)';
                alertArea.innerHTML = `<div class="alert alert-success">🎉 <strong>${data.message}</strong></div>`;
                setTimeout(() => location.reload(), 2500);
            })
            .catch(err => {
                btnCompressExisting.disabled = false;
                btnCompressExisting.innerHTML = '<i class="ti ti-photo-check me-1"></i> Kompres Foto Existing (~50%)';
                alertArea.innerHTML = `<div class="alert alert-danger">⚠️ Request Error: ${err.message}</div>`;
            });
        });
    }

});
</script>
