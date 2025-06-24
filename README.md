# 🌱 Tanahku.id — Platform Digital Jual Beli Tanah Berbasis WebGIS

**Tanahku.id** adalah aplikasi berbasis web yang mengintegrasikan Laravel dan Leaflet.js untuk mempermudah masyarakat dalam memetakan, menjual, dan mencari lahan atau titik lokasi strategis secara interaktif. Platform ini mendukung visualisasi spasial langsung melalui peta digital, serta memungkinkan pengguna mengelola informasi tanah secara transparan dan efisien.

---

## 🔍 Fitur Utama

- 🗺️ **Peta Interaktif Leaflet** — Menampilkan titik dan polygon (area tanah) langsung di peta.
- 📸 **Upload Gambar Tanah & Titik** — Mempermudah calon pembeli melihat kondisi tanah.
- 📝 **Deskripsi & Informasi Lengkap** — Tambahkan nama, lokasi, dan penjelasan tanah.
- 👥 **Login & Register Pengguna** — Autentikasi Laravel built-in.
- 🧭 **Fokus Lokasi Otomatis** — Arahkan ke titik atau polygon spesifik langsung dari beranda.
- ⚙️ **Kelola Data** — Tambah/Edit/Hapus data tanah dan titik lokasi (untuk pengguna terdaftar).
- 🔐 **Akses Terverifikasi** — Hanya pengguna login yang bisa menambah data.

---

## 🧱 Teknologi yang Digunakan

| Komponen     | Teknologi                       |
|--------------|----------------------------------|
| Backend      | Laravel 11.x                    |
| Frontend     | Blade, Bootstrap 5, Font Awesome|
| Peta         | Leaflet.js                      |
| Database     | DBeaver                 |
| Storage      | Laravel Storage (public/images) |
| Auth         | Laravel Breeze (opsional)       |

---

## 🚀 Instalasi Lokal

```bash
git clone https://github.com/yourusername/tanahku.id.git
cd tanahku.id

# Install dependency PHP dan JS
composer install
npm install && npm run dev

# Salin file env dan generate key
cp .env.example .env
php artisan key:generate

# Atur koneksi DB di .env, lalu:
php artisan migrate

# Jalankan server
php artisan serve
