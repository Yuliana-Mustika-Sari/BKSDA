# BKSDA Web — Peraturan, Galeri & Admin

Selamat datang di repo BKSDA (Balai Konservasi Sumber Daya Alam) — sebuah situs PHP sederhana yang
menyediakan halaman publik untuk peraturan, galeri, serta panel admin untuk CRUD konten.

Kenapa repo ini berguna
- Menyajikan contoh aplikasi CMS ringan berbasis PHP + MySQL.
- Panel admin untuk mengelola peraturan, galeri, dan pengguna.
- UI responsif menggunakan Bootstrap untuk tampilan yang rapi di desktop dan mobile.

Ringkasan Cepat
- Halaman publik utama: `index.php`
- Halaman peraturan publik: `User/peraturan.php`
- Panel admin utama: `Admin/kelola-peraturan.php`, `Admin/kelola-galeri.php`
- Koneksi DB: `db-connect-admin.php` (sesuaikan kredensial)

Persyaratan
- PHP 7.4+ (direkomendasikan) dengan ekstensi mysqli
- MySQL / MariaDB
- Web server lokal seperti Laragon, XAMPP, atau built-in PHP server

Instalasi & Setup
1. Buat database dan jalankan migrasi SQL (dari root repo):

```bash
mysql -u <db_user> -p <database_name> < db\create_peraturan.sql
mysql -u <db_user> -p <database_name> < db\create_galleries_table.sql
mysql -u <db_user> -p <database_name> < db\create_users_table.sql
```

2. Alternatif (Windows): jalankan helper PHP untuk membuat DB dan import SQL:

```bash
php db\setup_database.php
```

3. Edit `db-connect-admin.php` untuk menambahkan `DB_HOST`, `DB_USER`, `DB_PASS`, dan `DB_NAME`.

4. Pastikan folder upload memiliki permission tulis (`uploads/galeri/`, `uploads/konflik/`).

Menjalankan secara lokal
- Letakkan repo di folder web root (contoh Laragon: `www/BKSDA`) lalu buka
	`http://localhost/BKSDA`.

Fitur Utama
- Daftar peraturan dengan preview ringkasan, filter, dan tautan dokumen (PDF atau sumber eksternal).
- Table peraturan yang telah diperindah dan responsive.
- CRUD galeri dan peraturan melalui `Admin/`.
- Manajemen pengguna sederhana melalui admin.

File & Lokasi Penting
- `User/peraturan.php` — daftar peraturan publik.
- `Admin/kelola-peraturan.php` — antarmuka admin untuk mengelola peraturan.
- `db-connect-admin.php` — file koneksi database.
- Folder upload: `uploads/galeri/`, `uploads/konflik/`.

Tips Penggunaan
- Gunakan admin untuk menambah data (judul, ringkasan, file PDF atau URL sumber, lingkup, tag).
- Untuk debugging DB, cek `db-connect-admin.php` dan akses MySQL secara manual.

Kontribusi
- Perbaikan bug dan usulan UI diterima melalui pull request.
- Jangan sertakan kredensial nyata di commit.

Lisensi & Kontak
- Repo ini bersifat contoh/demo — pastikan Anda memiliki izin apabila akan dipublikasikan.
- Untuk pertanyaan, hubungi maintainer atau lihat file header pada skrip PHP.

Terima kasih sudah menggunakan repo ini — jika mau, saya bisa menambahkan screenshot, badge, atau
petunjuk deploy ke server produksi.
