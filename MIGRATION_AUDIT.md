# MIGRATION AUDIT REPORT - JURNAL GURU (CI3 TO LARAVEL)

Date: 2026-09-18
Project: Jurnal Guru Migration (CodeIgniter 3 → Laravel)
Source Path: `c:\laragon\www\jg`
Target Path: `c:\laragon\www\jurnal-guru-laravel`

---

## 1. DAFTAR ROLE
1. **admin** (`1`): Administrator - Full access ke seluruh sistem, master data, dan log.
2. **guru** (`2`): Guru Mata Pelajaran - Akses ke Jurnal Guru, Presensi, Penilaian, Perangkat Ajar, Karya, Poin Keaktifan, Perkembangan Diri.
3. **walikelas** (`3`): Wali Kelas - Akses ke Dashboard Wali Kelas, Program Kerja, Penanganan Siswa, Rekap Pelanggaran, Kokurikuler, Presensi Kelas, Rekap Perkembangan Diri.
4. **kamad** (`4`): Kepala Madrasah - Monitoring KBM, Kehadiran Kelas, Supervisi Akademik (Form 1-4), Laporan & Rekap.
5. **waka** (`5`): Waka Kurikulum - Monitoring, Evaluasi, Verifikasi Perangkat Ajar, Supervisi Akademik (Form 1-4), Rekap & Laporan.
6. **superadmin** (`6`): Super Admin - Akses penuh ke seluruh sistem dan konfigurasi internal.
7. **tentor** (`7`): Tentor MBF - Akses khusus kegiatan MBF (Dashboard Tentor, Mapel MBF, Peserta Mapel MBF, Presensi MBF, Rekap Presensi MBF, Laporan MBF, Profil Tentor).

---

## 2. DAFTAR MENU & NAVIGASI
- **Dashboard Utama / Jurnal Guru** (`/dashboard`)
- **Jurnal Guru** (`/jurnal`, `/jurnal/add`, `/jurnal/jadwal`)
- **Presensi Kelas** (`/presensikelas`)
- **Presensi Siswa** (`/presensi`, `/presensi/rekap`)
- **Poin Keaktifan Siswa** (`/poinkeaktifan`)
- **Penilaian** (`/penilaian`, `/penilaian/rekap`, `/penilaian/import_history`)
- **Perkembangan Diri** (`/perkembangan`)
- **Karya Pembelajaran** (`/karya`)
- **Perangkat Ajar** (`/perangkat_ajar`, `/perangkat_ajar/upload`, `/perangkat_ajar/rencana`, `/perangkat_ajar/daftar`, `/perangkat_ajar/revisi`, `/perangkat_ajar/verifikasi`, `/perangkat_ajar/arsip`)
- **Wali Kelas** (`/walikelas`, `/walikelas/program_kelas`, `/walikelas/penanganan_siswa`, `/walikelas/rekap_pelanggaran`, `/walikelas/kokurikuler`)
- **Master Data (Admin)** (`/master/tahun_pelajaran`, `/master/kelas`, `/master/ruangan`, `/master/mapel`, `/master/jam_pelajaran`, `/master/guru`, `/master/siswa`, `/master/jadwal`)
- **Modul MBF (Admin)** (`/mbf`, `/mbf/tentor`, `/mbf/mapel`, `/mbf/siswa`, `/mbf/presensi`, `/mbf/rekap`, `/mbf/laporan`)
- **Modul Tentor MBF** (`/tentor`, `/tentor/mapel`, `/tentor/peserta`, `/tentor/presensi`, `/tentor/rekap`, `/tentor/laporan`, `/tentor/profil`)
- **Supervisi Akademik** (`/supervisi/dashboard`, `/supervisi/guru`, `/supervisi/form1`, `/supervisi/form2`, `/supervisi/form3`, `/supervisi/form4`, `/supervisi/rekap`, `/supervisi/laporan`)
- **Monitoring KBM** (`/monitoring`)
- **Laporan Jurnal Guru** (`/laporan`)
- **Pengaturan & System** (`/logs`, `/system_monitor`, `/google_drive_sync`, `/settings`)

---

## 3. DAFTAR CONTROLLER (23)
1. `Auth.php`
2. `Dashboard.php`
3. `Master.php`
4. `Jurnal.php`
5. `Presensi.php`
6. `Presensikelas.php`
7. `Poinkeaktifan.php`
8. `Penilaian.php`
9. `Perangkat_ajar.php`
10. `Karya.php`
11. `Perkembangan.php`
12. `Walikelas.php`
13. `Mbf.php`
14. `Tentor.php`
15. `Supervisi.php`
16. `Laporan.php`
17. `Google_drive_sync.php`
18. `Settings.php`
19. `Logs.php`
20. `Monitoring.php`
21. `Health_check.php`
22. `System_monitor.php`
23. `Media.php`

---

