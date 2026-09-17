<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Informasi Detail</div>
      <h2 class="page-title">Jurnal Pembelajaran <?= html_escape($jurnal['kode_jurnal']) ?></h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
      <button onclick="window.print()" class="btn btn-outline-secondary"><i class="ti ti-printer me-1"></i> Cetak Dokumen</button>
      <a href="<?= base_url('jurnal') ?>" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i> Kembali</a>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="text-muted small">Tahun Pelajaran / Semester</label>
        <div class="fw-bold fs-3"><?= html_escape($jurnal['tahun']) ?> (<?= html_escape($jurnal['semester']) ?>)</div>
      </div>
      <div class="col-md-6 mb-3 text-md-end">
        <label class="text-muted small">Status Jurnal</label>
        <div><?= get_badge_jurnal_status($jurnal['status']) ?></div>
      </div>

      <div class="col-md-4 mb-3">
        <label class="text-muted small">Tanggal KBM</label>
        <div class="fw-bold"><?= format_indo_date($jurnal['tanggal']) ?></div>
      </div>
      <div class="col-md-4 mb-3">
        <label class="text-muted small">Kelas & Jam ke-</label>
        <div class="fw-bold"><?= html_escape($jurnal['nama_kelas']) ?> (Jam ke-<?= html_escape($jurnal['jam_ke']) ?>)</div>
      </div>
      <div class="col-md-4 mb-3">
        <label class="text-muted small">Mata Pelajaran & Guru</label>
        <div class="fw-bold"><?= html_escape($jurnal['nama_mapel']) ?> - <?= html_escape($jurnal['nama_guru']) ?></div>
      </div>

      <div class="col-12 mb-3">
        <label class="text-muted small">Materi Pembelajaran / Pokok Bahasan</label>
        <div class="p-3 bg-light rounded text-dark fw-bold"><?= nl2br(html_escape($jurnal['materi_pembelajaran'])) ?></div>
      </div>

      <!-- Rencana Pelaksanaan & Detail Pembelajaran -->
      <?php 
        $cp_val = !empty($jurnal['capaian_pembelajaran']) ? $jurnal['capaian_pembelajaran'] : ($jurnal['pa_cp'] ?? '');
        $tp_val = !empty($jurnal['tujuan_pembelajaran']) ? $jurnal['tujuan_pembelajaran'] : ($jurnal['pa_tp'] ?? '');
        $metode_val = !empty($jurnal['metode_pembelajaran']) ? $jurnal['metode_pembelajaran'] : ($jurnal['pa_metode'] ?? '');
        $model_val = !empty($jurnal['model_pembelajaran']) ? $jurnal['model_pembelajaran'] : ($jurnal['pa_model'] ?? '');
        $media_val = !empty($jurnal['media_pembelajaran']) ? $jurnal['media_pembelajaran'] : ($jurnal['pa_media'] ?? '');
        $sumber_val = !empty($jurnal['sumber_belajar']) ? $jurnal['sumber_belajar'] : ($jurnal['pa_sumber'] ?? '');
        $penilaian_val = !empty($jurnal['bentuk_penilaian']) ? $jurnal['bentuk_penilaian'] : ($jurnal['pa_penilaian'] ?? '');
        $alokasi_val = !empty($jurnal['alokasi_waktu']) ? $jurnal['alokasi_waktu'] : ($jurnal['pa_alokasi'] ?? '');
      ?>

      <?php if (!empty($jurnal['sub_materi'])): ?>
      <div class="col-md-12 mb-3">
        <label class="text-muted small fw-bold">Sub Materi Pembelajaran</label>
        <div class="p-2 bg-light rounded text-dark"><?= nl2br(html_escape($jurnal['sub_materi'])) ?></div>
      </div>
      <?php endif; ?>

      <?php if (!empty($cp_val)): ?>
      <div class="col-md-12 mb-3">
        <label class="text-muted small fw-bold">Capaian Pembelajaran (CP)</label>
        <div class="p-3 bg-indigo-lt rounded text-dark border border-indigo-subtle"><?= nl2br(html_escape($cp_val)) ?></div>
      </div>
      <?php endif; ?>

      <?php if (!empty($tp_val)): ?>
      <div class="col-md-12 mb-3">
        <label class="text-muted small fw-bold text-indigo">Tujuan Pembelajaran (TP)</label>
        <div class="p-3 bg-indigo-lt rounded text-dark border border-indigo fw-bold"><?= nl2br(html_escape($tp_val)) ?></div>
      </div>
      <?php endif; ?>

      <?php if (!empty($metode_val)): ?>
      <div class="col-md-6 mb-3">
        <label class="text-muted small fw-bold">Metode Pembelajaran</label>
        <div class="p-2 bg-light rounded text-dark"><?= nl2br(html_escape($metode_val)) ?></div>
      </div>
      <?php endif; ?>

      <?php if (!empty($model_val)): ?>
      <div class="col-md-6 mb-3">
        <label class="text-muted small fw-bold">Model Pembelajaran</label>
        <div class="p-2 bg-light rounded text-dark"><?= nl2br(html_escape($model_val)) ?></div>
      </div>
      <?php endif; ?>

      <?php if (!empty($media_val)): ?>
      <div class="col-md-6 mb-3">
        <label class="text-muted small fw-bold">Media Pembelajaran</label>
        <div class="p-2 bg-light rounded text-dark"><?= nl2br(html_escape($media_val)) ?></div>
      </div>
      <?php endif; ?>

      <?php if (!empty($sumber_val)): ?>
      <div class="col-md-6 mb-3">
        <label class="text-muted small fw-bold">Sumber Belajar</label>
        <div class="p-2 bg-light rounded text-dark"><?= nl2br(html_escape($sumber_val)) ?></div>
      </div>
      <?php endif; ?>

      <?php if (!empty($penilaian_val)): ?>
      <div class="col-md-6 mb-3">
        <label class="text-muted small fw-bold">Bentuk Penilaian / Asesmen</label>
        <div class="p-2 bg-light rounded text-dark"><?= nl2br(html_escape($penilaian_val)) ?></div>
      </div>
      <?php endif; ?>

      <?php if (!empty($alokasi_val)): ?>
      <div class="col-md-6 mb-3">
        <label class="text-muted small fw-bold">Alokasi Waktu</label>
        <div class="p-2 bg-light rounded text-dark"><?= nl2br(html_escape($alokasi_val)) ?></div>
      </div>
      <?php endif; ?>

      <?php if (!empty($jurnal['hambatan_solusi'])): ?>
      <div class="col-md-12 mb-3">
        <label class="text-muted small fw-bold">Catatan Hambatan & Solusi</label>
        <div class="p-2 bg-light rounded text-dark"><?= nl2br(html_escape($jurnal['hambatan_solusi'])) ?></div>
      </div>
      <?php endif; ?>

      <?php if (!empty($jurnal['file_dokumentasi'])): ?>
      <div class="col-12 mb-3">
        <label class="text-muted small">Dokumentasi Pembelajaran</label>
        <div>
          <?php 
            $file_url = base_url($jurnal['file_dokumentasi']);
            $media_src = gdrive_media_url($jurnal['file_dokumentasi']);
            $ext = pathinfo(parse_url($file_url, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (empty($ext) || in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif', 'webp')) || strpos($file_url, 'drive.google.com') !== false):
          ?>
            <img src="<?= $media_src ?>" class="img-fluid rounded border shadow-sm mb-2" style="max-height: 400px; display: block; margin-top: 5px;" alt="Dokumentasi KBM">
            <a href="<?= $file_url ?>" target="_blank" class="btn btn-outline-primary btn-sm">
              <i class="ti ti-external-link me-1"></i> Buka / Unduh File Dokumentasi
            </a>
          <?php else: ?>
            <a href="<?= $file_url ?>" target="_blank" class="btn btn-outline-primary btn-sm mt-1">
              <i class="ti ti-download me-1"></i> Unduh File Dokumentasi (<?= strtoupper($ext ? $ext : 'FILE') ?>)
            </a>
          <?php endif; ?>

        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Presensi Kelas Info & Kehadiran Siswa -->
<div class="row row-cards mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header bg-indigo text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title text-white"><i class="ti ti-building-community me-2"></i>Presensi Kelas & Keterlaksanaan Pembelajaran</h3>
        <?php if (!$presensi_kelas): ?>
          <span class="badge bg-danger text-white">Belum Dibuat</span>
        <?php else: ?>
          <span class="badge bg-success text-white">Sesi Aktif</span>
        <?php endif; ?>
      </div>
      <div class="card-body">
        <?php if (!$presensi_kelas): ?>
          <div class="text-center py-4">
            <p class="text-muted mb-3">Presensi Kelas belum dibuat untuk jurnal pembelajaran ini.</p>
            <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
              <a href="<?= base_url('presensikelas/add/' . $jurnal['id']) ?>" class="btn btn-indigo fw-bold">
                <i class="ti ti-plus me-1"></i> Buat Presensi Kelas Sekarang
              </a>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <div class="row">
            <div class="col-md-3 mb-2">
              <label class="text-muted small">Waktu KBM</label>
              <div class="fw-bold"><?= substr($presensi_kelas['jam_mulai'], 0, 5) ?> - <?= substr($presensi_kelas['jam_selesai'], 0, 5) ?></div>
            </div>
            <div class="col-md-3 mb-2">
              <label class="text-muted small">Pertemuan Ke-</label>
              <div class="fw-bold">Pertemuan <?= html_escape($presensi_kelas['pertemuan_ke']) ?></div>
            </div>
            <div class="col-md-3 mb-2">
              <label class="text-muted small">Status Keterlaksanaan</label>
              <div class="fw-bold">
                <?php if ($presensi_kelas['status_pembelajaran'] == 'Terlaksana'): ?>
                  <span class="badge bg-success text-white">Terlaksana</span>
                <?php elseif ($presensi_kelas['status_pembelajaran'] == 'Tidak Terlaksana'): ?>
                  <span class="badge bg-danger text-white">Tidak Terlaksana</span>
                <?php else: ?>
                  <span class="badge bg-indigo text-white"><?= html_escape($presensi_kelas['status_pembelajaran']) ?></span>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-md-3 mb-2">
              <label class="text-muted small">Ruangan KBM</label>
              <div class="fw-bold"><?= html_escape($presensi_kelas['nama_ruangan'] ?? '-') ?></div>
            </div>

            <?php if ($presensi_kelas['alasan_tidak_terlaksana']): ?>
              <div class="col-12 mb-2">
                <label class="text-muted small text-danger">Alasan Pembelajaran Tidak Terlaksana</label>
                <div class="p-2 border border-danger-subtle rounded text-danger bg-danger-lt"><?= nl2br(html_escape($presensi_kelas['alasan_tidak_terlaksana'])) ?></div>
              </div>
            <?php endif; ?>

            <?php if ($presensi_kelas['catatan_guru']): ?>
              <div class="col-12 mb-2">
                <label class="text-muted small">Catatan Pembelajaran Guru</label>
                <div class="p-2 bg-light rounded text-dark"><?= nl2br(html_escape($presensi_kelas['catatan_guru'])) ?></div>
              </div>
            <?php endif; ?>

            <?php if ($presensi_kelas['dokumentasi']): ?>
              <div class="col-12 mb-2">
                <label class="text-muted small">Dokumentasi Presensi Kelas</label>
                <div>
                  <img src="<?= gdrive_media_url($presensi_kelas['dokumentasi']) ?>" class="img-fluid rounded border" style="max-height: 250px;">
                </div>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php if ($presensi_kelas && $presensi_kelas['status_pembelajaran'] != 'Tidak Terlaksana'): ?>
  <!-- Rekapitulasi Presensi Table -->
  <div class="card">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
      <h3 class="card-title text-white"><i class="ti ti-user-check me-2"></i>Daftar Presensi Siswa Pertemuan Ini</h3>
      <?php if (empty($presensi) && in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
        <a href="<?= base_url('presensi/input/' . $presensi_kelas['id']) ?>" class="btn btn-sm btn-indigo text-white fw-bold">
          <i class="ti ti-plus me-1"></i> Isi Kehadiran Siswa
        </a>
      <?php endif; ?>
    </div>
    <div class="table-responsive">
      <table class="table table-vcenter card-table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>NIS / NISN</th>
            <th>Nama Siswa</th>
            <th>JK</th>
            <th>Status Kehadiran</th>
            <th>Catatan</th>
            <th>Bukti Surat</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($presensi)): ?>
            <tr>
              <td colspan="7" class="text-center text-muted py-4">Presensi siswa belum dicatat untuk sesi ini.</td>
            </tr>
          <?php else: ?>
            <?php $no=1; foreach ($presensi as $p): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><code><?= html_escape($p['nis']) ?></code></td>
                <td class="fw-bold"><?= html_escape($p['nama_lengkap']) ?></td>
                <td><span class="badge bg-secondary-lt"><?= html_escape($p['jk']) ?></span></td>
                <td><?= get_badge_presensi($p['status']) ?></td>
                <td><?= html_escape($p['catatan'] ?? '-') ?></td>
                <td>
                  <?php if ($p['bukti_izin']): ?>
                    <a href="<?= base_url($p['bukti_izin']) ?>" target="_blank" class="badge bg-green-lt"><i class="ti ti-file me-1"></i> Unduh Bukti</a>
                  <?php else: ?>
                    <span class="text-muted small">-</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

<!-- Poin Keaktifan Siswa Section -->
<div class="card mt-4 mb-4">
  <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
    <h3 class="card-title fw-bold text-dark mb-0">
      <i class="ti ti-star me-2"></i>Poin Keaktifan Siswa (Jurnal Sesi Ini)
    </h3>
    <a href="<?= base_url('poinkeaktifan/input/' . $jurnal['id']) ?>" class="btn btn-sm btn-dark text-white fw-bold">
      <i class="ti ti-edit me-1"></i> Kelola Poin Keaktifan
    </a>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped table-hover">
      <thead>
        <tr>
          <th style="width: 40px;">#</th>
          <th>NIS</th>
          <th>Nama Siswa</th>
          <th class="text-center" style="width: 60px;">JK</th>
          <th class="text-center" style="width: 220px;">Poin Keaktifan</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($poin_siswa)): ?>
          <tr>
            <td colspan="5" class="text-center text-muted py-3">Tidak ada data siswa untuk jurnal ini.</td>
          </tr>
        <?php else: ?>
          <?php $p_no = 1; foreach ($poin_siswa as $ps): ?>
            <tr>
              <td><?= $p_no++ ?></td>
              <td><code><?= html_escape($ps['nis']) ?></code></td>
              <td class="fw-bold text-dark"><?= html_escape($ps['nama_lengkap']) ?></td>
              <td class="text-center"><span class="badge bg-secondary-lt"><?= html_escape($ps['jk']) ?></span></td>
              <td class="text-center">
                <div class="d-inline-flex align-items-center justify-content-center gap-2 p-1 bg-light rounded-pill border">
                  <button type="button" 
                          class="btn btn-sm btn-outline-danger rounded-circle p-0 d-flex align-items-center justify-content-center btn-quick-poin" 
                          style="width: 28px; height: 28px;"
                          data-siswa-id="<?= $ps['siswa_id'] ?>"
                          data-action="sub">
                    <i class="ti ti-minus"></i>
                  </button>
                  <span class="fw-bold px-2 text-primary fs-3" id="quick-poin-val-<?= $ps['siswa_id'] ?>">
                    <?= (int)$ps['poin'] ?>
                  </span>
                  <button type="button" 
                          class="btn btn-sm btn-outline-success rounded-circle p-0 d-flex align-items-center justify-content-center btn-quick-poin" 
                          style="width: 28px; height: 28px;"
                          data-siswa-id="<?= $ps['siswa_id'] ?>"
                          data-action="add">
                    <i class="ti ti-plus"></i>
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const jurnalId = <?= (int)$jurnal['id'] ?>;
  let csrfName = '<?= $this->security->get_csrf_token_name() ?>';
  let csrfHash = '<?= $this->security->get_csrf_hash() ?>';

  document.querySelectorAll('.btn-quick-poin').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const button = this;
      const siswaId = button.getAttribute('data-siswa-id');
      const action = button.getAttribute('data-action');
      const displayElem = document.getElementById('quick-poin-val-' + siswaId);
      
      const parentContainer = button.closest('.d-inline-flex');
      const allBtns = parentContainer.querySelectorAll('.btn-quick-poin');
      allBtns.forEach(b => b.disabled = true);

      const formData = new FormData();
      formData.append('jurnal_id', jurnalId);
      formData.append('siswa_id', siswaId);
      formData.append('action', action);
      formData.append(csrfName, csrfHash);

      fetch('<?= base_url('poinkeaktifan/update_poin_ajax') ?>', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.csrf_token) csrfHash = data.csrf_token;
        if (data.status) {
          displayElem.textContent = data.data.new_poin;
        } else {
          alert(data.message || 'Gagal mengubah poin.');
        }
      })
      .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan koneksi server.');
      })
      .finally(() => {
        allBtns.forEach(b => b.disabled = false);
      });
    });
  });
});
</script>

