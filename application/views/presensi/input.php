<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Presensi</div>
      <h2 class="page-title">Pencatatan Kehadiran Siswa</h2>
      <div class="text-muted small mt-1">Sesi KBM: Kelas <?= html_escape($pk['nama_kelas']) ?> | Mapel: <?= html_escape($pk['nama_mapel']) ?> | Pertemuan Ke: <?= html_escape($pk['pertemuan_ke']) ?></div>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('presensi') ?>" class="btn btn-secondary">
        <i class="ti ti-arrow-left me-1"></i> Kembali
      </a>
    </div>
  </div>
</div>

<form action="<?= base_url('presensi/input/' . $pk['id']) ?>" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

  <div class="card mb-4">
    <div class="card-header bg-indigo text-white d-flex justify-content-between align-items-center">
      <h3 class="card-title text-white"><i class="ti ti-users me-2"></i>Daftar Kehadiran Siswa</h3>
      <button type="button" class="btn btn-sm btn-success fw-bold" id="setAllHadir">
        <i class="ti ti-check me-1"></i> Set Semua HADIR
      </button>
    </div>
    <div class="table-responsive">
      <table class="table table-vcenter card-table table-hover table-striped">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th class="text-center" style="width: 380px;">Status Kehadiran</th>
            <th>Catatan Khusus</th>
            <th style="width: 250px;">Bukti Surat / Surat Izin</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; foreach ($list_siswa as $s): 
            $existing = isset($existing_presensi[$s['id']]) ? $existing_presensi[$s['id']] : array();
            $status = isset($existing['status']) ? $existing['status'] : 'Hadir';
            $catatan = isset($existing['catatan']) ? $existing['catatan'] : '';
            $bukti = isset($existing['bukti_izin']) ? $existing['bukti_izin'] : '';
          ?>
            <tr class="align-middle">
              <td><?= $no++ ?></td>
              <td><code><?= html_escape($s['nis']) ?></code></td>
              <td>
                <div class="fw-bold"><?= html_escape($s['nama_lengkap']) ?></div>
                <div class="text-muted small"><?= ($s['jk'] == 'L') ? 'Laki-laki' : 'Perempuan' ?></div>
              </td>
              <td>
                <div class="d-flex justify-content-center gap-1">
                  <!-- Hadir -->
                  <input type="radio" class="btn-check btn-status" name="presensi[<?= $s['id'] ?>]" id="status_h_<?= $s['id'] ?>" value="Hadir" autocomplete="off" <?= ($status == 'Hadir') ? 'checked' : '' ?>>
                  <label class="btn btn-outline-success btn-sm px-2 fw-semibold" style="width: 65px;" for="status_h_<?= $s['id'] ?>">Hadir</label>
                  
                  <!-- Sakit -->
                  <input type="radio" class="btn-check btn-status" name="presensi[<?= $s['id'] ?>]" id="status_s_<?= $s['id'] ?>" value="Sakit" autocomplete="off" <?= ($status == 'Sakit') ? 'checked' : '' ?>>
                  <label class="btn btn-outline-info btn-sm px-2 fw-semibold" style="width: 65px;" for="status_s_<?= $s['id'] ?>">Sakit</label>
                  
                  <!-- Izin -->
                  <input type="radio" class="btn-check btn-status" name="presensi[<?= $s['id'] ?>]" id="status_i_<?= $s['id'] ?>" value="Izin" autocomplete="off" <?= ($status == 'Izin') ? 'checked' : '' ?>>
                  <label class="btn btn-outline-warning btn-sm px-2 fw-semibold" style="width: 65px;" for="status_i_<?= $s['id'] ?>">Izin</label>
                  
                  <!-- Terlambat -->
                  <input type="radio" class="btn-check btn-status" name="presensi[<?= $s['id'] ?>]" id="status_t_<?= $s['id'] ?>" value="Terlambat" autocomplete="off" <?= ($status == 'Terlambat') ? 'checked' : '' ?>>
                  <label class="btn btn-outline-secondary btn-sm px-2 fw-semibold" style="width: 80px;" for="status_t_<?= $s['id'] ?>">Terlambat</label>
                  
                  <!-- Alpa -->
                  <input type="radio" class="btn-check btn-status" name="presensi[<?= $s['id'] ?>]" id="status_a_<?= $s['id'] ?>" value="Alpa" autocomplete="off" <?= ($status == 'Alpa') ? 'checked' : '' ?>>
                  <label class="btn btn-outline-danger btn-sm px-2 fw-semibold" style="width: 65px;" for="status_a_<?= $s['id'] ?>">Alpa</label>
                </div>
              </td>
              <td>
                <input type="text" name="catatan[<?= $s['id'] ?>]" class="form-control form-control-sm" value="<?= html_escape($catatan) ?>" placeholder="Sebab terlambat/sakit...">
              </td>
              <td>
                <div class="d-flex flex-column gap-1">
                  <input type="file" name="bukti_file_<?= $s['id'] ?>" class="form-control form-control-sm">
                  <?php if ($bukti): ?>
                    <div class="text-muted small">
                      <a href="<?= base_url($bukti) ?>" target="_blank" class="badge bg-green-lt"><i class="ti ti-file me-1"></i> Lihat Bukti Surat</a>
                    </div>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="card-footer text-end bg-light">
      <button type="submit" class="btn btn-indigo btn-lg fw-bold px-4 py-2">
        <i class="ti ti-device-floppy me-2"></i> Simpan Presensi Siswa
      </button>
    </div>
  </div>
</form>

<script>
  $(document).ready(function() {
    // Set all students to Hadir
    $('#setAllHadir').click(function() {
      $('.btn-status[value="Hadir"]').prop('checked', true);
    });
  });
</script>
