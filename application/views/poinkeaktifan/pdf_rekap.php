<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Rekapitulasi Poin Keaktifan Siswa PDF</title>
  <style>
    body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #222; margin: 10px; }
    .header { text-align: center; border-bottom: 2px solid #222; padding-bottom: 8px; margin-bottom: 15px; }
    .header h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
    .header h3 { margin: 4px 0; font-size: 13px; font-weight: normal; }
    .header p { margin: 0; font-size: 10px; color: #666; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    table, th, td { border: 1px solid #444; }
    th { background-color: #e6e6e6; padding: 6px; text-align: left; font-size: 11px; }
    td { padding: 5px 6px; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .footer { margin-top: 25px; float: right; width: 200px; text-align: center; font-size: 11px; }
  </style>
</head>
<body>
  <div class="header">
    <h2><?= html_escape($settings['app_institution'] ?? 'Sekolah Enterprise') ?></h2>
    <h3>REKAPITULASI POIN KEAKTIFAN SISWA</h3>
    <p>Periode Bulan: <?= (int)$filters['bulan'] ?> - Tahun: <?= (int)$filters['tahun'] ?> | Tanggal Unduh: <?= date('d/m/Y H:i') ?></p>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width: 25px;" class="text-center">No</th>
        <th style="width: 80px;">NIS</th>
        <th>Nama Siswa</th>
        <th style="width: 35px;" class="text-center">JK</th>
        <th style="width: 80px;">Kelas</th>
        <th style="width: 90px;" class="text-center">Sesi Jurnal</th>
        <th style="width: 100px;" class="text-right">Total Poin</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($rekap)): ?>
        <tr><td colspan="7" class="text-center">Tidak ada data rekap poin keaktifan.</td></tr>
      <?php else: ?>
        <?php $no = 1; foreach ($rekap as $r): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= html_escape($r['nis']) ?></td>
            <td><strong><?= html_escape($r['nama_lengkap']) ?></strong></td>
            <td class="text-center"><?= html_escape($r['jk']) ?></td>
            <td><?= html_escape($r['nama_kelas']) ?></td>
            <td class="text-center"><?= (int)$r['total_sesi_aktif'] ?> Sesi</td>
            <td class="text-right"><strong>+<?= (int)$r['total_poin'] ?></strong></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <div class="footer">
    <p>Tanggal: <?= date('d F Y') ?></p>
    <br><br><br>
    <p>__________________________<br>Penanggung Jawab</p>
  </div>
</body>
</html>
