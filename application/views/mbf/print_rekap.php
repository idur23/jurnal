<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= html_escape($title ?? 'Cetak Laporan Presensi MBF') ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; position: relative; }
        .header img { height: 60px; position: absolute; left: 0; top: 0; }
        .header-title { font-size: 18px; font-weight: bold; text-transform: uppercase; }
        .header-sub { font-size: 14px; font-weight: bold; }
        .meta-table { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .meta-table td { padding: 4px; vertical-align: top; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        .data-table th { background-color: #eee; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .signature-table { width: 100%; margin-top: 40px; page-break-inside: avoid; }
        .signature-table td { width: 50%; text-align: center; vertical-align: top; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Cetak Dokumen
        </button>
        <button onclick="window.close()" style="padding: 8px 16px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Tutup
        </button>
    </div>

    <div class="header">
        <?php if (!empty($settings['app_logo']) && file_exists('./' . $settings['app_logo'])): ?>
            <img src="<?= base_url($settings['app_logo']) ?>">
        <?php endif; ?>
        <div class="header-title"><?= html_escape($settings['app_institution'] ?? 'NAMA SEKOLAH') ?></div>
        <div class="header-sub">LAPORAN PRESENSI MBF</div>
        <div style="font-size: 11px;"><?= html_escape($settings['app_address'] ?? '') ?></div>
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
            <td><strong>Tanggal Cetak</strong></td>
            <td>: <?= date('d M Y H:i') ?></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="100">NIS</th>
                <th>Nama Siswa</th>
                <th width="100">Kelas</th>
                <th width="50">Hadir</th>
                <th width="50">Izin</th>
                <th width="50">Sakit</th>
                <th width="50">Alpa</th>
                <th width="60">Total</th>
                <th width="80">% Kehadiran</th>
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
                Kepala Sekolah / Madrasah<br><br><br><br><br>
                <strong><?= html_escape($settings['headmaster_name'] ?? 'Kepala Sekolah') ?></strong><br>
                NIP. <?= html_escape($settings['headmaster_nip'] ?? '-') ?>
            </td>
            <td>
                Dicetak oleh,<br>
                Tentor / Admin MBF<br><br><br><br><br>
                <strong><?= html_escape($settings['printed_by'] ?? 'Staf Administrator') ?></strong>
            </td>
        </tr>
    </table>

</body>
</html>
