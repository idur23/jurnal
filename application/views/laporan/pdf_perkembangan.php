<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapor Perkembangan Diri Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .student-page {
            page-break-after: always;
        }
        .student-page:last-child {
            page-break-after: avoid;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 3px double #333;
            padding-bottom: 8px;
        }
        .header h2 {
            margin: 0;
            font-size: 15px;
            text-transform: uppercase;
        }
        .header h3 {
            margin: 3px 0 0 0;
            font-size: 11px;
            font-weight: normal;
        }
        .header p {
            margin: 3px 0 0 0;
            font-size: 9px;
            color: #666;
        }
        .report-title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #1e1b4b;
            border-bottom: 1px solid #1e1b4b;
            padding-bottom: 3px;
            margin-top: 15px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .data-table th {
            background-color: #f5f5f7;
            border: 1px solid #ddd;
            padding: 5px;
            font-weight: bold;
            text-align: left;
        }
        .data-table td {
            border: 1px solid #ddd;
            padding: 5px;
            vertical-align: middle;
        }
        .ratings-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .ratings-table td {
            border: 1px solid #ddd;
            padding: 5px;
        }
        .rating-bar-bg {
            background-color: #e2e8f0;
            border-radius: 4px;
            height: 10px;
            width: 100px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 5px;
        }
        .rating-bar-fill {
            background-color: #6366f1;
            height: 10px;
            border-radius: 4px;
        }
        .catatan-box {
            border: 1px solid #ddd;
            background-color: #fafafb;
            padding: 8px;
            border-radius: 4px;
            min-height: 40px;
            margin-bottom: 10px;
        }
        .footer-sig {
            width: 100%;
            margin-top: 25px;
        }
        .footer-sig td {
            text-align: center;
            width: 50%;
        }
    </style>
