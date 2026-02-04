# Panduan Upload ke Server 192.168.100.3:81/garda

## Langkah-langkah:

### 1. Upload File ke Server
Upload semua file project ke folder `/garda` di server (di dalam htdocs atau www)

Struktur folder di server:
```
/htdocs/garda/  (atau /www/garda/)
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── .htaccess
├── artisan
├── composer.json
└── ...
```

### 2. Set Permission (di server)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

Atau via FTP/cPanel, set permission:
- Folder `storage` dan semua isinya: **775**
- Folder `bootstrap/cache` dan isinya: **775**

### 3. File .env Sudah Dikonfigurasi
File `.env` sudah diupdate dengan:
```
APP_URL=http://192.168.100.3:81/garda
```

### 4. File .htaccess
File `.htaccess` di root sudah dibuat, akan otomatis redirect ke folder `public`

### 5. Akses Aplikasi
Buka browser dan akses:
```
http://192.168.100.3:81/garda
```

---

## Jika Ada Error:

### Error 500 - Internal Server Error
1. Cek permission folder `storage` dan `bootstrap/cache`
2. Pastikan file `.env` ada dan valid
3. Di server, jalankan:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   ```

### CSS/JS Tidak Load
1. Pastikan `APP_URL` di `.env` sudah benar: `http://192.168.100.3:81/garda`
2. Clear browser cache (Ctrl + F5)
3. Jalankan: `php artisan config:clear`

### Database Error
Update konfigurasi database di `.env` sesuai dengan server:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_garda
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

## Checklist Deployment

- [x] Update `.env` dengan APP_URL yang benar
- [x] Enable konfigurasi subdirectory di `AppServiceProvider.php`
- [x] File `.htaccess` sudah dibuat
- [ ] Upload semua file ke server
- [ ] Set permission storage dan bootstrap/cache
- [ ] Test akses http://192.168.100.3:81/garda
- [ ] Test login
- [ ] Test semua fitur

---

## File yang Sudah Dikonfigurasi:

✅ `.env` - APP_URL sudah diset ke `http://192.168.100.3:81/garda`
✅ `AppServiceProvider.php` - Konfigurasi subdirectory sudah diaktifkan
✅ `.htaccess` - Redirect ke folder public sudah dibuat
✅ Cache sudah di-clear

Tinggal upload ke server dan set permission!
