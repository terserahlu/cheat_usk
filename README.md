<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## How to Clone

Langkah-Langkah clone project bila lupa, tehee :

- git clone hhttps://github.com/terserahlu/cheat_usk.git
- cd cheat_usk
- rm -rf .git
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate

## Hint Answer Usk

Jawaban soal usk, stttss.. jangan kasih tau siapa siapa tehe:

- 1. C. <body background="gambar.jpg">
- 2. D. website yang memberi fasilitas pada pengunjung untuk menawar harga
- 3. C. Javascript
- 4. A. require("koneksi.php");
- 5. D. $
- 6. A. / ... /
- 7. A. require("koneksi.php");
- 8. C. menutupi inputan (masked)
- 9. B. password
- 10. E. javac ujian.java
 
Soal Essai:
#ARRAY
1. Pengertian

Array adalah struktur data yang menyimpan banyak data dalam satu variabel, dan setiap data punya indeks.

2. Ciri-ciri Array

Ukuran tetap (misal ditentukan saat deklarasi).

Data disimpan berurutan dalam memori.

Akses cepat menggunakan indeks → array[2].

3. Kelebihan Array

Akses elemen sangat cepat.

Cocok untuk data yang tidak sering berubah.

Memori lebih efisien karena tanpa pointer.

4. Kekurangan Array

Tidak bisa menambah elemen jika ukuran sudah penuh.

Insert atau delete di tengah array lambat karena harus menggeser elemen lain.

#LINKED LIST
1. Pengertian

Linked List adalah struktur data dinamis yang terdiri dari node.
Setiap node berisi:

data

pointer ke node berikutnya (next)

2. Ciri-ciri Linked List

Ukuran boleh bertambah/berkurang secara dinamis.

Elemen tidak berurutan dalam memori, tapi saling terhubung pointer.

Untuk mengakses elemen ke-5, harus traverse dari awal.

3. Kelebihan Linked List

Mudah menambah/menghapus elemen kapan saja.

Ukuran fleksibel (dinamis).

Tidak membuang memori untuk ruang kosong (seperti array fixed size).

4. Kekurangan Linked List

Akses elemen lebih lambat (harus satu per satu).

Membutuhkan memori lebih besar karena ada pointer.

Tidak bisa diakses dengan indeks langsung.

| Perbandingan  | Array                   | Linked List                       |
| ------------- | ----------------------- | --------------------------------- |
| Penyimpanan   | Rapi dan berurutan      | Berantakan tapi terhubung pointer |
| Ukuran        | Tetap                   | Fleksibel                         |
| Akses data    | Cepat (langsung indeks) | Lambat (harus satu-satu)          |
| Insert/delete | Lambat di tengah        | Cepat                             |
| Memori        | Lebih hemat             | Lebih boros                       |
| Cocok untuk   | Data stabil             | Data sering berubah               |

##Use Case Diagram adalah diagram UML yang menggambarkan:

Fungsi utamanya:

Menunjukkan hubungan antara pengguna (actor) dengan sistem.

Menjelaskan apa saja yang bisa dilakukan dalam sistem (fitur/layanan).

Mempermudah komunikasi antara analis, programmer, dan user.

Menentukan ruang lingkup sistem (apa yang termasuk dan apa yang tidak).

Memberikan gambaran umum alur interaksi sistem secara sederhana.

Contoh sederhana Use Case Diagram:

Sistem: Aplikasi Kasir

Actor:

Kasir

Use Case:

Login

Input barang

Cetak struk

Logout


## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
