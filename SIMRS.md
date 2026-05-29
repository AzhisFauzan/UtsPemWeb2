# SIMRS.md — Mini API Sistem Inventaris & Maintenance Perangkat IT Rumah Sakit
> Panduan lengkap untuk AI agent / developer dalam mengerjakan project REST API
> Tema: Inventaris & Maintenance Perangkat IT RS | Framework: Laravel 10+ (PHP 8.2+)

---

## 1. KONTEKS PROJECT

Membangun **REST API backend** untuk sistem inventaris dan pemeliharaan perangkat IT di lingkungan rumah sakit dengan fitur:
- **User Management** (Register, Login, Role: admin, teknisi)
- **Ruangan / Lokasi** (Data ruangan tempat perangkat berada: ICU, Radiologi, Farmasi, dll.)
- **Perangkat IT** (CRUD perangkat: PC, Printer, Monitor, Server, dll.)
- **Maintenance / Pemeliharaan** (Pencatatan riwayat perbaikan & perawatan berkala)
- **Peminjaman Perangkat** (Catat siapa meminjam perangkat apa, kapan dikembalikan)

**Stack:**
- PHP 8.2+, Laravel 10+
- Laravel Sanctum (Token Auth)
- MySQL

---

## 2. STRUKTUR DATABASE

### Tabel & Kolom

| Tabel | Kolom |
|---|---|
| `users` | id, name, email, password, role (enum: admin, teknisi), timestamps |
| `ruangan` | id, nama, lantai (integer), keterangan (text, nullable), timestamps |
| `perangkat` | id, nama, jenis (enum: pc, laptop, printer, monitor, server, network, lainnya), merk, serial_number (unique), ruangan_id (FK), kondisi (enum: baik, rusak_ringan, rusak_berat, tidak_aktif), tanggal_pembelian (date, nullable), timestamps |
| `maintenance` | id, perangkat_id (FK), user_id (FK → teknisi), tanggal (date), jenis (enum: perbaikan, perawatan), keterangan (text), biaya (decimal 15,2, default 0), status (enum: pending, dikerjakan, selesai), timestamps |
| `peminjaman` | id, perangkat_id (FK), nama_peminjam (string), unit_kerja (string), tanggal_pinjam (date), tanggal_kembali (date, nullable), status (enum: dipinjam, dikembalikan), timestamps |

### Relasi Eloquent

```text
Ruangan      → hasMany    → Perangkat
Perangkat    → belongsTo  → Ruangan
Perangkat    → hasMany    → Maintenance
Perangkat    → hasMany    → Peminjaman
Maintenance  → belongsTo  → Perangkat
Maintenance  → belongsTo  → User (teknisi)
Peminjaman   → belongsTo  → Perangkat
User         → hasMany    → Maintenance (sebagai teknisi)
```

---

## 3. URUTAN SETUP PROJECT (WAJIB BERURUTAN)

### Step 1 — Migrations (Jalankan Sesuai Urutan)

Buat migration untuk tabel berikut dan sesuaikan skemanya:
1. `add_role_to_users_table`
2. `create_ruangan_table`
3. `create_perangkat_table`
4. `create_maintenance_table`
5. `create_peminjaman_table`

**Constraint Penting:**
- Gunakan `constrained()->cascadeOnDelete()` untuk semua foreign key.
- Kolom `serial_number` di perangkat harus `unique()`.
- Override nama tabel di model dengan `$table` karena Laravel akan salah mengira plural (contoh: `ruangans`, `perangkats`).

### Step 2 — Models

Buat model `Ruangan`, `Perangkat`, `Maintenance`, dan `Peminjaman`.
- Tambahkan properti `$table` untuk override nama tabel Laravel.
- Tambahkan properti `$fillable` di setiap model.
- Definisikan method relasi (`belongsTo`, `hasMany`) sesuai struktur database di atas.
- Update model `User` untuk menyertakan `HasApiTokens`, fillable `role`, dan helper method `isAdmin()`.

### Step 3 — Seeders

Buat seeder untuk:
- **UserSeeder**: 1 Admin, 2 Teknisi.
- **RuanganSeeder**: Minimal 5 ruangan (contoh: ICU, UGD, Radiologi, Farmasi, Laboratorium).
- **PerangkatSeeder**: Minimal 8 perangkat tersebar di beberapa ruangan.

