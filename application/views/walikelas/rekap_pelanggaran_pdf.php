<!DOCTYPE html>
<html>
<head>
    <title><?= html_escape($title) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
        }
        .header-table td {
            padding: 5px;
            vertical-align: middle;
        }
        .school-name {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .school-subtitle {
            font-size: 11px;
            margin-top: 3px;
        }
        .school-info {
            font-size: 9px;
            color: #555;
            margin-top: 3px;
        }
        .report-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .meta-table td {
            font-size: 11px;
            padding: 3px 0;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            font-size: 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .badge-danger {
            background-color: #fde8e8;
            color: #9b1c1c;
        }
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-success {
            background-color: #def7ec;
            color: #03543f;
        }
        .signature-container {
            width: 100%;
            margin-top: 40px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 11px;
        }
        .signature-space {
            height: 60px;
        }
    </style>
</head>
<body>

    <!-- Header / Kop Surat -->
    <table class="header-table">
        <tr>
            <td style="width: 10%;">
                <?php if (!empty($settings['app_logo_left']) && file_exists('./' . $settings['app_logo_left'])): ?>
                    <img src="<?= get_image_base64('./' . $settings['app_logo_left']) ?>" style="max-height: 55px; max-width: 55px; object-fit: contain;">
                <?php endif; ?>
            </td>
            <td style="width: 80%; text-align: center;">
                <div class="school-name"><?= html_escape($settings['app_name'] ?? 'JURNAL GURU ENTERPRISE') ?></div>
                <div class="school-subtitle"><?= html_escape($settings['app_slogan'] ?? 'Pusat Monitoring dan Informasi Akademik Sekolah') ?></div>
                <div class="school-info"><?= html_escape($settings['app_address'] ?? '') ?></div>
            </td>
            <td style="width: 10%; text-align: right;">
                <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
                    <img src="<?= get_image_base64('./' . $settings['app_logo_right']) ?>" style="max-height: 55px; max-width: 55px; object-fit: contain;">
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <div class="report-title">REKAPITULASI PELANGGARAN SISWA</div>

    <!-- Metadata -->
    <table class="meta-table">
        <tr>
            <td style="width: 15%;"><strong>Kelas</strong></td>
            <td style="width: 35%;">: <?= html_escape($kelas['nama_kelas']) ?></td>
            <td style="width: 20%;"><strong>Tahun Pelajaran</strong></td>
            <td style="width: 30%;">: <?= html_escape($active_tp['tahun']) ?></td>
        </tr>
        <tr>
            <td><strong>Wali Kelas</strong></td>
            <td>: <?= html_escape($kelas['nama_guru']) ?></td>
            <td><strong>Semester</strong></td>
            <td>: <?= html_escape($active_tp['semester']) ?></td>
        </tr>
    </table>

    <!-- Main Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 40px;" class="text-center">No</th>
                <th style="width: 100px;">NIS</th>
                <th>Nama Lengkap</th>
                <th style="width: 90px;" class="text-center">Jenis Kelamin</th>
                <th style="width: 90px;" class="text-center">Total Kasus</th>
                <th style="width: 100px;" class="text-center">Akumulasi Poin</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($list_siswa as $s): 
                $poin = $s['total_poin'];
                if ($poin == 0) {
                    $class = 'badge-success';
                } elseif ($poin <= 10) {
                    $class = 'badge-success';
                } elseif ($poin <= 30) {
                    $class = 'badge-warning';
                } else {
                    $class = 'badge-danger';
                }
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><code><?= html_escape($s['nis']) ?></code></td>
                    <td style="font-weight: bold;"><?= html_escape($s['nama_lengkap']) ?></td>
                    <td class="text-center"><?= $s['jk'] == 'L' ? 'Laki-Laki' : 'Perempuan' ?></td>
                    <td class="text-center"><?= $s['total_kasus'] ?> Kasus</td>
                    <td class="text-center">
                        <span class="badge <?= $class ?>"><?= $poin ?> Poin</span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Signature / Tanda Tangan -->
    <div class="signature-container">
        <table class="signature-table">
            <tr>
                <td>
                    Mengetahui,<br>
                    Kepala Sekolah
                    <div class="signature-space"></div>
                    <strong>( ___________________________ )</strong><br>
                    NIP. ........................................
                </td>
                <td>
                    Madrasah, <?= date('d M Y') ?><br>
                    Wali Kelas <?= html_escape($kelas['nama_kelas']) ?>
                    <div class="signature-space"></div>
                    <strong><?= html_escape($kelas['nama_guru']) ?></strong><br>
                    NIP. <?= html_escape($kelas['nip_guru'] ?? '........................................') ?>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
