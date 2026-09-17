<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-user-check me-2 text-warning"></i> DATA PRESENSI MBF
        </h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <button type="button" class="btn btn-warning text-white fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPresensi">
          <i class="ti ti-plus me-1"></i> Input Presensi Baru
        </button>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <!-- FLASH MESSAGES -->
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check me-2 fs-3"></i> <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ti ti-alert-circle me-2 fs-3"></i> <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- FILTER -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title text-dark mb-0"><i class="ti ti-filter me-2 text-info"></i> FILTER PRESENSI MBF</h3>
      </div>
      <div class="card-body">
        <form action="<?= base_url('mbf/presensi') ?>" method="GET" class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Mapel MBF</label>
            <select name="mapel_id" class="form-select">
              <option value="">-- Semua Mapel --</option>
              <?php foreach ($list_mapel as $m): ?>
                <option value="<?= $m['id'] ?>" <?= (isset($filters['mapel_mbf_id']) && $filters['mapel_mbf_id'] == $m['id']) ? 'selected' : '' ?>>
                  <?= html_escape($m['nama_mapel']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Tentor</label>
            <select name="tentor_id" class="form-select">
              <option value="">-- Semua Tentor --</option>
              <?php foreach ($list_tentor as $t): ?>
                <option value="<?= $t['id'] ?>" <?= (isset($filters['tentor_id']) && $filters['tentor_id'] == $t['id']) ? 'selected' : '' ?>>
                  <?= html_escape($t['nama_lengkap']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="<?= html_escape($filters['tanggal_mulai'] ?? '') ?>">
          </div>

          <div class="col-md-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" value="<?= html_escape($filters['tanggal_selesai'] ?? '') ?>">
          </div>

          <div class="col-12 text-end d-flex gap-2 justify-content-end">
            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-search me-1"></i> Tampilkan</button>
            <a href="<?= base_url('mbf/presensi') ?>" class="btn btn-outline-secondary"><i class="ti ti-refresh"></i> Reset</a>
          </div>
        </form>
      </div>
    </div>

    <!-- LOG TABLE -->
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h3 class="card-title text-dark mb-0"><i class="ti ti-list me-2"></i> LOG KELUARAN PRESENSI MBF</h3>
        <span class="badge bg-warning-lt fs-3 px-3"><?= count($logs) ?> Pertemuan Record</span>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter table-hover card-table">
          <thead class="bg-light">
            <tr>
              <th width="40">No</th>
              <th>Tanggal & Waktu</th>
              <th>Pertemuan</th>
              <th>Mapel & Ruangan</th>
              <th>Tentor Pengajar</th>
              <th>Materi Pembahasan</th>
              <th class="text-center">Hadir</th>
              <th class="text-center">Izin</th>
              <th class="text-center">Sakit</th>
              <th class="text-center">Alpa</th>
              <th class="text-center">Foto / Catatan</th>
              <th class="text-center" width="120">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($logs)): ?>
              <?php $no = 1; foreach ($logs as $l): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td>
                    <div class="fw-bold text-dark"><?= date('d-m-Y', strtotime($l['tanggal'])) ?></div>
                    <div class="small text-muted"><i class="ti ti-clock me-1"></i><?= html_escape($l['jam_mulai'] ?? '-') ?> - <?= html_escape($l['jam_selesai'] ?? '-') ?></div>
                  </td>
                  <td class="text-center">
                    <span class="badge bg-secondary-lt">Ke-<?= $l['pertemuan_ke'] ?></span>
                    <span class="badge bg-info-lt d-block mt-1"><?= html_escape($l['status_sesi'] ?? 'Selesai') ?></span>
                  </td>
                  <td>
                    <div class="fw-bold text-primary"><?= html_escape($l['nama_mapel_custom'] ? $l['nama_mapel_custom'] : $l['nama_mapel']) ?></div>
                    <div class="small text-muted"><i class="ti ti-building me-1"></i><?= html_escape($l['ruangan'] ? $l['ruangan'] : 'Kode: ' . $l['kode_mapel']) ?></div>
                  </td>
                  <td><i class="ti ti-user-check me-1 text-info"></i> <?= html_escape($l['nama_tentor']) ?></td>
                  <td><span class="small text-dark fw-semibold"><?= html_escape($l['materi_pembahasan'] ? $l['materi_pembahasan'] : '-') ?></span></td>
                  <td class="text-center"><span class="badge bg-success-lt fs-3"><?= (int)$l['count_hadir'] ?></span></td>
                  <td class="text-center"><span class="badge bg-info-lt fs-3"><?= (int)$l['count_izin'] ?></span></td>
                  <td class="text-center"><span class="badge bg-warning-lt fs-3"><?= (int)$l['count_sakit'] ?></span></td>
                  <td class="text-center"><span class="badge bg-danger-lt fs-3"><?= (int)$l['count_alpa'] ?></span></td>
                  <td class="text-center">
                    <?php 
                      $foto_url = '';
                      if (!empty($l['foto_dokumentasi'])) {
                        $p = $l['foto_dokumentasi'];
                        if (strpos($p, 'http://') === 0 || strpos($p, 'https://') === 0) {
                          $foto_url = $p;
                        } else {
                          $foto_url = base_url(ltrim($p, '/'));
                        }
                      }
                      
                      $notes_arr = array();
                      if (!empty($l['catatan_tentor'])) {
                        $notes_arr[] = $l['catatan_tentor'];
                      }
                      if (!empty($l['catatan']) && !in_array($l['catatan'], $notes_arr)) {
                        $notes_arr[] = $l['catatan'];
                      }
                      if (empty($notes_arr) && !empty($l['materi_pembahasan'])) {
                        $notes_arr[] = $l['materi_pembahasan'];
                      }
                      $note_text = !empty($notes_arr) ? implode(' • ', $notes_arr) : '-';
                    ?>
                    <?php if (!empty($foto_url)): ?>
                      <a href="<?= $foto_url ?>" target="_blank" class="btn btn-sm btn-outline-info p-1 px-2 mb-1" title="Lihat Foto Dokumentasi">
                        <i class="ti ti-photo me-1"></i> Foto
                      </a>
                    <?php endif; ?>
                    <div class="small text-muted" title="<?= html_escape($note_text) ?>"><?= html_escape($note_text) ?></div>
                  </td>
                  <td class="text-center text-nowrap">
                    <button type="button" class="btn btn-icon btn-sm btn-outline-info me-1" onclick="viewDetail(<?= $l['id'] ?>)" title="Detail Log">
                      <i class="ti ti-eye"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-sm btn-outline-warning me-1" onclick="editPresensi(<?= $l['id'] ?>)" title="Edit Log">
                      <i class="ti ti-edit"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-sm btn-outline-danger" onclick="confirmDelete(<?= $l['id'] ?>, '<?= date('d-m-Y', strtotime($l['tanggal'])) ?>', '<?= html_escape(addslashes($l['nama_mapel_custom'] ? $l['nama_mapel_custom'] : $l['nama_mapel'])) ?>')" title="Hapus Log">
                      <i class="ti ti-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="12" class="text-center text-muted py-4">Belum ada data presensi MBF yang sesuai.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- MODAL TAMBAH PRESENSI -->
<div class="modal modal-blur fade" id="modalTambahPresensi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('mbf/presensi') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">
        
        <div class="modal-header bg-warning text-white py-3">
          <h5 class="modal-title fw-bold"><i class="ti ti-user-check me-2"></i> Input Presensi & Jurnal MBF Baru</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label required">Mapel MBF</label>
              <select name="mapel_mbf_id" id="tambah_mapel_id" class="form-select" required onchange="loadPesertaTambah(this.value)">
                <option value="">-- Pilih Mapel MBF --</option>
                <?php foreach ($list_mapel as $m): ?>
                  <option value="<?= $m['id'] ?>"><?= html_escape($m['nama_mapel']) ?> (Tentor: <?= html_escape($m['nama_tentor']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label required">Tanggal</label>
              <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Pertemuan Ke-</label>
              <input type="number" name="pertemuan_ke" class="form-control" placeholder="Otomatis / 1">
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <label class="form-label">Status Sesi</label>
              <select name="status_sesi" class="form-select">
                <option value="Selesai" selected>Selesai</option>
                <option value="Terjadwal">Terjadwal</option>
                <option value="Diganti">Diganti</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Ruangan / Tempat</label>
              <input type="text" name="ruangan" class="form-control" placeholder="Contoh: R. Lab Komputer / Kelas 9A">
            </div>
            <div class="col-md-2">
              <label class="form-label">Jam Mulai</label>
              <input type="time" name="jam_mulai" class="form-control" value="12:35">
            </div>
            <div class="col-md-2">
              <label class="form-label">Jam Selesai</label>
              <input type="time" name="jam_selesai" class="form-control" value="14:05">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Materi Pembahasan</label>
            <input type="text" name="materi_pembahasan" class="form-control" placeholder="Contoh: Coding Expert - Algoritma Dasar">
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Catatan Tentor / Kegiatan</label>
              <textarea name="catatan_tentor" class="form-control" rows="2" placeholder="Catatan selama kegiatan MBF..."></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Foto Dokumentasi (Ter-sync Drive)</label>
              <input type="file" name="foto_dokumentasi" class="form-control" accept="image/*">
              <div class="form-hint">Format JPG/PNG (Maks 3MB). Otomatis disinkronkan ke Google Drive folder MBF.</div>
            </div>
          </div>

          <hr class="my-3">
          <h4 class="card-title mb-2 text-dark"><i class="ti ti-users me-1"></i> Data Kehadiran Siswa</h4>
          <div id="tambah_siswa_container" class="table-responsive border rounded p-2 bg-light">
            <div class="text-muted text-center py-4">Silakan pilih Mapel MBF terlebih dahulu untuk menampilkan daftar siswa.</div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning text-white px-4"><i class="ti ti-device-floppy me-1"></i> Simpan Data Presensi</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT PRESENSI -->
<div class="modal modal-blur fade" id="modalEditPresensi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('mbf/presensi') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" id="edit_id">
        <input type="hidden" name="mapel_mbf_id" id="edit_mapel_mbf_id">

        <div class="modal-header bg-primary text-white py-3">
          <h5 class="modal-title fw-bold"><i class="ti ti-edit me-2"></i> Edit Presensi & Jurnal MBF</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Mapel MBF</label>
              <input type="text" id="edit_nama_mapel" class="form-control bg-light" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label required">Tanggal</label>
              <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Pertemuan Ke-</label>
              <input type="number" name="pertemuan_ke" id="edit_pertemuan_ke" class="form-control">
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <label class="form-label">Status Sesi</label>
              <select name="status_sesi" id="edit_status_sesi" class="form-select">
                <option value="Selesai">Selesai</option>
                <option value="Terjadwal">Terjadwal</option>
                <option value="Diganti">Diganti</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Ruangan / Tempat</label>
              <input type="text" name="ruangan" id="edit_ruangan" class="form-control">
            </div>
            <div class="col-md-2">
              <label class="form-label">Jam Mulai</label>
              <input type="time" name="jam_mulai" id="edit_jam_mulai" class="form-control">
            </div>
            <div class="col-md-2">
              <label class="form-label">Jam Selesai</label>
              <input type="time" name="jam_selesai" id="edit_jam_selesai" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Materi Pembahasan</label>
            <input type="text" name="materi_pembahasan" id="edit_materi_pembahasan" class="form-control">
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Catatan Tentor / Kegiatan</label>
              <textarea name="catatan_tentor" id="edit_catatan_tentor" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Ganti Foto Dokumentasi (Opsional)</label>
              <input type="file" name="foto_dokumentasi" class="form-control" accept="image/*">
              <div id="edit_foto_preview" class="mt-2"></div>
            </div>
          </div>

          <hr class="my-3">
          <h4 class="card-title mb-2 text-dark"><i class="ti ti-users me-1"></i> Update Kehadiran Siswa</h4>
          <div id="edit_siswa_container" class="table-responsive border rounded p-2 bg-light">
            <div class="text-muted text-center py-4">Memuat data siswa...</div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check me-1"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL DETAIL PRESENSI -->
<div class="modal modal-blur fade" id="modalDetailPresensi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white py-3">
        <h5 class="modal-title fw-bold"><i class="ti ti-file-text me-2"></i> Detail Log Presensi MBF</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="detail_body">
        <div class="text-center py-4"><div class="spinner-border text-info" role="status"></div></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL HAPUS PRESENSI -->
<div class="modal modal-blur fade" id="modalHapusPresensi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('mbf/presensi') ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" id="delete_id">
        <div class="modal-body text-center py-4">
          <i class="ti ti-alert-triangle text-danger display-3 mb-2"></i>
          <h3>Konfirmasi Hapus</h3>
          <div class="text-muted mb-2">Apakah Anda yakin ingin menghapus data presensi MBF tanggal <strong id="delete_tgl"></strong> untuk mapel <strong id="delete_mapel"></strong>?</div>
          <div class="small text-danger">Tindakan ini tidak dapat dibatalkan.</div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger px-4">Hapus Presensi</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function loadPesertaTambah(mapelId) {
  const container = document.getElementById('tambah_siswa_container');
  if (!container) return;

  if (!mapelId) {
    container.innerHTML = '<div class="text-muted text-center py-4"><i class="ti ti-info-circle me-1"></i> Silakan pilih Mapel MBF terlebih dahulu untuk menampilkan daftar siswa.</div>';
    return;
  }

  container.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-warning" role="status"></div><div class="mt-2 text-muted small">Memuat daftar siswa MBF...</div></div>';
  fetch('<?= base_url("mbf/get_peserta_json/") ?>' + mapelId)
    .then(res => {
      if (!res.ok) throw new Error('HTTP ' + res.status);
      return res.json();
    })
    .then(data => {
      if (!data || data.length === 0) {
        container.innerHTML = '<div class="text-warning text-center py-4"><i class="ti ti-alert-circle me-1 fs-2 d-block mb-2"></i> Belum ada siswa yang terdaftar pada Mapel MBF ini.<br><a href="<?= base_url("mbf/peserta/") ?>' + mapelId + '" class="btn btn-sm btn-outline-primary mt-2"><i class="ti ti-user-plus me-1"></i> Klik di sini untuk Kelola & Tambah Peserta MBF</a></div>';
        return;
      }
      let html = '<table class="table table-sm table-vcenter card-table table-hover">';
      html += '<thead class="bg-light"><tr><th>No</th><th>Nama Siswa</th><th>Kelas</th><th class="text-center">Status Kehadiran</th><th>Catatan</th></tr></thead><tbody>';
      data.forEach((s, idx) => {
        html += `<tr>
          <td>${idx + 1}</td>
          <td><div class="fw-semibold text-dark">${s.nama_lengkap}</div><div class="small text-muted">NIS: ${s.nis || '-'}</div></td>
          <td><span class="badge bg-secondary-lt">${s.nama_kelas || '-'}</span></td>
          <td class="text-center text-nowrap">
            <div class="btn-group btn-group-sm" role="group">
              <input type="radio" class="btn-check" name="presensi[${s.id}]" id="st_h_${s.id}" value="Hadir" checked>
              <label class="btn btn-outline-success" for="st_h_${s.id}">Hadir</label>
              
              <input type="radio" class="btn-check" name="presensi[${s.id}]" id="st_i_${s.id}" value="Izin">
              <label class="btn btn-outline-info" for="st_i_${s.id}">Izin</label>
              
              <input type="radio" class="btn-check" name="presensi[${s.id}]" id="st_s_${s.id}" value="Sakit">
              <label class="btn btn-outline-warning" for="st_s_${s.id}">Sakit</label>
              
              <input type="radio" class="btn-check" name="presensi[${s.id}]" id="st_a_${s.id}" value="Alpa">
              <label class="btn btn-outline-danger" for="st_a_${s.id}">Alpa</label>
            </div>
          </td>
          <td>
            <input type="text" name="catatan_siswa[${s.id}]" class="form-control form-control-sm" placeholder="Catatan khusus...">
          </td>
        </tr>`;
      });
      html += '</tbody></table>';
      container.innerHTML = html;
    })
    .catch(err => {
      console.error('Error fetching peserta:', err);
      container.innerHTML = '<div class="text-danger text-center py-4"><i class="ti ti-alert-triangle me-1 fs-2 d-block mb-2"></i> Gagal memuat data siswa. Silakan coba pilih ulang Mapel MBF.</div>';
    });
}

function viewDetail(id) {
  const body = document.getElementById('detail_body');
  body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-info"></div></div>';
  const modal = new bootstrap.Modal(document.getElementById('modalDetailPresensi'));
  modal.show();

  fetch('<?= base_url("mbf/get_presensi_json/") ?>' + id)
    .then(res => res.json())
    .then(data => {
      if (!data) {
        body.innerHTML = '<div class="text-danger text-center">Data tidak ditemukan.</div>';
        return;
      }
      let photoHtml = '';
      if (data.foto_dokumentasi) {
        let photoSrc = data.foto_dokumentasi;
        if (!photoSrc.startsWith('http://') && !photoSrc.startsWith('https://')) {
          photoSrc = '<?= base_url() ?>' + photoSrc.replace(/^\/+/, '');
        }
        photoHtml = `<div class="mb-3 text-center">
          <img src="${photoSrc}" class="img-fluid rounded border shadow-sm" style="max-height:250px;">
          <div class="small text-muted mt-1"><a href="${photoSrc}" target="_blank" class="btn btn-sm btn-outline-info mt-1"><i class="ti ti-external-link me-1"></i> Buka Foto Ukuran Penuh</a></div>
        </div>`;
      }

      let notesList = [];
      if (data.catatan_tentor) notesList.push(data.catatan_tentor);
      if (data.catatan && !notesList.includes(data.catatan)) notesList.push(data.catatan);
      let noteText = notesList.length > 0 ? notesList.join(' • ') : '-';

      let html = `
        ${photoHtml}
        <div class="row g-2 mb-3 bg-light p-3 rounded">
          <div class="col-md-6"><strong>Mapel:</strong> ${data.nama_mapel_custom ? data.nama_mapel_custom : data.nama_mapel} (${data.kode_mapel})</div>
          <div class="col-md-6"><strong>Tentor Pengajar:</strong> ${data.nama_tentor}</div>
          <div class="col-md-6"><strong>Tanggal & Waktu:</strong> ${data.tanggal} (${data.jam_mulai || '-'} - ${data.jam_selesai || '-'})</div>
          <div class="col-md-6"><strong>Ruangan & Sesi:</strong> ${data.ruangan || '-'} (${data.status_sesi || 'Selesai'})</div>
          <div class="col-12"><strong>Materi Pembahasan:</strong> ${data.materi_pembahasan || '-'}</div>
          <div class="col-12"><strong>Catatan Tentor / Kegiatan:</strong> ${noteText}</div>
        </div>
        <h5 class="fw-bold mb-2">Daftar Kehadiran Siswa</h5>
        <div class="table-responsive">
          <table class="table table-sm table-vcenter card-table">
            <thead><tr><th>No</th><th>Nama Siswa</th><th>Kelas</th><th class="text-center">Status</th><th>Catatan</th></tr></thead>
            <tbody>`;
      if (data.details && data.details.length > 0) {
        data.details.forEach((d, idx) => {
          let badgeClass = 'bg-secondary';
          if (d.status === 'Hadir') badgeClass = 'bg-success';
          else if (d.status === 'Izin') badgeClass = 'bg-info';
          else if (d.status === 'Sakit') badgeClass = 'bg-warning';
          else if (d.status === 'Alpa') badgeClass = 'bg-danger';

          html += `<tr>
            <td>${idx + 1}</td>
            <td><div class="fw-bold">${d.nama_siswa}</div><div class="small text-muted">NIS: ${d.nis || '-'}</div></td>
            <td><span class="badge bg-secondary-lt">${d.nama_kelas || '-'}</span></td>
            <td class="text-center"><span class="badge ${badgeClass} text-white">${d.status}</span></td>
            <td><span class="small text-muted">${d.catatan || '-'}</span></td>
          </tr>`;
        });
      } else {
        html += '<tr><td colspan="5" class="text-center text-muted">Tidak ada detail peserta.</td></tr>';
      }
      html += '</tbody></table></div>';
      body.innerHTML = html;
    });
}

function editPresensi(id) {
  const modal = new bootstrap.Modal(document.getElementById('modalEditPresensi'));
  modal.show();

  const container = document.getElementById('edit_siswa_container');
  container.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>';

  fetch('<?= base_url("mbf/get_presensi_json/") ?>' + id)
    .then(res => res.json())
    .then(data => {
      document.getElementById('edit_id').value = data.id;
      document.getElementById('edit_mapel_mbf_id').value = data.mapel_mbf_id;
      document.getElementById('edit_nama_mapel').value = data.nama_mapel_custom ? data.nama_mapel_custom : data.nama_mapel;
      document.getElementById('edit_tanggal').value = data.tanggal;
      document.getElementById('edit_pertemuan_ke').value = data.pertemuan_ke;
      document.getElementById('edit_status_sesi').value = data.status_sesi || 'Selesai';
      document.getElementById('edit_ruangan').value = data.ruangan || '';
      document.getElementById('edit_jam_mulai').value = data.jam_mulai || '';
      document.getElementById('edit_jam_selesai').value = data.jam_selesai || '';
      document.getElementById('edit_materi_pembahasan').value = data.materi_pembahasan || '';
      document.getElementById('edit_catatan_tentor').value = data.catatan_tentor || data.catatan || '';

      const fotoPrev = document.getElementById('edit_foto_preview');
      if (data.foto_dokumentasi) {
        fotoPrev.innerHTML = `<small class="text-success"><i class="ti ti-check me-1"></i> Foto ada: <a href="<?= base_url() ?>${data.foto_dokumentasi}" target="_blank">Lihat Foto</a></small>`;
      } else {
        fotoPrev.innerHTML = '<small class="text-muted">Belum ada foto dokumentasi.</small>';
      }

      let html = '<table class="table table-sm table-vcenter card-table">';
      html += '<thead><tr><th>No</th><th>Nama Siswa</th><th>Kelas</th><th class="text-center">Status Kehadiran</th><th>Catatan</th></tr></thead><tbody>';

      if (data.details && data.details.length > 0) {
        data.details.forEach((s, idx) => {
          const st = s.status || 'Hadir';
          html += `<tr>
            <td>${idx + 1}</td>
            <td><div class="fw-semibold text-dark">${s.nama_siswa}</div><div class="small text-muted">NIS: ${s.nis || '-'}</div></td>
            <td><span class="badge bg-secondary-lt">${s.nama_kelas || '-'}</span></td>
            <td class="text-center text-nowrap">
              <div class="btn-group btn-group-sm" role="group">
                <input type="radio" class="btn-check" name="presensi[${s.siswa_id}]" id="edit_st_h_${s.siswa_id}" value="Hadir" ${st === 'Hadir' ? 'checked' : ''}>
                <label class="btn btn-outline-success" for="edit_st_h_${s.siswa_id}">Hadir</label>
                
                <input type="radio" class="btn-check" name="presensi[${s.siswa_id}]" id="edit_st_i_${s.siswa_id}" value="Izin" ${st === 'Izin' ? 'checked' : ''}>
                <label class="btn btn-outline-info" for="edit_st_i_${s.siswa_id}">Izin</label>
                
                <input type="radio" class="btn-check" name="presensi[${s.siswa_id}]" id="edit_st_s_${s.siswa_id}" value="Sakit" ${st === 'Sakit' ? 'checked' : ''}>
                <label class="btn btn-outline-warning" for="edit_st_s_${s.siswa_id}">Sakit</label>
                
                <input type="radio" class="btn-check" name="presensi[${s.siswa_id}]" id="edit_st_a_${s.siswa_id}" value="Alpa" ${st === 'Alpa' ? 'checked' : ''}>
                <label class="btn btn-outline-danger" for="edit_st_a_${s.siswa_id}">Alpa</label>
              </div>
            </td>
            <td>
              <input type="text" name="catatan_siswa[${s.siswa_id}]" class="form-control form-control-sm" value="${s.catatan || ''}" placeholder="Catatan khusus...">
            </td>
          </tr>`;
        });
      } else {
        html += '<tr><td colspan="5" class="text-center text-muted">Tidak ada detail peserta.</td></tr>';
      }
      html += '</tbody></table>';
      container.innerHTML = html;
    });
}

function confirmDelete(id, tanggal, mapel) {
  document.getElementById('delete_id').value = id;
  document.getElementById('delete_tgl').textContent = tanggal;
  document.getElementById('delete_mapel').textContent = mapel;
  const modal = new bootstrap.Modal(document.getElementById('modalHapusPresensi'));
  modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
  const selectMapel = document.getElementById('tambah_mapel_id');
  if (selectMapel) {
    selectMapel.addEventListener('change', function() {
      loadPesertaTambah(this.value);
    });
    if (selectMapel.value) {
      loadPesertaTambah(selectMapel.value);
    }
  }

  const modalTambah = document.getElementById('modalTambahPresensi');
  if (modalTambah) {
    ['show.bs.modal', 'shown.bs.modal'].forEach(function(evt) {
      modalTambah.addEventListener(evt, function() {
        const select = document.getElementById('tambah_mapel_id');
        if (select && select.value) {
          loadPesertaTambah(select.value);
        }
      });
    });
  }
});
</script>
