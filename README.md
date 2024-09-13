<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Sistem Rest API Pengiriman Uang Antar Bank

## Deskripsi Proyek

Proyek ini adalah pengembangan **Sistem Rest API** sederhana yang digunakan untuk melakukan pengiriman uang gratis antar bank, dengan otentikasi berbasis **JWT (JSON Web Token)**. Sistem ini memungkinkan pengguna untuk melakukan transfer antar bank dengan menggunakan **rekening perantara** yang terdaftar dalam sistem.

Proses transfer dimulai dari bank pengirim hingga bank tujuan melalui bank perantara yang terdaftar atas nama **PT BosCOD Indonesia**. Setiap transaksi yang dilakukan akan mencakup validasi data, enkripsi password, serta penentuan biaya administrasi dengan kode unik.

## Endpoint API Utama

1. Login: 
   - Endpoint: `/api/auth/login`
   - Metode: `POST`
   - Input: `username`, `password`
   - Output: `accessToken`, `refreshToken`

2. Update Token:
   - Endpoint: `/api/auth/update-token`
   - Metode: `POST`
   - Input: `token`
   - Output: `accessToken`, `refreshToken`

3. Create Transfer:
   - Endpoint: `/api/transfer`
   - Metode: `POST`
   - Input: `nilai_transfer`, `bank_tujuan`, `rekening_tujuan`, `atasnama_tujuan`, `bank_pengirim`
   - Output: `id_transaksi`, `nilai_transfer`, `kode_unik`, `biaya_admin`, `total_transfer`, `bank_perantara`, `rekening_perantara`

## Teknologi yang Digunakan

1. Backend Framework: Laravel 11 (PHP)
2. Database: MySQL
3. Autentikasi: JWT (JSON Web Token)
4. Enkripsi: Password dienkripsi menggunakan Hash.
5. Validasi: Validasi input menggunakan Laravel Validator.
6. API Response Format: JSON

## Tabel Database

1. `users` - Menyimpan data pengguna.
2. `banks` - Menyimpan data bank yang terdaftar.
3. `rekening_admins` - Menyimpan data rekening perantara.
4. `transaksi_transfers` - Menyimpan data transaksi transfer uang antar bank.

## Installation

1. Konfigurasi Database: Edit file .env untuk menyesuaikan pengaturan database.

    ```properties
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_bank_api
    DB_USERNAME=root
    DB_PASSWORD=
    ```

2. Migrasi dan Seeder Database: Jalankan migrasi dan seeder untuk membuat tabel-tabel yang diperlukan di database.

    ```bash
    php artisan migrate --seed
    ```

3. Jalankan Server Pengembangan: Gunakan perintah berikut untuk menjalankan server pengembangan Laravel.

    ```bash
    php artisan serve
    ```

## Cara Kerja Proses Transfer

1. Pengguna melakukan **login** untuk mendapatkan token JWT.

    ![Login](https://raw.githubusercontent.com/dikiarmanda/bank-api/main/login.png)

    Pengguna juga dapat melakukan update token.

    ![Update Token](https://raw.githubusercontent.com/dikiarmanda/bank-api/main/update-token.png)

2. Pengguna mengirimkan request untuk **membuat transfer** dengan menyertakan informasi bank tujuan, rekening tujuan, dan nominal transfer.

    ![Transfer](https://raw.githubusercontent.com/dikiarmanda/bank-api/main/transfer.png)

3. Sistem akan memproses permintaan transfer dengan melalui rekening admin perantara, menghitung kode unik, serta total transfer.

4. Sistem mengembalikan respons yang berisi **ID transaksi**, **total transfer**, **kode unik**, dan **rekening perantara** yang harus digunakan.
