# Kopnus TEST - Simple Job Portal API

## 📌 Deskripsi Singkat
API CRUD untuk entitas User menggunakan Laravel dan MySQL. API ini mencakup validasi input, logging, dan pengujian dengan PHPUnit.

## 🚀 Instalasi

### **1. Clone Repository**
```sh
git clone <repository-url>
cd <project-folder>
```

### **2. Instal Dependensi**
```sh
composer install
```

### **3. Konfigurasi Lingkungan**
Salin file `.env.example` menjadi `.env` dan sesuaikan dengan konfigurasi database:
```sh
cp .env.example .env
```
Lalu, edit file `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=password
```

### **4. Generate Key & Migrasi Database**
```sh
php artisan key:generate
php artisan migrate --seed
```
## 🛠 Access
### **1. Recruiter**
username : recruiter
password : 12345678

### **2. JobSeeker**
username : recruiter
password : 12345678

### **5. Jalankan Server**
```sh
php artisan serve
```
API akan berjalan di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 📌 Dokumentasi API [Postman]
Dokumentasi API ini tersedia dalam format Postman Collection. Silakan unduh atau impor langsung ke Postman melalui tautan di bawah:
## 🔗 Unduh Koleksi Postman

Klik tautan berikut untuk mengunduh file koleksi:

👉 [Download API Postman Collection](./Kopnus.postman_collection.json)