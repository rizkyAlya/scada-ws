# Menjalankan WebSocket Server (PHP Ratchet)

Dokumentasi ini menjelaskan langkah-langkah untuk menjalankan WebSocket server.

---

## 1. Persyaratan

Pastikan sistem sudah memiliki:

* PHP ≥ 7.4 & MySQL
* Composer
* Akses terminal / command prompt

Jika Composer belum terinstall, unduh dari:
https://getcomposer.org/

---

## 2. Clone Repository

Clone repository ke komputer lokal.

```
git clone <repository-url>
cd <nama-folder-project>
```

---

## 3. Install Dependency

Install dependensi menggunakan Composer.

```
composer install
```

Perintah ini akan mengunduh semua library yang dibutuhkan dan membuat folder:

```
vendor/
```

---

## 4. Struktur Project

Setelah instalasi selesai, struktur project akan terlihat seperti berikut:

```
project
│
├── vendor/
├── composer.json
├── composer.lock
├── db_connect.php
├── polling_process.php
└── ws_server.php
```

---

## 5. Menjalankan Server

Jalankan server WebSocket melalui terminal:

```
php ws_server.php
```

Jika berhasil, server akan berjalan dan menunggu koneksi client.

Jalankan proses polling melalui terminal:
```
php polling_process.php
```

Jika berhasil, client dapat mengirimkan data ke Websocket.

---

## 6. Menghentikan Server

Untuk menghentikan server, tekan:

```
CTRL + C
```

pada terminal.

---

## 7. Catatan

* Pastikan port server tidak digunakan oleh aplikasi lain.
* Pastikan konfigurasi database sudah sesuai pada file `db_connect.php`.
* Pastikan server MySQL telah berjalan.
