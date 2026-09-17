<!DOCTYPE html>
<html>
<head>
  <title><?= html_escape($title) ?></title>
  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      color: #333;
      font-size: 11px;
      margin: 0;
      padding: 0;
    }
    .header-table {
      width: 100%;
      border-bottom: 2px solid #333;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .header-table td {
      vertical-align: middle;
    }
    .logo-container {
      width: 80px;
      text-align: left;
    }
    .logo {
      max-height: 70px;
    }
    .school-info {
      text-align: center;
    }
    .school-name {
      font-size: 16px;
      font-weight: bold;
      text-transform: uppercase;
      margin: 0 0 5px 0;
    }
    .school-sub {
      font-size: 11px;
      color: #666;
      margin: 0;
    }
    .title {
      font-size: 14px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 15px;
      text-transform: uppercase;
    }
    .meta-table {
      width: 100%;
      margin-bottom: 15px;
      font-size: 11px;
    }
    .meta-table td {
      padding: 3px 0;
    }
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    .data-table th, .data-table td {
      border: 1px solid #999;
      padding: 6px 8px;
      text-align: left;
      vertical-align: top;
    }
    .data-table th {
      background-color: #f2f2f2;
      font-weight: bold;
      text-transform: uppercase;
    }
    .text-center {
      text-align: center !important;
    }
    .badge {
      display: inline-block;
      padding: 2px 5px;
      font-size: 9px;
      font-weight: bold;
      border-radius: 3px;
      color: #fff;
    }
    .badge-success { background-color: #28a745; }
    .badge-danger { background-color: #dc3545; }
    .badge-info { background-color: #17a2b8; }
    .footer-table {
      width: 100%;
      margin-top: 40px;
      font-size: 11px;
    }
    .footer-table td {
      width: 33%;
    }
  </style>
</head>
<body>

  <!-- Header Kop Surat -->
  <table class="header-table" style="width: 100%; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; border-collapse: collapse; border: none;">
    <tr style="border: none;">
      <td style="width: 15%; text-align: left; vertical-align: middle; border: none; padding: 0;">
        <?php if (!empty($settings['app_logo_left']) && file_exists('./' . $settings['app_logo_left'])): ?>
          <img src="<?= get_image_base64('./' . $settings['app_logo_left']) ?>" style="max-height: 85px; max-width: 85px; object-fit: contain;">
        <?php endif; ?>
      </td>
      <td style="width: 70%; text-align: center; vertical-align: middle; border: none; padding: 0;">
        <h1 style="font-size: 16px; font-weight: bold; text-transform: uppercase; margin: 0 0 5px 0;"><?= html_escape($settings['app_institution'] ?? 'SMA Negeri Enterprise 1') ?></h1>
        <p style="font-size: 11px; color: #666; margin: 0 0 3px 0;"><?= html_escape($settings['app_name'] ?? 'Jurnal Guru Enterprise') ?></p>
        <p style="font-size: 10px; color: #666; margin: 0;"><?= html_escape($settings['app_address'] ?? 'Jl. Edukasi No. 1, Kota Enterprise') ?></p>
      </td>
      <td style="width: 15%; text-align: right; vertical-align: middle; border: none; padding: 0;">
        <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
          <img src="<?= get_image_base64('./' . $settings['app_logo_right']) ?>" style="max-height: 85px; max-width: 85px; object-fit: contain;">
        <?php endif; ?>
      </td>
    </tr>
  </table>

  <!-- Judul Laporan -->
  <div class="title"><?= html_escape($title) ?></div>

  <table class="meta-table">
    <tr>
      <td style="width: 15%;">Tahun Pelajaran</td>
      <td style="width: 2%;">:</td>
      <td style="width: 48%; font-weight: bold;"><?= html_escape($active_tp['tahun']) ?> (<?= html_escape($active_tp['semester']) ?>)</td>
      <td style="width: 15%;">Tanggal Cetak</td>
      <td style="width: 2%;">:</td>
      <td style="width: 18%;"><?= date('d M Y') ?></td>
    </tr>
  </table>

  <!-- Data Table -->
  <table class="data-table">
    <thead>
      <tr>
        <th class="text-center" style="width: 30px;">No</th>
        <th style="width: 80px;">Tanggal</th>
        <th style="width: 70px;">Jam KBM</th>
        <th style="width: 70px;">Kelas</th>
        <th style="width: 120px;">Mata Pelajaran</th>
        <th style="width: 130px;">Guru Pengampu</th>
        <th style="width: 80px;">Ruangan</th>
        <th class="text-center" style="width: 60px;">Pertemuan</th>
        <th style="width: 110px;">Status KBM</th>
        <th>Catatan Guru / Alasan</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($logs)): ?>
        <tr>
          <td colspan="10" class="text-center" style="padding: 20px;">Tidak ada data log presensi kelas ditemukan.</td>
        </tr>
      <?php else: ?>
        <?php $no=1; foreach ($logs as $l): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= date('d-m-Y', strtotime($l['tanggal'])) ?></td>
            <td><?= substr($l['jam_mulai'], 0, 5) ?>-<?= substr($l['jam_selesai'], 0, 5) ?></td>
            <td style="font-weight: bold;"><?= html_escape($l['nama_kelas']) ?></td>
            <td><?= html_escape($l['nama_mapel']) ?></td>
            <td><?= html_escape($l['nama_guru']) ?></td>
            <td><?= html_escape($l['nama_ruangan'] ? $l['nama_ruangan'] : '-') ?></td>
            <td class="text-center">Ke-<?= html_escape($l['pertemuan_ke']) ?></td>
            <td>
              <?php if ($l['status_pembelajaran'] == 'Terlaksana'): ?>
                <span class="badge badge-success">Terlaksana</span>
              <?php elseif ($l['status_pembelajaran'] == 'Tidak Terlaksana'): ?>
                <span class="badge badge-danger">Tidak Terlaksana</span>
              <?php else: ?>
                <span class="badge badge-info"><?= html_escape($l['status_pembelajaran']) ?></span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($l['status_pembelajaran'] == 'Tidak Terlaksana'): ?>
                <span style="color: red; font-style: italic;">Alasan: <?= html_escape($l['alasan_tidak_terlaksana']) ?></span>
              <?php else: ?>
                <?= $l['catatan_guru'] ? html_escape($l['catatan_guru']) : '-' ?>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Tanda Tangan -->
  <table class="footer-table">
    <tr>
      <td>
        <p>Mengetahui,</p>
        <p style="margin-bottom: 50px;"><?= html_escape($settings['report_signer_title'] ?? 'Kepala Madrasah') ?></p>
        <p style="font-weight: bold; text-decoration: underline;"><?= html_escape($settings['headmaster_name'] ?? 'M. Fakhrur Rozi, M.Pd') ?></p>
        <p class="school-sub">NIP: <?= html_escape($settings['headmaster_nip'] ?? '001') ?></p>
      </td>
      <td></td>
      <td style="text-align: right;">
        <p><?= html_escape($settings['report_city'] ?? 'Malang') ?>, <?= format_indo_date(date('Y-m-d')) ?></p>
        <p style="margin-bottom: 50px;">Staf Tata Usaha</p>
        <p style="font-weight: bold; text-decoration: underline;"><?= html_escape($settings['printed_by'] ?? $_user['full_name'] ?? 'Administrator') ?></p>
      </td>
    </tr>
  </table>

</body>
</html>
