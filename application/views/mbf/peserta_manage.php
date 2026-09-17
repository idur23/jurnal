<style>
.student-card {
  transition: all 0.2s ease-in-out;
  border: 1px solid #e2e8f0 !important;
  background-color: #ffffff !important;
}
.student-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
}
.student-card.selected-card {
  border: 2px solid #2fb344 !important;
  background-color: #f0fdf4 !important;
}
.student-name {
  color: #1e293b !important;
  font-weight: 700 !important;
}
.student-sub {
  color: #64748b !important;
}
</style>

<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL MBF — KELOLA PESERTA</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-users me-2 text-emerald"></i> MAPEL: <?= html_escape($mapel['nama_mapel']) ?>
        </h2>
        <div class="text-muted small mt-1">
          Tentor: <strong class="text-primary"><?= html_escape($mapel['nama_tentor']) ?></strong> | Kode: <span class="badge bg-secondary-lt"><?= html_escape($mapel['kode_mapel']) ?></span>
        </div>
      </div>
      <div class="col-auto ms-auto">
        <a href="<?= base_url('mbf/mapel') ?>" class="btn btn-outline-secondary">
          <i class="ti ti-arrow-left me-1"></i> Kembali ke Mapel
        </a>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check me-2 fs-2"></i> <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ti ti-alert-circle me-2 fs-2"></i> <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('mbf/peserta/' . $mapel['id']) ?>" method="POST" id="formPeserta">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

      <!-- TOOLBAR & FILTER -->
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body py-3">
          <div class="row g-3 align-items-center">
            
            <!-- SEARCH SISWA -->
            <div class="col-md-5">
              <div class="input-icon">
                <span class="input-icon-addon"><i class="ti ti-search text-muted"></i></span>
                <input type="text" id="searchSiswa" class="form-control" placeholder="Cari Nama Siswa / NIS / NISN...">
              </div>
            </div>

            <!-- FILTER KELAS -->
            <div class="col-md-4">
              <select id="filterKelas" class="form-select">
                <option value="">-- Semua Kelas --</option>
                <?php foreach ($list_kelas as $k): ?>
                  <option value="<?= $k['id'] ?>"><?= html_escape($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="col-md-3 text-end d-flex gap-2 justify-content-end">
              <button type="button" class="btn btn-outline-primary btn-sm flex-fill" id="btnSelectAll">
                <i class="ti ti-check-all me-1"></i> Select All
              </button>
              <button type="button" class="btn btn-outline-warning btn-sm flex-fill" id="btnUnselectAll">
                <i class="ti ti-x me-1"></i> Unselect All
              </button>
            </div>

          </div>
        </div>
      </div>

      <!-- STUDENT SELECTION LIST -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
          <h3 class="card-title text-dark mb-0">
            <i class="ti ti-user-check me-2 text-success"></i> SISWA TERPILIH PESERTA MAPEL
            <span class="badge bg-success-lt fs-3 ms-2" id="countSelected">0 Siswa</span>
          </h3>
          <button type="submit" class="btn btn-success shadow-sm">
            <i class="ti ti-device-floppy me-1"></i> Simpan Peserta Mapel
          </button>
        </div>

        <div class="card-body bg-light">
          <div class="row row-cards" id="studentListContainer">
            <?php foreach ($all_siswa as $s): ?>
              <?php $is_enrolled = in_array($s['id'], $enrolled_ids); ?>
              <div class="col-sm-6 col-md-4 col-lg-3 student-item" data-kelas="<?= $s['kelas_id'] ?>" data-search="<?= strtolower(html_escape($s['nama_lengkap'] . ' ' . $s['nis'] . ' ' . $s['nisn'] . ' ' . $s['nama_kelas'])) ?>">
                <div class="card p-3 shadow-sm h-100 student-card <?= $is_enrolled ? 'selected-card' : '' ?>" style="cursor: pointer;" onclick="toggleStudentCheckbox(<?= $s['id'] ?>)">
                  <div class="d-flex align-items-center">
                    <div class="form-check me-3 mb-0">
                      <input class="form-check-input student-checkbox" type="checkbox" name="siswa_ids[]" value="<?= $s['id'] ?>" id="chk_<?= $s['id'] ?>" <?= $is_enrolled ? 'checked' : '' ?> onclick="event.stopPropagation(); updateCount();" style="transform: scale(1.2);">
                    </div>
                    <div class="overflow-hidden">
                      <div class="student-name fs-3 text-truncate"><?= html_escape($s['nama_lengkap']) ?></div>
                      <div class="student-sub small mt-1">
                        <span class="badge bg-secondary-lt me-1"><?= html_escape($s['nama_kelas']) ?></span>
                        <span>NIS: <?= html_escape($s['nis']) ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3">
          <span class="text-muted small">Centang siswa yang mengikuti Mapel <strong><?= html_escape($mapel['nama_mapel']) ?></strong>. Siswa dapat berasal dari kelas yang berbeda.</span>
          <button type="submit" class="btn btn-success shadow-sm">
            <i class="ti ti-device-floppy me-1"></i> Simpan Peserta Mapel
          </button>
        </div>
      </div>

    </form>

  </div>
</div>

<script>
function updateCount() {
  const checkboxes = document.querySelectorAll('.student-checkbox:checked');
  document.getElementById('countSelected').innerText = checkboxes.length + ' Siswa';

  // Highlight cards
  document.querySelectorAll('.student-card').forEach(card => {
    const chk = card.querySelector('.student-checkbox');
    if (chk && chk.checked) {
      card.classList.add('selected-card');
    } else {
      card.classList.remove('selected-card');
    }
  });
}

function toggleStudentCheckbox(id) {
  const chk = document.getElementById('chk_' + id);
  if (chk) {
    chk.checked = !chk.checked;
    updateCount();
  }
}

document.addEventListener('DOMContentLoaded', function() {
  updateCount();

  const searchInput = document.getElementById('searchSiswa');
  const filterKelas = document.getElementById('filterKelas');
  const btnSelectAll = document.getElementById('btnSelectAll');
  const btnUnselectAll = document.getElementById('btnUnselectAll');
  const items = document.querySelectorAll('.student-item');

  function filterStudents() {
    const q = searchInput.value.toLowerCase().trim();
    const k = filterKelas.value;

    items.forEach(item => {
      const text = item.getAttribute('data-search');
      const kelasId = item.getAttribute('data-kelas');

      const matchesSearch = !q || text.includes(q);
      const matchesKelas = !k || kelasId === k;

      if (matchesSearch && matchesKelas) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  }

  searchInput.addEventListener('input', filterStudents);
  filterKelas.addEventListener('change', filterStudents);

  btnSelectAll.addEventListener('click', function() {
    items.forEach(item => {
      if (item.style.display !== 'none') {
        const chk = item.querySelector('.student-checkbox');
        if (chk) chk.checked = true;
      }
    });
    updateCount();
  });

  btnUnselectAll.addEventListener('click', function() {
    items.forEach(item => {
      if (item.style.display !== 'none') {
        const chk = item.querySelector('.student-checkbox');
        if (chk) chk.checked = false;
      }
    });
    updateCount();
  });
});
</script>
