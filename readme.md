# Aplikasi Rekam Medis
Spesifikasi Projek
- Laravel 5.7
- VueJS 2
- PHP 7.1 keatas
- Node JS
- NPM

Cara Instalasi
1. Clone terlebih dahulu
2. Sebelumnya pastikan pada komputer / server anda sudah terinstall [composer](https://getcomposer.org/ "composer")
3. Pada CMD ketikan **composer install**
4. Tunggu hingga proses selesai
5. Jika proses composer telah selesai selanjutnya jalankan **npm install**
6. Jika proses instalasi Node Modules sudah selesai, selanjtnya copy file **.env.example** menjadi **.env**
7. Lalu sesuaikan nama table dan credential mysql pada local/server
8. Jika sudah, pada CMD jalankan **php artisan key:generate**
9. Selanjutnya jalankan pada cmd **php artisan migrate**
10. Lalu jalankan salah satu dari command berikut 
	- **npm run watch** : Jika dalam development
	- **npm run prod** : Untuk production

Letak File
- Untuk tampilan ada di **resources/views/pages**
- Untuk tag custom seperti **<tambah-pasien>** cari filenya pada **resources/js/app.js** Jika mengubah file .vue harus menjalankan **npm run watch** atau **npm run prod**
- Untuk controllernya ada di **app/Http/Controllers**
- Untuk routingnya ada di **routes/web.php**

Credits : @adityabm