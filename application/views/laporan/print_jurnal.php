<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Jurnal Guru Enterprise</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; color: #000; }
    .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
    .header h2 { margin: 0; text-transform: uppercase; font-size: 18px; font-weight: bold; }
    .header p { margin: 4px 0 0 0; font-size: 13px; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid #333; padding: 7px 9px; text-align: left; vertical-align: top; }
    th { background-color: #f2f2f2; font-weight: bold; font-size: 12px; }
    .text-center { text-align: center; }
    .signature-box { margin-top: 35px; width: 100%; font-size: 12px; clear: both; }
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
        <p style="margin: 3px 0 0 0; font-size: 12px; font-weight: bold; color: #333;"><?= html_escape($settings['report_header_title'] ?? 'LAPORAN JURNAL KEGIATAN BELAJAR MENGAJAR (KBM)') ?></p>
        <p style="margin: 3px 0 0 0; font-size: 10px; color: #555;">Tahun Pelajaran: <?= html_escape($active_tp['tahun'] ?? '-') ?> (Semester <?= html_escape($active_tp['semester'] ?? '-') ?>)</p>
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
        <th style="width: 30px;" class="text-center">#</th>
        <th style="width: 85px;">Tanggal</th>
        <th style="width: 60px;" class="text-center">Jam Ke</th>
        <th style="width: 120px;">Kelas & Mapel</th>
        <th style="width: 110px;">Guru Pengampu</th>
        <th>Materi Pembelajaran</th>
        <th style="width: 130px;">Ketidakhadiran (S/I/A/D)</th>
        <th style="width: 90px;" class="text-center">Dokumentasi</th>
        <th style="width: 65px;" class="text-center">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($jurnal_list)): ?>
        <tr>
          <td colspan="9" class="text-center">Tidak ada data jurnal ditemukan.</td>
        </tr>
      <?php else: ?>
        <?php $no=1; foreach ($jurnal_list as $j): 
          // Fetch absent students
          $absents = $this->db->select('siswa.nama_lengkap, presensi_siswa.status')
                              ->join('siswa', 'siswa.id = presensi_siswa.siswa_id')
                              ->join('presensi_kelas', 'presensi_kelas.id = presensi_siswa.presensi_kelas_id')
                              ->get_where('presensi_siswa', array('presensi_kelas.jurnal_id' => $j['id'], 'presensi_siswa.status !=' => 'Hadir'))
                              ->result_array();
          $absent_list = array();
          foreach ($absents as $a) {
              $absent_list[] = html_escape($a['nama_lengkap']) . ' (' . substr($a['status'], 0, 1) . ')';
          }
          $absent_str = empty($absent_list) ? '<span style="color:#888; font-style:italic;">Nihil</span>' : implode(', ', $absent_list);
        ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= $j['tanggal'] ?></td>
            <td class="text-center"><?= $j['jam_ke'] ?></td>
            <td><strong><?= html_escape($j['nama_kelas']) ?></strong><br><small><?= html_escape($j['nama_mapel']) ?></small></td>
            <td><?= html_escape($j['nama_guru']) ?></td>
            <td>
              <strong><?= nl2br(html_escape($j['materi_pembelajaran'])) ?></strong>
              <?php if (!empty($j['indikator_tp'])): ?>
                <div style="margin-top: 4px; font-size: 10px; color: #555;">
                  <strong>Indikator/Tujuan:</strong> <?= html_escape($j['indikator_tp']) ?>
                </div>
              <?php endif; ?>
              <?php if (!empty($j['hambatan_solusi'])): ?>
                <div style="margin-top: 2px; font-size: 10px; color: #b55;">
                  <strong>Hambatan & Solusi:</strong> <?= html_escape($j['hambatan_solusi']) ?>
                </div>
              <?php endif; ?>
            </td>
            <td style="font-size: 11px;"><?= $absent_str ?></td>
            <td class="text-center">
              <?php if (!empty($j['file_dokumentasi'])): ?>
                <?php 
                  $media_src = gdrive_media_url($j['file_dokumentasi']);
                  $ext = pathinfo(parse_url($j['file_dokumentasi'], PHP_URL_PATH), PATHINFO_EXTENSION);
                  if (empty($ext) || in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif', 'webp')) || strpos($j['file_dokumentasi'], 'drive.google.com') !== false):
                ?>
                  <img src="<?= $media_src ?>" style="max-height: 50px; max-width: 80px; border-radius: 3px; border: 1px solid #ccc;" alt="Dokumentasi">
                <?php else: ?>
                  <span style="font-size: 9px; color:#555;">[Dokumen <?= strtoupper($ext ? $ext : 'FILE') ?>]</span>
                <?php endif; ?>

              <?php else: ?>
                <span style="color:#aaa;">-</span>
              <?php endif; ?>
            </td>
            <td class="text-center"><span style="font-size:10px; font-weight:bold; color:green;"><?= $j['status'] ?></span></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Dynamic Signature Section -->
  <div class="signature-box" style="margin-top: 30px;">
    <table style="width: 100%; border: none;">
      <tr>
        <td style="text-align: left; vertical-align: top; border: none; width: 50%;">
          <p>Mengetahui,</p>
          <p style="margin-bottom: 50px;"><?= html_escape($settings['report_signer_title'] ?? 'Kepala Madrasah') ?></p>
          <p><strong><u><?= html_escape($settings['headmaster_name'] ?? $settings['report_signer_name'] ?? 'M. Fakhrur Rozi, M.Pd') ?></u></strong><br>
          NIP. <?= html_escape($settings['headmaster_nip'] ?? $settings['report_signer_nip'] ?? '001') ?></p>
        </td>
        <td style="text-align: right; vertical-align: top; border: none; width: 50%;">
          <p><?= html_escape($settings['report_city'] ?? 'Malang') ?>, <?= format_indo_date(date('Y-m-d')) ?></p>
          <p style="margin-bottom: 50px;">Staf Tata Usaha</p>
          <p><strong><u><?= html_escape($settings['printed_by'] ?? $_user['full_name'] ?? 'Administrator') ?></u></strong></p>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
