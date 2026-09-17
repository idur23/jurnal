<div class="container-xl">
  <!-- Page Header -->
  <div class="page-header d-print-none mb-4">
    <div class="row align-items-center">
      <div class="col">
        <div class="page-pretitle">Modul Supervisi Akademik</div>
        <h2 class="page-title text-primary fw-bold">
          <i class="ti ti-printer me-2"></i>Laporan Supervisi Akademik
        </h2>
        <div class="text-muted small mt-1">
          Cetak dan unduh laporan hasil supervisi akademik MA Darul Faqih Indonesia
        </div>
      </div>
    </div>
  </div>

  <div class="row row-cards">
    <!-- Card 1: Laporan Per Form -->
    <div class="col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-transparent">
          <h4 class="card-title fw-bold text-dark mb-0"><i class="ti ti-file-text me-2 text-indigo"></i>Laporan Per Form Instrumen</h4>
        </div>
        <div class="card-body">
          <form method="GET" action="<?= base_url('supervisi/rekap') ?>" target="_blank">
            <div class="mb-3">
              <label class="form-label required">Pilih Form Instrumen</label>
              <select name="form_id" class="form-select" required>
                <option value="">-- Pilih Form --</option>
                <?php foreach ($form_list as $f): ?>
                  <option value="<?= $f['id'] ?>"><?= html_escape($f['nama_form']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Tahun Pelajaran</label>
              <select name="tp_id" class="form-select">
                <option value="">-- Semua Tahun Pelajaran --</option>
                <?php foreach ($tp_list as $tp): ?>
                  <option value="<?= $tp['id'] ?>"><?= html_escape($tp['tahun']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary"><i class="ti ti-eye me-1"></i> Tampilkan Rekap Laporan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Card 2: Laporan Per Guru -->
    <div class="col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-transparent">
          <h4 class="card-title fw-bold text-dark mb-0"><i class="ti ti-user me-2 text-success"></i>Laporan Riwayat Guru</h4>
        </div>
        <div class="card-body">
          <form method="GET" action="<?= base_url('supervisi/detail_guru') ?>">
            <div class="mb-3">
              <label class="form-label required">Pilih Guru</label>
              <select name="guru_id" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                <?php foreach ($guru_list as $g): ?>
                  <option value="<?= $g['id'] ?>"><?= html_escape($g['nama_lengkap']) ?> (NIP: <?= html_escape($g['nip'] ? $g['nip'] : '-') ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-success"><i class="ti ti-chart-dots me-1"></i> Buka Detail & Grafik Guru</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