</head>
<body>
    <?php foreach ($report_data as $s_id => $data_item): ?>
        <?php 
            $s = $data_item['siswa'];
            $catatan_mapel = $data_item['catatan_mapel'];
            $rekap = $data_item['rekap'];
            $nilai_summary = $data_item['nilai_summary'];
            $rata_nilai_total = $data_item['rata_nilai_total'];
            $presensi = $data_item['presensi'];
            $aspek_avg = $data_item['aspek_avg'];
        ?>
        <div class="student-page">
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
                Laporan Hasil Perkembangan Diri Siswa
            </div>

            <table class="info-table">
                <tr>
                    <td style="width: 15%; font-weight: bold;">Nama Siswa</td>
                    <td style="width: 2%;">:</td>
                    <td style="width: 33%;"><?= html_escape($s['nama_lengkap']) ?></td>
                    <td style="width: 15%; font-weight: bold;">Kelas</td>
                    <td style="width: 2%;">:</td>
                    <td style="width: 33%;"><?= html_escape($s['nama_kelas']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">NIS / NISN</td>
                    <td>:</td>
                    <td><?= html_escape($s['nis'] . ' / ' . $s['nisn']) ?></td>
                    <td style="font-weight: bold;">Semester / TP</td>
                    <td>:</td>
                    <td><?= html_escape($active_tp['semester'] . ' / ' . $active_tp['tahun']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Wali Kelas</td>
                    <td>:</td>
                    <td colspan="4"><?= html_escape($s['nama_wali'] ?? '-') ?></td>
                </tr>
            </table>

            <!-- Aspek Non-Akademik -->
            <div class="section-title">I. Aspek Perkembangan Non-Akademik</div>
            <table class="ratings-table">
                <thead>
                    <tr style="background-color: #f5f5f7;">
                        <th style="padding: 5px; border: 1px solid #ddd; text-align: left; width: 40%;">Aspek Perkembangan</th>
                        <th style="padding: 5px; border: 1px solid #ddd; text-align: left; width: 25%;">Rerata Nilai (1.00 - 4.00)</th>
                        <th style="padding: 5px; border: 1px solid #ddd; text-align: left; width: 35%;">Predikat Keberhasilan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $labels = array(
                            'perilaku' => 'Sikap / Perilaku Sosial',
                            'keaktifan' => 'Keaktifan & Partisipasi Belajar',
                            'kedisiplinan' => 'Kedisiplinan & Ketaatan Aturan',
                            'motivasi' => 'Motivasi & Etos Belajar'
                        );
                        foreach ($aspek_avg as $aspek => $score): 
                            $predikat = 'Kurang';
                            if ($score >= 3.5) $predikat = 'Sangat Baik';
                            elseif ($score >= 2.8) $predikat = 'Baik';
                            elseif ($score >= 1.8) $predikat = 'Cukup';
                    ?>
                        <tr>
                            <td style="font-weight: bold;"><?= $labels[$aspek] ?></td>
                            <td>
                                <div class="rating-bar-bg">
                                    <div class="rating-bar-fill" style="width: <?= ($score/4)*100 ?>%;"></div>
                                </div>
                                <strong><?= number_format($score, 2) ?></strong>
                            </td>
                            <td>
                                <strong><?= $predikat ?></strong>
                                <small style="color:#666;">(Rerata dari semua guru mapel)</small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Summary KBM / Akademik & Presensi -->
            <div class="section-title">II. Ringkasan Akademik & Kehadiran (Single Source of Truth)</div>
            <table style="width: 100%; margin-bottom: 10px;">
                <tr>
                    <td style="width: 48%; vertical-align: top; padding-right: 15px;">
                        <strong style="display:block; margin-bottom:5px;">Rerata Nilai Mata Pelajaran:</strong>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th style="text-align: right; width: 30%;">Rerata Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($nilai_summary)): ?>
                                    <tr>
                                        <td colspan="2" style="text-align: center; color: #666;">Belum ada penilaian.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($nilai_summary as $ns): ?>
                                        <tr>
                                            <td><?= html_escape($ns['nama_mapel']) ?></td>
                                            <td style="text-align: right; font-weight: bold;"><?= number_format($ns['rata_nilai'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr style="background-color: #f5f5f7;">
                                        <td style="font-weight: bold;">Rerata Akumulatif</td>
                                        <td style="text-align: right; font-weight: bold; color: #6366f1;"><?= number_format($rata_nilai_total, 2) ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 4%;">&nbsp;</td>
                    <td style="width: 48%; vertical-align: top;">
                        <strong style="display:block; margin-bottom:5px;">Rekapitulasi Kehadiran:</strong>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Status Kehadiran</th>
                                    <th style="text-align: right; width: 40%;">Jumlah Pertemuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Hadir (H)</td>
                                    <td style="text-align: right; font-weight: bold; color: green;"><?= $presensi['Hadir'] ?></td>
                                </tr>
                                <tr>
                                    <td>Izin (I)</td>
                                    <td style="text-align: right; font-weight: bold; color: orange;"><?= $presensi['Izin'] ?></td>
                                </tr>
                                <tr>
                                    <td>Sakit (S)</td>
                                    <td style="text-align: right; font-weight: bold; color: blue;"><?= $presensi['Sakit'] ?></td>
                                </tr>
                                <tr>
                                    <td>Alpa (A)</td>
                                    <td style="text-align: right; font-weight: bold; color: red;"><?= $presensi['Alpa'] ?></td>
                                </tr>
                                <tr>
                                    <td>Dispensasi (D)</td>
                                    <td style="text-align: right; font-weight: bold; color: purple;"><?= $presensi['Dispen'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Catatan Seluruh Guru Mapel -->
            <div class="section-title">III. Catatan Perkembangan Mata Pelajaran</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Mata Pelajaran</th>
                        <th style="width: 25%;">Kelebihan</th>
                        <th style="width: 25%;">Kekurangan</th>
                        <th style="width: 25%;">Saran / Rekomendasi Guru</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($catatan_mapel)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #666;">Belum ada catatan perkembangan mata pelajaran dari guru mapel.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($catatan_mapel as $cm): ?>
                            <tr>
                                <td>
                                    <strong><?= html_escape($cm['nama_mapel']) ?></strong><br>
                                    <small style="color: #666;">Oleh: <?= html_escape($cm['nama_guru']) ?></small>
                                </td>
                                <td><?= html_escape($cm['kelebihan'] ? $cm['kelebihan'] : '-') ?></td>
                                <td style="color:#d9534f;"><?= html_escape($cm['kekurangan'] ? $cm['kekurangan'] : '-') ?></td>
                                <td><?= html_escape($cm['rekomendasi'] ? $cm['rekomendasi'] : '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Kesimpulan Wali Kelas -->
            <div class="section-title">IV. Keputusan & Evaluasi Akhir Wali Kelas</div>
            <table style="width: 100%; border: 1px solid #ddd; background-color: #fafafb; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd; width: 25%; font-weight: bold;">Status Perkembangan</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">
                        <span style="font-weight: bold; color: #1e1b4b; background-color: #eff6ff; padding: 2px 8px; border-radius: 4px; border: 1px solid #bfdbfe;">
                            <?= html_escape($rekap['status_perkembangan'] ?? 'Baik') ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold; vertical-align: top;">Kesimpulan Wali Kelas</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd; line-height: 1.4;">
                        <?= $rekap && $rekap['kesimpulan_wali'] ? nl2br(html_escape($rekap['kesimpulan_wali'])) : 'Siswa menunjukkan perkembangan yang stabil dan berintegritas. Disarankan untuk konsisten meningkatkan fokus belajarnya.' ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold; vertical-align: top;">Rekomendasi Tindak Lanjut</td>
                    <td style="padding: 8px; line-height: 1.4;">
                        <?= $rekap && $rekap['tindak_lanjut'] ? nl2br(html_escape($rekap['tindak_lanjut'])) : 'Terus didampingi belajarnya di rumah, khususnya pendalaman pemahaman materi evaluasi semester.' ?>
                    </td>
                </tr>
            </table>

            <table class="footer-sig">
                <tr>
                    <td>
                        Mengetahui,<br>
                        Orang Tua / Wali Siswa<br><br><br><br>
                        <strong>_____________________</strong>
                    </td>
                    <td>
                        <?= html_escape($settings['report_city'] ?? 'Kota Enterprise') ?>, <?= date('d M Y') ?><br>
                        Wali Kelas,<br><br><br><br>
                        <strong><?= html_escape($s['nama_wali'] ?? '_____________________') ?></strong><br>
                        <small style="color:#555;">NIP: <?= html_escape($s['nip_wali'] ?? '-') ?></small>
                    </td>
                </tr>
            </table>
        </div>
    <?php endforeach; ?>
</body>
</html>
