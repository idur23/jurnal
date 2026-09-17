<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Rekap Nilai RDM Kelas <?= html_escape($kelas_row['nama_kelas']) ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 11px;
      color: #333;
      margin: 20px;
    }
    .header {
      text-align: center;
      margin-bottom: 20px;
      border-bottom: 3px double #000;
      padding-bottom: 10px;
    }
    .header h2 {
      margin: 0;
      font-size: 16px;
      text-transform: uppercase;
    }
    .header p {
      margin: 5px 0 0 0;
      font-size: 11px;
    }
    .doc-title {
      text-align: center;
      text-transform: uppercase;
      font-weight: bold;
      font-size: 13px;
      margin-bottom: 15px;
    }
    .metadata-table {
      width: 100%;
      margin-bottom: 15px;
    }
    .metadata-table td {
      padding: 3px 0;
    }
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 25px;
    }
    .data-table th, .data-table td {
      border: 1px solid #000;
      padding: 6px 8px;
    }
    .data-table th {
      background-color: #f2f2f2;
      font-weight: bold;
      text-align: center;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .bold { font-weight: bold; }
    
    /* Footer Signatures */
    .signature-container {
      width: 100%;
      margin-top: 30px;
    }
    .signature-box {
      float: right;
      width: 250px;
      text-align: center;
    }
    .signature-space {
      height: 70px;
    }
    
    @media print {
      body { margin: 10px; }
      .no-print { display: none; }
    }
  </style>
</head>
<body onload="window.print()">

  <table style="width: 100%; border-bottom: 3px double #333; padding-bottom: 8px; margin-bottom: 15px; border-collapse: collapse; border: none;">
    <tr style="border: none;">
      <td style="width: 15%; text-align: left; vertical-align: middle; border: none; padding: 0;">
        <?php if (!empty($settings['app_logo_left']) && file_exists('./' . $settings['app_logo_left'])): ?>
          <img src="<?= base_url($settings['app_logo_left']) ?>" style="max-height: 85px; max-width: 85px; object-fit: contain;">
        <?php endif; ?>
      </td>
      <td style="width: 70%; text-align: center; vertical-align: middle; border: none; padding: 0;">
        <h2 style="margin: 0; font-size: 15px; text-transform: uppercase; font-weight: bold;"><?= html_escape($settings['app_institution'] ?? 'SMA NEGERI ENTERPRISE 1') ?></h2>
        <p style="margin: 3px 0 0 0; font-size: 10px; color: #555;"><?= nl2br(html_escape($settings['app_address'] ?? '')) ?></p>
      </td>
      <td style="width: 15%; text-align: right; vertical-align: middle; border: none; padding: 0;">
        <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
          <img src="<?= base_url($settings['app_logo_right']) ?>" style="max-height: 85px; max-width: 85px; object-fit: contain;">
        <?php endif; ?>
      </td>
    </tr>
  </table>

  <div class="doc-title">
    REKAPITULASI NILAI RAPOR DIGITAL MADRASAH (RDM)
  </div>

  <table class="metadata-table">
    <tr>
      <td style="width: 15%;">Kelas</td>
      <td style="width: 35%;">: <strong><?= html_escape($kelas_row['nama_kelas']) ?></strong></td>
      <td style="width: 20%;">Tahun Pelajaran</td>
      <td style="width: 30%;">: <?= html_escape($tp_row['tahun']) ?> (Semester <?= html_escape($tp_row['semester']) ?>)</td>
    </tr>
    <tr>
      <td>Mata Pelajaran</td>
      <td>: <?= html_escape($mapel_row['nama_mapel']) ?></td>
      <td>Kriteria Kelulusan (KKM)</td>
      <td>: <strong><?= number_format($kelas_row['kkm'] ?? 75, 2) ?></strong></td>
    </tr>
  </table>

  <table class="data-table">
    <thead>
      <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 15%;">NIS</th>
        <th>Nama Lengkap</th>
        <?php foreach ($categories as $cat): ?>
          <th style="width: 10%;" class="text-center"><?= html_escape(str_replace('Nilai ', '', $cat['nama_kategori'])) ?></th>
        <?php endforeach; ?>
        <th style="width: 12%;" class="text-center">Nilai Akhir</th>
        <th style="width: 10%;" class="text-center">Predikat</th>
        <th style="width: 10%;" class="text-center">Ketuntasan</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($rekap as $r): ?>
        <tr>
          <td class="text-center"><?= $no++ ?></td>
          <td class="text-center"><code><?= html_escape($r['nis']) ?></code></td>
          <td class="bold"><?= html_escape($r['nama_lengkap']) ?></td>
          
          <?php foreach ($categories as $cat): ?>
            <?php $score = $r['scores'][$cat['kode_kategori']]; ?>
            <td class="text-center bold">
              <?= $score !== NULL ? number_format($score, 2) : '-' ?>
            </td>
          <?php endforeach; ?>

          <td class="text-center bold" style="background-color: #f9f9f9;"><?= number_format($r['nilai_akhir'], 2) ?></td>
          <td class="text-center bold"><?= html_escape($r['predikat']) ?></td>
          <td class="text-center bold"><?= html_escape($r['ketuntasan']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="signature-container">
    <div class="signature-box">
      <div><?= html_escape($settings['report_city'] ?? 'Kota Enterprise') ?>, <?= date('d M Y') ?></div>
      <div style="margin-top: 5px;"><?= html_escape($settings['report_signer_title'] ?? 'Kepala Sekolah') ?></div>
      <div class="signature-space"></div>
      <div class="bold" style="text-decoration: underline;"><?= html_escape($settings['report_signer_name'] ?? '') ?></div>
      <div>NIP. <?= html_escape($settings['report_signer_nip'] ?? '') ?></div>
    </div>
  </div>

</body>
</html>
