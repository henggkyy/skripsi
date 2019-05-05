# SI Kegiatan Operasional Laboratorium Komputasi TIF UNPAR

Proyek ini dibuat untuk memenuhi skripsi di Teknik Informatika Universitas Katolik Parahyangan. Sistem Informasi (SI) Kegiatan Operasional Laboratorium Komputasi TIF UNPAR bertujuan untuk mewadahi kegiatan operasional laboratorium, seperti pengelolaan jadwal pemakaian laboratorium, pengelolaan jadwal bertugas admin, peminjaman ruangan atau alat laboratorium, sistem penggajian admin, dan pengelolaan mata kuliah yang mengadakan kegiatan akademik di laboratorium.

### Installing

1. Silahkan clone proyek ini ke dalam direktori Anda.
2. Ubah konfigurasi dalam file /config/config.php dan /config/database.php dan sesuaikan dengan environment server yang akan dipakai.
3. Isi google client ID dan google api key yang terdapat pada file /config/google_config.php
4. Isi alamat email yang akan digunakan untuk mengirimkan notifikasi pada method sendEmail yang ada di dalam file /controller/C_peminjaman.php
5. Buka folder checker dengan IDE untuk Java, seperti Netbeans. Ubah base_url yang terdapat pada file BuildConfig.java dengan alamat base URL dari server yang akan digunakan. Setelah itu, clean and build project tersebut. Ambil program checker.jar yang terdapat pada folder /checker/dist dan simpan pada folder assets/checker web server.

## Built With

* Bahasa pemrograman : PHP 7.3.4 (website) & Java (checker)
* Database : mySQL
* User Interface : Inspinia, Tiva Timetable
* Framework : CodeIgnter
* Library : Unirest API
