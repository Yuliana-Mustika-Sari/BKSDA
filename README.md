# BKSDA - Gallery & Admin extensions

This workspace contains enhancements to support a database-driven gallery and admin CRUD.

Quick setup
1. Create the database (if not exists) and run migrations:

```sh
mysql -u <db_user> -p <database_name> < db\create_galleries_table.sql
mysql -u <db_user> -p <database_name> < db\create_users_table.sql
# optionally add sample entries
mysql -u <db_user> -p <database_name> < db\sample_galleries.sql
```

Alternatively you can run the included PHP helper which will create the database and execute the SQL files for you (Windows / PHP CLI):

```sh
php db\setup_database.php
```

2. Ensure `db-connect-admin.php` contains correct DB credentials.
3. Upload sample images into `uploads/galeri/` and set proper write permissions.

New files added
- `User/galeri_view.php` — public gallery page (reads `galleries` table)
- `Admin/kelola-galeri.php`, `Admin/tambah-galeri.php`, `Admin/edit-galeri.php`, `Admin/hapus-galeri.php` — gallery CRUD
- `Admin/tambah-pengguna.php` — create users (passwords hashed)
- `db/create_galleries_table.sql`, `db/create_users_table.sql` — migrations

Notes
- Admin pages require login with `$_SESSION['role']=='admin'` and `$_SESSION['loggedin']==true`.
- Existing `User/galeri.php` remains as the 'Lapor Konflik' form; gallery viewer is `User/galeri_view.php`.
- After migration, use the admin UI to upload gallery images and fill `peraturan` field per item.
