<!DOCTYPE html>
<html>
<head>
    <title><?= html_escape($title) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #000;
            margin-bottom: 15px;
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
            font-size: 10px;
            margin-top: 3px;
        }
        .school-info {
            font-size: 8px;
            color: #555;
            margin-top: 3px;
        }
        .report-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .meta-table td {
            font-size: 10px;
            padding: 2px 0;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 9px;
        }
        .data-table td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 9px;
        }
        .text-center {
            text-align: center;
        }
        .signature-container {
            width: 100%;
            margin-top: 30px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 10px;
        }
        .signature-space {
            height: 50px;
        }
    </style>
</head>
<body>

    <!-- Header / Kop Surat -->
    <table class="header-table">
        <tr>
            <td style="width: 10%;">
                <?php if (!empty($settings['app_logo_left']) && file_exists('./' . $settings['app_logo_left'])): ?>
                    <img src="<?= get_image_base64('./' . $settings['app_logo_left']) ?>" style="max-height: 50px; max-width: 50px; object-fit: contain;">
                <?php endif; ?>
            </td>
            <td style="width: 80%; text-align: center;">
                <div class="school-name"><?= html_escape($settings['app_name'] ?? 'JURNAL GURU ENTERPRISE') ?></div>
                <div class="school-subtitle"><?= html_escape($settings['app_slogan'] ?? 'Pusat Monitoring dan Informasi Akademik Sekolah') ?></div>
                <div class="school-info"><?= html_escape($settings['app_address'] ?? '') ?></div>
            </td>
            <td style="width: 10%; text-align: right;">
                <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
                    <img src="<?= get_image_base64('./' . $settings['app_logo_right']) ?>" style="max-height: 50px; max-width: 50px; object-fit: contain;">
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <div class="report-title">REKAPITULASI NILAI RAPOR DIGITAL MADRASAH (RDM)</div>

    <!-- Metadata -->
    <table class="meta-table">
        <tr>
            <td style="width: 15%;"><strong>Mata Pelajaran</strong></td>
            <td style="width: 35%;">: <?= html_escape($mapel_row['nama_mapel']) ?></td>
            <td style="width: 15%;"><strong>Kelas</strong></td>
            <td style="width: 35%;">: <?= html_escape($kelas_row['nama_kelas']) ?></td>
        </tr>
        <tr>
            <td><strong>Guru Pengampu</strong></td>
            <td>: <?= html_escape($mapel_row['nama_guru'] ?? '-') ?></td>
            <td><strong>Tahun Pelajaran</strong></td>
            <td>: <?= html_escape($active_tp['tahun']) ?> (Semester <?= html_escape($active_tp['semester']) ?>)</td>
        </tr>
    </table>

    <!-- Main Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;" class="text-center">No</th>
                <th style="width: 80px;">NIS</th>
                <th>Nama Siswa</th>
                <?php foreach ($categories as $cat): ?>
                    <th style="width: 70px;" class="text-center"><?= html_escape(str_replace('Nilai ', '', $cat['nama_kategori'])) ?></th>
                <?php endforeach; ?>
                <th style="width: 75px;" class="text-center">Nilai Akhir</th>
                <th style="width: 55px;" class="text-center">Predikat</th>
                <th style="width: 75px;" class="text-center">Ketuntasan</th>
                <th style="width: 85px;" class="text-center">Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($rekap as $r): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><code><?= html_escape($r['nis']) ?></code></td>
                    <td style="font-weight: bold;"><?= html_escape($r['nama_lengkap']) ?></td>
                    <?php foreach ($categories as $cat): 
                        $code = $cat['kode_kategori'];
                        $score = $r['scores'][$code];
                    ?>
                        <td class="text-center"><?= $score !== NULL ? number_format($score, 2) : '-' ?></td>
                    <?php endforeach; ?>
                    <td class="text-center" style="font-weight: bold; background-color: #f9fafb;"><?= number_format($r['nilai_akhir'], 2) ?></td>
                    <td class="text-center" style="font-weight: bold;"><?= html_escape($r['predikat']) ?></td>
                    <td class="text-center"><?= html_escape($r['ketuntasan']) ?></td>
                    <td class="text-center"><?= html_escape($r['tindak_lanjut']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Signature -->
    <div class="signature-container">
        <table class="signature-table">
            <tr>
                <td>
                    Mengetahui,<br>
                    Kepala Sekolah / Madrasah
                    <div class="signature-space"></div>
                    <strong>( ___________________________ )</strong><br>
                    NIP. ........................................
                </td>
                <td>
                    Madrasah, <?= date('d M Y') ?><br>
                    Guru Mata Pelajaran
                    <div class="signature-space"></div>
                    <strong><?= html_escape($mapel_row['nama_guru'] ?? '___________________________') ?></strong><br>
                    NIP. <?= html_escape($mapel_row['nip_guru'] ?? '........................................') ?>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
