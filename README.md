# STTC-NEWS - Sistem Informasi Portal Berita Kampus

**Nama:** Anita Dewi Permani  
**Mata Kuliah:** Pemrosesan Data Terdistribusi  
**Institusi:** Sekolah Tinggi Teknologi Cipasung

---

## Deskripsi Sistem
STTC-NEWS adalah sistem informasi portal berita kampus berbasis REST API yang dibangun menggunakan Laravel. Sistem ini mengimplementasikan konsep **Distributed Database** dengan menggunakan **2 PostgreSQL database** yang dihubungkan menggunakan **Foreign Data Wrapper (FDW)**.

---

## Arsitektur Sistem
## Arsitektur Sistem

```
Laravel Backend (Port 8000)
├── db_main (PostgreSQL Port 5432) → menyimpan: admins, kategoris
└── db_berita (PostgreSQL Port 5433) → menyimpan: beritas

FDW: db_main dapat membaca tabel beritas di db_berita
```---

## Teknologi yang Digunakan
- **Backend:** Laravel 10 (PHP 8.4)
- **Database 1:** PostgreSQL 15 (db_main) → admins, kategoris
- **Database 2:** PostgreSQL 15 (db_berita) → beritas
- **FDW:** postgres_fdw (Foreign Data Wrapper)
- **Container:** Docker
- **API Testing:** Postman

---

## Cara Menjalankan Sistem

### Prasyarat
- Docker Desktop
- Postman

### Langkah-langkah

**1. Clone repository:**
```bash
git clone https://github.com/anitt17/sttc-news.git
cd sttc-news
```

**2. Jalankan Docker:**
```bash
docker-compose up -d --build
```

**3. Generate app key:**
```bash
docker exec sttc_app php artisan key:generate
```

**4. Jalankan migration:**
```bash
docker exec sttc_app php artisan migrate
```

**5. Isi data awal:**
```bash
docker exec sttc_app php artisan db:seed
```

**6. Setup FDW:**
```bash
docker exec sttc_db_main psql -U sttc_user -d sttc_main -c "CREATE EXTENSION IF NOT EXISTS postgres_fdw;"

docker exec sttc_db_main psql -U sttc_user -d sttc_main -c "CREATE SERVER db_berita_server FOREIGN DATA WRAPPER postgres_fdw OPTIONS (host 'db_berita', port '5432', dbname 'sttc_berita');"

docker exec sttc_db_main psql -U sttc_user -d sttc_main -c "CREATE USER MAPPING FOR sttc_user SERVER db_berita_server OPTIONS (user 'sttc_user', password 'sttc_password');"

docker exec sttc_db_main psql -U sttc_user -d sttc_main -c "CREATE FOREIGN TABLE beritas_foreign (id_berita bigint, judul varchar(200), isi text, tanggal date, id_kategori bigint, id_admin bigint, created_at timestamp, updated_at timestamp) SERVER db_berita_server OPTIONS (schema_name 'public', table_name 'beritas');"
```

---

## Daftar API Endpoint

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/api/login` | Login admin |
| GET | `/api/berita` | Tampilkan semua berita |
| GET | `/api/berita/{id}` | Tampilkan detail berita |
| GET | `/api/berita/search?keyword=` | Cari berita |
| POST | `/api/berita` | Tambah berita baru |
| PUT | `/api/berita/{id}` | Edit berita |
| DELETE | `/api/berita/{id}` | Hapus berita |
| GET | `/api/kategori` | Tampilkan semua kategori |
| POST | `/api/kategori` | Tambah kategori |
| PUT | `/api/kategori/{id}` | Edit kategori |
| DELETE | `/api/kategori/{id}` | Hapus kategori |

---

## Akun Default
- **Username:** admin
- **Password:** admin123

---

## Bukti Distributed Database (FDW)
```bash
# Query FDW dari db_main ke db_berita
docker exec sttc_db_main psql -U sttc_user -d sttc_main -c "SELECT * FROM beritas_foreign;"
```