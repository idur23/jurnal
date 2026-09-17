<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= html_escape($form_info['nama_form']) ?> - <?= html_escape($supervisi['nama_guru']) ?></title>
  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      font-size: 11pt;
      line-height: 1.4;
      color: #111;
      margin: 0;
      padding: 0;
    }
    .header-table {
      width: 100%;
      border-bottom: 3px double #000;
      padding-bottom: 8px;
      margin-bottom: 15px;
    }
    .header-logo {
      width: 70px;
      height: 70px;
      text-align: center;
    }
    .header-title {
      text-align: center;
    }
    .header-title h2 {
      margin: 0;
      font-size: 14pt;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .header-title h1 {
      margin: 2px 0 0 0;
      font-size: 16pt;
      font-weight: bold;
      color: #1e3a8a;
      text-transform: uppercase;
    }
    .header-title p {
      margin: 2px 0 0 0;
      font-size: 9pt;
      color: #444;
    }
    .doc-title {
      text-align: center;
      margin-bottom: 15px;
    }
    .doc-title h3 {
      margin: 0;
      font-size: 12pt;
      text-transform: uppercase;
      font-weight: bold;
    }
    .identitas-table {
      width: 100%;
      margin-bottom: 15px;
      border-collapse: collapse;
    }
    .identitas-table td {
      padding: 4px 6px;
      font-size: 10pt;
      vertical-align: top;
    }
    .instrumen-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }
    .instrumen-table th, .instrumen-table td {
      border: 1px solid #333;
      padding: 5px 6px;
      font-size: 9.5pt;
    }
    .instrumen-table th {
      background-color: #f1f5f9;
      text-align: center;
      font-weight: bold;
      text-transform: uppercase;
    }
    .bg-sub {
      background-color: #e2e8f0;
      font-weight: bold;
    }
    .summary-box {
      border: 1px solid #333;
      padding: 8px 12px;
      margin-bottom: 15px;
      background-color: #f8fafc;
    }
    .summary-box table {
      width: 100%;
    }
    .summary-box td {
      font-size: 10pt;
    }
    .notes-box {
      border: 1px solid #333;
      padding: 8px 12px;
      margin-bottom: 15px;
    }
    .notes-box h4 {
      margin: 0 0 5px 0;
      font-size: 10pt;
      font-weight: bold;
      text-decoration: underline;
    }
    .signature-table {
      width: 100%;
      margin-top: 30px;
    }
    .signature-table td {
      text-align: center;
      vertical-align: top;
      font-size: 10pt;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .fw-bold { font-weight: bold; }
  </style>
</head>
<body>

  <!-- Header Kop Surat -->
  <table class="header-table">
    <tr>
      <td class="header-logo" style="width: 15%;">
        <?php 
          $logo_path = FCPATH . ($settings['app_logo'] ?? 'assets/img/logo.png');
          if (file_exists($logo_path)):
        ?>
          <img src="<?= $logo_path ?>" style="max-width: 65px; max-height: 65px;">
        <?php else: ?>
          <div style="font-weight: bold; font-size: 16pt;">DF</div>
        <?php endif; ?>
      </td>
      <td class="header-title" style="width: 85%;">
        <h2>YAYASAN DARUL FAQIH MALANG INDONESIA</h2>
        <h1>MA DARUL FAQIH INDONESIA</h1>
        <p>Jl. Raya Pandanlandung No. 27, Wagir, Kabupaten Malang | Telp/WA: 0812-3456-7890</p>
      </td>
    </tr>
  </table>

  <!-- Document Title -->
  <div class="doc-title">
    <h3><?= html_escape($form_info['nama_form']) ?></h3>
  </div>

  <!-- Identitas Table -->
  <table class="identitas-table">
    <tr>
      <td style="width: 18%;" class="fw-bold">Nama Madrasah</td>
      <td style="width: 2%;">:</td>
      <td style="width: 30%;">MA DARUL FAQIH INDONESIA</td>
      <td style="width: 18%;" class="fw-bold">Tanggal Supervisi</td>
      <td style="width: 2%;">:</td>
      <td style="width: 30%;"><?= date('d F Y', strtotime($supervisi['tanggal_supervisi'])) ?></td>
    </tr>
    <tr>
      <td class="fw-bold">Nama Guru</td>
      <td>:</td>
      <td><?= html_escape($supervisi['nama_guru']) ?></td>
      <td class="fw-bold">Supervisor</td>
      <td>:</td>
      <td><?= html_escape($supervisi['nama_supervisor'] ?? 'Supervisor') ?></td>
    </tr>
    <tr>
      <td class="fw-bold">NIP / NIK</td>
      <td>:</td>
      <td><?= html_escape(!empty($supervisi['nip_guru']) ? $supervisi['nip_guru'] : '-') ?></td>
      <td class="fw-bold">Jabatan Supervisor</td>
      <td>:</td>
      <td><?= html_escape($supervisi['supervisor_role']) ?></td>
    </tr>
    <tr>
      <td class="fw-bold">Mata Pelajaran</td>
      <td>:</td>
      <td><?= html_escape($supervisi['nama_mapel'] ?? '-') ?></td>
      <td class="fw-bold">Tahap Supervisi</td>
      <td>:</td>
      <td><?= html_escape($supervisi['tahap']) ?></td>
    </tr>
    <tr>
      <td class="fw-bold">Kelas</td>
      <td>:</td>
      <td><?= html_escape($supervisi['nama_kelas'] ?? '-') ?></td>
      <td class="fw-bold">Tahun Pelajaran</td>
      <td>:</td>
      <td><?= html_escape($supervisi['tahun'] ?? '-') ?> (Semester <?= html_escape($supervisi['semester']) ?>)</td>
    </tr>
    <?php if ($supervisi['form_id'] == 3 && !empty($supervisi['jam_mulai'])): ?>
    <tr>
      <td class="fw-bold">Waktu Observasi</td>
      <td>:</td>
      <td colspan="4"><?= $supervisi['jam_mulai'] ?> s.d. <?= $supervisi['jam_selesai'] ?? 'Selesai' ?> WIB</td>
    </tr>
    <?php endif; ?>
  </table>

  <!-- Table Instrumen Penilaian -->
  <table class="instrumen-table">
    <thead>
      <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 65%;">Fokus Pengamatan / Indikator Penilaian</th>
        <th style="width: 15%;">Skor (0-4)</th>
        <th style="width: 15%;">Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($details)): ?>
        <tr>
          <td colspan="4" class="text-center">Data indikator tidak ditemukan.</td>
        </tr>
      <?php else: ?>
        <?php $curr_sub = ''; foreach ($details as $d): ?>
          <?php if (!empty($d['sub_bagian']) && $d['sub_bagian'] != $curr_sub): ?>
            <?php $curr_sub = $d['sub_bagian']; ?>
            <tr class="bg-sub">
              <td colspan="4"><?= html_escape($curr_sub) ?></td>
            </tr>
          <?php endif; ?>
          <tr>
            <td class="text-center"><?= $d['nomor_urut'] ?></td>
            <td><?= html_escape($d['nama_indikator']) ?></td>
            <td class="text-center fw-bold">
              <?php 
                if ($d['skor'] == 0) echo 'Tidak Ada (0)';
                else echo $d['skor'];
              ?>
            </td>
            <td class="text-center">
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
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Score Summary -->
  <div class="summary-box">
    <table>
      <tr>
        <td style="width: 33%;"><strong>Jumlah Skor:</strong> <?= $supervisi['jumlah_skor'] ?></td>
        <td style="width: 33%;"><strong>Skor Maksimal:</strong> <?= $supervisi['skor_maksimal'] ?></td>
        <td style="width: 34%; text-align: right;"><strong style="font-size: 11pt;">NILAI AKHIR: <?= number_format($supervisi['nilai_akhir'], 2) ?> / 100</strong></td>
      </tr>
    </table>
  </div>

  <!-- Catatan Supervisor -->
  <div class="notes-box">
    <h4>Analisis Kekuatan & Kelemahan Hasil Supervisi:</h4>
    <p style="margin: 0 0 8px 0; font-size: 9.5pt;"><?= nl2br(html_escape($supervisi['catatan_analisis'] ? $supervisi['catatan_analisis'] : '-')) ?></p>

    <h4>Tindak Lanjut:</h4>
    <p style="margin: 0 0 8px 0; font-size: 9.5pt;"><?= nl2br(html_escape($supervisi['tindak_lanjut'] ? $supervisi['tindak_lanjut'] : '-')) ?></p>

    <h4>Saran Supervisor:</h4>
    <p style="margin: 0; font-size: 9.5pt;"><?= nl2br(html_escape($supervisi['saran'] ? $supervisi['saran'] : '-')) ?></p>
  </div>

  <!-- Signatures Block -->
  <table class="signature-table">
    <tr>
      <td style="width: 50%;">
        Mengetahui,<br>
        <strong>Supervisor</strong><br><br><br><br><br>
        <u><strong><?= html_escape($supervisi['nama_supervisor'] ?? 'Supervisor') ?></strong></u><br>
        <span><?= html_escape($supervisi['supervisor_role']) ?></span>
      </td>
      <td style="width: 50%;">
        Malang, <?= date('d F Y', strtotime($supervisi['tanggal_supervisi'])) ?><br>
        <strong>Guru Ter-supervisi</strong><br><br><br><br><br>
        <u><strong><?= html_escape($supervisi['nama_guru']) ?></strong></u><br>
        <span>NIP: <?= html_escape(!empty($supervisi['nip_guru']) ? $supervisi['nip_guru'] : '-') ?></span>
      </td>
    </tr>
  </table>

</body>
</html>
