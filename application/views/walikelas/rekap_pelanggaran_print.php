<!DOCTYPE html>
<html>
<head>
    <title><?= html_escape($title) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
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
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .school-subtitle {
            font-size: 12px;
            margin-top: 3px;
        }
        .school-info {
            font-size: 10px;
            color: #555;
            margin-top: 3px;
        }
        .report-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .meta-table td {
            font-size: 12px;
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
            font-size: 12px;
        }
        .signature-space {
            height: 60px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 15px; padding: 10px; background: #e2e8f0; border-radius: 4px; text-align: right;">
        <button onclick="window.print();" style="padding: 6px 12px; font-weight: bold; cursor: pointer;">Cetak Sekarang</button>
        <button onclick="window.close();" style="padding: 6px 12px; cursor: pointer;">Tutup Halaman</button>
    </div>

    <!-- Header / Kop Surat -->
    <table class="header-table">
        <tr>
            <td style="width: 10%;">
                <?php if (!empty($settings['app_logo_left']) && file_exists('./' . $settings['app_logo_left'])): ?>
                    <img src="<?= base_url($settings['app_logo_left']) ?>" style="max-height: 55px; max-width: 55px; object-fit: contain;">
                <?php endif; ?>
            </td>
            <td style="width: 80%; text-align: center;">
                <div class="school-name"><?= html_escape($settings['app_name'] ?? 'JURNAL GURU ENTERPRISE') ?></div>
                <div class="school-subtitle"><?= html_escape($settings['app_slogan'] ?? 'Pusat Monitoring dan Informasi Akademik Sekolah') ?></div>
                <div class="school-info"><?= html_escape($settings['app_address'] ?? '') ?></div>
            </td>
            <td style="width: 10%; text-align: right;">
                <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
                    <img src="<?= base_url($settings['app_logo_right']) ?>" style="max-height: 55px; max-width: 55px; object-fit: contain;">
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
            <?php $no = 1; foreach ($list_siswa as $s): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><code><?= html_escape($s['nis']) ?></code></td>
                    <td style="font-weight: bold;"><?= html_escape($s['nama_lengkap']) ?></td>
                    <td class="text-center"><?= $s['jk'] == 'L' ? 'Laki-Laki' : 'Perempuan' ?></td>
                    <td class="text-center"><?= $s['total_kasus'] ?> Kasus</td>
                    <td class="text-center"><?= $s['total_poin'] ?> Poin</td>
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

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
