## Teknologi yang Digunakan
Proyek ini dibangun menggunakan:
- **Bahasa Pemrograman**: PHP
- **Framework**: Laravel 13.15.0
- **Database**: MySQL (disarankan versi terbaru)


## Cara Penggunaan

Untuk menjalankan Web Sales Mobil di lokal Anda, ikuti langkah-langkah berikut:
1. **Clone Repository**
``` bash
git clone -b main https://github.com/adinikolas/trans-aduan.git
cd trans-aduan
```

2. **Install Dependencies**
``` bash
composer install
npm install
```

3. **Konfigurasi Database** Buat file .env dari .env.example:
``` bash
cp .env.example .env
```
Kemudian, edit file .env dan atur konfigurasi database Anda:
``` bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trans-aduan
DB_USERNAME=root
DB_PASSWORD=
```

4. **Migrasi Database** Pastikan database kosong tanpa tabel, lebih baik jika belum ada databasenya. Kemudian, jalankan:
``` bash
php artisan migrate
```

5. **Seed Database** Seed database dengan data awal:
``` bash
php artisan db:seed --class=DatabaseSeeder
```

6. **Menjalankan Server** Untuk menjalankan project ini diperlukan 2 proses terminal antara lain:
``` bash
php artisan serve
npm run dev
```
