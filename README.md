# Laporan UTS Praktikum Pemrograman Web Fullstack
## Mini SIMRS - Inventaris & Maintenance IT RS

**Oleh:** Azhis Fauzan P (2305101010 / 6B)  

---

## ERD Database & Relasi
<img width="886" height="1020" alt="image" src="https://github.com/user-attachments/assets/cca6765f-f93c-4d16-99fe-8f74969da3a3" />


Berdasarkan *Foreign Key* (FK) yang dirancang pada database, berikut adalah relasi antar tabelnya:

- **Ruangan ke Perangkat (One-to-Many)**
  Satu ruangan dapat memiliki atau menampung banyak perangkat (PC, Printer, dll). *Foreign key* `ruangan_id` berada di tabel `perangkat`.
- **Perangkat ke Maintenance (One-to-Many)**
  Satu perangkat bisa memiliki banyak riwayat catatan maintenance atau perbaikan dari waktu ke waktu. *Foreign key* `perangkat_id` berada di tabel `maintenance`.
- **Users ke Maintenance (One-to-Many)**
  Satu Teknisi (User) bisa mengerjakan banyak tugas maintenance. *Foreign key* `user_id` berada di tabel `maintenance`.
- **Perangkat ke Peminjaman (One-to-Many)**
  Satu perangkat bisa dipinjam berkali-kali secara bergantian (historis). *Foreign key* `perangkat_id` berada di tabel `peminjaman`.

---

## Daftar Endpoint API

| Modul | Method | Endpoint (Route) | Deskripsi & Akses |
| :--- | :---: | :--- | :--- |
| **Auth** | `POST` | `/api/register` | Mendaftarkan user baru |
| | `POST` | `/api/login` | Login Admin / Teknisi untuk mendapatkan Token |
| | `POST` | `/api/logout` | Logout dan menghapus Token |
| **Ruangan** | `GET` | `/api/ruangan` | Menampilkan semua daftar ruangan |
| | `POST` | `/api/ruangan` | Menambah ruangan baru (Admin) |
| | `PUT/DELETE` | `/api/ruangan/{id}` | Update / Hapus ruangan (Admin) |
| **Perangkat** | `GET` | `/api/perangkat` | List perangkat (Bisa filter ruangan/kondisi/jenis) |
| | `GET` | `/api/perangkat/{id}` | Menampilkan detail & riwayat perangkat |
| | `POST` | `/api/perangkat` | Menambah perangkat baru (Hanya Admin) |
| | `PUT/DELETE` | `/api/perangkat/{id}` | Update / Hapus perangkat (Hanya Admin) |
| **Maintenance** | `GET` | `/api/maintenance` | Melihat daftar maintenance IT |
| | `POST` | `/api/maintenance` | Mencatat maintenance baru (`user_id` terisi otomatis) |
| | `PUT` | `/api/maintenance/{id}` | Update status selesai & ubah kondisi perangkat |
| | `DELETE` | `/api/maintenance/{id}` | Menghapus log maintenance (Admin) |
| **Peminjaman** | `GET` | `/api/peminjaman` | List data peminjaman alat IT |
| | `POST` | `/api/peminjaman` | Mencatat peminjaman (Validasi alat sudah dipinjam) |
| | `PUT` | `/api/peminjaman/{id}` | Pengembalian perangkat |
| | `DELETE` | `/api/peminjaman/{id}` | Menghapus data peminjaman (Admin) |

---

## Testing & Dokumentasi API (Postman)

### 1. Auth
- `[POST]` `/api/register`
  
  <img width="674" height="465" alt="image" src="https://github.com/user-attachments/assets/c084caa7-efd5-491f-9121-e9bfc4a11906" />

- `[POST]` `/api/login` (Admin)
  
  <img width="676" height="415" alt="image" src="https://github.com/user-attachments/assets/c38b5712-b63f-4eb1-8458-7714c9b328f3" />

- `[POST]` `/api/login` (Teknisi)
  
  <img width="677" height="429" alt="image" src="https://github.com/user-attachments/assets/0e384a46-8fd8-47d9-84e6-57ac76777ced" />

- `[POST]` `/api/logout`
  
  <img width="692" height="330" alt="image" src="https://github.com/user-attachments/assets/4b845f3b-283f-49de-8e18-115686ebd079" />


### 2. Ruangan
- `[GET]` `/api/ruangan` (List Ruangan)

  <img width="602" height="412" alt="image" src="https://github.com/user-attachments/assets/f7187093-c141-418b-8fb6-2d26510e6dcd" />

- `[POST]` `/api/ruangan` (Tambah Ruangan)

  <img width="677" height="465" alt="image" src="https://github.com/user-attachments/assets/ea53c10c-06c8-4176-8e5e-19f51ee6bd52" />

- `[PUT]` `/api/ruangan/{id}` (Update Ruangan)

  <img width="681" height="396" alt="image" src="https://github.com/user-attachments/assets/afd8957a-da44-40ac-9586-89559e36f577" />


### 3. Perangkat
- `[GET]` `/api/perangkat` (List Perangkat)

  <img width="660" height="471" alt="image" src="https://github.com/user-attachments/assets/534be7c2-72b3-4aa6-924c-3d79fa9c2d77" />

