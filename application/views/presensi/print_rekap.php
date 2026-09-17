<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Rekapitulasi Presensi Siswa</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; color: #000; }
    .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
    .header h2 { margin: 0; text-transform: uppercase; font-size: 18px; font-weight: bold; }
    .header p { margin: 4px 0 0 0; font-size: 13px; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid #333; padding: 7px 9px; text-align: left; vertical-align: middle; }
    th { background-color: #f2f2f2; font-weight: bold; font-size: 12px; text-align: center; }
    .text-center { text-align: center; }
    .signature-box { margin-top: 35px; float: right; width: 280px; text-align: center; font-size: 12px; }
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
        <h2 style="margin: 0; font-size: 15px; text-transform: uppercase; font-weight: bold;"><?= html_escape($settings['app_institution'] ?? 'MA DARUL FAQIH') ?></h2>
        <p style="margin: 3px 0 0 0; font-size: 12px; font-weight: bold; color: #333;">REKAPITULASI PRESENSI SISWA PER BULAN</p>
        <p style="margin: 3px 0 0 0; font-size: 10px; color: #555;">Kelas: <?= html_escape($kelas['nama_kelas'] ?? '-') ?> | Periode: <?= date('F', mktime(0, 0, 0, $selected_bulan, 10)) ?> <?= $selected_tahun ?></p>
      </td>
      <td style="width: 15%; text-align: right; vertical-align: middle; border: none; padding: 0;">
        <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
          <img src="<?= base_url($settings['app_logo_right']) ?>" style="max-height: 85px; max-width: 85px; object-fit: contain;">
        <?php endif; ?>
      </td>
    </tr>
  </table>

  <table>
    <thead>
      <tr>
        <th style="width: 30px;">#</th>
        <th>NIS</th>
        <th>Nama Siswa</th>
        <th style="width: 80px;">Hadir (H)</th>
        <th style="width: 80px;">Izin (I)</th>
        <th style="width: 80px;">Sakit (S)</th>
        <th style="width: 80px;">Alpa (A)</th>
        <th style="width: 80px;">Dispen (D)</th>
        <th style="width: 100px;">% Kehadiran</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($rekap_presensi)): ?>
        <tr>
          <td colspan="9" class="text-center">Tidak ada data presensi ditemukan.</td>
        </tr>
      <?php else: ?>
        <?php $no=1; foreach ($rekap_presensi as $r): 
          $total = $r['hadir'] + $r['izin'] + $r['sakit'] + $r['alpa'] + $r['dispen'];
          $persen = ($total > 0) ? round(($r['hadir'] / $total) * 100, 1) : 0;
        ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= html_escape($r['nis']) ?></td>
            <td><strong><?= html_escape($r['nama_lengkap']) ?></strong></td>
            <td class="text-center"><?= $r['hadir'] ?></td>
            <td class="text-center"><?= $r['izin'] ?></td>
            <td class="text-center"><?= $r['sakit'] ?></td>
            <td class="text-center"><?= $r['alpa'] ?></td>
            <td class="text-center"><?= $r['dispen'] ?></td>
            <td class="text-center" style="font-weight: bold;"><?= $persen ?>%</td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Dynamic Signature Section -->
  <div class="signature-box" style="margin-top: 35px; width: 100%; clear: both;">
    <table style="width: 100%; border: none;">
      <tr style="border: none;">
        <td style="text-align: left; vertical-align: top; border: none; width: 50%;">
          <p style="margin: 0;">Mengetahui,</p>
          <p style="margin: 5px 0 50px 0;"><?= html_escape($settings['report_signer_title'] ?? 'Kepala Madrasah') ?></p>
          <p style="margin: 0;"><strong><u><?= html_escape($settings['headmaster_name'] ?? 'M. Fakhrur Rozi, M.Pd') ?></u></strong></p>
          <p style="margin: 3px 0 0 0;">NIP. <?= html_escape($settings['headmaster_nip'] ?? '001') ?></p>
        </td>
        <td style="text-align: right; vertical-align: top; border: none; width: 50%;">
          <p style="margin: 0;"><?= html_escape($settings['report_city'] ?? 'Malang') ?>, <?= format_indo_date(date('Y-m-d')) ?></p>
          <p style="margin: 5px 0 50px 0;">Staf Tata Usaha</p>
          <p style="margin: 0;"><strong><u><?= html_escape($settings['printed_by'] ?? 'Administrator') ?></u></strong></p>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
