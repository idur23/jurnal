<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Cetak Instrumen - <?= html_escape($form_info['nama_form']) ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
  <style>
    @media print {
      .d-print-none { display: none !important; }
      body { background: #fff !important; font-size: 11pt; color: #000; }
      .card { border: none !important; shadow: none !important; }
    }
    body { background-color: #f4f6fb; padding: 20px 0; }
    .paper { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin: auto; max-width: 900px; }
    .header-logo { width: 75px; height: 75px; }
  </style>
</head>
<body>

<div class="container-xl d-print-none mb-3 text-center">
  <button onclick="window.print()" class="btn btn-primary btn-lg shadow"><i class="ti ti-printer me-2"></i> Cetak Dokumen Sekarang</button>
  <button onclick="window.close()" class="btn btn-outline-secondary btn-lg ms-2">Tutup Window</button>
</div>

<div class="paper">
  <!-- Header Kop Surat -->
  <div class="d-flex align-items-center border-bottom border-3 border-dark pb-3 mb-4">
    <div class="me-3">
      <?php 
        $logo_url = base_url($settings['app_logo'] ?? 'assets/img/logo.png');
      ?>
      <img src="<?= $logo_url ?>" class="header-logo" alt="Logo">
    </div>
    <div class="text-center flex-fill">
      <h3 class="fw-bold mb-0 text-uppercase">YAYASAN DARUL FAQIH MALANG INDONESIA</h3>
      <h2 class="fw-bold mb-0 text-primary text-uppercase">MA DARUL FAQIH INDONESIA</h2>
      <p class="small text-muted mb-0">Jl. Raya Pandanlandung No. 27, Wagir, Kabupaten Malang | Email: info@darulfaqih.sch.id</p>
    </div>
  </div>

  <!-- Form Title -->
  <div class="text-center mb-4">
    <h3 class="fw-bold text-uppercase mb-1"><?= html_escape($form_info['nama_form']) ?></h3>
  </div>

  <!-- Identitas Table -->
  <table class="table table-borderless table-sm mb-4">
    <tr>
      <th style="width: 20%;">Nama Madrasah</th>
      <td style="width: 2%;">:</td>
      <td style="width: 28%;">MA DARUL FAQIH INDONESIA</td>
      <th style="width: 20%;">Tanggal Supervisi</th>
      <td style="width: 2%;">:</td>
      <td style="width: 28%;"><?= date('d F Y', strtotime($supervisi['tanggal_supervisi'])) ?></td>
    </tr>
    <tr>
      <th>Nama Guru</th>
      <td>:</td>
      <td><strong><?= html_escape($supervisi['nama_guru']) ?></strong></td>
      <th>Supervisor</th>
      <td>:</td>
      <td><?= html_escape($supervisi['nama_supervisor'] ?? 'Supervisor') ?></td>
    </tr>
    <tr>
      <th>NIP / NIK</th>
      <td>:</td>
      <td><?= html_escape(!empty($supervisi['nip_guru']) ? $supervisi['nip_guru'] : '-') ?></td>
      <th>Jabatan Supervisor</th>
      <td>:</td>
      <td><?= html_escape($supervisi['supervisor_role']) ?></td>
    </tr>
    <tr>
      <th>Mata Pelajaran</th>
      <td>:</td>
      <td><?= html_escape($supervisi['nama_mapel'] ?? '-') ?></td>
      <th>Tahap Supervisi</th>
      <td>:</td>
      <td><?= html_escape($supervisi['tahap']) ?></td>
    </tr>
    <tr>
      <th>Kelas</th>
      <td>:</td>
      <td><?= html_escape($supervisi['nama_kelas'] ?? '-') ?></td>
      <th>Tahun Pelajaran</th>
      <td>:</td>
      <td><?= html_escape($supervisi['tahun'] ?? '-') ?> (Semester <?= html_escape($supervisi['semester']) ?>)</td>
    </tr>
    <?php if ($supervisi['form_id'] == 3 && !empty($supervisi['jam_mulai'])): ?>
    <tr>
      <th>Waktu Observasi</th>
      <td>:</td>
      <td colspan="4"><?= $supervisi['jam_mulai'] ?> s.d. <?= $supervisi['jam_selesai'] ?? 'Selesai' ?> WIB</td>
    </tr>
    <?php endif; ?>
  </table>

  <!-- Instrumen Table -->
  <table class="table table-bordered table-sm align-middle mb-4">
    <thead>
      <tr class="bg-light text-center">
        <th style="width: 5%;">No</th>
        <th>Fokus Pengamatan / Indikator Penilaian</th>
        <th style="width: 15%;">Skor (0-4)</th>
        <th style="width: 20%;">Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php $curr_sub = ''; foreach ($details as $d): ?>
        <?php if (!empty($d['sub_bagian']) && $d['sub_bagian'] != $curr_sub): ?>
          <?php $curr_sub = $d['sub_bagian']; ?>
          <tr class="bg-light fw-bold">
            <td colspan="4"><?= html_escape($curr_sub) ?></td>
          </tr>
        <?php endif; ?>
        <tr>
          <td class="text-center"><?= $d['nomor_urut'] ?></td>
          <td><?= html_escape($d['nama_indikator']) ?></td>
          <td class="text-center fw-bold"><?= ($d['skor'] == 0) ? 'Tidak Ada (0)' : $d['skor'] ?></td>
          <td class="text-center small">
            <?php 
              if ($d['skor'] == 4) echo 'Sangat Baik';
              elseif ($d['skor'] == 3) echo 'Baik';
              elseif ($d['skor'] == 2) echo 'Cukup';
              elseif ($d['skor'] == 1) echo 'Kurang';
              else echo 'Tidak Ada';
            ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Score Summary -->
  <div class="card border border-dark p-3 mb-4 bg-light">
    <div class="row text-center">
      <div class="col-4">
        <div class="small text-muted">Jumlah Skor</div>
        <div class="h3 fw-bold mb-0"><?= $supervisi['jumlah_skor'] ?></div>
      </div>
      <div class="col-4">
        <div class="small text-muted">Skor Maksimal</div>
        <div class="h3 fw-bold mb-0"><?= $supervisi['skor_maksimal'] ?></div>
      </div>
      <div class="col-4">
        <div class="small text-muted">NILAI AKHIR</div>
        <div class="h2 fw-bold text-success mb-0"><?= number_format($supervisi['nilai_akhir'], 2) ?> / 100</div>
      </div>
    </div>
  </div>

  <!-- Catatan & Recommendations -->
  <div class="card border border-dark p-3 mb-4">
    <h5 class="fw-bold text-decoration-underline mb-1">Catatan Analisis Kekuatan & Kelemahan:</h5>
    <p class="small mb-3"><?= nl2br(html_escape($supervisi['catatan_analisis'] ? $supervisi['catatan_analisis'] : '-')) ?></p>

    <h5 class="fw-bold text-decoration-underline mb-1">Tindak Lanjut:</h5>
    <p class="small mb-3"><?= nl2br(html_escape($supervisi['tindak_lanjut'] ? $supervisi['tindak_lanjut'] : '-')) ?></p>

    <h5 class="fw-bold text-decoration-underline mb-1">Saran Supervisor:</h5>
    <p class="small mb-0"><?= nl2br(html_escape($supervisi['saran'] ? $supervisi['saran'] : '-')) ?></p>
  </div>

  <!-- Signatures Block -->
  <div class="row text-center mt-5">
    <div class="col-6">
      <div>Mengetahui,</div>
      <div class="fw-bold">Supervisor</div>
      <div style="height: 70px;"></div>
      <div class="fw-bold text-decoration-underline"><?= html_escape($supervisi['nama_supervisor'] ?? 'Supervisor') ?></div>
      <div class="small text-muted"><?= html_escape($supervisi['supervisor_role']) ?></div>
    </div>
    <div class="col-6">
      <div>Malang, <?= date('d F Y', strtotime($supervisi['tanggal_supervisi'])) ?></div>
      <div class="fw-bold">Guru Ter-supervisi</div>
      <div style="height: 70px;"></div>
      <div class="fw-bold text-decoration-underline"><?= html_escape($supervisi['nama_guru']) ?></div>
      <div class="small text-muted">NIP: <?= html_escape(!empty($supervisi['nip_guru']) ? $supervisi['nip_guru'] : '-') ?></div>
    </div>
  </div>
</div>

</body>
</html>
