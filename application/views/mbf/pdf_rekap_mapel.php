<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= html_escape($title ?? 'Laporan Presensi MBF') ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 15px; }
        .header img { height: 50px; float: left; }
        .header-title { font-size: 16px; font-weight: bold; text-transform: uppercase; }
        .header-sub { font-size: 12px; }
        .meta-table { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .meta-table td { padding: 4px; vertical-align: top; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #666; padding: 6px 8px; text-align: left; }
        .data-table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .signature-table { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .signature-table td { width: 50%; text-align: center; vertical-align: top; }
    </style>
</head>
<body>

    <div class="header">
        <?php if (!empty($settings['app_logo']) && file_exists('./' . $settings['app_logo'])): ?>
            <img src="<?= base_url($settings['app_logo']) ?>">
        <?php endif; ?>
        <div class="header-title"><?= html_escape($settings['app_institution'] ?? 'NAMA SEKOLAH') ?></div>
        <div class="header-sub">LAPORAN PRESENSI MBF</div>
        <div style="font-size: 10px; color: #555;"><?= html_escape($settings['app_address'] ?? '') ?></div>
    </div>

    <table class="meta-table">
        <tr>
            <td width="15%"><strong>Mapel MBF</strong></td>
            <td width="35%">: <?= html_escape($mapel['nama_mapel']) ?> (<?= html_escape($mapel['kode_mapel']) ?>)</td>
            <td width="15%"><strong>Tahun Pelajaran</strong></td>
            <td width="35%">: <?= html_escape($active_tp['tahun'] ?? '-') ?> (<?= html_escape($active_tp['semester'] ?? '-') ?>)</td>
        </tr>
        <tr>
            <td><strong>Tentor</strong></td>
            <td>: <?= html_escape($mapel['nama_tentor']) ?></td>
            <td><strong>Tanggal Unduh</strong></td>
            <td>: <?= date('d M Y H:i') ?></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="90">NIS</th>
                <th>Nama Siswa</th>
                <th width="90">Kelas</th>
                <th width="45">Hadir</th>
                <th width="45">Izin</th>
                <th width="45">Sakit</th>
                <th width="45">Alpa</th>
                <th width="50">Total</th>
                <th width="65">% Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rekap)): ?>
                <?php $no = 1; foreach ($rekap as $r): $s = $r['siswa']; ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= html_escape($s['nis']) ?></td>
                        <td><?= html_escape($s['nama_lengkap']) ?></td>
                        <td class="text-center"><?= html_escape($s['nama_kelas']) ?></td>
                        <td class="text-center"><?= $r['Hadir'] ?></td>
                        <td class="text-center"><?= $r['Izin'] ?></td>
                        <td class="text-center"><?= $r['Sakit'] ?></td>
                        <td class="text-center"><?= $r['Alpa'] ?></td>
                        <td class="text-center"><strong><?= $r['total'] ?></strong></td>
                        <td class="text-center"><strong><?= $r['persentase'] ?>%</strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center">Belum ada data presensi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                Kepala Sekolah / Madrasah<br><br><br><br>
                <strong><?= html_escape($settings['headmaster_name'] ?? 'Kepala Sekolah') ?></strong><br>
                NIP. <?= html_escape($settings['headmaster_nip'] ?? '-') ?>
            </td>
            <td>
                Dicetak oleh,<br>
                Tentor / Admin MBF<br><br><br><br>
                <strong><?= html_escape($settings['printed_by'] ?? 'Staf Administrator') ?></strong>
            </td>
        </tr>
    </table>

</body>
</html>
