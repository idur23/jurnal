<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title text-indigo"><i class="ti ti-file-analytics me-2"></i>Pusat Laporan & Export Data</h2>
      <div class="text-muted small mt-1">Cetak laporan kegiatan KBM Jurnal Guru, Kehadiran, Penanganan Kasus, dan Perkembangan Diri Siswa.</div>
    </div>
  </div>
</div>

<div class="row row-cards g-4">
  <?php 
    $role = $this->session->userdata('user_session')['role_code'] ?? '';
    if ($role !== 'walikelas'): 
  ?>
  <!-- Laporan Jurnal Guru -->
  <div class="col-md-6">
    <form action="<?= base_url('laporan/print_jurnal') ?>" method="GET" target="_blank" class="h-100">
      <div class="card h-100 shadow-sm border-0 d-flex flex-column">
        <div class="card-header bg-primary text-white py-3">
          <h3 class="card-title text-white fw-bold m-0"><i class="ti ti-file-report fs-2 me-2"></i>Laporan Jurnal Guru</h3>
        </div>
        <div class="card-body flex-fill">
          <div class="mb-3">
            <label class="form-label fw-semibold">Filter Kelas</label>
            <select name="kelas_id" class="form-select select2">
              <option value="">-- Semua Kelas Diampu --</option>
              <?php foreach ($list_kelas_jurnal as $k): ?>
                <option value="<?= $k['id'] ?>"><?= html_escape($k['nama_kelas']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Filter Mata Pelajaran</label>
            <select name="mapel_id" class="form-select select2">
              <option value="">-- Semua Mapel Diampu --</option>
              <?php foreach ($list_mapel as $m): ?>
                <option value="<?= $m['id'] ?>"><?= html_escape($m['nama_mapel']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row">
            <div class="col-6">
              <label class="form-label fw-semibold">Dari Tanggal</label>
              <input type="text" name="tanggal_mulai" class="form-control datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Sampai Tanggal</label>
              <input type="text" name="tanggal_selesai" class="form-control datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="card-footer bg-light border-top-0 pt-0 pb-3">
          <button type="submit" class="btn btn-primary w-100 fw-bold py-2"><i class="ti ti-printer me-2"></i> Cetak / Preview Jurnal</button>
        </div>
      </div>
    </form>
  </div>
  <?php endif; ?>

  <!-- Laporan Presensi Kelas -->
  <div class="col-md-6">
    <form action="<?= base_url('presensi') ?>" method="GET" class="h-100">
      <div class="card h-100 shadow-sm border-0 d-flex flex-column">
        <div class="card-header bg-success text-white py-3">
          <h3 class="card-title text-white fw-bold m-0"><i class="ti ti-user-check fs-2 me-2"></i>Laporan Rekapitulasi Presensi</h3>
        </div>
        <div class="card-body flex-fill">
          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Kelas Binaan / Diampu</label>
            <select name="kelas_id" class="form-select select2">
              <?php foreach ($list_kelas_presensi as $k): ?>
                <option value="<?= $k['id'] ?>"><?= html_escape($k['nama_kelas']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Bulan & Tahun</label>
            <div class="row g-2">
              <div class="col-6">
                <select name="bulan" class="form-select">
                  <option value="01" <?= (date('m') == '01') ? 'selected' : '' ?>>Januari</option>
                  <option value="02" <?= (date('m') == '02') ? 'selected' : '' ?>>Februari</option>
                  <option value="03" <?= (date('m') == '03') ? 'selected' : '' ?>>Maret</option>
                  <option value="04" <?= (date('m') == '04') ? 'selected' : '' ?>>April</option>
                  <option value="05" <?= (date('m') == '05') ? 'selected' : '' ?>>Mei</option>
                  <option value="06" <?= (date('m') == '06') ? 'selected' : '' ?>>Juni</option>
                  <option value="07" <?= (date('m') == '07') ? 'selected' : '' ?>>Juli</option>
                  <option value="08" <?= (date('m') == '08') ? 'selected' : '' ?>>Agustus</option>
                  <option value="09" <?= (date('m') == '09') ? 'selected' : '' ?>>September</option>
                  <option value="10" <?= (date('m') == '10') ? 'selected' : '' ?>>Oktober</option>
                  <option value="11" <?= (date('m') == '11') ? 'selected' : '' ?>>November</option>
                  <option value="12" <?= (date('m') == '12') ? 'selected' : '' ?>>Desember</option>
                </select>
              </div>
              <div class="col-6">
                <input type="number" name="tahun" class="form-control" value="<?= date('Y') ?>">
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer bg-light border-top-0 pt-0 pb-3">
          <button type="submit" class="btn btn-success w-100 fw-bold py-2"><i class="ti ti-eye me-2"></i> Lihat Rekap Kehadiran</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Laporan Presensi Kelas (CR-003) -->
  <div class="col-md-6">
    <form id="formPresensiKelas" method="GET" class="h-100">
      <div class="card h-100 shadow-sm border-0 d-flex flex-column">
        <div class="card-header bg-indigo text-white py-3">
          <h3 class="card-title text-white fw-bold m-0"><i class="ti ti-building-community fs-2 me-2"></i>Laporan Presensi Kelas & KBM</h3>
        </div>
        <div class="card-body flex-fill">
          <div class="row g-3 mb-3">
            <div class="col-6">
              <label class="form-label fw-semibold">Kelas</label>
              <select name="kelas_id" class="form-select select2">
                <option value="">-- Semua Kelas --</option>
                <?php foreach ($list_kelas_jurnal as $k): ?>
                  <option value="<?= $k['id'] ?>"><?= html_escape($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Mata Pelajaran</label>
              <select name="mapel_id" class="form-select select2">
                <option value="">-- Semua Mapel --</option>
                <?php foreach ($list_mapel as $m): ?>
                  <option value="<?= $m['id'] ?>"><?= html_escape($m['nama_mapel']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-6">
              <label class="form-label fw-semibold">Guru Pengampu</label>
              <select name="guru_id" class="form-select select2">
                <option value="">-- Semua Guru --</option>
                <?php foreach ($list_guru as $g): ?>
                  <option value="<?= $g['id'] ?>"><?= html_escape($g['nama_lengkap']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Status KBM</label>
              <select name="status_pembelajaran" class="form-select">
                <option value="">-- Semua Status --</option>
                <option value="Terlaksana">Terlaksana</option>
                <option value="Tidak Terlaksana">Tidak Terlaksana</option>
                <option value="Diganti">Diganti</option>
                <option value="Daring">Daring</option>
                <option value="Luring">Luring</option>
                <option value="Gabungan Kelas">Gabungan Kelas</option>
              </select>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-6">
              <label class="form-label fw-semibold">Dari Tanggal</label>
              <input type="text" name="tanggal_mulai" class="form-control datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Sampai Tanggal</label>
              <input type="text" name="tanggal_selesai" class="form-control datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="card-footer bg-light border-top-0 pt-0 pb-3">
          <div class="row g-2">
            <div class="col-6">
              <button type="submit" onclick="this.form.action='<?= base_url('laporan/presensikelas_pdf') ?>'; this.form.target='_blank';" class="btn btn-outline-danger w-100 fw-bold py-2">
                <i class="ti ti-file-pdf me-2"></i> PDF
              </button>
            </div>
            <div class="col-6">
              <button type="submit" onclick="this.form.action='<?= base_url('laporan/presensikelas_excel') ?>'; this.form.target='_self';" class="btn btn-outline-success w-100 fw-bold py-2">
                <i class="ti ti-file-spreadsheet me-2"></i> Excel
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <!-- Laporan Jurnal Penanganan Siswa -->
  <div class="col-md-6">
    <form id="formPenanganan" method="GET" class="h-100">
      <div class="card h-100 shadow-sm border-0 d-flex flex-column">
        <div class="card-header bg-danger text-white py-3">
          <h3 class="card-title text-white fw-bold m-0"><i class="ti ti-user-exclamation me-2"></i>Laporan Penanganan & Pembinaan Siswa</h3>
        </div>
        <div class="card-body flex-fill">
          <div class="row g-3 mb-3">
            <div class="col-6">
              <label class="form-label fw-semibold">Filter Kelas</label>
              <select name="kelas_id" class="form-select select2">
                <option value="">-- Semua Kelas --</option>
                <?php foreach ($list_kelas_jurnal as $k): ?>
                  <option value="<?= $k['id'] ?>"><?= html_escape($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Filter Siswa</label>
              <select name="siswa_id" class="form-select select2">
                <option value="">-- Semua Siswa --</option>
                <?php foreach ($list_siswa as $s): ?>
                  <option value="<?= $s['id'] ?>"><?= html_escape($s['nama_lengkap']) ?> (<?= html_escape($s['nama_kelas']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-6">
              <label class="form-label fw-semibold">Kategori Masalah</label>
              <select name="kategori" class="form-select">
                <option value="">-- Semua Kategori --</option>
                <option value="Akademik">Akademik</option>
                <option value="Disiplin">Disiplin</option>
                <option value="Perilaku">Perilaku</option>
                <option value="Kesehatan">Kesehatan</option>
                <option value="Sosial">Sosial</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Tahun Pelajaran / Semester</label>
              <select name="tahun_pelajaran_id" class="form-select">
                <option value="">-- TP Aktif --</option>
                <?php foreach ($list_tp as $tp): ?>
                  <option value="<?= $tp['id'] ?>"><?= html_escape($tp['tahun'] . ' - ' . $tp['semester']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-6">
              <label class="form-label fw-semibold">Dari Tanggal</label>
              <input type="text" name="tanggal_mulai" class="form-control datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Sampai Tanggal</label>
              <input type="text" name="tanggal_selesai" class="form-control datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="card-footer bg-light border-top-0 pt-0 pb-3">
          <div class="row g-2">
            <div class="col-6">
              <button type="submit" onclick="this.form.action='<?= base_url('laporan/penanganan_pdf') ?>'; this.form.target='_blank';" class="btn btn-outline-danger w-100 fw-bold py-2">
                <i class="ti ti-file-pdf me-2"></i> PDF
              </button>
            </div>
            <div class="col-6">
              <button type="submit" onclick="this.form.action='<?= base_url('laporan/penanganan_excel') ?>'; this.form.target='_self';" class="btn btn-outline-success w-100 fw-bold py-2">
                <i class="ti ti-file-spreadsheet me-2"></i> Excel
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <!-- Laporan Perkembangan Diri Siswa -->
  <div class="col-md-6">
    <form id="formPerkembangan" method="GET" class="h-100">
      <div class="card h-100 shadow-sm border-0 d-flex flex-column">
        <div class="card-header bg-indigo text-white py-3">
          <h3 class="card-title text-white fw-bold m-0"><i class="ti ti-user-heart me-2"></i>Laporan Perkembangan Diri Siswa</h3>
        </div>
        <div class="card-body flex-fill">
          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Kelas</label>
            <select name="kelas_id" class="form-select select2" required>
              <option value="">-- Pilih Kelas --</option>
              <?php foreach ($list_kelas_jurnal as $k): ?>
                <option value="<?= $k['id'] ?>"><?= html_escape($k['nama_kelas']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Siswa (Opsional - Kosongkan jika ingin Rekap Kelas)</label>
            <select name="siswa_id" class="form-select select2">
              <option value="">-- Semua Siswa (Rekapitulasi Kelas) --</option>
              <?php foreach ($list_siswa as $s): ?>
                <option value="<?= $s['id'] ?>"><?= html_escape($s['nama_lengkap']) ?> (<?= html_escape($s['nama_kelas']) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Tahun Pelajaran / Semester</label>
            <select name="tahun_pelajaran_id" class="form-select">
              <option value="">-- TP Aktif --</option>
              <?php foreach ($list_tp as $tp): ?>
                <option value="<?= $tp['id'] ?>"><?= html_escape($tp['tahun'] . ' - ' . $tp['semester']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="card-footer bg-light border-top-0 pt-0 pb-3">
          <div class="row g-2">
            <div class="col-6">
              <button type="submit" onclick="this.form.action='<?= base_url('laporan/perkembangan_pdf') ?>'; this.form.target='_blank';" class="btn btn-outline-danger w-100 fw-bold py-2">
                <i class="ti ti-file-pdf me-2"></i> Download PDF
              </button>
            </div>
            <div class="col-6">
              <button type="submit" onclick="this.form.action='<?= base_url('laporan/perkembangan_excel') ?>'; this.form.target='_self';" class="btn btn-outline-success w-100 fw-bold py-2">
                <i class="ti ti-file-spreadsheet me-2"></i> Download Excel
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