## 4. DAFTAR MODEL (14)
1. `User_model.php` (`users`)
2. `Master_model.php` (`guru`, `siswa`, `mata_pelajaran`, `kelas`, `ruangan`, `jam_pelajaran`, `jadwal_pelajaran`, `tahun_pelajaran`)
3. `Jurnal_model.php` (`jurnal_guru`)
4. `Presensi_model.php` (`presensi_siswa`)
5. `Presensikelas_model.php` (`presensi_kelas`)
6. `Poin_keaktifan_model.php` (`jurnal_poin_keaktifan`)
7. `Penilaian_model.php` (`penilaian_siswa`, `kategori_penilaian`, `import_nilai_history`)
8. `Perangkat_model.php` (`perangkat_ajar`, `rencana_pelaksanaan`)
9. `Karya_model.php` (`karya_pembelajaran`)
10. `Perkembangan_model.php` (`perkembangan_siswa`, `perkembangan_rekap`)
11. `Walikelas_model.php` (`jurnal_walikelas`, `penanganan_siswa`, `kokurikuler`)
12. `Mbf_model.php` (`tentor`, `mapel_mbf`, `peserta_mapel_mbf`, `presensi_mbf`, `presensi_mbf_detail`)
13. `Supervisi_model.php` (`supervisi`, `supervisi_detail`, `supervisi_form`, `supervisi_histori`, `supervisi_indikator`, `supervisi_notifikasi`)
14. `Log_model.php` (`activity_logs`)

---

## 5. DAFTAR TABEL DATABASE (44)
1. `users`
2. `roles`
3. `login_attempts`
4. `activity_logs`
5. `system_settings`
6. `sys_performance_logs`
7. `sys_slow_queries`
8. `google_drive_sync`
9. `tahun_pelajaran`
10. `kelas`
11. `ruangan`
12. `mata_pelajaran`
13. `guru`
14. `guru_mapel`
15. `siswa`
16. `mapel_kelas`
17. `jam_pelajaran`
18. `jadwal_pelajaran`
19. `jurnal_guru`
20. `jurnal_poin_keaktifan`
21. `presensi_kelas`
22. `presensi_siswa`
23. `kategori_penilaian`
24. `penilaian_siswa`
25. `import_nilai_history`
26. `perangkat_ajar`
27. `rencana_pelaksanaan`
28. `karya_pembelajaran`
29. `perkembangan_siswa`
30. `perkembangan_rekap`
31. `jurnal_walikelas`
32. `penanganan_siswa`
33. `kokurikuler`
34. `tentor`
35. `mapel_mbf`
36. `peserta_mapel_mbf`
37. `presensi_mbf`
38. `presensi_mbf_detail`
39. `supervisi`
40. `supervisi_detail`
41. `supervisi_form`
42. `supervisi_histori`
43. `supervisi_indikator`
44. `supervisi_notifikasi`

---

## 6. FEATURE AUDIT & CHECKLIST

| Feature | CI3 | Laravel | Status |
|---------|-----|---------|--------|
| Authentication & Session Rate Limiting | ✓ | ✓ | PENDING IMPLEMENTATION |
| Role-based Authorization (7 Roles) | ✓ | ✓ | PENDING IMPLEMENTATION |
| Dashboard Utama & Stat Widget per Role | ✓ | ✓ | PENDING IMPLEMENTATION |
| Master Data (TP, Kelas, Ruangan, Mapel, Jam, Guru, Siswa, Jadwal) | ✓ | ✓ | PENDING IMPLEMENTATION |
| Jurnal Guru & Dynamic Select AJAX | ✓ | ✓ | PENDING IMPLEMENTATION |
| Presensi Kelas & Presensi Siswa | ✓ | ✓ | PENDING IMPLEMENTATION |
| Poin Keaktifan Siswa (+/- AJAX) | ✓ | ✓ | PENDING IMPLEMENTATION |
| Input & Rekap Penilaian (Kategori A & B) | ✓ | ✓ | PENDING IMPLEMENTATION |
| Perangkat Ajar & Rencana Pelaksanaan | ✓ | ✓ | PENDING IMPLEMENTATION |
| Karya Pembelajaran (Upload/Preview/Download) | ✓ | ✓ | PENDING IMPLEMENTATION |
| Perkembangan Diri Siswa & Rekap Wali Kelas | ✓ | ✓ | PENDING IMPLEMENTATION |
| Wali Kelas (Program Kelas, Penanganan, Rekap Pelanggaran, Kokurikuler) | ✓ | ✓ | PENDING IMPLEMENTATION |
| Modul MBF Admin (Mapel, Tentor, Peserta Beda Kelas, Presensi, Rekap) | ✓ | ✓ | PENDING IMPLEMENTATION |
| Modul Tentor MBF (Dashboard, Mapel Saya, Peserta, Presensi MBF, Laporan) | ✓ | ✓ | PENDING IMPLEMENTATION |
| Supervisi Akademik (Form 1, Form 2, Form 3, Form 4, Supervisor/Guru Workflow) | ✓ | ✓ | PENDING IMPLEMENTATION |
| Monitoring KBM Realtime | ✓ | ✓ | PENDING IMPLEMENTATION |
| Laporan Jurnal Guru & Multi-Filter PDF/Excel/Print dengan Logo | ✓ | ✓ | PENDING IMPLEMENTATION |
| Import & Export Excel (Siswa, Jadwal, Nilai, Presensi) | ✓ | ✓ | PENDING IMPLEMENTATION |
| Google Drive Sync & Fallback Stream | ✓ | ✓ | PENDING IMPLEMENTATION |
| System Settings & Activity Logs | ✓ | ✓ | PENDING IMPLEMENTATION |
