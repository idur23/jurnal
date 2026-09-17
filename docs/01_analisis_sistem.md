# DOKUMEN ANALISIS SISTEM ENTERPRISE
## Website Jurnal Guru Enterprise (CodeIgniter 3 MVC)

### 1. Pendahuluan
Website Jurnal Guru Enterprise dirancang untuk memodernisasi, mengintegrasikan, dan memantau kegiatan pembelajaran, presensi siswa, serta penilaian akademik secara akurat dan real-time di lingkungan institusi pendidikan enterprise.

---

### 2. Analisis Pengguna & Hak Akses (RBAC Matrix)

| Modul / Fitur | Administrator | Guru Mata Pelajaran | Wali Kelas |
| :--- | :---: | :---: | :---: |
| **Authentication & Profile** | Full | Full | Full |
| **User & Role Management** | CRUD | Read (Self) | Read (Self) |
| **Master Data** (Tahun Pelajaran, Semester, Kelas, Mapel, Siswa, Guru, Jam, Ruangan) | CRUD | Read | Read |
| **Jurnal Guru** (Entry & Riwayat Pembelajaran) | Read & Validasi | CRUD (Kelas Ampuan) | Read (Kelas Ampuan) |
| **Presensi Siswa** | Read & Overwrite | CRUD (Saat Jam Mapel) | Read & Monitoring Rekap |
| **Penilaian Siswa** (Formatif, Sumatif, Sikap) | Read | CRUD (Kelas Ampuan) | Read & Rekap Kelas |
| **Monitoring & Rekapitulasi** | Full System | Kelas Ampuan | Kelas Ampuan |
| **Laporan & Export (PDF/Excel)** | Full System | Mapel Ampuan | Kelas Ampuan |
| **Activity Log / Audit Trail** | Read & Clear | No Access | No Access |
| **Pengaturan Sistem** | Full Access | No Access | No Access |

---

### 3. Kebutuhan Fungsional (Functional Requirements)

1. **Sistem Autentikasi & Keamanan Akses**:
   - Authentication menggunakan email/username dan password terenkripsi (`password_hash` default Bcrypt/Argon2id).
   - Fitur Login Attempt Limiter (Maksimal 5x percobaan gagal sebelum dikunci sementara 15 menit).
   - Role-Based Access Control (RBAC) murni dievaluasi pada `MY_Controller`.
   - Protection terhadap CSRF, XSS Filter, dan SQL Injection (Query Builder mandatory).

2. **Manajemen Master Data**:
   - Master Tahun Pelajaran & Semester (Status Aktif).
   - Master Kelas & Ruangan (Penetapan Wali Kelas per Kelas).
   - Master Mata Pelajaran (Kelompok Mapel, KKM/Kriterian Ketuntasan).
   - Master Jam Pelajaran (Slot Waktu Pembelajaran).
   - Master Data Guru & Data Siswa (NIS, NISN, Gender, Status Aktif).
   - Ploting Jadwal / Ampuan Guru & Pengalokasian Siswa ke Kelas.

3. **Modul Jurnal Guru Enterprise**:
   - Guru menginput Jurnal Pembelajaran: Tanggal, Jam ke-, Kelas, Mapel, Subjek/KD/TP, Materi Pembelajaran, Activity/Metode Pembelajaran, Catatan Guru, Hambatan/Solusi.
   - Status Jurnal: *Draft*, *Submitted*, *Validated*.
   - Filter Jurnal berdasarkan Tanggal, Kelas, Mapel, dan Guru.

4. **Modul Presensi Siswa Realtime**:
   - Terintegrasi langsung dengan Jurnal Guru.
   - Opsi Status Kehadiran Siswa per Jam Pelajaran: **Hadir (H)**, **Izin (I)**, **Sakit (S)**, **Alpa (A)**, **Dispen (D)**.
   - Catatan khusus per siswa (misal: terlambat, meninggalkan kelas).

5. **Modul Penilaian Akademik & Sikap**:
   - Form penilaian Nilai Formatif, Nilai Sumatif (PTS/PAS/PAT), serta Catatan Sikap.
   - Perhitungan Nilai Akhir otomatis berbasis bobot.

6. **Modul Monitoring & Rekapitulasi Wali Kelas**:
   - Wali Kelas dapat memantau jurnal harian yang diisi guru mata pelajaran di kelasnya.
   - Dashboard rekapitulasi presensi harian/bulanan siswa kelasnya.

7. **Modul Laporan & Export**:
   - Cetak Laporan Jurnal Guru (PDF via Dompdf & Excel via PhpSpreadsheet).
   - Cetak Laporan Rekap Presensi Siswa per Semester/Bulan.
   - Cetak Laporan Rekap Nilai Akademik per Kelas.

8. **Modul Activity Log (Audit Trail)**:
   - Mencatat seluruh aktivitas sistem (Login, Logout, Insert Jurnal, Update Nilai, Delete User, Export Report) mencakup User ID, Role, IP Address, User Agent, Timestamp, dan Action Description.

---

### 4. Kebutuhan Non-Fungsional (Non-Functional Requirements)

1. **Performance**: Page load response time `< 500ms`, AJAX DataTables response time `< 300ms` dengan server-side processing untuk dataset besar.
2. **Security**:
   - Strict CSRF token validation pada setiap HTTP POST/PUT/DELETE request.
   - Prepared statements via CodeIgniter 3 Query Builder.
   - XSS sanitization pada input POST & output rendering `html_escape()`.
   - Secure HTTP session management (`cookie_httponly`, `cookie_secure`, `sess_regenerate_destroy`).
3. **Usability & UI/UX**:
   - UI modern berbasis **Tabler Dashboard (Bootstrap 5)**.
   - Responsive layout (Mobile, Tablet, Desktop).
   - Feedback interaktif via **SweetAlert2** dan indikator status yang jelas.
4. **Maintainability & Scalability**:
   - Arsitektur CodeIgniter 3 MVC murni (Clean Code, DRY, SOLID).
   - Pemisahan tegas logic Controller, Model Data, dan Templating View.
