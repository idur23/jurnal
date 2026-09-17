<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title text-indigo"><i class="ti ti-edit me-2"></i>Edit Jurnal Pembelajaran: <?= html_escape($jurnal['kode_jurnal']) ?></h2>
      <div class="text-muted small mt-1">Perbarui detail jurnal kegiatan pembelajaran KBM.</div>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('jurnal') ?>" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i> Kembali</a>
    </div>
  </div>
</div>

<form action="<?= base_url('jurnal/edit/' . $jurnal['id']) ?>" method="POST" id="formEditJurnal" enctype="multipart/form-data">
  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
  <input type="hidden" name="perangkat_ajar_id" id="perangkatAjarId" value="<?= html_escape($jurnal['perangkat_ajar_id'] ?? '') ?>">

  <div class="row row-cards justify-content-center">
    <!-- Left Panel: Core Details -->
    <div class="col-lg-8">
      <div class="card mb-4 border-indigo shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-indigo text-white d-flex justify-content-between align-items-center">
          <h3 class="card-title text-white"><i class="ti ti-notebook me-2"></i>Detail Pembelajaran</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label required">Tanggal KBM</label>
              <input type="text" name="tanggal" class="form-control datepicker" value="<?= html_escape($jurnal['tanggal']) ?>" required>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label required">Kelas</label>
              <select name="kelas_id" id="selectKelas" class="form-select select2" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($list_kelas as $k): ?>
                  <option value="<?= $k['id'] ?>" <?= ($jurnal['kelas_id'] == $k['id']) ? 'selected' : '' ?>><?= html_escape($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label required">Mata Pelajaran</label>
              <select name="mapel_id" id="selectMapel" class="form-select select2" required>
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($list_mapel as $m): ?>
                  <option value="<?= $m['id'] ?>" <?= ($jurnal['mapel_id'] == $m['id']) ? 'selected' : '' ?>><?= html_escape($m['nama_mapel']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label required">Pertemuan Ke-</label>
              <input type="number" name="pertemuan_ke" id="pertemuanKe" class="form-control" min="1" value="<?= html_escape($jurnal['pertemuan_ke'] ?? '1') ?>" required>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label required">Jam Pelajaran</label>
              <div class="row g-1">
                <div class="col-6">
                  <select name="jam_mulai_ke" id="jamMulai" class="form-select select2" required>
                    <?php for ($i=1; $i<=10; $i++): ?>
                      <option value="<?= $i ?>" <?= ($jam_mulai_ke == $i) ? 'selected' : '' ?>>Jam ke-<?= $i ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
                <div class="col-6">
                  <select name="jam_selesai_ke" id="jamSelesai" class="form-select select2" required>
                    <?php for ($i=1; $i<=12; $i++): ?>
                      <option value="<?= $i ?>" <?= ($jam_selesai_ke == $i) ? 'selected' : '' ?>>s/d Jam ke-<?= $i ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>
            </div>

            <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'waka', 'kamad'))): ?>
            <div class="col-md-4 mb-3">
              <label class="form-label required">Guru Pengampu</label>
              <select name="guru_id" id="selectGuru" class="form-select select2" required>
                <option value="">-- Pilih Guru --</option>
                <?php foreach ($list_guru as $g): ?>
                  <option value="<?= $g['id'] ?>" <?= ($jurnal['guru_id'] == $g['id']) ? 'selected' : '' ?>><?= html_escape($g['nama_lengkap']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <?php else: ?>
              <input type="hidden" name="guru_id" id="selectGuru" value="<?= $jurnal['guru_id'] ?>">
            <?php endif; ?>

            <div class="col-md-12 mb-3">
              <label class="form-label required">Materi Pembelajaran</label>
              <input type="text" name="materi_pembelajaran" id="materiPembelajaran" class="form-control" placeholder="Tuliskan materi pokok..." value="<?= html_escape($jurnal['materi_pembelajaran']) ?>" required>
            </div>

            <div class="col-md-12 mb-3">
              <label class="form-label">Sub Materi</label>
              <textarea name="sub_materi" id="subMateri" class="form-control" rows="2" placeholder="Sub materi pokok..."><?= html_escape($jurnal['sub_materi']) ?></textarea>
            </div>

            <div class="col-md-12 mb-3">
              <label class="form-label">Capaian Pembelajaran (CP)</label>
              <textarea name="capaian_pembelajaran" id="capaianPembelajaran" class="form-control" rows="2" placeholder="Capaian Pembelajaran..."><?= html_escape($jurnal['capaian_pembelajaran']) ?></textarea>
            </div>

            <div class="col-md-12 mb-3">
              <label class="form-label">Tujuan Pembelajaran (TP)</label>
              <textarea name="tujuan_pembelajaran" id="tujuanPembelajaran" class="form-control" rows="2" placeholder="Tujuan Pembelajaran..."><?= html_escape($jurnal['tujuan_pembelajaran']) ?></textarea>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Metode Pembelajaran</label>
              <input type="text" name="metode_pembelajaran" id="metodePembelajaran" class="form-control" value="<?= html_escape($jurnal['metode_pembelajaran']) ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Model Pembelajaran</label>
              <input type="text" name="model_pembelajaran" id="modelPembelajaran" class="form-control" value="<?= html_escape($jurnal['model_pembelajaran']) ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Media Pembelajaran</label>
              <input type="text" name="media_pembelajaran" id="mediaPembelajaran" class="form-control" value="<?= html_escape($jurnal['media_pembelajaran']) ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Sumber Belajar</label>
              <input type="text" name="sumber_belajar" id="sumberBelajar" class="form-control" value="<?= html_escape($jurnal['sumber_belajar']) ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Bentuk Penilaian</label>
              <input type="text" name="bentuk_penilaian" id="bentukPenilaian" class="form-control" value="<?= html_escape($jurnal['bentuk_penilaian']) ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Alokasi Waktu</label>
              <input type="text" name="alokasi_waktu" id="alokasiWaktu" class="form-control" value="<?= html_escape($jurnal['alokasi_waktu']) ?>">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Panel: Teacher Input -->
    <div class="col-lg-4">
      <div class="card mb-4 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-light">
          <h3 class="card-title text-indigo"><i class="ti ti-edit me-2"></i>Catatan & Refleksi Guru</h3>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Catatan Pembelajaran</label>
            <textarea name="catatan_pembelajaran" class="form-control" rows="3" placeholder="Tuliskan catatan KBM..."><?= html_escape($jurnal['catatan_pembelajaran']) ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Refleksi Pembelajaran</label>
            <textarea name="refleksi_pembelajaran" class="form-control" rows="3" placeholder="Tuliskan refleksi..."><?= html_escape($jurnal['refleksi_pembelajaran']) ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Kendala KBM</label>
            <textarea name="kendala" class="form-control" rows="2" placeholder="Kendala KBM..."><?= html_escape($jurnal['kendala']) ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Solusi / Tindak Lanjut</label>
            <textarea name="solusi" class="form-control" rows="2" placeholder="Solusi KBM..."><?= html_escape($jurnal['solusi']) ?></textarea>
          </div>


        </div>
        <div class="card-footer bg-light" style="border-radius: 0 0 12px 12px;">
          <button type="submit" class="btn btn-primary w-100 fw-bold py-2"><i class="ti ti-device-floppy me-2"></i> Perbarui Jurnal Pembelajaran</button>
        </div>
      </div>
    </div>
  </div>
</form>
