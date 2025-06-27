SEA Catering

Sistem langganan makanan sehat menggunakan Laravel. Platform ini mendukung admin dan user dengan fitur seperti langganan customize pilihan hari/mingguan, invoice otomatis (pdf), dashboard statistik, dll.
(fitur lengkap tertera dibawah)

--------------------------------------------

🚀 Cara Menjalankan Project

1. Clone Repository

- git clone https://github.com/restuhrs/SEA_Catering.git
- cd SEA_Catering

2. Install Dependency

- composer install
- npm install 

⚠️ Jalankan npm run build jika folder public/build belum tersedia atau tidak ikut di-commit:
- npm run build

3. Konfigurasi Environment

Copy file .env.example ke .env dan sesuaikan pengaturannya seperti (port, password, database, dll), 
karena saya menggunakan MAMP maka portnya "8889" dan password "root":

- cp .env.example .env

Lalu generate app key:

- php artisan key:generate

4. Setup Database

Pastikan database sudah dibuat, lalu jalankan:

- php artisan migrate:fresh --seed

Untuk testing data subscription di admin dashboard rekomendasi range filter 01/06/2025 - 30/06/2025

5. Jalankan Server Lokal

- php artisan serve

Akses: http://localhost:8000

--------------------------------------

📁 Fitur Utama

✅ Langganan makanan sehat tersedia customize pilihan hari/mingguan
📊 Dashboard Admin: perhitungan pendapatan, langganan aktif, reaktivasi, langganan baru 
📆 Chart dinamis & filter berdasarkan tanggal
🔍 Pencarian dan paginasi real-time
🧾 Cetak invoice otomatis (pdf)
🔐 Autentikasi
🔄 Sistem reaktivasi pengguna otomatis
📖 Cek history berlangganan
📅 Sistem berlangganan aktif dan nonaktif otomatis sesuai tanggal pemesanan


🔐 Akun Demo

- Role Admin 

Email: admin@example.com
Password: @Password123 (perhatikan besar kecil huruf)

- Role Customer 

Email: customer@example.com
Password: @Password123 (perhatikan besar kecil huruf)


📄 License
MIT License © Restu Kharisma 
