# Stock Management - Sistem Penjualan TokoKu

Aplikasi manajemen stok dan penjualan berbasis web menggunakan **CodeIgniter 4** dengan arsitektur **Clean Architecture** dan **Service Layer Pattern**.

---

## Fitur

- **Autentikasi**  Login & Register (dengan hashing password)
- **Dashboard**  Ringkasan data penjualan & stok
- **Manajemen Kategori**  CRUD kategori produk
- **Manajemen Produk**  CRUD produk dengan upload gambar & manajemen stok
- **Transaksi Penjualan**  Buat transaksi, otomatis kurangi stok, cetak invoice

---

## Tech Stack

- **PHP** >= 8.2
- **CodeIgniter 4**
- **MySQL / MariaDB**
- **Bootstrap 5** (UI)

---

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/Yuzzar/Stock-Management.git
cd Stock-Management
```

### 2. Install dependencies

```bash
composer install
```

### 3. Konfigurasi environment

```bash
cp env .env
```

Edit `.env` dan sesuaikan:

```env
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = toko_penjualan
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

### 4. Buat database & jalankan migration + seeder

```bash
php spark migrate
php spark db:seed UserSeeder
```

### 5. Jalankan server

```bash
php spark serve
```

Akses di: `http://localhost:8080`

---

## Akun Default

| Username | Email              | Password   |
|----------|--------------------|------------|
| admin    | admin@example.com  | password   |

---

## Struktur Folder

```
app/
├── Controllers/     # HTTP Controllers
├── Models/          # Database Models
├── Services/        # Business Logic (Service Layer)
├── Filters/         # Middleware (Auth, Guest)
├── Views/           # Blade-style Views (Bootstrap 5)
└── Database/
    ├── Migrations/  # Schema migrations
    └── Seeds/       # Data seeders
```

---

## Server Requirements

- PHP >= 8.2 dengan ekstensi: `intl`, `mbstring`, `json`, `mysqlnd`
- MySQL / MariaDB
- Composer

---

## License

MIT License
