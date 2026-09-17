# DOKUMEN FLOWCHART SISTEM ENTERPRISE
## Website Jurnal Guru Enterprise (CodeIgniter 3 MVC)

### 1. Flowchart Autentikasi & Otorisasi Pengguna

```mermaid
flowchart TD
    A[Mulai] --> B[Akses Halaman Login]
    B --> C[Input Username/Email & Password]
    C --> D{Cek Rate Limiter<br/>Fail Count >= 5?}
    D -- Ya --> E[Tampilkan Pesan Account Locked 15 Mnt]
    E --> Z[Selesai]
    D -- Tidak --> F[Validasi Input CSRF & Form Validation]
    F -- Invalid --> G[Tampilkan Validation Error]
    G --> B
    F -- Valid --> H[Cek Credentials ke Database via MY_Model]
    H -- User Tidak Ditemukan / Password Salah --> I[Tambah Fail Count di Session/DB]
    I --> G
    H -- Match Password Hash --> J[Reset Fail Count]
    J --> K[Generate New Session ID & Save Audit Log Login]
    K --> L{Cek Role User}
    L -- Administrator --> M[Redirect ke /admin/dashboard]
    L -- Guru --> N[Redirect ke /guru/dashboard]
    L -- Wali Kelas --> O[Redirect ke /walikelas/dashboard]
    M --> Z
    N --> Z
    O --> Z
```

---

### 2. Flowchart Pengisian Jurnal & Presensi Siswa (Workflow Guru)

```mermaid
flowchart TD
    A[Mulai - Guru Dashboard] --> B[Pilih Menu Jurnal Guru]
    B --> C[Klik Tambah Jurnal Pembelajaran]
    C --> D[Pilih Tahun Pelajaran, Semester, Kelas, Mapel & Jam Ke-]
    D --> E[Sistem Load Daftar Siswa Aktif di Kelas Terkait via AJAX]
    E --> F[Input Judul Materi, TP/Subjek, Catatan Pembelajaran & Status Jurnal]
    F --> G[Input Presensi Siswa: Hadir/Izin/Sakit/Alpa/Dispen & Catatan Siswa]
    G --> H[Klik Simpan Jurnal & Presensi]
    H --> I{Validasi Server-Side<br/>MY_Controller}
    I -- Ada Error --> J[Return JSON Error / SweetAlert Notification]
    J --> F
    I -- Valid --> K[Begin DB Transaction]
    K --> L[Insert Data ke Table 'jurnal_guru']
    L --> M[Batch Insert Data ke Table 'presensi_siswa']
    M --> N[Write Audit Log Activity]
    N --> O{Commit Transaction<br/>Success?}
    O -- Fail --> P[Rollback Transaction & Alert Error]
    O -- Success --> Q[Commit & Return JSON Success + SweetAlert]
    Q --> R[Redirect / Refresh Tabel Jurnal]
    P --> F
    R --> Z[Selesai]
```

---

### 3. Flowchart Monitoring & Rekapitulasi (Workflow Wali Kelas)

```mermaid
flowchart TD
    A[Mulai - Wali Kelas Dashboard] --> B[Pilih Menu Monitoring Kelas]
    B --> C[Pilih Tanggal / Bulan Filter]
    C --> D[Fetch Data Jurnal Mapel & Presensi Harian Siswa Kelas Ampuan]
    D --> E[Tampilkan Summary Card: Kehadiran %, Alpa Count, Jurnal Terisi]
    E --> F{Pilih Aksis Action}
    F -- Lihat Detail Jurnal --> G[Buka Modal Detail Jurnal Pembelajaran & Catatan Guru Mapel]
    F -- Rekap Presensi --> H[Render Tabular Data Presensi Per Siswa]
    F -- Export Laporan --> I[Pilih Format PDF / Excel]
    I --> J[Generate File via Dompdf / PhpSpreadsheet]
    J --> K[Download File Laporan]
    G --> Z[Selesai]
    H --> Z
    K --> Z
```

---

### 4. Flowchart Penilaian & Laporan Enterprise

```mermaid
flowchart TD
    A[Mulai] --> B[Pilih Modul Penilaian]
    B --> C[Pilih Kelas, Mapel, Jenis Penilaian: Formatif/Sumatif/Sikap]
    C --> D[Sistem Load Input Grid Penilaian Siswa]
    D --> E[Input / Edit Nilai & Catatan Evaluasi]
    E --> F[Simpan Nilai -> Database Update/Insert]
    F --> G[Pilih Menu Laporan Enterprise]
    G --> H[Pilih Parameter Laporan: Periode, Kelas, Type]
    H --> I[Pilih Format Cetak: PDF / Excel]
    I --> J{Status Request}
    J -- PDF --> K[Process Dompdf Builder -> Render Stream PDF]
    J -- Excel --> L[Process PhpSpreadsheet Writer -> Stream XLSX]
    K --> M[Download / Preview Laporan]
    L --> M
    M --> Z[Selesai]
```
