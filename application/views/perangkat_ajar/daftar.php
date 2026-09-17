<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Perangkat Ajar</div>
      <h2 class="page-title text-indigo"><i class="ti ti-list-details me-2"></i>Daftar Perangkat Ajar Guru</h2>
    </div>
    <div class="col-auto ms-auto">
      <div class="btn-list">
        <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'guru'))): ?>
          <a href="<?= base_url('perangkat_ajar/upload') ?>" class="btn btn-indigo">
            <i class="ti ti-upload me-1"></i> Unggah Perangkat Baru
          </a>
        <?php endif; ?>
        
        <!-- Dropdown Export -->
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ti ti-download me-1"></i> Ekspor Laporan
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#" id="btnExportPdf"><i class="ti ti-file-type-pdf text-danger me-2"></i> Ekspor PDF</a></li>
            <li><a class="dropdown-item" href="#" id="btnExportExcel"><i class="ti ti-file-spreadsheet text-success me-2"></i> Ekspor Excel</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filters Panel -->
<div class="card mb-4 border-light shadow-sm" style="border-radius: 12px;">
  <div class="card-header bg-light">
    <h3 class="card-title text-indigo"><i class="ti ti-filter me-2"></i>Filter Pencarian</h3>
  </div>
  <div class="card-body">
    <div class="row" id="filterForm">
      <div class="col-md-3 mb-3">
        <label class="form-label">Mata Pelajaran</label>
        <select id="filterMapel" class="form-select select2">
          <option value="">-- Semua Mapel --</option>
          <?php foreach ($list_mapel as $m): ?>
            <option value="<?= $m['id'] ?>"><?= html_escape($m['nama_mapel']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3 mb-3">
        <label class="form-label">Kelas</label>
        <select id="filterKelas" class="form-select select2">
          <option value="">-- Semua Kelas --</option>
          <?php foreach ($list_kelas as $k): ?>
            <option value="<?= $k['id'] ?>"><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'waka', 'kamad'))): ?>
        <div class="col-md-3 mb-3">
          <label class="form-label">Guru Pengampu</label>
          <select id="filterGuru" class="form-select select2">
            <option value="">-- Semua Guru --</option>
            <?php foreach ($list_guru as $g): ?>
              <option value="<?= $g['id'] ?>"><?= html_escape($g['nama_lengkap']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endif; ?>

      <div class="col-md-3 mb-3">
        <label class="form-label">Semester</label>
        <select id="filterSemester" class="form-select select2">
          <option value="">-- Semua Semester --</option>
          <option value="Ganjil">Ganjil</option>
          <option value="Genap">Genap</option>
        </select>
      </div>

      <div class="col-md-3 mb-3">
        <label class="form-label">Status Verifikasi</label>
        <select id="filterStatus" class="form-select select2">
          <option value="">-- Semua Status --</option>
          <option value="Draft">Draft</option>
          <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
          <option value="Disetujui">Disetujui</option>
          <option value="Revisi">Revisi</option>
          <option value="Ditolak">Ditolak</option>
        </select>
      </div>
    </div>
  </div>
</div>

<!-- Table -->
<div class="card shadow-sm" style="border-radius: 12px;">
  <div class="table-responsive p-3">
    <table id="tablePerangkat" class="table table-vcenter table-striped card-table w-100">
      <thead>
        <tr>
          <th>Jenis Perangkat</th>
          <th>Mata Pelajaran</th>
          <th>Kelas</th>
          <th>Guru Pengampu</th>
          <th>Semester / Pertemuan</th>
          <th>Versi</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function() {
    var table = $('#tablePerangkat').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url('perangkat_ajar/get_daftar_ajax') ?>",
        "type": "POST",
        "data": function(d) {
          d.mapel_id = $('#filterMapel').val();
          d.kelas_id = $('#filterKelas').val();
          d.semester = $('#filterSemester').val();
          d.status_verifikasi = $('#filterStatus').val();
          <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'waka', 'kamad'))): ?>
            d.guru_id = $('#filterGuru').val();
          <?php endif; ?>
          d.<?= $this->security->get_csrf_token_name(); ?> = "<?= $this->security->get_csrf_hash(); ?>";
        }
      },
      "columnDefs": [
        { "targets": [7], "orderable": false }
      ],
      "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
      }
    });

    // Reload on filter change
    $('#filterMapel, #filterKelas, #filterGuru, #filterSemester, #filterStatus').on('change', function() {
      table.ajax.reload();
    });

    // Export Reports
    $('#btnExportPdf').on('click', function(e) {
      e.preventDefault();
      var query = getFilterQueryString();
      window.open("<?= base_url('perangkat_ajar/export_report/pdf') ?>?" + query, '_blank');
    });

    $('#btnExportExcel').on('click', function(e) {
      e.preventDefault();
      var query = getFilterQueryString();
      window.location.href = "<?= base_url('perangkat_ajar/export_report/excel') ?>?" + query;
    });

    function getFilterQueryString() {
      var query = [];
      query.push("mapel_id=" + encodeURIComponent($('#filterMapel').val() || ''));
      query.push("kelas_id=" + encodeURIComponent($('#filterKelas').val() || ''));
      query.push("semester=" + encodeURIComponent($('#filterSemester').val() || ''));
      query.push("status_verifikasi=" + encodeURIComponent($('#filterStatus').val() || ''));
      <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'waka', 'kamad'))): ?>
        query.push("guru_id=" + encodeURIComponent($('#filterGuru').val() || ''));
      <?php endif; ?>
      return query.join("&");
    }
  });
</script>
