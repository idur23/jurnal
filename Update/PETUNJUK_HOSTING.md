# Panduan Deploy & Impor Sistem Jurnal Guru ke Hosting

Sistem **Jurnal Guru** telah disiapkan dan dioptimalkan agar dapat berjalan langsung di **Shared Hosting (cPanel / DirectAdmin / Plesk)** maupun **VPS (Apache / Nginx / LiteSpeed)**.

---

## 📁 File Penting Siap Upload

1. **`database.sql`**: Database dump lengkap (328 KB, 29 tabel & data awal) siap diimpor ke phpMyAdmin hosting.
2. **`.htaccess`**: Aturan URL Rewrite bersih (`index.php` tersembunyi) dan proteksi keamanan folder sensitif (`application`, `system`, `.git`, `database.sql`).
3. **`application/config/config.php`**: Berisi deteksi SSL (HTTP/HTTPS) otomatis dan manajemen session aman.
4. **`application/config/database.php`**: Berisi kustomisasi kredensial database lokal dan hosting.

---

## 🚀 Langkah Deploy ke Hosting (cPanel)

### Langkah 1: Upload File Projek
1. Compress seluruh isi folder projek ini menjadi file `.zip`.
2. Buka **cPanel > File Manager**.
3. Upload file `.zip` ke `public_html` (atau subfolder, misal: `public_html/jg`).
4. Extract file `.zip` tersebut.

### Langkah 2: Buat & Impor Database
1. Buka **cPanel > MySQL® Databases**.
2. Buat database baru (misal: `user_jurnalguru`).
3. Buat user MySQL baru beserta passwordnya, lalu assign user tersebut ke database dengan **ALL PRIVILEGES**.
4. Buka **cPanel > phpMyAdmin**.
5. Pilih database yang baru dibuat, klik menu **Import**, pilih file **`database.sql`**, lalu klik **Kirim / Go**.

### Langkah 3: Konfigurasi Database
Buka file `application/config/database.php` dan sesuaikan kredensial hosting pada bagian `else` (sekitar baris 27-30):

```php
} else {
    // Hosting cPanel Configuration
    $db_user = "USER_DATABASE_HOSTING_ANDA";
    $db_pass = "PASSWORD_DATABASE_HOSTING_ANDA";
    $db_name = "NAMA_DATABASE_HOSTING_ANDA";
}
```

### Langkah 4: Verifikasi Permission Folder Uploads & Cache
Pastikan folder-folder berikut memiliki permission `755` (atau writable):
- `assets/uploads/` (dan seluruh subfolder di dalamnya)
- `application/cache/`
- `application/logs/`

---

## 🔒 Fitur Keamanan & Otomatisasi Terpasang
- **Auto SSL / HTTPS**: Sistem otomatis mendeteksi HTTPS dari SSL cPanel / Cloudflare / Nginx Reverse Proxy.
- **Environment Auto-Switch**: Ketika berjalan di domain hosting, `ENVIRONMENT` otomatis diset ke `production` untuk menyembunyikan error PHP dari pengunjung.
- **Proteksi Akses File**: Folder `application/`, `system/`, dan file `database.sql` secara otomatis diblokir dari akses langsung browser via `.htaccess`.
