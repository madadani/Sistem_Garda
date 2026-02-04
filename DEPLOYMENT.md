# Panduan Deployment ke Server (Subdirectory /garda)

## Cara 1: Upload Semua File (Termasuk Public)

### Langkah-langkah:

1. **Upload semua file project** ke folder `/garda` di server
   ```
   /garda/
   ├── app/
   ├── bootstrap/
   ├── config/
   ├── database/
   ├── public/
   ├── resources/
   ├── routes/
   ├── storage/
   ├── vendor/
   ├── .htaccess          (sudah dibuat)
   ├── artisan
   ├── composer.json
   └── ...
   ```

2. **Set Permission** untuk folder `storage` dan `bootstrap/cache`:
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

3. **Update file `.env`**:
   ```env
   APP_URL=https://yourdomain.com/garda
   ```

4. **Akses aplikasi**:
   - URL: `https://yourdomain.com/garda`
   - File `.htaccess` di root akan otomatis redirect ke folder `public`

---

## Cara 2: Public Folder Sebagai Document Root (Lebih Aman)

### Struktur di Server:

```
/garda/                    (di luar public_html)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── artisan
└── composer.json

/public_html/garda/        (atau /htdocs/garda/)
└── (isi dari folder public)
    ├── index.php
    ├── .htaccess
    ├── css/
    ├── js/
    └── ...
```

### Langkah-langkah:

1. **Upload folder project** (kecuali public) ke `/garda` di luar public_html

2. **Upload isi folder public** ke `/public_html/garda/`

3. **Edit `/public_html/garda/index.php`**:
   
   Cari baris:
   ```php
   require __DIR__.'/../vendor/autoload.php';
   ```
   Ganti menjadi:
   ```php
   require __DIR__.'/../../garda/vendor/autoload.php';
   ```

   Cari baris:
   ```php
   $app = require_once __DIR__.'/../bootstrap/app.php';
   ```
   Ganti menjadi:
   ```php
   $app = require_once __DIR__.'/../../garda/bootstrap/app.php';
   ```

4. **Set Permission**:
   ```bash
   chmod -R 775 /garda/storage
   chmod -R 775 /garda/bootstrap/cache
   ```

5. **Update `.env`**:
   ```env
   APP_URL=https://yourdomain.com/garda
   ```

6. **Copy file `.htaccess.subdirectory`** ke `/public_html/garda/.htaccess`

---

## Cara 3: Menggunakan Symbolic Link (Jika Server Support)

### Langkah-langkah:

1. **Upload semua file** ke `/garda`

2. **Buat symbolic link** dari public_html ke folder public:
   ```bash
   ln -s /path/to/garda/public /path/to/public_html/garda
   ```

3. **Set Permission**:
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

4. **Update `.env`**:
   ```env
   APP_URL=https://yourdomain.com/garda
   ```

---

## Konfigurasi Tambahan

### 1. Update `AppServiceProvider.php`

Jika menggunakan subdirectory, uncomment baris berikut di `app/Providers/AppServiceProvider.php`:

```php
public function boot()
{
    config(['app.locale' => 'id']);
    Carbon::setLocale('id');
    date_default_timezone_set('Asia/Jakarta');
    
    // Uncomment untuk subdirectory deployment
    \URL::forceRootUrl(config('app.url'));
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        \URL::forceScheme('https');
    }
}
```

### 2. Clear Cache di Server

Setelah upload, jalankan:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

Atau jika tidak bisa akses terminal, hapus manual:
- `bootstrap/cache/config.php`
- `bootstrap/cache/routes-v7.php`
- Semua file di `storage/framework/cache/`
- Semua file di `storage/framework/views/`

---

## Troubleshooting

### 1. Error 500 - Internal Server Error
- Cek permission folder `storage` dan `bootstrap/cache` (harus 775 atau 777)
- Cek file `.env` sudah ada dan valid
- Cek `APP_KEY` sudah di-generate

### 2. Asset (CSS/JS) Tidak Load
- Pastikan `APP_URL` di `.env` sudah benar
- Cek path di `config/app.php`
- Jalankan `php artisan config:clear`

### 3. Route Tidak Ditemukan (404)
- Pastikan `.htaccess` ada di folder yang benar
- Cek mod_rewrite Apache sudah enabled
- Jalankan `php artisan route:clear`

### 4. Database Connection Error
- Update konfigurasi database di `.env`
- Pastikan host, username, password, dan database name benar

---

## Checklist Deployment

- [ ] Upload semua file ke server
- [ ] Set permission storage (775)
- [ ] Set permission bootstrap/cache (775)
- [ ] Update file `.env` (APP_URL, DB config)
- [ ] Copy/update `.htaccess`
- [ ] Clear all cache
- [ ] Test akses URL
- [ ] Test login
- [ ] Test semua fitur utama
- [ ] Test export Excel
- [ ] Backup database

---

## File Penting yang Sudah Dibuat

1. **`.htaccess`** - Di root project, redirect ke folder public
2. **`.htaccess.subdirectory`** - Template untuk deployment subdirectory
3. **`AppServiceProvider.php`** - Sudah ditambahkan konfigurasi subdirectory (commented)

Pilih cara deployment yang sesuai dengan konfigurasi server Anda!
