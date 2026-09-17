<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Verifikasi</div>
      <h2 class="page-title text-indigo"><i class="ti ti-check-double me-2"></i>Tinjau Perangkat Ajar (v<?= $d['version'] ?>)</h2>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= base_url('perangkat_ajar/verifikasi') ?>" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i> Kembali</a>
    </div>
  </div>
</div>

<div class="row row-cards">
  <!-- Left Column: Verification Form -->
  <div class="col-md-5">
    <div class="card mb-4 border-indigo shadow-sm" style="border-radius: 12px;">
      <div class="card-header bg-indigo text-white" style="border-radius: 12px 12px 0 0;">
        <h3 class="card-title text-white"><i class="ti ti-check-double me-2"></i>Keputusan Verifikasi</h3>
      </div>
      <div class="card-body">
        <form action="<?= current_url() ?>" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

          <div class="mb-3">
            <label class="form-label required fw-bold">Status Verifikasi</label>
            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column gap-2">
              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="status_verifikasi" value="Disetujui" class="form-selectgroup-input" checked>
                <span class="form-selectgroup-label d-flex align-items-center p-3 border-success text-success">
                  <span class="avatar avatar-sm bg-success text-white me-3"><i class="ti ti-check"></i></span>
                  <div>
                    <span class="d-block fw-bold">Disetujui (Approved)</span>
                    <span class="text-muted small">Perangkat ajar aktif dan dapat digunakan pada Jurnal.</span>
                  </div>
                </span>
              </label>

              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="status_verifikasi" value="Revisi" class="form-selectgroup-input">
                <span class="form-selectgroup-label d-flex align-items-center p-3 border-info text-info">
                  <span class="avatar avatar-sm bg-info text-white me-3"><i class="ti ti-edit"></i></span>
                  <div>
                    <span class="d-block fw-bold">Perlu Revisi (Needs Revision)</span>
                    <span class="text-muted small">Guru pengampu wajib memperbarui dan mengunggah ulang.</span>
                  </div>
                </span>
              </label>

              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="status_verifikasi" value="Ditolak" class="form-selectgroup-input">
                <span class="form-selectgroup-label d-flex align-items-center p-3 border-danger text-danger">
                  <span class="avatar avatar-sm bg-danger text-white me-3"><i class="ti ti-x"></i></span>
                  <div>
                    <span class="d-block fw-bold">Ditolak (Rejected)</span>
                    <span class="text-muted small">Perangkat ajar ini ditolak sepenuhnya dari kurikulum.</span>
                  </div>
                </span>
              </label>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Catatan Revisi / Alasan Penolakan</label>
            <textarea name="catatan_revisi" class="form-control" rows="4" placeholder="Tuliskan alasan penolakan atau saran perbaikan bagi guru pengampu..."></textarea>
          </div>

          <div class="card-footer bg-light text-end" style="border-radius: 0 0 12px 12px; margin: 0 -20px -20px -20px;">
            <button type="submit" class="btn btn-indigo w-100 fw-bold py-2"><i class="ti ti-send me-1"></i> Simpan Keputusan Verifikasi</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Info Box -->
    <div class="card shadow-sm" style="border-radius: 12px;">
      <div class="card-body">
        <h4 class="card-title text-indigo"><i class="ti ti-info-circle me-1"></i>Panduan Peninjauan</h4>
        <ul class="small text-muted ps-3">
          <li>Periksa apakah Rencana Pembelajaran sesuai dengan Kurikulum Merdeka atau K13.</li>
          <li>Pastikan Tujuan Pembelajaran (TP) terukur dan realistis untuk alokasi waktu yang ditentukan.</li>
          <li>Unduh dan tinjau lampiran file perangkat untuk memastikan tidak ada kesalahan data.</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Right Column: Document Details & Preview -->
  <div class="col-md-7">
    <div class="card mb-4 shadow-sm" style="border-radius: 12px;">
      <div class="card-header bg-light">
        <h3 class="card-title text-indigo"><i class="ti ti-article me-2"></i>Rencana Pelaksanaan Pembelajaran</h3>
      </div>
      <div class="card-body">
        <table class="table table-sm table-borderless small mb-4">
          <tbody>
            <tr>
              <td class="text-muted w-30">Guru Pengampu</td>
              <td>: <strong><?= html_escape($d['nama_guru']) ?></strong></td>
            </tr>
            <tr>
              <td class="text-muted">Mata Pelajaran / Kelas</td>
              <td>: <?= html_escape($d['nama_mapel']) ?> / <?= html_escape($d['nama_kelas']) ?></td>
            </tr>
            <tr>
              <td class="text-muted">Semester / Pertemuan</td>
              <td>: Semester <?= $d['semester'] ?> (Pertemuan Ke-<?= $d['pertemuan_ke'] ?>)</td>
            </tr>
            <tr>
              <td class="text-muted">Materi Pokok</td>
              <td>: <?= html_escape($d['materi_pembelajaran']) ?></td>
            </tr>
          </tbody>
        </table>

        <div class="mb-3">
          <h5 class="text-indigo">Tujuan Pembelajaran (TP)</h5>
          <p class="border-start border-indigo border-3 ps-3 text-justify"><?= nl2br(html_escape($d['tujuan_pembelajaran'])) ?></p>
        </div>

        <div class="mb-3">
          <h5 class="text-indigo">Capaian Pembelajaran (CP)</h5>
          <p class="border-start border-light border-3 ps-3 text-justify"><?= nl2br(html_escape($d['capaian_pembelajaran'] ? $d['capaian_pembelajaran'] : '-')) ?></p>
        </div>

        <div class="row">
          <div class="col-6 mb-3">
            <h6 class="text-indigo">Metode</h6>
            <p class="small text-muted"><?= html_escape($d['metode_pembelajaran'] ? $d['metode_pembelajaran'] : '-') ?></p>
          </div>
          <div class="col-6 mb-3">
            <h6 class="text-indigo">Model</h6>
            <p class="small text-muted"><?= html_escape($d['model_pembelajaran'] ? $d['model_pembelajaran'] : '-') ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- PDF IFrame Preview -->
    <?php if ($d['file_path'] && strtolower(pathinfo($d['file_path'], PATHINFO_EXTENSION)) == 'pdf'): ?>
      <div class="card shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-light">
          <h3 class="card-title text-indigo"><i class="ti ti-file-text me-2"></i>Pratinjau File</h3>
        </div>
        <div class="card-body p-0">
          <iframe src="<?= base_url($d['file_path']) ?>" width="100%" height="450px" style="border: none; border-radius: 0 0 12px 12px;"></iframe>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
