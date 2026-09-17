<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Rekapitulasi Nilai RDM</h2>
      <div class="text-muted small mt-1">Laporan rekap nilai lengkap berdasarkan bobot Rapor Digital Madrasah (RDM).</div>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card mb-4 d-print-none">
  <div class="card-body">
    <form action="<?= base_url('penilaian/rekap') ?>" method="GET" class="row g-3">
      <div class="col-md-5">
        <label class="form-label required">Kelas</label>
        <select name="kelas_id" class="form-select select2" required>
          <option value="">-- Pilih Kelas --</option>
          <?php foreach ($list_kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= (($selected_kelas_id ?? '') == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-5">
        <label class="form-label required">Mata Pelajaran</label>
        <select name="mapel_id" class="form-select select2" required>
          <option value="">-- Pilih Mapel --</option>
          <?php foreach ($list_mapel as $m): ?>
            <option value="<?= $m['id'] ?>" <?= (($selected_mapel_id ?? '') == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-1"></i> Rekap</button>
      </div>
    </form>
  </div>
</div>

<?php if ($selected_kelas_id && $selected_mapel_id): ?>
  <div class="card mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center d-print-none">
      <h3 class="card-title text-white">
        <i class="ti ti-table me-2"></i>Rekap Akademik RDM Kelas: <?= html_escape($kelas_row['nama_kelas']) ?> | Mapel: <?= html_escape($mapel_row['nama_mapel']) ?>
      </h3>
      <div class="d-flex gap-2">
        <a href="<?= base_url("penilaian/export_rekap_excel?kelas_id=$selected_kelas_id&mapel_id=$selected_mapel_id&tp_id={$active_tp['id']}") ?>" class="btn btn-success btn-sm font-weight-bold">
          <i class="ti ti-file-spreadsheet me-1"></i> Excel
        </a>
        <a href="<?= base_url("penilaian/export_rekap_pdf?kelas_id=$selected_kelas_id&mapel_id=$selected_mapel_id&tp_id={$active_tp['id']}") ?>" target="_blank" class="btn btn-danger btn-sm font-weight-bold">
          <i class="ti ti-file-text me-1"></i> PDF / Cetak
        </a>
      </div>
    </div>
    <div class="card-body">
      <!-- Info Header -->
      <div class="row mb-3 p-3 rounded bg-secondary-lt border border-secondary border-opacity-10 mx-0 g-2">
        <div class="col-sm-4 text-center text-sm-start">
          <div class="text-muted small">Tahun Pelajaran / Semester:</div>
          <div class="fw-bold fs-3 text-indigo"><?= html_escape($active_tp['tahun']) ?> (Semester <?= html_escape($active_tp['semester']) ?>)</div>
        </div>
        <div class="col-sm-4 text-center text-sm-start">
          <div class="text-muted small">Kriteria Ketuntasan Minimal (KKM):</div>
          <div class="fw-bold fs-3 text-indigo">KKM: <?= number_format($rekap[0]['kkm'] ?? 75, 2) ?></div>
        </div>
        <div class="col-sm-4 text-center text-sm-start">
          <div class="text-muted small">Bobot Nilai RDM:</div>
          <div class="text-muted small">
            <?php foreach ($categories as $cat): ?>
              <span class="badge bg-purple-lt me-1 mb-1"><?= html_escape($cat['nama_kategori']) ?>: <?= $cat['bobot'] ?>%</span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped datatable">
          <thead>
            <tr>
              <th>#</th>
              <th>NIS</th>
              <th>Nama Siswa</th>
              <?php foreach ($categories as $cat): ?>
                <th class="text-center"><?= html_escape(str_replace('Nilai ', '', $cat['nama_kategori'])) ?></th>
              <?php endforeach; ?>
              <th class="text-center bg-indigo-lt text-indigo fw-bold">Nilai Akhir</th>
              <th class="text-center">Predikat</th>
              <th class="text-center">Ketuntasan</th>
              <th class="text-center">Tindak Lanjut</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach ($rekap as $r): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><code><?= html_escape($r['nis']) ?></code></td>
                <td class="fw-bold"><?= html_escape($r['nama_lengkap']) ?></td>
                
                <?php foreach ($categories as $cat): ?>
                  <?php $score = $r['scores'][$cat['kode_kategori']]; ?>
                  <td class="text-center fw-bold <?= $score !== NULL && $score < $r['kkm'] ? 'text-danger' : 'text-success' ?>">
                    <?= $score !== NULL ? number_format($score, 2) : '<span class="text-muted font-weight-normal">-</span>' ?>
                  </td>
                <?php endforeach; ?>

                <td class="text-center bg-indigo-lt text-indigo fw-bold fs-3"><?= number_format($r['nilai_akhir'], 2) ?></td>
                <td class="text-center">
                  <span class="badge bg-blue-lt fw-bold fs-4"><?= html_escape($r['predikat']) ?></span>
                </td>
                <td class="text-center">
                  <?php if ($r['ketuntasan'] == 'Tuntas'): ?>
                    <span class="badge bg-success text-white fw-bold">Tuntas</span>
                  <?php else: ?>
                    <span class="badge bg-danger text-white fw-bold">Belum Tuntas</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <?php if ($r['tindak_lanjut'] == 'Pengayaan'): ?>
                    <span class="badge bg-cyan-lt fw-bold">Pengayaan</span>
                  <?php else: ?>
                    <span class="badge bg-warning-lt fw-bold">Remedial</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php else: ?>
  <div class="card card-body text-center text-muted py-5 mb-4">
    <i class="ti ti-info-circle fs-1 text-primary mb-2"></i>
    <h3>Silakan pilih Kelas dan Mata Pelajaran terlebih dahulu.</h3>
    <p class="mb-0">Pilih filter di atas lalu klik tombol <strong>Rekap</strong> untuk memuat data rekapitulasi nilai akhir RDM.</p>
  </div>
<?php endif; ?>
