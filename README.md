# 🧾 Employee Attendance Frontend (Blade UI)

Antarmuka web Laravel Blade untuk sistem absensi karyawan. Menghubungkan API backend melalui HTTP Client Laravel.

---

## ✅ Repository GitHub

```
https://github.com/zhabsnaziz/employee-attendance-frontend
```

---

## 📁 Struktur Folder

```
employee-attendance-frontend/
├── app/
│   └── Http/Controllers/
├── resources/
│   └── views/
│       ├── home/
│       ├── employees/
│       ├── departments/
│       └── attendance/
│       ├── layout/
├── routes/
│   └── web.php
├── public/
├── .env
├── composer.json
├── README.md
└── ...
```

---

## 📘 Fitur Frontend

- CRUD Karyawan
- CRUD Departemen
- Absen Masuk & Keluar
- Log Absensi + Filter Tanggal & Departemen

---

## ⚙️ Instalasi

```bash
git clone https://github.com/zhabsnaziz/employee-attendance-frontend.git
cd employee-attendance-frontend
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

---

## 🌐 Koneksi API

Gunakan `Http::get()`, `Http::post()` dari Laravel untuk komunikasi ke backend:

```php
$response = Http::get("http://127.0.0.1:8000/api/");
```

---

## 🖼️ Struktur Blade

- `home/index.blade.php` → List karyawan
- `employees/index.blade.php` → List karyawan
- `employees/form.blade.php` → Tambah karyawan & Edit karyawan
- `departments/index.blade.php` → List departments
- `departments/form.blade.php` → Tambah departments & Edit departments
- `attendance/form.blade.blade.php` → Clock In & Clock Out
- `attendance/log.blade.php` → Log Absensi + Filter
- `layouts/app.blade.php` → Layout

---

## 🔒 Keamanan

- Validasi input melalui Blade
- Proteksi CSRF
- Flash message untuk error/sukses dari API

---

## 📄 Info Tambahan

- Laravel 12.x
- PHP >= 8.2
- Gunakan template `@extends('layouts.app')`
- API dikonsumsi secara asinkron dari server Blade

_Dikembangkan untuk keperluan ujian Fullstack Developer Challenge oleh PT Fleetify._
