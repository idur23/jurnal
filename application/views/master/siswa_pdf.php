<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= html_escape($title) ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; color: #333; margin: 0; padding: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #333; padding: 4px 6px; vertical-align: middle; }
        th { background-color: #e8e8e8; font-weight: bold; text-align: center; }
        .header-table td { border: none; padding: 0; }
        .title-section { text-align: center; margin: 14px 0 10px 0; }
        .title-section h2 { font-size: 13px; text-transform: uppercase; margin: 0 0 2px 0; }
        .title-section p { font-size: 10px; margin: 0; color: #555; }
        .footer { margin-top: 16px; font-size: 9px; color: #777; text-align: right; }
        tr:nth-child(even) td { background-color: #fafafa; }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <table class="header-table" style="width: 100%; border-bottom: 2px solid #333; padding-bottom: 8px; margin-bottom: 0;">
        <tr>
            <td style="width: 12%; text-align: left; vertical-align: middle;">
                <?php if (!empty($settings['app_logo_left']) && file_exists('./' . $settings['app_logo_left'])): ?>
                    <img src="<?= get_image_base64('./' . $settings['app_logo_left']) ?>" style="max-height: 85px; max-width: 85px; object-fit: contain;">
                <?php endif; ?>
            </td>
            <td style="width: 76%; text-align: center; vertical-align: middle;">
                <strong style="font-size: 14px; text-transform: uppercase;"><?= html_escape($settings['app_institution'] ?? 'Madrasah') ?></strong><br>
                <span style="font-size: 10px;"><?= html_escape($settings['app_address'] ?? '') ?></span><br>
                <span style="font-size: 10px;">Telp. <?= html_escape($settings['app_phone'] ?? '-') ?></span>
            </td>
            <td style="width: 12%; text-align: right; vertical-align: middle;">
                <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
                    <img src="<?= get_image_base64('./' . $settings['app_logo_right']) ?>" style="max-height: 85px; max-width: 85px; object-fit: contain;">
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <!-- Judul -->
    <div class="title-section">
        <h2>Data Siswa</h2>
        <p>Filter: <?= html_escape($label_filter) ?> &nbsp;&middot;&nbsp; Dicetak: <?= date('d M Y H:i') ?></p>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 10%;">NIS</th>
                <th style="width: 12%;">NISN</th>
                <th style="width: 30%;">Nama Lengkap</th>
                <th style="width: 5%;">JK</th>
                <th style="width: 8%;">Angkatan</th>
                <th style="width: 18%;">Kelas</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($list_siswa)): ?>
                <tr><td colspan="8" style="text-align:center; color:#888;">Tidak ada data siswa.</td></tr>
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

    <div class="footer">
        Total: <?= count($list_siswa) ?> siswa &nbsp;|&nbsp; <?= html_escape($settings['app_name'] ?? 'Jurnal Guru') ?>
    </div>
</body>
</html>
