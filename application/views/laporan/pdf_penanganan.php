<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jurnal Penanganan Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header h3 {
            margin: 5px 0 0 0;
            font-size: 12px;
            font-weight: normal;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 10px;
            color: #666;
        }
        .report-title {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 6px;
            font-weight: bold;
            text-align: left;
        }
        .data-table td {
            border: 1px solid #ddd;
            padding: 6px;
            vertical-align: top;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 3px;
            color: #fff;
        }
        .badge-proses { background-color: #d9534f; }
        .badge-monitoring { background-color: #f0ad4e; }
        .badge-selesai { background-color: #5cb85c; }
        .footer {
            width: 100%;
            margin-top: 30px;
        }
        .footer td {
            text-align: center;
            width: 50%;
        }
    </style>
</head>
<body>
    <table style="width: 100%; border-bottom: 3px double #333; padding-bottom: 8px; margin-bottom: 15px; border-collapse: collapse;">
        <tr>
            <td style="width: 15%; text-align: left; vertical-align: middle; border: none; padding: 0;">
                <?php if (!empty($settings['app_logo_left']) && file_exists('./' . $settings['app_logo_left'])): ?>
                    <img src="<?= get_image_base64('./' . $settings['app_logo_left']) ?>" style="max-height: 85px; max-width: 85px; object-fit: contain;">
                <?php endif; ?>
            </td>
            <td style="width: 70%; text-align: center; vertical-align: middle; border: none; padding: 0;">
                <h2 style="margin: 0; font-size: 14px; text-transform: uppercase; font-weight: bold;"><?= html_escape($settings['app_institution'] ?? 'SMA Negeri Enterprise 1') ?></h2>
                <h3 style="margin: 3px 0 0 0; font-size: 11px; font-weight: normal; color: #333;"><?= html_escape($settings['app_name'] ?? 'Jurnal Guru Enterprise') ?></h3>
                <p style="margin: 3px 0 0 0; font-size: 9px; color: #555;"><?= html_escape($settings['app_address'] ?? 'Jl. Edukasi No. 1, Kota Enterprise') ?></p>
            </td>
            <td style="width: 15%; text-align: right; vertical-align: middle; border: none; padding: 0;">
                <?php if (!empty($settings['app_logo_right']) && file_exists('./' . $settings['app_logo_right'])): ?>
                    <img src="<?= get_image_base64('./' . $settings['app_logo_right']) ?>" style="max-height: 85px; max-width: 85px; object-fit: contain;">
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <div class="report-title">
        Laporan Jurnal Penanganan & Pembinaan Siswa
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 15%;">Tahun Pelajaran</td>
            <td style="width: 2%;">:</td>
            <td style="width: 33%;"><?= html_escape($active_tp['tahun'] . ' (' . $active_tp['semester'] . ')') ?></td>
            <td style="width: 15%;">Wali Kelas</td>
            <td style="width: 2%;">:</td>
            <td style="width: 33%;"><?= html_escape($wali_kelas['nama_lengkap'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>Kelas Binaan</td>
            <td>:</td>
            <td><?= html_escape($selected_kelas['nama_kelas'] ?? 'Semua Kelas') ?></td>
            <td>Filter Siswa</td>
            <td>:</td>
            <td><?= html_escape($selected_siswa['nama_lengkap'] ?? 'Semua Siswa') ?></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 8%;">Tanggal</th>
                <th style="width: 15%;">Siswa</th>
                <th style="width: 8%;">Kelas</th>
                <th style="width: 10%;">Kategori</th>
                <th style="width: 20%;">Permasalahan</th>
                <th style="width: 15%;">Tindakan</th>
                <th style="width: 10%;">Hasil</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 10%;">Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($cases)): ?>
                <tr>
                    <td colspan="10" style="text-align: center;">Tidak ada riwayat penanganan siswa ditemukan.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($cases as $c): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d-m-Y', strtotime($c['tanggal'])) ?></td>
                        <td>
                            <strong><?= html_escape($c['nama_siswa']) ?></strong><br>
                            <span style="color:#666; font-size:9px;">NIS: <?= html_escape($c['nis']) ?></span>
                        </td>
                        <td><?= html_escape($c['nama_kelas']) ?></td>
                        <td><?= html_escape($c['kategori']) ?></td>
                        <td><?= html_escape($c['permasalahan']) ?></td>
                        <td>
                            <?= html_escape($c['tindakan'] ? $c['tindakan'] : '-') ?><br>
                            <?php if ($c['rencana_tindak_lanjut']): ?>
                                <small style="color:#555;">RTL: <?= html_escape($c['rencana_tindak_lanjut']) ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= html_escape($c['hasil'] ? $c['hasil'] : '-') ?></td>
                        <td>
                            <?php if ($c['status'] == 'Selesai'): ?>
                                <span class="badge badge-selesai">Selesai</span>
                            <?php elseif ($c['status'] == 'Monitoring'): ?>
                                <span class="badge badge-monitoring">Monitoring</span>
                            <?php else: ?>
                                <span class="badge badge-proses">Proses</span>
                            <?php endif; ?>
                        </td>
                        <td><?= html_escape($c['nama_guru']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <table class="footer">
        <tr>
            <td>
                Mengetahui,<br>
                <?= html_escape($settings['report_signer_title'] ?? 'Kepala Madrasah') ?><br><br><br><br>
                <strong><u><?= html_escape($settings['headmaster_name'] ?? 'M. Fakhrur Rozi, M.Pd') ?></u></strong><br>
                <small>NIP: <?= html_escape($settings['headmaster_nip'] ?? '001') ?></small>
            </td>
            <td>
                <?= html_escape($settings['report_city'] ?? 'Malang') ?>, <?= format_indo_date(date('Y-m-d')) ?><br>
                Staf Tata Usaha / Petugas,<br><br><br><br>
                <strong><u><?= html_escape($settings['printed_by'] ?? $wali_kelas['nama_lengkap'] ?? 'Administrator') ?></u></strong>
            </td>
        </tr>
    </table>
</body>
</html>