### Step 4 — Middleware Role Authorization

Buat middleware:
- `EnsureUserIsAdmin`: Hanya untuk `admin`.

Daftarkan middleware alias di `app/Http/Kernel.php` (contoh: `admin`).

### Step 5 — API Controllers

Buat controller berikut di namespace `App\Http\Controllers\Api`:
- `AuthController`: register, login, logout.
- `RuanganController`: CRUD ruangan.
- `PerangkatController`: CRUD perangkat (dengan filter berdasarkan ruangan & kondisi).
- `MaintenanceController`: CRUD riwayat maintenance.
- `PeminjamanController`: CRUD peminjaman, termasuk endpoint khusus untuk pengembalian.

### Step 6 — API Routes

Kelompokkan routes dengan Sanctum middleware dan role middleware:

**Public Routes:**
- `POST /register`
- `POST /login`

**Protected (Semua Role — admin & teknisi):**
- `POST /logout`
- `GET /ruangan` — Lihat daftar ruangan
- `GET /perangkat` — Lihat daftar perangkat (support query: `?ruangan_id=`, `?kondisi=`, `?jenis=`)
- `GET /perangkat/{id}` — Detail perangkat beserta riwayat maintenance & peminjaman
- `GET /maintenance` — Lihat riwayat maintenance
- `POST /maintenance` — Catat maintenance baru (teknisi mengerjakan)
- `PUT /maintenance/{id}` — Update status maintenance (pending → dikerjakan → selesai)
- `GET /peminjaman` — Lihat daftar peminjaman
- `POST /peminjaman` — Catat peminjaman baru
- `PUT /peminjaman/{id}/kembali` — Tandai perangkat sudah dikembalikan

**Admin Only (`admin`):**
- `POST, PUT, DELETE /ruangan`
- `POST, PUT, DELETE /perangkat`
- `DELETE /maintenance`
- `DELETE /peminjaman`

---

## 4. DAFTAR ENDPOINT API

| Endpoint | Method | Auth & Role | Keterangan |
|---|---|---|---|
| `/api/register` | POST | Public | Daftar akun baru |
| `/api/login` | POST | Public | Login → dapat token |
| `/api/logout` | POST | Bearer Token | Hapus token aktif |
| `/api/ruangan` | GET | Token (Semua) | Daftar ruangan |
| `/api/ruangan` | POST | Admin | Tambah ruangan |
| `/api/ruangan/{id}` | PUT | Admin | Update ruangan |
| `/api/ruangan/{id}` | DELETE | Admin | Hapus ruangan |
| `/api/perangkat` | GET | Token (Semua) | Daftar perangkat (filterable) |
| `/api/perangkat/{id}` | GET | Token (Semua) | Detail perangkat + riwayat |
| `/api/perangkat` | POST | Admin | Tambah perangkat |
| `/api/perangkat/{id}` | PUT | Admin | Update perangkat |
| `/api/perangkat/{id}` | DELETE | Admin | Hapus perangkat |
| `/api/maintenance` | GET | Token (Semua) | Daftar maintenance |
| `/api/maintenance` | POST | Token (Semua) | Catat maintenance baru |
| `/api/maintenance/{id}` | PUT | Token (Semua) | Update status maintenance |
| `/api/maintenance/{id}` | DELETE | Admin | Hapus record maintenance |
| `/api/peminjaman` | GET | Token (Semua) | Daftar peminjaman |
| `/api/peminjaman` | POST | Token (Semua) | Catat peminjaman baru |
| `/api/peminjaman/{id}/kembali` | PUT | Token (Semua) | Pengembalian perangkat |
| `/api/peminjaman/{id}` | DELETE | Admin | Hapus record peminjaman |

---

## 5. FORMAT RESPONSE STANDAR

Semua response **wajib** konsisten (selalu format JSON):

```json
// Sukses
{ "success": true, "message": "Berhasil mengambil data", "data": { ... } }

// Sukses dengan pagination (untuk list endpoint)
{
  "success": true,
  "message": "Daftar perangkat",
  "data": [ ... ],
  "meta": { "current_page": 1, "total": 50, "per_page": 15 }
}

// Error validasi (422)
{ "success": false, "message": "Data tidak valid", "errors": { "field": ["pesan error"] } }

// Error akses / auth (401 / 403)
{ "success": false, "message": "Akses ditolak.", "errors": null }
```

