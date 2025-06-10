# Kopnus TEST - Simple Job Portal API

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

### **4. Generate Key, Migrasi Database & Seeder**
```sh
php artisan key:generate
php artisan migrate
php artisan db:seed --class=UserSeeder
```
## 🛠 Access
### 👤 Recruiter
- **Username:** `recruiter`  
- **Password:** `12345678`

### 👤 Job Seeker
- **Username:** `jobseeker`  
- **Password:** `12345678`

### **5. Jalankan Server**
```sh
php artisan serve
```
API akan berjalan di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Stuktur Database
Klik tautan berikut untuk melihat class diagram:
👉 [Lihat Diagram](https://viewer.diagrams.net/?tags=%7B%7D&lightbox=1&highlight=0000ff&edit=_blank&layers=1&nav=1&title=Kopnus%20Test.drawio&dark=auto#Uhttps%3A%2F%2Fdrive.google.com%2Fuc%3Fid%3D1AssRuMQ0ieJmC4X3AUZv53JtU0zKcBe5%26export%3Ddownload)

## 📌 Dokumentasi API [Postman]
Dokumentasi API ini tersedia dalam format Postman Collection. Silakan unduh atau impor langsung ke Postman melalui tautan di bawah:
## 🔗 Unduh Koleksi Postman

Klik tautan berikut untuk mengunduh file koleksi:

👉 [Download API Postman Collection](./Kopnus.postman_collection.json)