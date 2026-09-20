<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth routes
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';

// Dashboard routes
$route['dashboard'] = 'dashboard/index';

// Master Data routes
$route['master/tahun_pelajaran'] = 'master/tahun_pelajaran';
$route['master/kelas'] = 'master/kelas';
$route['master/ruangan'] = 'master/ruangan';
$route['master/mapel'] = 'master/mapel';
$route['master/guru'] = 'master/guru';
$route['master/siswa'] = 'master/siswa';
$route['master/export_siswa'] = 'master/export_siswa';
$route['master/import_siswa'] = 'master/import_siswa';
$route['master/download_template_siswa'] = 'master/download_template_siswa';
$route['master/jam_pelajaran'] = 'master/jam_pelajaran';
$route['master/jadwal'] = 'master/jadwal';
$route['master/export_excel/(:any)'] = 'master/export_excel/$1';
$route['master/import_excel/(:any)'] = 'master/import_excel/$1';

// Jurnal Guru routes
$route['jurnal'] = 'jurnal/index';
$route['jurnal/add'] = 'jurnal/add';
$route['jurnal/jadwal'] = 'jurnal/jadwal';
$route['jurnal/get_perangkat_ajax'] = 'jurnal/get_perangkat_ajax';
$route['jurnal/get_siswa_ajax'] = 'jurnal/get_siswa_ajax';
$route['jurnal/edit/(:num)'] = 'jurnal/edit/$1';
$route['jurnal/detail/(:num)'] = 'jurnal/detail/$1';
$route['jurnal/delete/(:num)'] = 'jurnal/delete/$1';

// Perangkat Ajar routes
$route['perangkat_ajar'] = 'perangkat_ajar/index';
$route['perangkat_ajar/upload'] = 'perangkat_ajar/upload';
$route['perangkat_ajar/upload/(:num)'] = 'perangkat_ajar/upload/$1';
$route['perangkat_ajar/daftar'] = 'perangkat_ajar/daftar';
$route['perangkat_ajar/get_daftar_ajax'] = 'perangkat_ajar/get_daftar_ajax';
$route['perangkat_ajar/detail/(:num)'] = 'perangkat_ajar/detail/$1';
$route['perangkat_ajar/revisi'] = 'perangkat_ajar/revisi';
$route['perangkat_ajar/revisi/(:num)'] = 'perangkat_ajar/revisi/$1';
$route['perangkat_ajar/verifikasi'] = 'perangkat_ajar/verifikasi';
$route['perangkat_ajar/verifikasi/(:num)'] = 'perangkat_ajar/verifikasi/$1';
$route['perangkat_ajar/arsip'] = 'perangkat_ajar/arsip';
$route['perangkat_ajar/do_archive/(:num)'] = 'perangkat_ajar/do_archive/$1';
$route['perangkat_ajar/do_restore/(:num)'] = 'perangkat_ajar/do_restore/$1';
$route['perangkat_ajar/download/(:num)'] = 'perangkat_ajar/download/$1';
$route['perangkat_ajar/export_report/(:any)'] = 'perangkat_ajar/export_report/$1';


// Presensi routes
$route['presensi'] = 'presensi/index';
$route['presensi/rekap'] = 'presensi/rekap';

// Penilaian routes
$route['penilaian'] = 'penilaian/index';

// Laporan routes
$route['laporan'] = 'laporan/index';
$route['laporan/print_jurnal'] = 'laporan/print_jurnal';
$route['laporan/jurnal_pdf'] = 'laporan/jurnal_pdf';
$route['laporan/jurnal_excel'] = 'laporan/jurnal_excel';
$route['laporan/presensi_pdf'] = 'laporan/presensi_pdf';
$route['laporan/presensi_excel'] = 'laporan/presensi_excel';

// Audit Log & Settings
$route['logs'] = 'logs/index';
$route['settings'] = 'settings/index';

// System Performance Monitor routes
$route['system_monitor'] = 'system_monitor/index';
$route['system_monitor/get_performance_stats_ajax'] = 'system_monitor/get_performance_stats_ajax';

// Unified Database Monitor & Backup routes
$route['database_monitor'] = 'database_monitor/index';
$route['database_monitor/do_backup'] = 'database_monitor/do_backup';
$route['database_monitor/download/(.+)'] = 'database_monitor/download/$1';
$route['database_monitor/restore'] = 'database_monitor/restore';
$route['database_monitor/delete/(.+)'] = 'database_monitor/delete/$1';
$route['database_monitor/optimize/(.+)'] = 'database_monitor/optimize/$1';

// Fallback Media Route for missing local uploads -> Google Drive
$route['assets/uploads/(.+)'] = 'media/serve/$1';


