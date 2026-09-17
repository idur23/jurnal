<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Perkembangan Diri Siswa</h2>
      <div class="text-muted small mt-1">Berikan catatan deskriptif perkembangan diri, kelebihan, kekurangan, motivasi, dan perilaku untuk membantu penyusunan rapor siswa.</div>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card mb-4">
  <div class="card-body">
    <form action="<?= base_url('perkembangan') ?>" method="GET" class="row g-3">
      <div class="col-md-5">
        <label class="form-label required">Kelas</label>
        <select name="kelas_id" class="form-select select2" required>
          <option value="">-- Pilih Kelas --</option>
          <?php foreach ($list_kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= (($selected_kelas_id ?? '') == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-5">
        <label class="form-label">Mata Pelajaran (Opsional)</label>
        <select name="mapel_id" class="form-select select2">
          <option value="">-- Pilih Mapel --</option>
          <?php foreach ($list_mapel as $m): ?>
            <option value="<?= $m['id'] ?>" <?= (($selected_mapel_id ?? '') == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100"><i class="ti ti-search me-1"></i> Cari</button>
      </div>
    </form>
  </div>
</div>

<?php if ($selected_kelas_id): ?>
  <?php if ($selected_mapel_id): ?>
    <form action="<?= base_url('perkembangan') ?>" method="POST">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
      <input type="hidden" name="action" value="save_perkembangan">
      <input type="hidden" name="kelas_id" value="<?= $selected_kelas_id ?>">
      <input type="hidden" name="mapel_id" value="<?= $selected_mapel_id ?>">
  <?php endif; ?>

  <div class="card mb-4">
    <div class="card-header bg-indigo text-white d-flex justify-content-between align-items-center">
      <h3 class="card-title text-white"><i class="ti ti-user-exclamation me-2"></i>Daftar Evaluasi Siswa</h3>
      <?php if (!$selected_mapel_id): ?>
        <span class="badge bg-white text-indigo fw-bold">Mode Rekapitulasi Kelas</span>
      <?php endif; ?>
    </div>
    <div class="card-body px-0">
      <div class="table-responsive">
        <table class="table table-vcenter card-table table-hover">
          <thead>
            <tr>
              <th style="width: 50px;">#</th>
              <th>Siswa</th>
              <?php if ($selected_mapel_id): ?>
                <th>Kelebihan & Kekurangan</th>
                <th>Perilaku & Motivasi</th>
                <th>Rekomendasi / Saran</th>
              <?php else: ?>
                <th>Status Perkembangan Akhir</th>
                <th>Kesimpulan Wali Kelas</th>
              <?php endif; ?>
              <th class="text-center" style="width: 250px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($siswa)): ?>
              <tr>
                <td colspan="<?= $selected_mapel_id ? 6 : 5 ?>" class="text-center text-muted py-4">Tidak ada data siswa di kelas ini.</td>
              </tr>
            <?php else: ?>
              <?php $no=1; foreach ($siswa as $s): ?>
                <?php 
                  if ($selected_mapel_id) {
                    $d = isset($existing_data[$s['id']]) ? $existing_data[$s['id']] : array();
                    $cat = isset($d['catatan_perkembangan']) ? $d['catatan_perkembangan'] : '';
                    $kel = isset($d['kelebihan']) ? $d['kelebihan'] : '';
                    $kek = isset($d['kekurangan']) ? $d['kekurangan'] : '';
                    $per = isset($d['perilaku']) ? $d['perilaku'] : '';
                    $aktif = isset($d['keaktifan']) ? $d['keaktifan'] : '';
                    $dis = isset($d['kedisiplinan']) ? $d['kedisiplinan'] : '';
                    $mot = isset($d['motivasi']) ? $d['motivasi'] : '';
                    $rek = isset($d['rekomendasi']) ? $d['rekomendasi'] : '';
                  } else {
                    $r = isset($rekap_data[$s['id']]) ? $rekap_data[$s['id']] : array();
                    $status_rekap = isset($r['status_perkembangan']) ? $r['status_perkembangan'] : 'Baik';
                    $kesimpulan_rekap = isset($r['kesimpulan_wali']) ? $r['kesimpulan_wali'] : '-';
                  }
                ?>
                <!-- Main student info row -->
                <tr>
                  <td><?= $no++ ?></td>
                  <td>
                    <div class="fw-bold"><?= html_escape($s['nama_lengkap']) ?></div>
                    <div class="text-muted small">NIS: <?= html_escape($s['nis']) ?></div>
                  </td>
                  <?php if ($selected_mapel_id): ?>
                    <td>
                      <div class="small"><strong>Kelebihan:</strong> <?= $kel ? html_escape($kel) : '-' ?></div>
                      <div class="small text-danger"><strong>Kekurangan:</strong> <?= $kek ? html_escape($kek) : '-' ?></div>
                    </td>
                    <td>
                      <div class="small"><strong>Perilaku:</strong> <?= $per ? html_escape($per) : '-' ?></div>
                      <div class="small text-indigo"><strong>Motivasi:</strong> <?= $mot ? html_escape($mot) : '-' ?></div>
                    </td>
                    <td>
                      <div class="text-muted small"><?= $rek ? html_escape($rek) : 'Belum diisi' ?></div>
                    </td>
                  <?php else: ?>
                    <td>
                      <span class="badge bg-indigo-lt fw-bold"><?= html_escape($status_rekap) ?></span>
                    </td>
                    <td class="text-wrap" style="max-width: 250px;">
                      <div class="small text-muted text-truncate" style="max-width: 220px;" title="<?= html_escape($kesimpulan_rekap) ?>">
                        <?= html_escape($kesimpulan_rekap) ?>
                      </div>
                    </td>
                  <?php endif; ?>
                  <td class="text-center">
                    <div class="btn-list flex-nowrap justify-content-center">
                      <?php if ($selected_mapel_id): ?>
                        <button type="button" class="btn btn-sm btn-outline-indigo" data-bs-toggle="collapse" data-bs-target="#editRow_<?= $s['id'] ?>">
                          <i class="ti ti-edit me-1"></i> Edit Evaluasi
                        </button>
                      <?php endif; ?>
                      <a href="<?= base_url('perkembangan/profil/' . $s['id']) ?>" class="btn btn-sm btn-indigo text-white">
                        <i class="ti ti-user me-1"></i> Profil Perkembangan
                      </a>
                    </div>
                  </td>
                </tr>
                
                <?php if ($selected_mapel_id): ?>
                  <!-- Collapsible detail form row -->
                  <tr id="editRow_<?= $s['id'] ?>" class="collapse bg-light bg-opacity-50">
                    <td colspan="6">
                      <div class="p-3 border rounded bg-light-lt">
                        <h4 class="fw-bold text-indigo mb-3 border-bottom pb-1"><i class="ti ti-user me-1"></i>Form Evaluasi: <?= html_escape($s['nama_lengkap']) ?></h4>
                        <div class="row g-3">
                          <div class="col-md-6">
                            <label class="form-label">Catatan Perkembangan Umum</label>
                            <textarea name="catatan_perkembangan[<?= $s['id'] ?>]" class="form-control form-control-sm" rows="2" placeholder="Catatan perkembangan belajar siswa secara umum..."><?= html_escape($cat) ?></textarea>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label text-success">Kelebihan Siswa</label>
                            <input type="text" name="kelebihan[<?= $s['id'] ?>]" class="form-control form-control-sm" value="<?= html_escape($kel) ?>" placeholder="Misal: Cepat memahami logika algoritma">
                          </div>
                          <div class="col-md-3">
                            <label class="form-label text-danger">Kekurangan Siswa</label>
                            <input type="text" name="kekurangan[<?= $s['id'] ?>]" class="form-control form-control-sm" value="<?= html_escape($kek) ?>" placeholder="Misal: Kurang teliti dalam perhitungan">
                          </div>
                          
                          <div class="col-md-3">
                            <label class="form-label">Sikap / Perilaku</label>
                            <select name="perilaku[<?= $s['id'] ?>]" class="form-select form-select-sm">
                              <option value="Sangat Baik" <?= ($per == 'Sangat Baik') ? 'selected' : '' ?>>Sangat Baik</option>
                              <option value="Baik" <?= ($per == 'Baik' || !$per) ? 'selected' : '' ?>>Baik</option>
                              <option value="Cukup" <?= ($per == 'Cukup') ? 'selected' : '' ?>>Cukup</option>
                              <option value="Kurang" <?= ($per == 'Kurang') ? 'selected' : '' ?>>Kurang</option>
                            </select>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label">Tingkat Keaktifan</label>
                            <select name="keaktifan[<?= $s['id'] ?>]" class="form-select form-select-sm">
                              <option value="Sangat Aktif" <?= ($aktif == 'Sangat Aktif') ? 'selected' : '' ?>>Sangat Aktif</option>
                              <option value="Aktif" <?= ($aktif == 'Aktif' || !$aktif) ? 'selected' : '' ?>>Aktif</option>
                              <option value="Cukup Aktif" <?= ($aktif == 'Cukup Aktif') ? 'selected' : '' ?>>Cukup Aktif</option>
                              <option value="Pasif" <?= ($aktif == 'Pasif') ? 'selected' : '' ?>>Pasif</option>
                            </select>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label">Tingkat Kedisiplinan</label>
                            <select name="kedisiplinan[<?= $s['id'] ?>]" class="form-select form-select-sm">
                              <option value="Sangat Disiplin" <?= ($dis == 'Sangat Disiplin') ? 'selected' : '' ?>>Sangat Disiplin</option>
                              <option value="Disiplin" <?= ($dis == 'Disiplin' || !$dis) ? 'selected' : '' ?>>Disiplin</option>
                              <option value="Cukup Disiplin" <?= ($dis == 'Cukup Disiplin') ? 'selected' : '' ?>>Cukup Disiplin</option>
                              <option value="Kurang Disiplin" <?= ($dis == 'Kurang Disiplin') ? 'selected' : '' ?>>Kurang Disiplin</option>
                            </select>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label">Motivasi Belajar</label>
                            <select name="motivasi[<?= $s['id'] ?>]" class="form-select form-select-sm">
                              <option value="Sangat Tinggi" <?= ($mot == 'Sangat Tinggi') ? 'selected' : '' ?>>Sangat Tinggi</option>
                              <option value="Tinggi" <?= ($mot == 'Tinggi' || !$mot) ? 'selected' : '' ?>>Tinggi</option>
                              <option value="Sedang" <?= ($mot == 'Sedang') ? 'selected' : '' ?>>Sedang</option>
                              <option value="Rendah" <?= ($mot == 'Rendah') ? 'selected' : '' ?>>Rendah</option>
                            </select>
                          </div>
                          <div class="col-12">
                            <label class="form-label">Rekomendasi / Saran Guru</label>
                            <input type="text" name="rekomendasi[<?= $s['id'] ?>]" class="form-control form-control-sm" value="<?= html_escape($rek) ?>" placeholder="Tuliskan saran untuk bimbingan di rumah atau peningkatan belajarnya...">
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endif; ?>

              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    
    <?php if ($selected_mapel_id): ?>
      <div class="card-footer text-end">
        <button type="submit" class="btn btn-indigo btn-lg fw-bold"><i class="ti ti-device-floppy me-2"></i> Simpan Catatan Perkembangan Diri</button>
      </div>
      </form>
    <?php endif; ?>
  </div>

<?php else: ?>
  <div class="card card-body text-center text-muted py-5 mb-4">
    <i class="ti ti-info-circle fs-1 text-indigo mb-2"></i>
    <h3>Silakan pilih Kelas terlebih dahulu.</h3>
    <p class="mb-0">Pilih filter kelas binaan/diampu di atas lalu klik tombol <strong>Cari</strong> untuk memuat data perkembangan diri siswa.</p>
  </div>
<?php endif; ?>

