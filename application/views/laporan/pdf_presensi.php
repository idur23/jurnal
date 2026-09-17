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
    .footer-table {
      width: 100%;
      margin-top: 40px;
      font-size: 11px;
    }
    .footer-table td {
      width: 50%;
    }
  </style>
</head>
<body>

  <!-- Kop Surat -->
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
      <td style="width: 15%;">Kelas</td>
      <td style="width: 2%;">:</td>
      <td style="width: 48%; font-weight: bold;"><?= html_escape($kelas['nama_kelas'] ?? '-') ?></td>
      <td style="width: 15%;">Mata Pelajaran</td>
      <td style="width: 2%;">:</td>
      <td style="width: 18%; font-weight: bold;"><?= html_escape($mapel['nama_mapel'] ?? '-') ?></td>
    </tr>
    <tr>
      <td>Tahun Pelajaran</td>
      <td>:</td>
      <td><?= html_escape($active_tp['tahun']) ?> (<?= html_escape($active_tp['semester']) ?>)</td>
      <td>Tanggal Cetak</td>
      <td>:</td>
      <td><?= date('d M Y') ?></td>
    </tr>
  </table>

  <!-- Data Table -->
  <table class="data-table">
    <thead>
      <tr>
        <th class="text-center" style="width: 30px;">No</th>
        <th style="width: 100px;">NIS</th>
        <th>Nama Siswa</th>
        <th class="text-center" style="width: 60px;">Hadir (H)</th>
        <th class="text-center" style="width: 60px;">Sakit (S)</th>
        <th class="text-center" style="width: 60px;">Izin (I)</th>
        <th class="text-center" style="width: 60px;">Alpa (A)</th>
        <th class="text-center" style="width: 65px;">Terlambat (T)</th>
        <th class="text-center" style="width: 65px;">Dispen (D)</th>
        <th class="text-center" style="width: 90px;">% Kehadiran</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($siswa)): ?>
        <tr>
          <td colspan="10" class="text-center" style="padding: 20px;">Tidak ada data siswa ditemukan.</td>
        </tr>
      <?php else: ?>
        <?php $no=1; foreach ($siswa as $s): 
          $s_id = $s['id'];
          $hadir = isset($rekap[$s_id]['Hadir']) ? $rekap[$s_id]['Hadir'] : 0;
          $sakit = isset($rekap[$s_id]['Sakit']) ? $rekap[$s_id]['Sakit'] : 0;
          $izin = isset($rekap[$s_id]['Izin']) ? $rekap[$s_id]['Izin'] : 0;
          $alpa = isset($rekap[$s_id]['Alpa']) ? $rekap[$s_id]['Alpa'] : 0;
          $terlambat = isset($rekap[$s_id]['Terlambat']) ? $rekap[$s_id]['Terlambat'] : 0;
          $dispen = isset($rekap[$s_id]['Dispen']) ? $rekap[$s_id]['Dispen'] : 0;
          
          $total = $hadir + $sakit + $izin + $alpa + $terlambat + $dispen;
          $persen = ($total > 0) ? round((($hadir + $terlambat + $dispen) / $total) * 100, 1) . '%' : '100%';
        ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= html_escape($s['nis']) ?></td>
            <td><strong><?= html_escape($s['nama_lengkap']) ?></strong></td>
            <td class="text-center text-success"><?= $hadir ?></td>
            <td class="text-center"><?= $sakit ?></td>
            <td class="text-center"><?= $izin ?></td>
            <td class="text-center text-danger"><?= $alpa ?></td>
            <td class="text-center"><?= $terlambat ?></td>
            <td class="text-center text-purple"><?= $dispen ?></td>
            <td class="text-center" style="font-weight: bold;"><?= $persen ?></td>
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
      <td style="text-align: right;">
        <p><?= html_escape($settings['report_city'] ?? 'Malang') ?>, <?= format_indo_date(date('Y-m-d')) ?></p>
        <p style="margin-bottom: 50px;">Staf Tata Usaha / Guru Pengampu</p>
        <p style="font-weight: bold; text-decoration: underline;"><?= html_escape($settings['printed_by'] ?? $this->session->userdata('user_session')['full_name'] ?? 'Guru Pengampu') ?></p>
      </td>
    </tr>
  </table>

</body>
</html>
