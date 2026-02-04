# Panduan Deployment dengan Git Pull

## 🎯 Setup Pertama Kali di Server

### 1. Clone Repository
```bash
cd /var/www/html  # atau /htdocs, sesuaikan dengan server
git clone https://your-repo-url.git garda
cd garda
```

### 2. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

### 3. Setup Environment
```bash
cp .env.example .env
nano .env  # atau vi .env
```

Edit file `.env`:
```env
APP_NAME=SISTEM_GARDA
APP_ENV=production
APP_DEBUG=false
APP_URL=http://192.168.100.3:81/garda

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_garda
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Set Permission
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache  # sesuaikan user server
```

### 6. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 7. Akses Aplikasi
```
http://192.168.100.3:81/garda
```

---

## 🔄 Update Aplikasi (Setiap Ada Perubahan)

### Cara Manual:
```bash
cd /var/www/html/garda
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Cara Otomatis (Menggunakan Script):
```bash
cd /var/www/html/garda
chmod +x deploy.sh
./deploy.sh
```

---

## 📋 Checklist Setup Pertama Kali

- [ ] Clone repository ke server
- [ ] Install composer dependencies
- [ ] Copy dan edit file `.env`
- [ ] Generate APP_KEY
- [ ] Set permission storage dan bootstrap/cache
- [ ] Clear semua cache
- [ ] Test akses http://192.168.100.3:81/garda
- [ ] Test login
- [ ] Test semua fitur

---

## 📋 Checklist Update Rutin

- [ ] `git pull origin main`
- [ ] `composer install` (jika ada perubahan dependencies)
- [ ] Clear cache (config, route, view)
- [ ] Test aplikasi

---

## ⚠️ PENTING!

### File yang TIDAK di-push ke Git:
- `.env` (sudah ada di .gitignore)
- `vendor/` (akan di-install via composer)
- `node_modules/`
- `storage/` (kecuali struktur folder)

### File yang HARUS di-push:
- `.env.example` (template untuk .env)
- `.htaccess`
- `composer.json` dan `composer.lock`
- Semua file source code

### Setelah Git Pull, WAJIB:
1. Clear cache: `php artisan config:clear`
2. Clear route: `php artisan route:clear`
3. Clear view: `php artisan view:clear`

---

## 🐛 Troubleshooting

### Error: "Please provide a valid cache path"
```bash
chmod -R 775 storage/framework/cache
chmod -R 775 storage/framework/views
```

### Error: "The stream or file could not be opened"
```bash
chmod -R 775 storage/logs
```

### CSS/JS tidak load setelah pull
```bash
php artisan config:clear
# Clear browser cache (Ctrl + F5)
```

### Database error
Cek konfigurasi database di `.env` sudah benar

---

## 💡 Tips

1. **Selalu backup database** sebelum update besar
2. **Test di environment staging** dulu sebelum production
3. **Gunakan branch** untuk development dan production
4. **Set APP_DEBUG=false** di production
5. **Gunakan HTTPS** jika memungkinkan

---

## 🚀 Workflow Ideal

**Di Lokal:**
1. Develop fitur baru
2. Test di local
3. `git add .`
4. `git commit -m "message"`
5. `git push origin main`

**Di Server:**
1. `cd /var/www/html/garda`
2. `./deploy.sh` (atau manual git pull + clear cache)
3. Test aplikasi
4. Selesai!

---

File `deploy.sh` sudah dibuat untuk mempermudah update!
