<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Perangkat Ajar</div>
      <h2 class="page-title text-indigo"><i class="ti ti-file-analytics me-2"></i>Detail Perangkat Ajar (v<?= $d['version'] ?>)</h2>
    </div>
    <div class="col-auto ms-auto">
      <div class="btn-list">
        <a href="<?= base_url('perangkat_ajar/daftar') ?>" class="btn btn-secondary">
          <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
        
        <?php if ($d['file_path']): ?>
          <a href="<?= base_url('perangkat_ajar/download/' . $d['id']) ?>" class="btn btn-success">
            <i class="ti ti-download me-1"></i> Unduh File
          </a>
        <?php endif; ?>

        <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'guru'))): ?>
          <a href="<?= base_url('perangkat_ajar/upload/' . $d['id']) ?>" class="btn btn-warning">
            <i class="ti ti-edit me-1"></i> Revisi / Unggah Versi Baru
          </a>
        <?php endif; ?>

        <?php if (in_array($_user['role_code'] ?? '', array('admin', 'superadmin', 'waka', 'kamad')) && $d['status_verifikasi'] == 'Menunggu Verifikasi'): ?>
          <a href="<?= base_url('perangkat_ajar/verifikasi/' . $d['id']) ?>" class="btn btn-danger">
            <i class="ti ti-check-double me-1"></i> Verifikasi Perangkat
          </a>
        <?php endif; ?>

        <?php if ($d['is_archived'] == 0): ?>
          <a href="<?= base_url('perangkat_ajar/do_archive/' . $d['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin mengarsipkan perangkat ini?')">
            <i class="ti ti-archive me-1"></i> Arsipkan
          </a>
        <?php else: ?>
          <a href="<?= base_url('perangkat_ajar/do_restore/' . $d['id']) ?>" class="btn btn-outline-success" onclick="return confirm('Apakah Anda yakin ingin memulihkan perangkat ini dari arsip?')">
            <i class="ti ti-rotate me-1"></i> Pulihkan
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="row row-cards">
  <!-- Metadata Card -->
  <div class="col-md-5 col-lg-4">
    <div class="card mb-4 border-indigo shadow-sm" style="border-radius: 12px;">
      <div class="card-header bg-indigo text-white" style="border-radius: 12px 12px 0 0;">
        <h3 class="card-title text-white"><i class="ti ti-info-circle me-2"></i>Informasi Umum</h3>
      </div>
      <div class="card-body">
        <table class="table table-borderless table-sm small">
          <tbody>
            <tr>
              <td class="text-muted w-50">Jenis Perangkat</td>
              <td class="fw-bold">: <?= $d['jenis_perangkat'] ?></td>
            </tr>
            <tr>
              <td class="text-muted">Mata Pelajaran</td>
              <td>: <?= html_escape($d['nama_mapel']) ?></td>
            </tr>
            <tr>
              <td class="text-muted">Kelas</td>
              <td>: <?= html_escape($d['nama_kelas']) ?></td>
            </tr>
            <tr>
              <td class="text-muted">Fase / Elemen</td>
              <td>: <?= $d['fase'] ? 'Fase ' . $d['fase'] : '-' ?> / <?= $d['elemen'] ? html_escape($d['elemen']) : '-' ?></td>
            </tr>
            <tr>
              <td class="text-muted">Guru Pengampu</td>
              <td>: <?= html_escape($d['nama_guru']) ?></td>
            </tr>
            <tr>
              <td class="text-muted">Tahun Pelajaran</td>
              <td>: <?= html_escape($d['tahun']) ?></td>
            </tr>
            <tr>
              <td class="text-muted">Semester</td>
              <td>: <?= $d['semester'] ?></td>
            </tr>
            <tr>
              <td class="text-muted">Pertemuan Ke-</td>
              <td>: Pertemuan <?= $d['pertemuan_ke'] ?></td>
            </tr>
            <tr>
              <td class="text-muted">Alokasi Waktu</td>
              <td>: <?= $d['alokasi_waktu'] ? html_escape($d['alokasi_waktu']) : '-' ?></td>
            </tr>
            <tr>
              <td class="text-muted">Status Verifikasi</td>
              <td>: 
                <?php
                $status_class = 'bg-secondary';
                if ($d['status_verifikasi'] == 'Disetujui') $status_class = 'bg-success';
                elseif ($d['status_verifikasi'] == 'Menunggu Verifikasi') $status_class = 'bg-warning text-dark';
                elseif ($d['status_verifikasi'] == 'Revisi') $status_class = 'bg-info text-white';
                elseif ($d['status_verifikasi'] == 'Ditolak') $status_class = 'bg-danger';
                ?>
                <span class="badge <?= $status_class ?>"><?= $d['status_verifikasi'] ?></span>
              </td>
            </tr>
            <?php if ($d['status_verifikasi'] == 'Revisi' || $d['status_verifikasi'] == 'Ditolak'): ?>
              <tr>
                <td class="text-muted text-danger fw-bold">Catatan Revisi</td>
                <td class="text-danger">: <?= html_escape($d['catatan_revisi'] ? $d['catatan_revisi'] : 'Tidak ada catatan.') ?></td>
              </tr>
            <?php endif; ?>
            <tr>
              <td class="text-muted">Versi Saat Ini</td>
              <td>: <span class="badge bg-indigo-lt">v<?= $d['version'] ?></span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Revisions Card -->
    <div class="card mb-4 shadow-sm" style="border-radius: 12px;">
      <div class="card-header bg-light">
        <h3 class="card-title text-indigo"><i class="ti ti-history me-2"></i>Riwayat Versi / Revisi</h3>
      </div>
      <div class="card-body p-0">
        <div class="list-group list-group-flush list-group-hoverable" style="max-height: 250px; overflow-y: auto;">
          <?php foreach ($history as $h): ?>
            <div class="list-group-item">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="badge bg-indigo-lt">v<?= $h['version'] ?></span>
                </div>
                <div class="col text-truncate">
                  <a href="<?= base_url('perangkat_ajar/detail/' . $h['id']) ?>" class="text-body d-block fw-medium">
                    <?= basename($h['file_path']) ?>
                  </a>
                  <small class="d-block text-muted text-truncate">Oleh: <?= html_escape($h['creator_name']) ?> | <?= date('d M Y H:i', strtotime($h['created_at'])) ?></small>
                </div>
                <div class="col-auto">
                  <?php if ($h['id'] == $d['id']): ?>
                    <span class="badge bg-success-lt">Aktif</span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Detail Content Card -->
  <div class="col-md-7 col-lg-8">
    <div class="card mb-4 shadow-sm" style="border-radius: 12px;">
      <div class="card-header bg-light">
        <h3 class="card-title text-indigo"><i class="ti ti-article me-2"></i>Konten & Rencana Pembelajaran</h3>
      </div>
      <div class="card-body">
        <div class="mb-4">
          <h4 class="text-indigo mb-2">Materi Pembelajaran</h4>
          <p class="border-start border-indigo border-3 ps-3 text-justify"><?= nl2br(html_escape($d['materi_pembelajaran'] ? $d['materi_pembelajaran'] : '-')) ?></p>
        </div>

        <?php if ($d['sub_materi']): ?>
          <div class="mb-4">
            <h5 class="text-indigo mb-2">Sub Materi</h5>
            <p class="border-start border-secondary border-3 ps-3 text-justify"><?= nl2br(html_escape($d['sub_materi'])) ?></p>
          </div>
        <?php endif; ?>

        <?php if ($d['capaian_pembelajaran']): ?>
          <div class="mb-4">
            <h5 class="text-indigo mb-2">Capaian Pembelajaran (CP)</h5>
            <p class="border-start border-secondary border-3 ps-3 text-justify"><?= nl2br(html_escape($d['capaian_pembelajaran'])) ?></p>
          </div>
        <?php endif; ?>

        <div class="mb-4">
          <h5 class="text-indigo mb-2">Tujuan Pembelajaran (TP)</h5>
          <p class="border-start border-danger border-3 ps-3 text-justify"><?= nl2br(html_escape($d['tujuan_pembelajaran'])) ?></p>
        </div>

        <div class="row">
          <div class="col-md-6 mb-4">
            <h5 class="text-indigo mb-2">Metode Pembelajaran</h5>
            <p class="border-start border-light border-3 ps-3"><?= nl2br(html_escape($d['metode_pembelajaran'] ? $d['metode_pembelajaran'] : '-')) ?></p>
          </div>
          <div class="col-md-6 mb-4">
            <h5 class="text-indigo mb-2">Model Pembelajaran</h5>
            <p class="border-start border-light border-3 ps-3"><?= nl2br(html_escape($d['model_pembelajaran'] ? $d['model_pembelajaran'] : '-')) ?></p>
          </div>
          <div class="col-md-6 mb-4">
            <h5 class="text-indigo mb-2">Media Pembelajaran</h5>
            <p class="border-start border-light border-3 ps-3"><?= nl2br(html_escape($d['media_pembelajaran'] ? $d['media_pembelajaran'] : '-')) ?></p>
          </div>
          <div class="col-md-6 mb-4">
            <h5 class="text-indigo mb-2">Sumber Belajar</h5>
            <p class="border-start border-light border-3 ps-3"><?= nl2br(html_escape($d['sumber_belajar'] ? $d['sumber_belajar'] : '-')) ?></p>
          </div>
        </div>

        <div class="mb-4">
          <h5 class="text-indigo mb-2">Bentuk Penilaian</h5>
          <p class="border-start border-light border-3 ps-3"><?= nl2br(html_escape($d['bentuk_penilaian'] ? $d['bentuk_penilaian'] : '-')) ?></p>
        </div>
      </div>
    </div>

    <!-- PDF/Document Preview -->
    <?php if ($d['file_path'] && strtolower(pathinfo($d['file_path'], PATHINFO_EXTENSION)) == 'pdf'): ?>
      <div class="card shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
          <h3 class="card-title text-indigo"><i class="ti ti-file-text me-2"></i>Pratinjau Dokumen</h3>
          <span class="badge bg-secondary-lt">PDF Document</span>
        </div>
        <div class="card-body p-0">
          <iframe src="<?= base_url($d['file_path']) ?>" width="100%" height="600px" style="border: none; border-radius: 0 0 12px 12px;"></iframe>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
