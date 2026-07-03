# 📚 Sistem Informasi Akademik (SIAKAD)

Sistem Informasi Akademik (SIAKAD) merupakan aplikasi berbasis **Laravel** yang dirancang untuk membantu pengelolaan proses akademik di perguruan tinggi. Sistem ini berfokus pada pengelolaan semester, penyusunan jadwal kuliah secara otomatis, dan pengolahan nilai mahasiswa secara terintegrasi.

---

# ✨ Modul Utama

## 📅 Kelola Semester Akademik

Modul untuk mengatur seluruh aktivitas akademik berdasarkan semester yang sedang berjalan.

### Fitur
- ✅ Tambah Semester Akademik
- ✅ Ubah Data Semester
- ✅ Menentukan Semester Aktif
- ✅ Pengaturan Tahun Akademik
- ✅ Membuka & Menutup Periode KRS
- ✅ Monitoring Status Semester

---

## 🗓️ Generate Jadwal Kuliah Otomatis

Menyusun jadwal kuliah secara otomatis berdasarkan data mata kuliah, dosen, ruang, dan waktu sehingga meminimalkan bentrok jadwal.

### Fitur
- ✅ Generate Jadwal Otomatis
- ✅ Penempatan Dosen Pengampu
- ✅ Pengaturan Hari & Jam Kuliah
- ✅ Penempatan Ruang Kuliah
- ✅ Deteksi Bentrok Jadwal Dosen
- ✅ Deteksi Bentrok Ruangan
- ✅ Regenerate Jadwal
- ✅ Monitoring Jadwal Per Semester

---

## 📊 Input & Monitoring Nilai

Modul yang digunakan dosen untuk mengelola nilai mahasiswa.

### Fitur
- ✅ Input Nilai Tugas
- ✅ Input Nilai UTS
- ✅ Input Nilai UAS
- ✅ Perhitungan Nilai Akhir Otomatis
- ✅ Konversi Nilai Huruf
- ✅ Edit Nilai
- ✅ Monitoring Nilai Mahasiswa

---

# 🔄 Alur Sistem


Kelola Semester
        │
        ▼
Generate Jadwal Kuliah
        │
        ▼
Mahasiswa Mengambil KRS
        │
        ▼
Perkuliahan Berlangsung
        │
        ▼
Input Nilai
        │
        ▼
Hasil Nilai Mahasiswa
```

---

# 🛠️ Teknologi

- Laravel 10/11
- PHP 8.1+
- MySQL 5.7+
- Bootstrap 5

---

# 📋 Persyaratan

- PHP 8.1+
- Composer
- MySQL 5.7+
- Apache / Nginx

---

# 🚀 Instalasi

## 1. Clone Repository

```bash
git clone https://github.com/fanzqi/SIAKAD.git
cd siakad
```

## 2. Install Dependency

```bash
composer install
```

## 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

## 4. Konfigurasi Database

Edit file `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_siakad
DB_USERNAME=root
DB_PASSWORD=
```

## 5. Import Database

```bash
mysql -u root -p db_siakad < database/db_siakad.sql
```

atau apabila menggunakan migration

```bash
php artisan migrate
```

Jika terdapat seeder

```bash
php artisan db:seed
```

## 6. Jalankan Aplikasi

```bash
php artisan serve
```

Akses melalui browser

```
http://127.0.0.1:8000
```

---

# 🔑 Akun Default

| Role | Username | Password |
|------|----------|----------|
| Akademik | akademik | password |
| Dosen | dosen | password |
| Mahasiswa | 220001 | password |

> **Catatan:** Demi keamanan, segera ubah password default setelah login pertama.

---

# 📂 Struktur Project

```
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
```

---

# 🚀 Pengembangan Selanjutnya

- Export PDF
- Export Excel
- Kartu Hasil Studi (KHS)
- Transkrip Nilai
- Dashboard Statistik
- REST API
- Notifikasi Akademik
- Integrasi Single Sign-On (SSO)

---

# 👨‍💻 Tim Pengembang

- **Mohammad Zulfan Syafiqi** — 23060022
- **Jessica Christianto** — 23060018
- **Maulan Fawaidzul Amarin** — 23070001

**Institut Teknologi dan Sains Mandala**

