<div class="container-xl">
  <!-- Page Header -->
  <div class="page-header d-print-none mb-4">
    <div class="row align-items-center">
      <div class="col">
        <div class="page-pretitle">Modul Supervisi Akademik</div>
        <h2 class="page-title text-primary fw-bold">
          <i class="ti ti-report-analytics me-2"></i>Rekap Supervisi Akademik
        </h2>
        <div class="text-muted small mt-1">
          Rekapitulasi hasil penilaian supervisi akademik guru MA Darul Faqih Indonesia
        </div>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="<?= base_url('supervisi/export_excel?' . http_build_query($_GET)) ?>" class="btn btn-outline-success">
            <i class="ti ti-file-spreadsheet me-1"></i> Export Excel
          </a>
          <a href="<?= base_url('supervisi/laporan') ?>" class="btn btn-outline-primary">
            <i class="ti ti-printer me-1"></i> Cetak Laporan
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Card -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent">
      <h4 class="card-title fw-bold text-dark mb-0"><i class="ti ti-filter me-2 text-primary"></i>Filter Data Rekapitulasi</h4>
    </div>
    <div class="card-body">
      <form method="GET" action="<?= base_url('supervisi/rekap') ?>" class="row g-3">
        <!-- Tahun Pelajaran -->
        <div class="col-md-3">
          <label class="form-label">Tahun Pelajaran</label>
          <select name="tp_id" class="form-select">
            <option value="">-- Semua Tahun --</option>
            <?php foreach ($tp_list as $tp): ?>
              <option value="<?= $tp['id'] ?>" <?= (($filters['tahun_pelajaran_id'] ?? '') == $tp['id']) ? 'selected' : '' ?>>
                <?= html_escape($tp['tahun']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Semester -->
        <div class="col-md-3">
          <label class="form-label">Semester</label>
          <select name="semester" class="form-select">
            <option value="">-- Semua Semester --</option>
            <option value="Ganjil" <?= (($filters['semester'] ?? '') == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
            <option value="Genap" <?= (($filters['semester'] ?? '') == 'Genap') ? 'selected' : '' ?>>Genap</option>
          </select>
        </div>

        <!-- Guru -->
        <div class="col-md-3">
          <label class="form-label">Guru</label>
          <select name="guru_id" class="form-select">
            <option value="">-- Semua Guru --</option>
            <?php foreach ($guru_list as $g): ?>
              <option value="<?= $g['id'] ?>" <?= (($filters['guru_id'] ?? '') == $g['id']) ? 'selected' : '' ?>>
                <?= html_escape($g['nama_lengkap']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Form Supervisi -->
        <div class="col-md-3">
          <label class="form-label">Form Supervisi</label>
          <select name="form_id" class="form-select">
            <option value="">-- Semua Form --</option>
            <?php foreach ($form_list as $f): ?>
              <option value="<?= $f['id'] ?>" <?= (($filters['form_id'] ?? '') == $f['id']) ? 'selected' : '' ?>>
                <?= html_escape($f['kode_form']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Status -->
        <div class="col-md-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="">-- Semua Status --</option>
            <option value="DRAFT" <?= (($filters['status'] ?? '') == 'DRAFT') ? 'selected' : '' ?>>Draft</option>
            <option value="DALAM PROSES" <?= (($filters['status'] ?? '') == 'DALAM PROSES') ? 'selected' : '' ?>>Dalam Proses</option>
            <option value="SELESAI" <?= (($filters['status'] ?? '') == 'SELESAI') ? 'selected' : '' ?>>Selesai</option>
          </select>
        </div>

        <!-- Search Text -->
        <div class="col-md-6">
          <label class="form-label">Pencarian Kata Kunci</label>
          <input type="text" name="search" class="form-control" placeholder="Cari nama guru, supervisor, mapel..." value="<?= html_escape($filters['search'] ?? '') ?>">
        </div>

        <!-- Submit & Reset -->
        <div class="col-md-3 d-flex align-items-end gap-2">
          <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-1"></i> Terapkan Filter</button>
          <a href="<?= base_url('supervisi/rekap') ?>" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Master Table Card -->
  <div class="card border-0 shadow-sm mb-5">
    <div class="table-responsive">
      <table class="table table-vcenter card-table table-hover">
        <thead>
          <tr class="bg-light">
            <th class="w-1">No</th>
            <th>Guru</th>
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            <th>Supervisor</th>
            <th>Form</th>
            <th>Tanggal</th>
            <th>Skor</th>
            <th>Nilai Akhir</th>
            <th>Status</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($rekap_list)): ?>
            <tr>
              <td colspan="11" class="text-center py-5 text-muted">Tidak ada data supervisi yang sesuai dengan filter.</td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($rekap_list as $row): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <div class="fw-bold text-dark"><?= html_escape($row['nama_guru']) ?></div>
                  <div class="small text-muted">NIP: <?= html_escape($row['nip_guru'] ?? '-') ?></div>
                </td>
                <td><?= html_escape($row['nama_mapel'] ?? '-') ?></td>
                <td><span class="badge bg-blue-lt"><?= html_escape($row['nama_kelas'] ?? '-') ?></span></td>
                <td>
                  <div class="small fw-semibold"><?= html_escape($row['nama_supervisor'] ?? 'Supervisor') ?></div>
                  <div class="small text-muted"><?= html_escape($row['supervisor_role']) ?></div>
                </td>
                <td><span class="badge bg-indigo-lt"><?= html_escape($row['kode_form']) ?></span></td>
                <td><?= date('d/m/Y', strtotime($row['tanggal_supervisi'])) ?></td>
                <td class="small fw-bold text-muted"><?= $row['jumlah_skor'] ?> / <?= $row['skor_maksimal'] ?></td>
                <td>
                  <span class="fw-bold fs-3 <?= $row['nilai_akhir'] >= 80 ? 'text-success' : ($row['nilai_akhir'] >= 70 ? 'text-primary' : 'text-warning') ?>">
                    <?= number_format($row['nilai_akhir'], 1) ?>
                  </span>
                </td>
                <td>
                  <?php if ($row['status'] == 'SELESAI'): ?>
                    <span class="badge bg-success">Selesai</span>
                  <?php elseif ($row['status'] == 'DALAM PROSES'): ?>
                    <span class="badge bg-warning">Dalam Proses</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">Draft</span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <div class="btn-list flex-nowrap justify-content-end">
                    <a href="<?= base_url('supervisi/form' . $row['form_id'] . '?id=' . $row['id']) ?>" class="btn btn-sm btn-outline-primary" title="Buka Instrument">
                      <i class="ti ti-edit"></i>
                    </a>
                    <a href="<?= base_url('supervisi/print_form/' . $row['id']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="Cetak Fisik">
                      <i class="ti ti-printer"></i>
                    </a>
                    <a href="<?= base_url('supervisi/export_pdf/' . $row['id']) ?>" target="_blank" class="btn btn-sm btn-outline-danger" title="Download PDF">
                      <i class="ti ti-file-pdf"></i>
                    </a>
                    <?php if (in_array($user_role, array('admin', 'superadmin', 'kamad', 'waka'))): ?>
                      <button type="button" class="btn btn-sm btn-outline-danger btn-delete-supervisi" data-id="<?= $row['id'] ?>" data-name="<?= html_escape($row['nama_guru']) ?> (<?= html_escape($row['kode_form']) ?>)" title="Hapus Supervisi">
                        <i class="ti ti-trash"></i>
                      </button>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
