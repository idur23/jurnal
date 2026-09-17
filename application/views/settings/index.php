<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Pengaturan Sistem & Format Laporan</h2>
      <div class="text-muted small mt-1">Konfigurasi data sekolah, kop surat, dan format penandatangan laporan cetak.</div>
    </div>
  </div>
</div>

<form action="<?= base_url('settings') ?>" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
  
  <div class="row row-cards">
    <!-- Card 1: Konfigurasi Identitas Sekolah -->
    <div class="col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title text-white"><i class="ti ti-school me-2"></i>1. Identitas Sekolah & Aplikasi</h3>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label required">Nama Aplikasi</label>
            <input type="text" name="setting[app_name]" class="form-control" value="<?= html_escape($settings['app_name'] ?? 'Jurnal Guru Enterprise') ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label required">Nama Institusi / Sekolah (Header Laporan)</label>
            <input type="text" name="setting[app_institution]" class="form-control" value="<?= html_escape($settings['app_institution'] ?? 'SMA NEGERI ENTERPRISE 1') ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label required">Alamat Sekolah & Kontak</label>
            <textarea name="setting[app_address]" class="form-control" rows="3" required><?= html_escape($settings['app_address'] ?? '') ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Logo Aplikasi (Sidebar)</label>
            <input type="file" name="app_logo" class="form-control" accept="image/png, image/jpeg, image/gif">
            <div class="text-muted small mt-1">Format yang didukung: PNG, JPG, GIF. Maks: 2MB.</div>
            <?php if (!empty($settings['app_logo']) && file_exists('./' . $settings['app_logo'])): ?>
              <div class="mt-2">
                <span class="text-muted small d-block mb-1">Logo Saat Ini:</span>
                <img src="<?= base_url($settings['app_logo']) ?>?v=<?= time() ?>" class="rounded border p-1" style="height: 50px; max-width: 150px; object-fit: contain;">
              </div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label">Logo KOP Kiri (Format Cetak Laporan)</label>
            <input type="file" name="app_logo_left" class="form-control" accept="image/png, image/jpeg, image/gif">
            <div class="text-muted small mt-1">Format yang didukung: PNG, JPG, GIF. Maks: 2MB.</div>
            <?php if (!empty($settings['app_logo_left']) && file_exists('./' . $settings['app_logo_left'])): ?>
              <div class="mt-2">
                <span class="text-muted small d-block mb-1">Logo KOP Kiri Saat Ini:</span>
                <img src="<?= base_url($settings['app_logo_left']) ?>?v=<?= time() ?>" class="rounded border p-1" style="height: 50px; max-width: 150px; object-fit: contain;">
              </div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label">Logo KOP Kanan (Format Cetak Laporan)</label>
            <input type="file" name="app_logo_right" class="form-control" accept="image/png, image/jpeg, image/gif">
            <div class="text-muted small mt-1">Format yang didukung: PNG, JPG, GIF. Maks: 2MB.</div>
            <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
              <div class="mt-2">
                <span class="text-muted small d-block mb-1">Logo KOP Kanan Saat Ini:</span>
                <img src="<?= base_url($settings['app_logo_right']) ?>?v=<?= time() ?>" class="rounded border p-1" style="height: 50px; max-width: 150px; object-fit: contain;">
              </div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label">Favicon Aplikasi (Browser Tab)</label>
            <input type="file" name="app_favicon" class="form-control" accept="image/x-icon, image/png, image/gif, image/jpeg">
            <div class="text-muted small mt-1">Format yang didukung: ICO, PNG, JPG. Maks: 1MB.</div>
            <?php if (!empty($settings['app_favicon']) && file_exists('./' . $settings['app_favicon'])): ?>
              <div class="mt-2">
                <span class="text-muted small d-block mb-1">Favicon Saat Ini:</span>
                <img src="<?= base_url($settings['app_favicon']) ?>?v=<?= time() ?>" class="rounded border p-1" style="height: 32px; width: 32px; object-fit: cover;">
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2: Konfigurasi Kop & TTD Laporan -->
    <div class="col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-header bg-dark text-white">
          <h3 class="card-title text-white"><i class="ti ti-printer me-2"></i>2. Format Cetak Laporan & Penandatangan</h3>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label required">Sub-Judul Kop Laporan</label>
            <input type="text" name="setting[report_header_title]" class="form-control" value="<?= html_escape($settings['report_header_title'] ?? 'LAPORAN JURNAL KEGIATAN BELAJAR MENGAJAR (KBM)') ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label required">Kota / Tempat Penandatanganan</label>
            <input type="text" name="setting[report_city]" class="form-control" value="<?= html_escape($settings['report_city'] ?? 'Kota Enterprise') ?>" placeholder="Misal: Jakarta / Bandung" required>
          </div>

          <div class="mb-3">
            <label class="form-label required">Jabatan Penandatangan (TTD)</label>
            <input type="text" name="setting[report_signer_title]" class="form-control" value="<?= html_escape($settings['report_signer_title'] ?? 'Kepala Sekolah') ?>" placeholder="Misal: Kepala Sekolah / Wakasek Kurikulum" required>
          </div>

          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label required">Nama Penandatangan</label>
              <input type="text" name="setting[report_signer_name]" class="form-control" value="<?= html_escape($settings['report_signer_name'] ?? 'Drs. H. Ahmad Fauzi, M.Pd.') ?>" placeholder="Nama & Gelar" required>
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">NIP Penandatangan</label>
              <input type="text" name="setting[report_signer_nip]" class="form-control" value="<?= html_escape($settings['report_signer_nip'] ?? '19700101 199503 1 001') ?>" placeholder="NIP Penandatangan">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 text-end mb-4">
      <button type="submit" class="btn btn-primary btn-lg fw-bold px-4 py-2">
        <i class="ti ti-device-floppy me-2"></i> Simpan Semua Pengaturan
      </button>
    </div>
  </div>
</form>
