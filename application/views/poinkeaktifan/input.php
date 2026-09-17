<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Poin Keaktifan Siswa</div>
      <h2 class="page-title"><i class="ti ti-star text-warning me-2"></i>Input Poin Keaktifan - Jurnal <?= html_escape($jurnal['kode_jurnal']) ?></h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
      <a href="<?= base_url('jurnal/detail/' . $jurnal['id']) ?>" class="btn btn-outline-secondary me-2">
        <i class="ti ti-eye me-1"></i> Detail Jurnal
      </a>
      <a href="<?= base_url('poinkeaktifan') ?>" class="btn btn-secondary">
        <i class="ti ti-arrow-left me-1"></i> Kembali ke Rekap
      </a>
    </div>
  </div>
</div>

<!-- Header Context Info -->
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body bg-light-subtle rounded-3 p-4">
    <div class="row g-3">
      <div class="col-md-3 col-6 border-end">
        <div class="text-muted small">Tanggal Pembelajaran</div>
        <div class="fw-bold fs-4 text-dark"><i class="ti ti-calendar me-1 text-primary"></i><?= format_indo_date($jurnal['tanggal']) ?></div>
      </div>
      <div class="col-md-3 col-6 border-end">
        <div class="text-muted small">Kelas</div>
        <div class="fw-bold fs-4 text-dark"><i class="ti ti-school me-1 text-info"></i><?= html_escape($jurnal['nama_kelas']) ?></div>
      </div>
      <div class="col-md-3 col-6 border-end">
        <div class="text-muted small">Mata Pelajaran</div>
        <div class="fw-bold fs-4 text-dark"><i class="ti ti-book me-1 text-success"></i><?= html_escape($jurnal['nama_mapel']) ?></div>
      </div>
      <div class="col-md-3 col-6">
        <div class="text-muted small">Guru Pengampu</div>
        <div class="fw-bold fs-4 text-dark"><i class="ti ti-user-check me-1 text-indigo"></i><?= html_escape($jurnal['nama_guru']) ?></div>
      </div>
      <div class="col-12 mt-3 pt-2 border-top">
        <div class="text-muted small">Materi Pembelajaran:</div>
        <div class="fw-semibold text-secondary"><?= html_escape($jurnal['materi_pembelajaran']) ?></div>
      </div>
    </div>
  </div>
</div>

<!-- Main Table Input Poin -->
<div class="card shadow-sm">
  <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
    <h3 class="card-title text-white mb-0">
      <i class="ti ti-users me-2"></i>Daftar Siswa Kelas <?= html_escape($jurnal['nama_kelas']) ?>
    </h3>
    <span class="badge bg-warning text-dark fw-bold"><i class="ti ti-info-circle me-1"></i>Poin Tambah/Kurang Manual</span>
  </div>

  <div class="table-responsive">
    <table class="table table-vcenter card-table table-hover">
      <thead>
        <tr class="bg-light">
          <th style="width: 50px;">#</th>
          <th>NIS / NISN</th>
          <th>Nama Siswa</th>
          <th style="width: 80px;" class="text-center">JK</th>
          <th class="text-center" style="width: 250px;">Poin Keaktifan Sesi Ini</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($students)): ?>
          <tr>
            <td colspan="5" class="text-center text-muted py-4">
              Tidak ada data siswa aktif di kelas ini.
            </td>
          </tr>
        <?php else: ?>
          <?php $no = 1; foreach ($students as $s): ?>
            <tr id="row-siswa-<?= $s['siswa_id'] ?>">
              <td><?= $no++ ?></td>
              <td><code><?= html_escape($s['nis']) ?></code></td>
              <td class="fw-bold text-dark">
                <?= html_escape($s['nama_lengkap']) ?>
              </td>
              <td class="text-center">
                <span class="badge bg-secondary-lt"><?= html_escape($s['jk']) ?></span>
              </td>
              <td class="text-center">
                <div class="d-inline-flex align-items-center justify-content-center gap-2 p-1 bg-light rounded-pill border">
                  <!-- Button Decrement -->
                  <button type="button" 
                          class="btn btn-sm btn-outline-danger rounded-circle p-0 d-flex align-items-center justify-content-center btn-poin-adj" 
                          style="width: 34px; height: 34px;"
                          data-siswa-id="<?= $s['siswa_id'] ?>"
                          data-action="sub"
                          title="Kurangi 1 Poin">
                    <i class="ti ti-minus fs-3"></i>
                  </button>

                  <!-- Point Value Display -->
                  <span class="fw-bold fs-3 px-3 text-primary poin-display" id="poin-val-<?= $s['siswa_id'] ?>">
                    <?= (int)$s['poin'] ?>
                  </span>

                  <!-- Button Increment -->
                  <button type="button" 
                          class="btn btn-sm btn-outline-success rounded-circle p-0 d-flex align-items-center justify-content-center btn-poin-adj" 
                          style="width: 34px; height: 34px;"
                          data-siswa-id="<?= $s['siswa_id'] ?>"
                          data-action="add"
                          title="Tambah 1 Poin">
                    <i class="ti ti-plus fs-3"></i>
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="card-footer d-flex justify-content-between align-items-center bg-light">
    <div class="text-muted small">
      <i class="ti ti-info-circle me-1 text-info"></i> Seluruh perubahan poin otomatis tersimpan secara real-time via AJAX ke database.
    </div>
    <a href="<?= base_url('poinkeaktifan') ?>" class="btn btn-success fw-bold">
      <i class="ti ti-check me-1"></i> Selesai & Lihat Rekap
    </a>
  </div>
</div>

<!-- AJAX Script for Point Increments/Decrements -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const jurnalId = <?= (int)$jurnal['id'] ?>;
  let csrfName = '<?= $this->security->get_csrf_token_name() ?>';
  let csrfHash = '<?= $this->security->get_csrf_hash() ?>';

  document.querySelectorAll('.btn-poin-adj').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      
      const button = this;
      const siswaId = button.getAttribute('data-siswa-id');
      const action = button.getAttribute('data-action');
      const displayElem = document.getElementById('poin-val-' + siswaId);
      
      if (button.disabled) return;

      // Anti Double Click: Disable buttons for this student temporarily
      const parentContainer = button.closest('.d-inline-flex');
      const allBtns = parentContainer.querySelectorAll('.btn-poin-adj');
      allBtns.forEach(b => b.disabled = true);

      // Prepare Form Data
      const formData = new FormData();
      formData.append('jurnal_id', jurnalId);
      formData.append('siswa_id', siswaId);
      formData.append('action', action);
      formData.append(csrfName, csrfHash);

      // Send AJAX Request
      fetch('<?= base_url('poinkeaktifan/update_poin_ajax') ?>', {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        // Update CSRF Hash if returned
        if (data.csrf_token) {
          csrfHash = data.csrf_token;
        }

        if (data.status) {
          // Update Display Poin with smooth animation
          displayElem.textContent = data.data.new_poin;
          displayElem.classList.add('text-success', 'scale-125');
          setTimeout(() => {
            displayElem.classList.remove('text-success', 'scale-125');
          }, 300);
        } else {
          alert(data.message || 'Gagal mengubah poin.');
        }
      })
      .catch(error => {
        console.error('Error updating point:', error);
        alert('Terjadi kesalahan koneksi server.');
      })
      .finally(() => {
        // Re-enable buttons
        allBtns.forEach(b => b.disabled = false);
      });
    });
  });
});
</script>

<style>
.scale-125 {
  transform: scale(1.25);
  transition: transform 0.2s ease-in-out;
}
</style>
