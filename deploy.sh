#!/bin/bash
# Script untuk update aplikasi dari Git

echo "🔄 Pulling latest changes..."
git pull origin main

echo "📦 Installing/Updating dependencies..."
composer install --optimize-autoloader --no-dev

echo "🧹 Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "✅ Update selesai!"
echo "Akses: http://192.168.100.3:81/garda"