> **Catatan Exception:**
> Update `app/Exceptions/Handler.php` untuk memformat standard error dari `ValidationException` menjadi format JSON di atas.

---

## 6. LOGIKA BISNIS PENTING

### 6.1 Peminjaman Perangkat
- Perangkat hanya bisa dipinjam jika `kondisi = 'baik'` dan tidak sedang dipinjam (tidak ada record peminjaman dengan `status = 'dipinjam'`).
- Saat peminjaman dibuat, kondisi perangkat otomatis di-update sesuai kebutuhan.
- Endpoint `/peminjaman/{id}/kembali` mengisi `tanggal_kembali` dan mengubah `status` menjadi `dikembalikan`.

### 6.2 Maintenance
- Gunakan `DB::transaction()` jika maintenance selesai dan perlu mengubah `kondisi` perangkat (misal: dari `rusak_ringan` → `baik`).
- Saat maintenance baru dibuat, `user_id` otomatis terisi dari user yang sedang login (teknisi yang mengerjakan).

### 6.3 Validasi Hapus Ruangan
- Ruangan tidak boleh dihapus jika masih ada perangkat di dalamnya. Tampilkan pesan error yang jelas.

### 6.4 Filter Perangkat
- `GET /perangkat?ruangan_id=3` — filter perangkat berdasarkan ruangan
- `GET /perangkat?kondisi=rusak_ringan` — filter berdasarkan kondisi
- `GET /perangkat?jenis=printer` — filter berdasarkan jenis

---

## 7. SKENARIO TESTING (POSTMAN / CURL)

Validasi semua skenario berikut setelah implementasi selesai:

| # | Skenario | Expected |
|---|---|---|
| 1 | Register valid | 201 + token |
| 2 | Register email duplikat | 422 |
| 3 | Login benar | 200 + token |
| 4 | Login password salah | 401 |
| 5 | GET /perangkat tanpa token | 401 |
| 6 | GET /perangkat dengan token | 200 + list perangkat |
| 7 | POST /perangkat dengan token teknisi | 403 |
| 8 | POST /perangkat dengan token admin | 201 |
| 9 | POST /peminjaman perangkat yang sudah dipinjam | 422 |
| 10 | PUT /peminjaman/{id}/kembali | 200 + status dikembalikan |
| 11 | POST /maintenance | 201 + user_id otomatis |
| 12 | DELETE /ruangan yang masih ada perangkat | 422 |

---

## 8. PERINTAH ARTISAN BERGUNA

```bash
# Setup ulang dari nol
php artisan migrate:fresh --seed

# Lihat semua route terdaftar
php artisan route:list --path=api

# Eksplorasi query Eloquent secara interaktif
php artisan tinker
>>> Perangkat::where('kondisi', 'baik')->count()
>>> Ruangan::with('perangkat')->get()
>>> Maintenance::where('status', 'pending')->get()
```

---

## 9. ATURAN PENTING (JANGAN DILANGGAR)

1. **Jangan commit `.env`** ke Git — gunakan `.env.example`.
2. **Selalu tambahkan header** `Accept: application/json` saat testing agar Laravel mengembalikan JSON bukan HTML.
3. **Gunakan `DB::transaction()`** pada operasi yang melibatkan lebih dari satu tabel (terutama saat menyelesaikan maintenance yang mengubah kondisi perangkat).
4. **Nama tabel override** — override `$table` di model karena Laravel default akan mencari bentuk plural Inggris (`ruangans`, `perangkats`, `maintenances`, `peminjamans`).
5. **`serial_number` harus unique** — validasi di migration dan di controller (`unique:perangkat,serial_number`).
6. **`APP_DEBUG=true`** di `.env` selama development untuk melihat stack trace lengkap.
7. **Jalankan `php artisan migrate:fresh --seed`** setiap kali struktur database berubah.

---

## 10. REFERENSI

| Sumber | URL |
|---|---|
| Dokumentasi Laravel | https://laravel.com/docs |
| Laravel Sanctum | https://laravel.com/docs/sanctum |
| Eloquent Relationships | https://laravel.com/docs/eloquent-relationships |
| Database Transactions | https://laravel.com/docs/database#database-transactions |
