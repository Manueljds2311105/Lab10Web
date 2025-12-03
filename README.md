# Lab10 PHP OOP 

Nama: Manuel Johansen Dolok Saribu

Nim: 312410493

## 📁 Struktur Project
```
lab10_php_oop/
│
├── index.php
├── config.php
│
├── lib/
│   ├── Database.php
│   └── Form.php
│
├── models/
│   └── Barang.php
│
├── controllers/
│   └── BarangController.php
│
├── views/
│   ├── header.php
│   ├── footer.php
│   ├── dashboard.php
│   └── barang/
│       ├── list.php
│       ├── form_add.php
│       ├── form_edit.php
│
└── assets/
    └── css/style.css
```
## config.php
File ini berisi credential database:
```
$config = [
  'host' => 'localhost',
  'username' => 'root',
  'password' => '',
  'db_name' => 'lab10'
];
```
## lib/Database.php
Class ini meng-handle koneksi database & operasi CRUD.

Fitur utama:
- connect otomatis saat instansiasi class
- query()
- get()
- insert()
- update()
- delete()

Database class membantu agar query database lebih aman & terstruktur.

## lib/Form.php
Class untuk create form HTML secara dinamis.

Method utama:
- addField(name, label)
- displayForm()

Dengan class ini, form bisa dibuat lewat PHP tanpa hardcoding HTML berulang.

## models/Barang.php
Representasi object **Barang** di sistem.

Biasanya berisi:
- property barang (id, nama, stok, harga, dll)
- processing logic jika ada

Model digunakan oleh controller untuk interaksi dengan database.

## controllers/BarangController.php
File ini menjadi pusat logic bisnis.

Tugas controller:
- menerima request user
- berkomunikasi dengan model
- memanggil view yang tepat

Contohnya:
- menampilkan data barang
- menambah barang baru
- mengedit barang
- menghapus barang

## views/
Isi folder ini hanya untuk tampilan UI.

### views/header.php
Template navigasi & tag HTML awal.

### views/footer.php
Template penutup HTML.

### views/dashboard.php
Menampilkan halaman awal.

### views/barang/list.php
Menampilkan list barang dari database.

### views/barang/form_add.php  
Form tambah barang.

### views/barang/form_edit.php  
Form edit barang.

## index.php
File utama saat project dijalankan.

Berfungsi sebagai router sederhana yang memanggil controller.

## assets/css/style.css
File styling untuk tampilan UI agar tidak polos dan lebih rapi.

## Alur Sistem
1. User mengakses `index.php`
2. Controller menentukan halaman mana yang perlu ditampilkan
3. Controller memanggil model jika memerlukan data
4. Model menggunakan class Database untuk mengakses database
5. Controller mengirim data ke view
6. View menampilkan output ke user

## Kesimpulan
Project ini berhasil menerapkan:

✔ Konsep OOP  

✔ Code modular & reusable  

✔ Class library  