- `[GET]` `/api/perangkat/{id}` (Detail Perangkat & Riwayat)

  <img width="660" height="471" alt="image" src="https://github.com/user-attachments/assets/2704add4-355f-44ec-ae70-bcd0a19436b7" />

- `[POST]` `/api/perangkat` (Tambah Perangkat)

  <img width="655" height="464" alt="image" src="https://github.com/user-attachments/assets/60ea7691-2ba6-43b0-b110-8e5048fc9700" />

- `[DELETE]` `/api/perangkat/{id}` (Hapus Perangkat)

  <img width="654" height="269" alt="image" src="https://github.com/user-attachments/assets/de778fa5-1cc6-4005-a02d-1002734f02be" />


### 4. Maintenance
- `[GET]` `/api/maintenance` (List Maintenance)

  <img width="656" height="332" alt="image" src="https://github.com/user-attachments/assets/0f7986cd-4530-47e4-b039-facac5d15544" />

- `[POST]` `/api/maintenance` (Catat Maintenance)

  <img width="648" height="468" alt="image" src="https://github.com/user-attachments/assets/fe69bf9d-8236-4f6f-8d49-0eeb09741f8d" />

- `[PUT]` `/api/maintenance/{id}` (Update Maintenance / Selesai)

  <img width="711" height="466" alt="image" src="https://github.com/user-attachments/assets/1843beaa-9a2a-46f0-9778-583335960f14" />

- `[DELETE]` `/api/maintenance/{id}` (Hapus Maintenance)

  <img width="715" height="318" alt="image" src="https://github.com/user-attachments/assets/df2c59ff-91cb-480e-b141-c38e32c5e82d" />


### 5. Peminjaman
- `[GET]` `/api/peminjaman` (List Peminjaman)

  <img width="713" height="329" alt="image" src="https://github.com/user-attachments/assets/5dceeb04-7bcd-43d0-abf3-bd7323d2082d" />

- `[POST]` `/api/peminjaman` (Catat Peminjaman)

  <img width="660" height="317" alt="image" src="https://github.com/user-attachments/assets/d79c55b4-ba75-4071-ba66-5222442d1ec6" />

- `[PUT]` `/api/peminjaman/{id}` (Gagal karena perangkat rusak/sedang dipinjam)

  <img width="658" height="325" alt="image" src="https://github.com/user-attachments/assets/8dbc0838-675e-4912-a77c-e29b002cff2a" />

- `[DELETE]` `/api/peminjaman/{id}` (Hapus Peminjaman)

  <img width="719" height="341" alt="image" src="https://github.com/user-attachments/assets/49b075a8-3adb-43ad-8368-0301d0dbaa58" />


---

## Kendala dan Solusi

* **Kendala:** Saat melakukan testing endpoint `Login`, muncul error `Invalid URI "http:///login"` di Postman sehingga tidak bisa mendapatkan token.
* **Solusi:** Ternyata *environment variable* `{{api_url}}` belum tersimpan (*save*) dan *Current Value*-nya masih kosong. Setelah *value* diisi dengan URL lokal aplikasi dan disimpan, *request* berhasil dijalankan dengan baik.

---

## Langkah Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek **Mini SIMRS - Inventaris & Maintenance IT RS** secara lokal di komputer Anda.

### Persyaratan Sistem
Pastikan sistem Anda sudah terinstal:
- **PHP** (Minimal versi 8.2 atau yang sesuai dengan spesifikasi Laravel 12)
- **Composer** (Untuk manajemen dependensi PHP)
- **MySQL** (Atau aplikasi bundle seperti XAMPP/Laragon)
- **Git**

### Cara Instalasi

**1. Clone Repositori**
Buka terminal/command prompt, lalu jalankan perintah berikut untuk mengkloning repositori ini ke dalam direktori lokal Anda:
```
git clone [https://github.com/AzhisFauzan/UtsPemWeb2.git](https://github.com/AzhisFauzan/UtsPemWeb2.git)
```

**2. Masuk ke Direktori Proyek**
```
cd UtsPemWeb2
```

**3. Install Dependensi PHP (Composer)**
Jalankan perintah ini untuk menginstal semua library dan dependensi Laravel yang dibutuhkan:
```
composer install
```

**4. Konfigurasi Environment (File .env)**
Salin file konfigurasi bawaan menjadi file .env yang aktif:
```
cp .env.example .env
```

**5. Generate Application Key**
Buat key unik untuk keamanan aplikasi Laravel Anda:
```
php artisan key:generate
```

**6. Konfigurasi Database**

- Buka aplikasi database client Anda (misalnya phpMyAdmin, DBeaver, dll).
- Buat database baru (mini_simrs).
- Buka file .env di text editor Anda (VS Code), lalu sesuaikan konfigurasi koneksi database berikut:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_simrs   # Ubah sesuai nama database yang baru Anda buat
DB_USERNAME=root            # Username default XAMPP/Laragon
DB_PASSWORD=                # Kosongkan jika tidak ada password
```

**7. Jalankan Migrasi Database**
Setelah database terhubung, buat struktur tabel beserta datanya (jika ada seeder) menggunakan perintah:
```
php artisan migrate
```

**8. Jalankan Local Development Server**
Terakhir, nyalakan server bawaan Laravel:
```
php artisan serve
```
