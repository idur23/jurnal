# Jurnal Guru Enterprise & Modul Supervisi Akademik

![PHP Version](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Framework](https://img.shields.io/badge/Framework-CodeIgniter%203-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![Database](https://img.shields.io/badge/Database-MySQL%2FMariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![UI Template](https://img.shields.io/badge/UI-Bootstrap%205%20%2F%20Tabler-0054A6?style=for-the-badge&logo=tabler&logoColor=white)

Sistem Informasi Manajemen Terpadu untuk Kegiatan Belajar Mengajar (KBM), Monitoring Jurnal Pembelajaran, Presensi Siswa, Verifikasi Perangkat Ajar, serta **Modul Supervisi Akademik** untuk **Kepala Madrasah** dan **Waka Kurikulum** di **MA Darul Faqih Indonesia**.

---

## 🌟 Fitur Utama Sistem

### 1. 📋 Modul Supervisi Akademik
Memungkinkan **Kepala Madrasah** dan **Waka Kurikulum** untuk melakukan supervisi akademik digital terhadap Guru berbasis 4 Form Instrumen Baku:
- **Form 1: Administrasi Guru (Perencanaan Pembelajaran)** — Pemeriksaan 12 indikator kelengkapan dokumen administrasi (Kalender Pendidikan, Prota, Promes, RPP/Modul Ajar, Silabus, Agenda Harian, Daftar Nilai, KKM, Absensi, Buku Pegangan, Buku Teks).
- **Form 2: Supervisi RPP / Modul Ajar (Perencanaan Pembelajaran)** — Evaluasi 16 indikator komponen Modul Ajar/RPP (Identitas, CP, ATP, TP, Materi, Metode, Kegiatan Pendahuluan/Inti/Penutup, Penilaian, Media/Bahan, Sumber Belajar).
- **Form 3: Supervisi Pembelajaran (Observasi Kelas)** — Penilaian 41 indikator observasi langsung di kelas (Kegiatan Pendahuluan, Penguasaan Materi, Strategi Mendidik, Pendekatan Saintifik, Penilaian Autentik, Media & Keterlibatan Siswa, Bahasa, Penutup) dilengkapi **Mode Timer Real-time Observasi Kelas** (Jam Mulai & Jam Selesai).
- **Form 4: Supervisi Penilaian (Proses & Hasil Belajar Siswa)** — Pemeriksaan 20 indikator instrumen penilaian (Buku Nilai, Tes PH/PTS/PAS/PAT, Penilaian Pengetahuan/Keterampilan/Sikap, Remedial, Pengayaan, Analisis Nilai, Bank Soal).

#### Keunggulan Modul Supervisi:
- **Perhitungan Nilai Otomatis**: Rumus $\text{Nilai} = \left(\frac{\text{Jumlah Skor}}{\text{Skor Maksimal}}\right) \times 100$ dihitung secara real-time.
- **Dynamic Teacher Filtering**: Pilihan Mata Pelajaran dan Kelas pada form supervisi tersaring secara otomatis hanya menampilkan mata pelajaran dan kelas yang diampu oleh Guru terpilih.
- **Integrasi Perangkat Ajar**: Tautan langsung ke dokumen Modul Ajar/RPP yang telah diunggah Guru pada sistem.
- **Simpan Draft & Kunci Data**: Opsi menyimpan draf penilaian dan mengunci data secara otomatis setelah disubmit status `SELESAI`.
- **Pengajuan Revisi & Audit Histori**: Setiap perubahan data mencatat waktu, user, role, serta data sebelum dan sesudah.
- **Notifikasi & Respon Tindak Lanjut**: Guru menerima notifikasi hasil supervisi dan dapat mengunggah respon perkembangan tindak lanjut.
- **Ekspor & Cetak Official**: Fitur **Export PDF** (menggunakan Dompdf ber-Kop Resmi Yayasan Darul Faqih Malang), **Export Excel** (PhpSpreadsheet terfilter), dan **Print View** siap cetak fisik.

---

### 2. 📊 Dashboard Terpisah per Role
- **Dashboard Kepala Madrasah**: Metric Cards (Total Guru, Guru Sudah/Belum Disupervisi, Supervisi Berjalan/Selesai, Rata-Rata Nilai), Donut Chart Progress, Bar Chart Rekap Form 1-4, Grafik Perkembangan Nilai, dan Tabel Supervisi Terbaru.
- **Dashboard Waka Kurikulum**: Monitoring pelaksanaan KBM, Rekap per Form, Rekap per Guru, Rekap per Mata Pelajaran, dan Rekap per Periode.
- **Dashboard Guru**: Ringkasan Jurnal Guru, Jadwal Mengajar, serta Riwayat & Respon Hasil Supervisi Akademik.

---

### 3. 📚 Modul Pendukung Lainnya
- **Jurnal Guru & Jadwal Mengajar**: Pengisian agenda pembelajaran harian, integrasi jadwal tatap muka, dan cetak laporan jurnal.
- **Presensi Kelas & Presensi Siswa**: Monitoring kehadiran siswa per jam pelajaran dan rekap bulanan/semester.
- **Poin Keaktifan & Penilaian Siswa**: Pencatatan keaktifan siswa serta input nilai PH, PTS, PAS, PAT.
- **Perangkat Ajar & Rencana Pelaksanaan**: Pengunggahan, versi riwayat revisi, dan verifikasi Perangkat Ajar oleh Waka Kurikulum.
- **Modul Wali Kelas**: Monitoring program kelas, penanganan siswa, rekap pelanggaran, dan aktivitas kokurikuler.
- **Modul MBF (Tentor & Presensi MBF)**: Pengelolaan kegiatan bimbingan belajar/program khusus MBF.
- **Audit Log & System Monitor**: Monitoring aktivitas pengguna dan performa server.

---

## 👥 Struktur Role & Hak Akses

| Role | Kode | Hak Akses Utama |
| --- | --- | --- |
| **Admin / Super Admin** | `admin`, `superadmin` | Akses penuh ke seluruh master data, konfigurasi sistem, audit log, dan supervisi. |
| **Kepala Madrasah** | `kamad` | Monitoring KBM, Dashboard Supervisi Kamad, pelaksanaan supervisi Form 1-4, cetak laporan & PDF. |
| **Waka Kurikulum** | `waka` | Monitoring KBM, verifikasi perangkat ajar, Dashboard Waka, pelaksanaan supervisi Form 1-4, cetak laporan & PDF. |
| **Guru Mata Pelajaran** | `guru` | Pengisian Jurnal, Presensi, Penilaian, Unggah Perangkat Ajar, melihat hasil supervisi sendiri & respon tindak lanjut. |
| **Wali Kelas** | `walikelas` | Monitoring kehadiran kelas binaan, program kelas, penanganan siswa, dan kokurikuler. |
| **Tentor MBF** | `tentor` | Pengelolaan presensi dan laporan peserta bimbingan MBF. |

---

## 🛠️ Teknologi & Dependensi

- **Core**: CodeIgniter 3.1.x (PHP 8.x Ready - MVC Murni)
- **Database**: MySQL / MariaDB (InnoDB Engine, utf8mb4)
- **Frontend / Styling**: Vanilla CSS, Bootstrap 5, Tabler UI Framework, Tabler Icons
- **Chart Library**: ApexCharts JS & Chart.js
- **PDF Engine**: `dompdf/dompdf` (^3.1)
- **Excel Engine**: `phpoffice/phpspreadsheet` (^1.29)
- **JavaScript**: jQuery, DataTables, Select2, SweetAlert2, Flatpickr

---

## 🚀 Panduan Instalasi & Penggunaan

### 1. Prasyarat Sistem
- Web Server: Apache / Nginx (Laragon, XAMPP, atau cPanel)
- PHP: versi 8.0 / 8.1 / 8.2 (dengan ekstensi `mysqli`, `gd`, `zip`, `mbstring`, `openssl`)
- Database: MySQL 5.7+ / MariaDB 10.4+
- Composer: installed

### 2. Langkah Instalasi Local (Laragon / XAMPP)
1. **Clone Repositori**:
   ```bash
   git clone https://github.com/idur23/jurnal.git
   cd jurnal
   ```
2. **Install Dependensi Composer**:
   ```bash
   composer install
   ```
3. **Impor Database**:
   - Buat database MySQL baru dengan nama `jg_enterprise` (atau sesuaikan).
   - Impor file schema `database.sql` atau `database/hosting_import.sql`.
   - Jalankan migrasi modul supervisi:
     ```bash
     mysql -u root jg_enterprise < database/migration_supervisi.sql
     ```
4. **Konfigurasi Database (`application/config/database.php`)**:
   ```php
   $db['default'] = array(
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'jg_enterprise',
       'dbdriver' => 'mysqli',
       ...
   );
   ```
5. **Jalankan Aplikasi**:
   Akses di browser melalui `http://localhost/jg` atau domain lokal Laragon `http://jg.test`.

---

## 📜 Lisensi & Hak Cipta

Copyright &copy; 2026 **MA Darul Faqih Indonesia**. All rights reserved.
