<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Validasi & Preview Import Nilai</h2>
      <div class="text-muted small mt-1">Lakukan pemeriksaan akhir terhadap data nilai yang di-upload sebelum disimpan ke sistem.</div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger" role="alert">
        <div class="d-flex">
          <div><i class="ti ti-alert-triangle fs-2 me-2"></i></div>
          <div>
            <h4 class="alert-title fw-bold">Ditemukan Kesalahan Validasi Data!</h4>
            <div class="text-muted">Terdapat <?= count($errors) ?> baris bermasalah. Anda harus memperbaiki baris-baris ini di file Excel Anda dan mengunggahnya kembali. Tombol simpan dinonaktifkan.</div>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-success" role="alert">
        <div class="d-flex">
          <div><i class="ti ti-check fs-2 me-2"></i></div>
          <div>
            <h4 class="alert-title fw-bold">Validasi Berhasil!</h4>
            <div class="text-muted">Seluruh baris data nilai terverifikasi dan siap di-import. Periksa data di bawah sebelum menyimpan.</div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Metadata Card -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="text-muted">Kelas:</div>
            <div class="h3 fw-bold text-primary"><?= html_escape($kelas['nama_kelas']) ?></div>
          </div>
          <div class="col-md-3">
            <div class="text-muted">Mata Pelajaran:</div>
            <div class="h3 fw-bold text-primary"><?= html_escape($mapel['nama_mapel']) ?></div>
          </div>
          <div class="col-md-3">
            <div class="text-muted">Kategori:</div>
            <div class="h3 fw-bold text-success"><?= html_escape(ucfirst(str_replace('_', ' ', $jenis_penilaian))) ?></div>
          </div>
          <div class="col-md-3">
            <div class="text-muted">Nama Penilaian:</div>
            <div class="h3 fw-bold text-success"><?= html_escape($nama_penilaian) ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Errors Table if any -->
    <?php if (!empty($errors)): ?>
      <div class="card mb-4 border-danger">
        <div class="card-header bg-danger text-white">
          <h3 class="card-title text-white"><i class="ti ti-bug me-2"></i>Daftar Baris Error</h3>
        </div>
        <div class="table-responsive">
          <table class="table table-vcenter card-table">
            <thead>
              <tr class="bg-red-lt text-red">
                <th>Baris Excel</th>
                <th>NIS</th>
                <th>Nama Input</th>
                <th>Nilai Input</th>
                <th>Catatan Input</th>
                <th>Penyebab Error</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($errors as $e): ?>
                <tr>
                  <td>Row <?= $e['row'] ?></td>
                  <td><code><?= html_escape($e['nis']) ?></code></td>
                  <td><?= html_escape($e['nama']) ?></td>
                  <td class="fw-bold text-danger"><?= html_escape($e['nilai']) ?></td>
                  <td><?= html_escape($e['catatan']) ?></td>
                  <td><span class="badge bg-danger text-white"><?= html_escape($e['message']) ?></span></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <!-- Preview Table -->
    <div class="card mb-4">
      <div class="card-header">
        <h3 class="card-title"><i class="ti ti-eye me-2"></i>Preview Data Nilai (Total: <?= count($import_rows) ?> baris)</h3>
      </div>
      <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
        <table class="table table-vcenter table-striped card-table">
          <thead>
            <tr>
              <th style="width: 50px;">#</th>
              <th>NIS</th>
              <th>Nama Siswa</th>
              <th>Nilai</th>
              <th>Catatan</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach ($import_rows as $row): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><code><?= html_escape($row['nis']) ?></code></td>
                <td class="fw-bold"><?= html_escape($row['nama']) ?></td>
                <td class="fw-bold text-indigo"><?= html_escape($row['nilai']) ?></td>
                <td><?= html_escape($row['catatan']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer d-flex justify-content-between">
        <a href="<?= base_url("penilaian?kelas_id={$kelas['id']}&mapel_id={$mapel['id']}&jenis_penilaian=$jenis_penilaian") ?>" class="btn btn-outline-secondary">
          <i class="ti ti-arrow-left me-1"></i> Kembali ke Form Entry
        </a>
        
        <?php if (empty($errors)): ?>
          <form action="<?= base_url('penilaian/import') ?>" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="action" value="confirm_save">
            <input type="hidden" name="kelas_id" value="<?= $kelas['id'] ?>">
            <input type="hidden" name="mapel_id" value="<?= $mapel['id'] ?>">
            <input type="hidden" name="jenis_penilaian" value="<?= $jenis_penilaian ?>">
            <input type="hidden" name="nama_penilaian" value="<?= html_escape($nama_penilaian) ?>">
            <input type="hidden" name="file_name" value="<?= html_escape($file_name) ?>">
            
            <button type="submit" class="btn btn-success fw-bold">
              <i class="ti ti-device-floppy me-2"></i> Konfirmasi & Simpan Nilai
            </button>
          </form>
        <?php else: ?>
          <button type="button" class="btn btn-success fw-bold" disabled>
            <i class="ti ti-device-floppy me-2"></i> Konfirmasi & Simpan Nilai
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
