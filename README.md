# SERTIFICATE GENERATE

Certificate Generator adalah sebuah platform berbasis website yang dirancang untuk memudahkan pembuatan sertifikat digital secara cepat dan efisien. Website ini memungkinkan pengguna, seperti institusi pendidikan, perusahaan, atau penyelenggara acara, untuk menghasilkan sertifikat secara otomatis dengan desain profesional. Pengguna hanya perlu mengunggah data peserta, memilih template yang tersedia, dan sertifikat digital akan langsung dihasilkan dalam format PDF siap unduh.


## Teknologi yang Digunakan
- **Framework**: Laravel
- **Library**: DOMPDF
- **Database**: MySQL
- **Frontend**: Blade Template, Bootstrap, JavaScript, jQuery
- **Backend**: Laravel API, JWT Authentication, Queue

## Panduan Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek ini di lingkungan lokal Anda.

### 1. Clone Repository
Clone repositori dari GitHub dan masuk ke direktori proyek:
```bash
git clone https://github.com/username/reponame.git
cd reponame
code .
```

### 2. Instal Dependensi
Jalankan perintah berikut untuk menginstal semua dependensi Laravel dan Node.js:
```bash
composer install
composer update
npm install
```

### 3. Konfigurasi Environment
- Salin file `.env` dari contoh `.env.example`:
    ```bash
    cp .env.example .env
    ```
- Edit file `.env` untuk konfigurasi database:
    ```dotenv
    DB_DATABASE=nama_database
    DB_USERNAME=root
    DB_PASSWORD=isi_password_anda
    ```

### 4. Generate Kunci Aplikasi
Jalankan perintah untuk membuat kunci aplikasi:
```bash
php artisan key:generate
```

### 5. Instal Library Tambahan
Tambahkan library DOMPDF dan ikon Bootstrap:
```bash
composer require barryvdh/laravel-dompdf
npm install bootstrap-icons
```

### 6. Migrasi Database dan Seeder
Migrasikan tabel ke database dan jalankan seeder untuk mengisi data awal:
```bash
php artisan migrate
php artisan db:seed
```

### 7. Jalankan Aplikasi
Jalankan server lokal Laravel:
```bash
php artisan serve
```

Buka aplikasi di browser:
```
http://127.0.0.1:8000
```

---

## Fitur Utama
1. **Generate Sertifikat** - Buat sertifikat secara otomatis dalam format PDF menggunakan DOMPDF.  
2. **Autentikasi** - JWT Authentication untuk keamanan API.  
3. **Queue** - Proses generate sertifikat menggunakan antrian agar performa lebih optimal.  
4. **Tampilan Dinamis** - Menggunakan Blade Template, Bootstrap, dan jQuery untuk tampilan responsif.  

---

## Kontribusi
Jika Anda ingin berkontribusi pada proyek ini, silakan buat pull request atau hubungi kami melalui email.

---

## Lisensi
Proyek ini dilindungi oleh lisensi MIT.

