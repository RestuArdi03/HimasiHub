<p align="center">
<img src="himasi-logo.png" alt="HIMASI" style="border-radius: 5px" height="200">
</p>
<h1 align="center">HimasiHub</h1>
Sebuah website media informasi dan manajemen Himpunan Mahasiswa Sistem Informasi Universitas Bina Sarana Informatika PSDKU Kota Yogyakarta

## 📋 Requirements

- **PHP 8.2**
- **Composer**
- **Node.js & NPM**
- **MySQL**
- **Git**
---

## ⚙️ Installation

1. Clone project dan masuk ke foldernya:
```bash
git clone https://github.com/RestuArdi03/HimasiHub.git HimasiHub
cd HimasiHub
```

2. Menginstall modul composer
```bash
composer install
```

3. Menginstall modul npm
```bash
npm install
```

4. Membangun modul npm
```bash
npm run build
```

5. Menginstall Library Prasyarat (package doctrine/dbal)
```bash
composer require doctrine/dbal
```

6. Salin env, pastikan juga informasi didalamnya sesuai
```bash
cp .env.example .env
```

7. Membuat key laravel
```bash
php artisan key:generate
```

8. Membuat dan mengisi database
```bash
php artisan migrate --seed
```

9. Menghubungkan public ke storage
```bash
php artisan storage:link
```

10. Menjalankan project
```bash
php artisan serve
```