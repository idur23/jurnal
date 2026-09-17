<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-file-report me-2 text-danger"></i> LAPORAN PRESENSI MBF
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <div class="row row-cards">
      <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom py-3">
            <h3 class="card-title text-dark mb-0"><i class="ti ti-printer me-2 text-primary"></i> CETAK & EXPORT LAPORAN PRESENSI MBF</h3>
          </div>
          <div class="card-body">
            <form action="<?= base_url('mbf/export_pdf') ?>" method="GET" target="_blank" id="formLaporanMBF">

              <div class="mb-3">
                <label class="form-label required">Tahun Pelajaran</label>
                <select name="tahun_pelajaran_id" class="form-select" required>
                  <?php foreach ($list_tp as $tp): ?>
                    <option value="<?= $tp['id'] ?>" <?= ($active_tp && $active_tp['id'] == $tp['id']) ? 'selected' : '' ?>>
                      <?= html_escape($tp['tahun']) ?> (Semester <?= html_escape($tp['semester']) ?>)
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label required">Mapel MBF</label>
                <select name="mapel_id" class="form-select" required>
                  <option value="">-- Pilih Mapel MBF --</option>
                  <?php foreach ($list_mapel as $m): ?>
                    <option value="<?= $m['id'] ?>">
                      <?= html_escape($m['nama_mapel']) ?> (Tentor: <?= html_escape($m['nama_tentor']) ?>)
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <hr>

              <div class="d-flex gap-2 justify-content-center pt-2">
                <button type="submit" class="btn btn-danger px-4 shadow-sm">
                  <i class="ti ti-file-type-pdf me-1"></i> Download PDF
                </button>
                <button type="button" class="btn btn-success px-4 shadow-sm" onclick="exportExcel()">
                  <i class="ti ti-file-spreadsheet me-1"></i> Download Excel
                </button>
                <button type="button" class="btn btn-info px-4 shadow-sm" onclick="printReport()">
                  <i class="ti ti-printer me-1"></i> Print Laporan
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
function exportExcel() {
  const form = document.getElementById('formLaporanMBF');
  const mapel_id = form.elements['mapel_id'].value;
  const tp_id = form.elements['tahun_pelajaran_id'].value;

  if (!mapel_id) {
    alert('Silakan pilih Mapel MBF terlebih dahulu.');
    return;
  }

  window.location.href = '<?= base_url("mbf/export_excel") ?>?mapel_id=' + mapel_id + '&tahun_pelajaran_id=' + tp_id;
}

function printReport() {
  const form = document.getElementById('formLaporanMBF');
  const mapel_id = form.elements['mapel_id'].value;
  const tp_id = form.elements['tahun_pelajaran_id'].value;

  if (!mapel_id) {
    alert('Silakan pilih Mapel MBF terlebih dahulu.');
    return;
  }

  window.open('<?= base_url("mbf/print_rekap") ?>?mapel_id=' + mapel_id + '&tahun_pelajaran_id=' + tp_id, '_blank');
}
</script>
