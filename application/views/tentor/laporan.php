<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL TENTOR MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-file-report me-2 text-danger"></i> LAPORAN PRESENSI MBF SAYA
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
            <h3 class="card-title text-dark mb-0"><i class="ti ti-printer me-2 text-primary"></i> CETAK & EXPORT LAPORAN PRESENSI</h3>
          </div>
          <div class="card-body">
            <form action="<?= base_url('tentor/export_pdf') ?>" method="GET" target="_blank" id="formLaporanTentor">

              <div class="mb-3">
                <label class="form-label required">Mapel MBF Saya</label>
                <select name="mapel_id" class="form-select fs-3" required>
                  <?php foreach ($mapel_list as $m): ?>
                    <option value="<?= $m['id'] ?>">
                      <?= html_escape($m['nama_mapel']) ?> (<?= html_escape($m['kode_mapel']) ?>)
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <hr>

              <div class="d-flex gap-2 justify-content-center pt-2">
                <button type="submit" class="btn btn-danger px-4 shadow-sm">
                  <i class="ti ti-file-type-pdf me-1"></i> Download PDF
                </button>
                <button type="button" class="btn btn-success px-4 shadow-sm" onclick="exportExcelTentor()">
                  <i class="ti ti-file-spreadsheet me-1"></i> Download Excel
                </button>
                <button type="button" class="btn btn-info px-4 shadow-sm" onclick="printReportTentor()">
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
function exportExcelTentor() {
  const form = document.getElementById('formLaporanTentor');
  const mapel_id = form.elements['mapel_id'].value;

  if (!mapel_id) {
    alert('Silakan pilih Mapel MBF terlebih dahulu.');
    return;
  }

  window.location.href = '<?= base_url("tentor/export_excel") ?>?mapel_id=' + mapel_id;
}

function printReportTentor() {
  const form = document.getElementById('formLaporanTentor');
  const mapel_id = form.elements['mapel_id'].value;

  if (!mapel_id) {
    alert('Silakan pilih Mapel MBF terlebih dahulu.');
    return;
  }

  window.open('<?= base_url("tentor/print_rekap") ?>?mapel_id=' + mapel_id, '_blank');
}
</script>
