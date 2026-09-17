# DOKUMEN USE CASE DIAGRAM & SPESIFIKASI
## Website Jurnal Guru Enterprise (CodeIgniter 3 MVC)

### 1. Diagram Use Case (Mermaid)

```mermaid
graph TD
    %% Actors
    Admin((Administrator))
    Guru((Guru Mata Pelajaran))
    Wali((Wali Kelas))

    subgraph Website Jurnal Guru Enterprise System
        UC1[UC-01: Autentikasi & Kelola Profil]
        UC2[UC-02: Kelola User & Hak Akses]
        UC3[UC-03: Kelola Master Data Sekolah]
        UC4[UC-04: Ploting Jadwal & Ampuan Kelas]
        UC5[UC-05: Pengisian Jurnal Pembelajaran]
        UC6[UC-06: Pengisian Presensi Siswa Realtime]
        UC7[UC-07: Input & Kelola Penilaian Akademik]
        UC8[UC-08: Monitoring Jurnal & Presensi Kelas]
        UC9[UC-09: Rekapitulasi Presensi & Nilai Kelas]
        UC10[UC-10: Export Laporan PDF / Excel]
        UC11[UC-11: Audit Trail Activity Log]
        UC12[UC-12: Pengaturan Sistem & Backup]
    end

    %% Actor Relationships
    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC4
    Admin --> UC8
    Admin --> UC10
    Admin --> UC11
    Admin --> UC12

    Guru --> UC1
    Guru --> UC5
    Guru --> UC6
    Guru --> UC7
    Guru --> UC10

    Wali --> UC1
    Wali --> UC8
    Wali --> UC9
    Wali --> UC10

    %% Includes & Extends
    UC5 ..> UC6 : <<include>>
    UC10 ..> UC5 : <<extend>>
    UC10 ..> UC6 : <<extend>>
    UC10 ..> UC7 : <<extend>>
```

---

### 2. Spesifikasi Skenario Use Case Utama

#### UC-01: Autentikasi Pengguna & Security Session
- **Aktor**: Administrator, Guru, Wali Kelas
- **Deskripsi**: Aktor melakukan login ke dalam sistem menggunakan credentials terverifikasi.
- **Pre-condition**: Pengguna belum terautentikasi dan memiliki akun aktif di database.
- **Main Flow**:
  1. Pengguna membuka form login.
  2. Pengguna memasukkan username/email dan password.
  3. Sistem memeriksa login attempt limiter.
  4. Sistem memverifikasi hash password dengan `password_verify()`.
  5. Sistem membuat session secure dan mencatat Activity Log login.
  6. Sistem mengarahkan pengguna ke Dashboard sesuai Role.
- **Post-condition**: Session terbuat, cookie ter-update dengan atribut `HttpOnly`, dan akses menu diberikan sesuai role.

#### UC-05: Pengisian Jurnal Pembelajaran Guru
- **Aktor**: Guru Mata Pelajaran
- **Deskripsi**: Guru mencatat kegiatan belajar mengajar harian pada kelas dan mata pelajaran ampuan.
- **Pre-condition**: Guru telah login dan memiliki jadwal ampuan aktif pada semester berjalan.
- **Main Flow**:
  1. Guru memilih menu **Jurnal Guru** -> **Tambah Jurnal**.
  2. Guru memilih Tanggal, Kelas, Mata Pelajaran, Jam ke-, serta memasukkan Materi Pembelajaran, Indikator/Subjek, dan Catatan Kegiatan.
  3. Sistem secara otomatis memuat daftar siswa kelas tersebut untuk pengisian presensi (UC-06).
  4. Guru menyimpan data jurnal dan presensi.
  5. Sistem memvalidasi data dan menyimpan transaksi secara atomic (`trans_begin` / `trans_commit`).
- **Post-condition**: Data Jurnal dan Presensi tersimpan di database dan riwayat jurnal ter-update.

#### UC-08: Monitoring & Rekapitulasi Wali Kelas
- **Aktor**: Wali Kelas
- **Deskripsi**: Wali Kelas memantau keterlaksanaan pengisian jurnal oleh guru-guru lain dan tingkat kehadiran siswa di kelas ampuannya.
- **Pre-condition**: Wali Kelas terdaftar sebagai wali kelas aktif pada kelas tertentu.
- **Main Flow**:
  1. Wali Kelas membuka menu **Monitoring Kelas Ampuan**.
  2. Sistem menyajikan kartu ringkasan (Total Jurnal Terisi, Presentase Kehadiran Siswa, Jumlah Alpa).
  3. Wali Kelas melihat rincian presensi per siswa dan detail materi jurnal per pertemuan.
  4. Wali Kelas dapat mengekspor rekapitulasi harian/bulanan ke format PDF atau Excel.
- **Post-condition**: Wali Kelas mendapatkan wawasan lengkap aktivitas kelasnya tanpa dapat mengubah jurnal guru lain.
