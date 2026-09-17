<!DOCTYPE html>
<html>
<head>
  <title><?= html_escape($title) ?></title>
  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      color: #333;
      font-size: 10px;
      margin: 0;
      padding: 0;
    }
    .header-table {
      width: 100%;
      border-bottom: 2px solid #333;
      padding-bottom: 10px;
      margin-bottom: 15px;
    }
    .header-table td {
      vertical-align: middle;
    }
    .logo-container {
      width: 80px;
      text-align: left;
    }
    .logo {
      max-height: 60px;
    }
    .school-info {
      text-align: center;
    }
    .school-name {
      font-size: 14px;
      font-weight: bold;
      text-transform: uppercase;
      margin: 0 0 5px 0;
    }
    .school-sub {
      font-size: 10px;
      color: #555;
      margin: 0;
    }
    .title {
      font-size: 12px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 15px;
      text-transform: uppercase;
    }
    .meta-table {
      width: 100%;
      margin-bottom: 15px;
      font-size: 10px;
    }
    .meta-table td {
      padding: 2px 0;
    }
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    .data-table th, .data-table td {
      border: 1px solid #777;
      padding: 5px 6px;
      text-align: left;
      vertical-align: middle;
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
      padding: 2px 4px;
      font-weight: bold;
      border-radius: 3px;
    }
  </style>
</head>
<body>

  <!-- Kop Surat -->
  <table class="header-table" style="width: 100%; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; border-collapse: collapse; border: none;">
    <tr style="border: none;">
      <td style="width: 15%; text-align: left; vertical-align: middle; border: none; padding: 0;">
        <?php if (!empty($settings['app_logo_left']) && file_exists('./' . $settings['app_logo_left'])): ?>
          <img src="<?= base_url($settings['app_logo_left']) ?>" style="max-height: 55px; max-width: 55px; object-fit: contain;">
        <?php endif; ?>
      </td>
      <td style="width: 70%; text-align: center; vertical-align: middle; border: none; padding: 0;">
        <h1 style="font-size: 16px; font-weight: bold; text-transform: uppercase; margin: 0 0 5px 0;"><?= html_escape($settings['app_institution'] ?? 'SMA Negeri Enterprise 1') ?></h1>
        <p style="font-size: 11px; color: #666; margin: 0 0 3px 0;"><?= html_escape($settings['app_name'] ?? 'Jurnal Guru Enterprise') ?></p>
        <p style="font-size: 10px; color: #666; margin: 0;"><?= html_escape($settings['app_address'] ?? 'Jl. Edukasi No. 1, Kota Enterprise') ?></p>
      </td>
      <td style="width: 15%; text-align: right; vertical-align: middle; border: none; padding: 0;">
        <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
          <img src="<?= base_url($settings['app_logo_right']) ?>" style="max-height: 55px; max-width: 55px; object-fit: contain;">
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
      <td style="width: 48%; font-weight: bold;"><?= html_escape($active_tp['tahun']) ?> (Semester <?= html_escape($active_tp['semester']) ?>)</td>
      <td style="width: 15%;">Mata Pelajaran</td>
      <td style="width: 2%;">:</td>
      <td style="width: 18%; font-weight: bold;"><?= $selected_mapel ? html_escape($selected_mapel['nama_mapel']) : 'Semua Mapel' ?></td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td>:</td>
      <td><?= $selected_kelas ? html_escape($selected_kelas['nama_kelas']) : 'Semua Kelas' ?></td>
      <td>Guru Pengampu</td>
      <td>:</td>
      <td><?= $selected_guru ? html_escape($selected_guru['nama_lengkap']) : 'Semua Guru' ?></td>
    </tr>
    <tr>
      <td>Tanggal Cetak</td>
      <td>:</td>
      <td><?= date('d M Y H:i') ?></td>
      <td>Total Berkas</td>
      <td>:</td>
      <td style="font-weight: bold;"><?= count($list) ?> Dokumen</td>
    </tr>
  </table>

  <!-- Data Table -->
  <table class="data-table">
    <thead>
      <tr>
        <th class="text-center" style="width: 30px;">No</th>
        <th style="width: 100px;">Jenis Perangkat</th>
        <th style="width: 120px;">Mata Pelajaran</th>
        <th class="text-center" style="width: 50px;">Kelas</th>
        <th>Guru Pengampu</th>
        <th style="width: 110px;">Semester / Pertemuan</th>
        <th class="text-center" style="width: 40px;">Versi</th>
        <th class="text-center" style="width: 80px;">Status</th>
        <th style="width: 90px;">Tanggal Unggah</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($list)): ?>
        <tr>
          <td colspan="9" class="text-center" style="padding: 20px;">Tidak ada data perangkat ajar ditemukan.</td>
        </tr>
      <?php else: ?>
        <?php $no = 1; foreach ($list as $item): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td style="font-weight: bold;"><?= html_escape($item['jenis_perangkat']) ?></td>
            <td><?= html_escape($item['nama_mapel']) ?></td>
            <td class="text-center"><?= html_escape($item['nama_kelas']) ?></td>
            <td><?= html_escape($item['nama_guru']) ?></td>
            <td>Semester <?= html_escape($item['semester']) ?> (Pertemuan <?= $item['pertemuan_ke'] ?>)</td>
            <td class="text-center">v<?= $item['version'] ?></td>
            <td class="text-center">
              <strong><?= html_escape($item['status_verifikasi']) ?></strong>
            </td>
            <td><?= date('d-m-Y H:i', strtotime($item['created_at'])) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>
