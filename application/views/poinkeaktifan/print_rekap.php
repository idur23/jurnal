<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cetak Rekapitulasi Poin Keaktifan Siswa</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 20px; }
    .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
    .header h2 { margin: 0 0 5px 0; font-size: 18px; text-transform: uppercase; }
    .header p { margin: 0; font-size: 12px; color: #555; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    table, th, td { border: 1px solid #666; }
    th { background-color: #f2f2f2; padding: 8px; text-align: left; }
    td { padding: 6px 8px; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .footer { margin-top: 30px; float: right; width: 250px; text-align: center; }
    @media print {
      .no-print { display: none; }
    }
  </style>
</head>
<body onload="window.print()">
  <div class="no-print" style="margin-bottom: 15px;">
    <button onclick="window.print()" style="padding: 8px 16px; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 4px;">Cetak Sekarang</button>
  </div>

  <div class="header">
    <h2><?= html_escape($settings['app_institution'] ?? 'Website Jurnal Guru') ?></h2>
    <h3>REKAPITULASI POIN KEAKTIFAN SISWA</h3>
    <p>Periode Bulan: <?= (int)$filters['bulan'] ?> - Tahun: <?= (int)$filters['tahun'] ?> | Tanggal Cetak: <?= date('d/m/Y H:i') ?></p>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width: 30px;" class="text-center">No</th>
        <th style="width: 100px;">NIS</th>
        <th>Nama Siswa</th>
        <th style="width: 40px;" class="text-center">JK</th>
        <th style="width: 90px;">Kelas</th>
        <th style="width: 110px;" class="text-center">Sesi Jurnal Aktif</th>
        <th style="width: 120px;" class="text-right">Total Poin Keaktifan</th>
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
    <p>Dicetak Pada: <?= date('d F Y') ?></p>
    <br><br><br>
    <p>__________________________<br>Wali Kelas / Guru Pengampu</p>
  </div>
</body>
</html>
