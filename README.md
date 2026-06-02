LAPORAN
UTS PRAKTIKUM PEMROGRAMAN WEB FULLSATCK
MINI SIMRS - INVENTARIS & MAINTENACE IT RS

Oleh:
(Azhis Fauzan P/2305101010/6B)

1.	ERD DATABASE
    <img width="886" height="1020" alt="image" src="https://github.com/user-attachments/assets/b07016eb-a6f3-4f00-a5dd-609e8862366a" />

Berdasarkan Foreign Key (FK) yang ada di tabel-tabel tersebut, relasinya adalah:
1.	ruangan ke perangkat (One-to-Many):
Satu ruangan dapat memiliki/menampung banyak perangkat (PC, Printer, dll). Foreign key ruangan_id ada di tabel perangkat.
2.	perangkat ke maintenance (One-to-Many):
Satu perangkat bisa memiliki banyak riwayat catatan maintenance atau perbaikan dari waktu ke waktu. Foreign key perangkat_id ada di tabel maintenance.
3.	users ke maintenance (One-to-Many):
Satu Teknisi (User) bisa mengerjakan banyak tugas maintenance. Foreign key user_id ada di tabel maintenance.
4.	perangkat ke peminjaman (One-to-Many):
Satu perangkat bisa dipinjam berkali-kali secara bergantian (historis). Foreign key perangkat_id ada di tabel peminjaman.

2.	DAFTAR ENDPOINT

|     Modul          |     Method     |     Endpoint   (Route)       |     Deskripsi   & Akses                                     |
|--------------------|----------------|------------------------------|-------------------------------------------------------------|
|     Auth           |     POST       |     /api/register            |     Mendaftarkan user   baru                                |
|                    |     POST       |     /api/login               |     Login Admin / Teknisi   untuk dapat Token               |
|                    |     POST       |     /api/logout              |     Logout dan menghapus   Token                            |
|     Ruangan        |     GET        |     /api/ruangan             |     Menampilkan semua daftar   ruangan                      |
|                    |     POST       |     /api/ruangan             |     Menambah ruangan baru (Admin)                           |
|                    |     PUT/DEL    |     /api/ruangan/{id}        |     Update / Hapus ruangan (Admin)                          |
|     Perangkat      |     GET        |     /api/perangkat           |     List perangkat (Bisa   filter ruangan/kondisi/jenis)    |
|                    |     GET        |     /api/perangkat/{id}      |     Menampilkan detail &   riwayat perangkat                |
|                    |     POST       |     /api/perangkat           |     Menambah perangkat baru (Hanya   Admin)                 |
|                    |     PUT/DEL    |     /api/perangkat/{id}      |     Update / Hapus perangkat   (Hanya Admin)                |
|     Maintenance    |     GET        |     /api/maintenance         |     Melihat daftar maintenance   IT                         |
|                    |     POST       |     /api/maintenance         |     Mencatat maintenance   baru (user_id otomatis)          |
|                    |     PUT        |     /api/maintenance/{id}    |     Update status selesai   & ubah kondisi perangkat        |
|                    |     DEL        |     /api/maintenance/{id}    |     Menghapus log maintenance   (Admin)                     |
|     Peminjaman     |     GET        |     /api/peminjaman          |     List data peminjaman alat   IT                          |
|                    |     POST       |     /api/peminjaman          |     Mencatat peminjaman   (Validasi alat sudah dipinjam)    |
|                    |     PUT        |     /api/peminjaman/{id}     |     Pengembalian perangkat                                  |
|                    |     DEL        |     /api/peminjaman/{id}     |     Menghapus data peminjaman   (Admin)                     |

3.	TESTING & DOKUMENTASI API (POSTMAN)
    1. Auth
      - 
    2. Ruangan
      -

    3. Perangkat
    4. Maintenance
    5. Peminjaman

