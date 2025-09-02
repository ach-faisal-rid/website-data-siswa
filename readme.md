# 📂 Struktur Folder — Website Data Siswa

Proyek ini terbagi menjadi dua bagian utama: **Backend** (PHP + MySQL) dan **Frontend** (HTML/JS).
Berikut struktur folder lengkapnya:

```
website-data-siswa/
│
├── backend/                  # Folder untuk server-side (PHP + MySQL)
│   ├── koneksi.php           # File koneksi ke database MySQL
│   ├── siswa.php             # Endpoint untuk menampilkan (GET) data siswa
│   ├── tambah-siswa.php      # Endpoint untuk menambah (POST) data siswa
│   ├── edit-siswa.php        # Endpoint untuk mengedit (UPDATE) data siswa
│   ├── hapus-siswa.php       # Endpoint untuk menghapus (DELETE) data siswa
│
├── frontend/                 # Folder untuk client-side (HTML/JS)
│   └── index.html            # Halaman utama untuk menampilkan data siswa
│
└── readme.md                 # Dokumentasi proyek
```

---

## ✨ Penjelasan Singkat

* **Backend**
  Bagian ini berisi kode PHP yang berfungsi sebagai **REST API** untuk menangani operasi **CRUD** (Create, Read, Update, Delete) pada data siswa.

* **Frontend**
  Bagian ini menampilkan data siswa di browser. Frontend akan mengambil data dari **API (backend)** menggunakan JavaScript (misalnya `fetch()`).

* **Database**
  Proyek ini menggunakan **MySQL**. Pastikan database sudah dibuat dengan tabel `siswa` yang sesuai (id, nama, kelas).

---

## 🚀 Cara Menjalankan Proyek

1. Install **XAMPP / Laragon** dan jalankan `Apache` + `MySQL`.
2. Letakkan folder `website-data-siswa` di dalam `htdocs` (untuk XAMPP).
3. Import database:

   ```sql
   CREATE DATABASE db_siswa;
   USE db_siswa;
   CREATE TABLE siswa (
     id INT AUTO_INCREMENT PRIMARY KEY,
     nama VARCHAR(100),
     kelas VARCHAR(50)
   );
   ```
4. Akses API di browser:

   * `http://localhost/website-data-siswa/backend/siswa.php`
5. Akses halaman frontend:

   * `http://localhost/website-data-siswa/frontend/index.html`

---

# flowchart struktur

```mermaid
flowchart TD
    A[Pengguna Mengakses Aplikasi] --> B{Request Type}
    
    B -->|GET| C[Ambil Data Siswa]
    B -->|POST| D[Tambah Data Siswa]
    B -->|PUT| E[Edit Data Siswa]
    B -->|DELETE| F[Hapus Data Siswa]
    
    subgraph Backend [Backend Processing]
        C --> C1[siswa.php<br>GET Request]
        D --> D1[tambah-siswa.php<br>POST Request]
        E --> E1[edit-siswa.php<br>PUT Request]
        F --> F1[hapus-siswa.php<br>DELETE Request]
        
        C1 --> C2[Query SELECT<br>dari database]
        D1 --> D2[Query INSERT<br>ke database]
        E1 --> E2[Query UPDATE<br>di database]
        F1 --> F2[Query DELETE<br>dari database]
        
        C2 --> C3[Return data JSON]
        D2 --> D3[Return status sukses/gagal]
        E2 --> E3[Return status sukses/gagal]
        F2 --> F3[Return status sukses/gagal]
    end
    
    subgraph Database [MySQL Database]
        DB[(Tabel Siswa<br>id, nama, kelas)]
    end
    
    C2 --> DB
    D2 --> DB
    E2 --> DB
    F2 --> DB
    
    DB --> C3
    DB --> D3
    DB --> E3
    DB --> F3
    
    C3 --> G[Tampilkan Data di Frontend]
    D3 --> H[Notifikasi<br>Data berhasil ditambah]
    E3 --> I[Notifikasi<br>Data berhasil diupdate]
    F3 --> J[Notifikasi<br>Data berhasil dihapus]
    
    H --> K[Refresh Data]
    I --> K
    J --> K
    
    K --> G
    
    G --> L[Selesai]
```
