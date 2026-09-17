<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= html_escape($title) ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; background: #fff; padding: 15px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #555; padding: 4px 6px; vertical-align: middle; }
        th { background-color: #e8e8e8; font-weight: bold; text-align: center; }
        tr:nth-child(even) td { background-color: #f8f8f8; }
        .header-table td { border: none; padding: 2px; }
        .kop-border { border-bottom: 2.5px double #333; padding-bottom: 10px; margin-bottom: 10px; }
        .title-section { text-align: center; margin: 10px 0; }
        .title-section h2 { font-size: 13px; text-transform: uppercase; font-weight: bold; }
        .title-section p { font-size: 10px; color: #555; margin-top: 3px; }
        .footer-text { margin-top: 10px; font-size: 9px; color: #777; text-align: right; }
        .no-print { margin-bottom: 15px; }
        .btn-print { display:inline-block; padding:8px 20px; background:#0d6efd; color:#fff; border:none; border-radius:5px; cursor:pointer; font-size:13px; font-weight:bold; }
        .btn-close { display:inline-block; padding:8px 20px; background:#6c757d; color:#fff; border:none; border-radius:5px; cursor:pointer; font-size:13px; margin-left:8px; }
        @media print { .no-print { display: none !important; } body { padding: 5px; } }
    </style>
</head>
<body>
    <div class="no-print" style="padding:10px; background:#f0f4ff; border:1px solid #c0c8f0; border-radius:6px; margin-bottom:15px;">
        <strong>Preview Data Siswa</strong> &mdash; Filter: <?= html_escape($label_filter) ?> &mdash; Total: <?= count($list_siswa) ?> siswa
        <span style="float:right;">
            <button class="btn-print" onclick="window.print()">Cetak Sekarang</button>
            <button class="btn-close" onclick="window.close()">Tutup</button>
        </span>
    </div>
    <table class="header-table kop-border" style="margin-bottom:10px;">
        <tr>
            <td style="width:12%; text-align:left; vertical-align:middle;">
                <?php if (!empty($settings['app_logo_left']) && file_exists('./' . $settings['app_logo_left'])): ?>
                    <img src="<?= get_image_base64('./' . $settings['app_logo_left']) ?>" style="max-height:55px; max-width:55px; object-fit:contain;">
                <?php endif; ?>
            </td>
            <td style="width:76%; text-align:center; vertical-align:middle;">
                <strong style="font-size:14px; text-transform:uppercase; display:block;"><?= html_escape($settings['app_institution'] ?? 'Sekolah') ?></strong>
                <span style="font-size:10px;"><?= html_escape($settings['app_address'] ?? '') ?></span><br>
                <span style="font-size:10px;">Telp. <?= html_escape($settings['app_phone'] ?? '-') ?></span>
            </td>
            <td style="width:12%; text-align:right; vertical-align:middle;">
                <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
                    <img src="<?= get_image_base64('./' . $settings['app_logo_right']) ?>" style="max-height:55px; max-width:55px; object-fit:contain;">
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <div class="title-section">
        <h2>Daftar Data Siswa</h2>
        <p>Filter: <?= html_escape($label_filter) ?> &nbsp;&middot;&nbsp; Dicetak: <?= date('d M Y H:i') ?></p>
    </div>
    <table style="margin-top:10px;">
        <thead>
            <tr>
                <th style="width:4%;">No</th>
                <th style="width:10%;">NIS</th>
                <th style="width:12%;">NISN</th>
                <th style="width:32%;">Nama Lengkap</th>
                <th style="width:5%;">JK</th>
                <th style="width:9%;">Angkatan</th>
                <th style="width:18%;">Kelas</th>
                <th style="width:10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($list_siswa)): ?>
                <tr><td colspan="8" style="text-align:center; color:#888; padding:15px;">Tidak ada data siswa.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach ($list_siswa as $s): ?>
                    <tr>
                        <td style="text-align:center;"><?= $no++ ?></td>
                        <td><?= html_escape($s['nis']) ?></td>
                        <td><?= html_escape($s['nisn']) ?></td>
                        <td><?= html_escape($s['nama_lengkap']) ?></td>
                        <td style="text-align:center;"><?= html_escape($s['jk']) ?></td>
                        <td style="text-align:center;">Kelas <?= html_escape($s['tingkat']) ?></td>
                        <td><?= html_escape($s['nama_kelas']) ?></td>
                        <td style="text-align:center;"><?= ($s['status_aktif'] == 1) ? 'Aktif' : 'Non-Aktif' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="footer-text">Total: <?= count($list_siswa) ?> siswa &nbsp;|&nbsp; <?= html_escape($settings['app_name'] ?? 'Jurnal Guru') ?> &nbsp;|&nbsp; <?= date('d M Y H:i') ?></div>
</body>
</html>
