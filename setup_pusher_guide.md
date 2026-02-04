# Panduan Konfigurasi Pusher untuk Real-Time Dashboard

## Langkah 1: Daftar Pusher Account
1. Buka https://pusher.com/
2. Sign up untuk free account
3. Buat new app dengan:
   - Cluster: pilih yang terdekat (misal: ap1 untuk Asia Pacific)
   - Frontend: JavaScript
   - Backend: Laravel

## Langkah 2: Update .env File
Buka file `.env` dan update konfigurasi Pusher:

```env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=your_app_id_here
PUSHER_APP_KEY=your_app_key_here
PUSHER_APP_SECRET=your_app_secret_here
PUSHER_APP_CLUSTER=ap1  # ganti sesuai cluster pilihan

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

## Langkah 3: Install Dependencies
```bash
npm install --save-dev laravel-echo pusher-js
```

## Langkah 4: Rebuild Assets
```bash
npm run dev
# atau untuk production
npm run prod
```

## Langkah 5: Enable Broadcasting
Pastikan `BroadcastServiceProvider` terdaftar di `config/app.php`:

```php
'providers' => [
    // ...
    App\Providers\BroadcastServiceProvider::class,
    // ...
],
```

## Langkah 6: Test Real-Time Features
1. Buka dashboard di browser
2. Lakukan scan baru atau update poin driver
3. Dashboard harus update otomatis tanpa refresh

## Troubleshooting

### Jika tidak berfungsi:
1. Cek browser console untuk error
2. Pastikan Pusher credentials benar
3. Verify BROADCAST_DRIVER=pusher
4. Restart queue worker jika menggunakan queue: `php artisan queue:work`

### Fallback System:
Dashboard sudah memiliki polling fallback setiap 3 detik jika Pusher gagal.

## Channels yang Digunakan:
- `scans` - Untuk notifikasi scan baru
- `driver-points` - Untuk update poin driver

## Security Notes:
- Gunakan environment variables untuk credentials
- Enable private channels untuk data sensitif
- Consider authentication untuk production
