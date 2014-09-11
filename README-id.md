![Slimmy (mini) Framework](https://dl.dropboxusercontent.com/u/102070675/slimmy-framework-logo%5B250x185%5D.png)

slimmy-framework
================

Slimmy (mini) framework adalah framework rakitan yang dibuat dengan dasar [Slim micro framework](http://www.slimframework.com/ "Slim micro framework")
yang dikombinasikan dengan [illuminate/database Laravel](https://github.com/illuminate/database "Illuminate Database") sebagai model
dan [Twig template engine](http://twig.sensiolabs.org/ "Twig Template Engine") sebagai viewnya.

Slimmy framework dibuat untuk mempermudah membuat Slim project dengan simpel arsitektur (H)MVC. 

> FYI: Slimmy ini anaknya dari Slim(inheritance [Slim\Slim](https://github.com/emsifa/rakit-slimmy/blob/master/src/Rakit/Slimmy/Slimmy.php#L15)), jadi penggunaannya sama persis dengan Slim framework.
Framework ini hanya mengintegrasikan Illuminate/database, Illuminate/Validation, dan Twig kedalam simpel (H)MVC arsitekturnya.

## Fitur
Untuk fitur, karena Slimmy ini sebuah mini framework. 
Jadi hanya mengutamakan beberapa fitur untuk mendukung arsitektur (H)MVCnya, diantaranya:
- **powerful** Eloquent ORM for Models.
- **beautiful** Twig Template Engine for Views.
- **simple** Modular System.
- **great** Laravel Validator.

> Tapi, hei.. slimmy ini based on composer. Jadi kamu bisa install package(library) apapun yang kamu butuhkan dari ribuan package yang tersedia di packagist! dan jangan ragu untuk mengubah atau membuat sendiri file bootstrap(`app/app.php`) kamu.

## Instalasi
Pertama-tama, pastikan kamu sudah menginstal [composer](https://getcomposer.org) di komputer kamu. 
 Setelah itu, ikuti langkah di bawah ini:
- buka terminal atau cmd(untuk pengguna Windows)
- masuk ke direktori dimana kamu mau menempatkan direktori project kamu.
- ketik perintah composer dibawah ini:

    `composer create-project slimmy/framework yourprojectdirname --prefer-dist`

Setelah composer selesai menginstall dependency, buka `localhost/yourprojectdirname/public` di browser kamu.

## Pengetahuan Dasar

### Routing
Routing berasal dari kata Route, seperti artinya dia adalah `rute`. Routing adalah proses untuk menentukan **apa saja sih** `rute` yang terdapat dalam aplikasi yang akan kamu buat, dan menentukan apa metode untuk mengakses masing-masing `rute` tersebut. Untuk itu routing adalah salah 1 hal yang seharusnya kamu kerjakan pada tahap awal pembuatan aplikasi kamu. 

Untuk mendaftarkan sebuah `rute`, format dasarnya adalah seperti ini

`$app->[request_method]([route], [middleware1, middleware2, [action]]);`

**[request_method]** (required) : adalah metode untuk mengakses `rute` tersebut, ada beberapa request method yang perlu kamu ketahui di dalam HTTP, yaitu `get`, `post`, `put`, `patch`, `delete`, `head`. Dari beberapa http method tersebut, yang paling sering terpakai adalah `get`, dan `post`. Sementara yang lainnya biasa dipakai untuk membuat RESTful service.

**[route]** (required) : adalah path dari `rute` tersebut, dalam Slim, path harus diawali dengan '/'. Untuk itu path '/' adalah index aplikasi kamu.

**[middleware]** (optional) : adalah sebuah callable yang akan dipanggil sebelum [action] dijalankan. 
Middleware dapat berupa string nama sebuah function, dapat juga berupa variable [anonymous function](http://php.net/manual/en/functions.anonymous.php), dan juga dapat berupa Closure.
Salah 1 kegunaan Route Middleware adalah untuk memfilter user apakah [action] boleh dijalankan atau tidak. 
Contoh, jika pada rute `/admin`, hanya user yang sudah login yang boleh menjalankan [action] rute tersebut, kamu dapat
memanfaatkan middleware seperti dibawah ini:

```php
function check_login() {
 // cek session. Jika user belum login, 
 // kamu dapat menghentikan aplikasi 
 // atau kamu dapat melemparnya ke Error 403 (Forbidden Access)
}

// saat mengakses [site]/admin, route akan menjalankan fungsi check_login 
// sebelum memanggil aksi AdminController:pageIndex
$app->get('/admin', 'check_login', 'AdminController:pageIndex');
```

**[action]** (required) : action disini bisa berupa Closure(function), berupa string untuk mengakses aksi ke Controller, ataupun berupa string nama function.

#### Contoh mendaftarkan route
```php
// app/routes.php

// 1) mendaftarkan rute index, cukup dengan '/'
$app->get("/", "YourController:pageIndex");

// 2) mendaftarkan rute untuk menampilkan form add-user
$app->get("/user/add", "UserController:pageFormAddUser");

// 3) mendaftarkan rute untuk aksi add user
$app->post("/user/add", "UserController:addUser");
```

> Untuk dokumentasi selengkapnya tentang Routing, kamu bisa lihat di official site slim framework [disini](http://docs.slimframework.com/#Routing-Overview)

### Controller
Controller adalah sebuah Class yang menyimpan aksi-aksi dari aplikasi kamu, 
dan aksi tersebut dapat dipanggil melalui sebuah Route. File controller terletak di `app/controllers`.

Contoh, jika kamu mau membuat beberapa aksi untuk me-manage user
```php
<?php
// app/controllers/UserController.php

class UserController extends BaseController {

    public function pageManageUsers() {
        // some statements to create page manage users
    }
    
    public function addUser()
    {
        // some statements to add new user
    }
    
}
```
> **Note & Tips**: setiap aksi di dalam Controller, harus memiliki akses public (public function) agar dapat dipanggil melalui Route. Jadi kalau mau buat function dimana function tersebut tidak untuk dipanggil melalui Route(hanya untuk dipanggil di Class itu sendiri untuk mematangkan prinsip [DRY](http://en.wikipedia.org/wiki/Don't_repeat_yourself)), buat dalam akses private atau protected.

Setelah itu, kamu dapat menjalankan aksi tersebut melalui Route seperti dibawah ini
```php
// app/routes.php

// memanggil UserController->pageManageUser 
// ketika user membuka [site]/index.php/user/manage
$app->get("/user/manage", "UserController:pageManageUsers");

// memanggil aksi UserController->addUser 
// ketika user mem-post sesuatu to [site]/index.php/user/add
$app->post("/user/add", "UserController:addUser");
```

### Model
Model pada dasarnya adalah sebuah Class yang dirancang khusus untuk berinteraksi dengan table di database kamu.
File model terletak di direktori `app/models`. Sebelumnya, untuk membuat file model kamu berjalan dengan baik, kamu harus
membuat setidaknya sebuah koneksi database di `app/configs/database.php`.

Misalnya, kamu punya table `users` di database, maka User modelnya akan seperti ini: 
```php
<?php 
// app/models/User.php

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'users';

}
```
Setelah itu, kamu dapat dengan mudah melakukan CRUD pada table `users` tersebut. 
Dibawah ini adalah contoh dasar operasi CRUD dalam Eloquent ORM:
```php
// membuat User baru
$user = new User;
$user->username = "johndoe";
$user->email = "johndoe@mail.com";
$user->save();

// mengambil data User berdasarkan id
$user = User::find(1); // 1 = id user yang dicari

// mengupdate data user dengan id = 1
$user = User::find(1);
$user->email = "newmail@mail.com";
$user->save();

// menghapus data user dengan id = 1
$user = User::find(1);
$user->delete();
```


> Karena framework ini menggunakan Eloquent Modelnya Laravel sebagai modelnya, jadi untuk dokumentasi selengkapnya tentang Eloquent, kamu bisa temukan [disini](http://laravel.com/docs/eloquent)

### View
View adalah sebuah file yang dikhususkan untuk hanya berisi kode-kode HTML, css atau js, dimana dia nantinya akan
di render ke browser sebagai sebuah halaman web. File view defaultnya berada di direktori `app/views`. Framework
ini menggunakan Twig sebagai template engine viewnya, jadi ektensi file view kamu harus `.twig`.

Merender sebuah view melalui controller
```php
<?php
// app/controllers/UserController.php

// example rendering 'app/views/manage-users.twig' via controller
class UserController extends BaseController {

    public function pageManageUsers() {
        $data = array(
            // variables you want to creates in view
        );
        $this->app->render("manage-users.twig", $data);
    }

}
```

Merender sebuah view melalui Closure(function) di Route
```php
// app/routes.php

// example rendering 'app/views/manage-users.twig' via Route Closure
$app->get("/users/manage", function() use ($app) {
    $data = array(
        // variables you want to creates in view
    );
    $app->render("manage-users.twig", $data);

});
```
> Untuk dokumentasi penggunaan twig, kamu dapat langsung lihat di official site twig [disini](http://twig.sensiolabs.org/doc/templates.html)

## Bermain Dengan Module
Module adalah sebuah direktori yang memiliki file `controllers`, `models`, dan `views`nya sendiri. 
Module digunakan jika kamu ingin berkolaborasi dengan tim pengembangan kamu, misalnya si A fokus mengerjakan bagian `User`, si B fokus mengerjakan bagian `Post`, dsb. Dan dia juga berguna untuk mempermudah dalam memindahkan bagian
aplikasi dari aplikasi slimmy yang 1 ke aplikasi slimmy yang lain.

> pada dasarnya, module terletak di `app/modules`.

### Struktur Direktori Module
Struktur direktori dari sebuah module, pada dasarnya adalah seperti ini
```
YourModule
    ├── controllers
    │    └─ YourModuleController.php
    │
    ├── models
    │    └─ YourModuleModel.php
    │
    └── views
         └─ your-module-view.twig
```

### Memanggil Aksi di Controller yang terdapat pada Module
Slimmy menggunakan [autoload PSR-0 composer](https://getcomposer.org/doc/04-schema.md#psr-0) sebagai autoloader modulenya, untuk itu Controller didalam module harus memiliki namespacenya sendiri(defaultnya `App\Modules\[nama_module]\Controllers`). Jadi untuk mengakses aksi
pada Controller tersebut, kamu harus menambahkan @[nama_module] sebagai shortcut namespacingnya.

Contoh

```php
// app/routes.php

$app->get("/your-route", "@YourModuleName/YourModuleController:methodName");
```

### Merender View yang terdapat pada Module
Merender sebuah view di dalam module agak sedikit berbeda, karena view di dalam sebuah module juga memiliki [namespacenya](http://twig.sensiolabs.org/doc/api.html#built-in-loaders) sendiri. Format pemanggilan view di dalam module akan seperti ini `@[ModuleName]/[viewpath/viewname.twig]`. 

Contoh, jika kamu ingin merender `form-edit-user.twig` yang berada di dalam module `User`.
```php

// render app/modules/User/views/form-edit-user.twig
$this->app->render("@User/form-edit-user.twig", $data);
```

## Migrasi
Migrasi adalah sebuah fitur yang memungkinkan kamu mengontrol versi dari skema database aplikasi kamu. 

#### File Migrasi
File migrasi pada dasarnya terletak di `App/Migrations`. Karena Slimmy memanfaatkan migrator dan skema builder pada `Illuminate/Database`, jadi ada beberapa peraturan penamaan file dan class pada file migrasi. 

Untuk penamaan file, formatnya adalah sebagai berikut:
```
yyyy_mm_dd_hhiiss_nama_class.php
```
`yyyy` adalah tahun, `mm` adalah nomor bulan, `dd` adalah tanggal, `hhiiss` adalah jam, menit, dan detik, sedangkan `nama_class` adalah nama class migrasi kamu. Penamaan dengan format tersebut digunakan untuk memudahkan kamu mengenali kapan file migrasi itu dibuat.

Contoh untuk penamaan file migrasi untuk membuat table user
```
2014_08_12_114527_create_table_user.php
```

Perlu diperhatikan, pada bagian `create_table_user` itu mempengaruhi nama Class yang harus kalian gunakan di dalam file migrasi tersebut. Jika pada nama file menggunakan `create_table_user`, maka nama Class yang harus digunakan pada file migrasi tersebut adalah `CreateTableUser` (hilangkan underscore, dan gunakan studly case).

Pada file migrasi, ada 2 method yang **harus** digunakan, yaitu `up()` dan `down()`. Method `up()` digunakan apabila file migrasi dijalankan, sedangkan method `down()` digunakan apabila migrasi di *rollback*.


Contoh file migrasi `2014_08_12_114527_create_table_user.php`
```php
<?php
// isi dari Migrations/2014_08_12_114527_create_table_user.php

use Rakit\Slimmy\Migration;

class CreateTableUser extends Migration {

    public function up()
    {
        $this->schema->create('users', function($table) {
             $table->increments('id');
             $table->string('username', 20)->unique();
             $table->string('password');
             $table->string('name');
             $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('users');
    }

}
```

Pada script diatas, method `up()` akan membuat sebuah table bernama `users`. Sedangkan `down()` sebaliknya, dia akan menghapus table `users` tersebut. `$this->schema` pada contoh migrasi diatas adalah skema builder dari `Illuminate/Database` Laravel. Jadi untuk mempelajari skema builder, kamu dapat langsung melihat dokumentasinya [disini](http://laravel.com/docs/schema).

#### Menjalankan Migrasi

> Agar dapat menjalankan migrasi, sebelumnya pastikan pada `App/Configs/app.php` konfigurasi untuk `migration.enabled` bernilai `TRUE` dan juga pastikan kamu membuat sebuat koneksi database di `App/Configs/database.php`

Untuk menjalankan migrasi secara manual, kamu dapat memanfaatkan sebuah Route dan gunakan perintah `$app->migrator->run()`, dimana `$app` adalah aplikasi Slimmy kamu.

Contoh menjalankan migrasi menggunakan Route
```php
$app->get('/migration/migrate', function() use ($app) {
    $app->migrator->run();
});
```

Untuk menjalankan migrasi tersebut, di browser, buka url
```
localhost/[yourapp]/public/index.php/migration/migrate
```
Setelah itu coba perhatikan di database, seharusnya akan muncul table bernama `migrations` yang mencatat riwayat migrasi kamu. Apabila file migrasi kamu terdaftar disana, itu tandanya migrasi kamu berhasil.

> Jika kamu mau menggunakan nama table selain `migrations`, kamu dapat menggantinya melalui konfigurasi `migration.table` 

#### Rollback
Rollback digunakan untuk mengembalikan skema database kamu 1 step ke versi sebelumnya. Apabila kamu perhatikan, di table `migrations` yang terbentuk setelah migrasi dijalankan, ada sebuah kolom bernama `batch` bertipe *integer*. Kolom tersebut adalah penanda versi migrasi kamu. Jadi saat me-rollback, *migrator* akan mencari nilai terakhir dari `batch`. Dan selanjutnya migrator akan menjalankan method `down()` pada file-file di `batch` terakhir tersebut.

Untuk menggunakan rollback, kamu dapat gunakan `$app->migrator->rollback()`

Contoh menggunakan rollback melalui Route
```php
$app->get('/migration/rollback', function() use ($app) {
    $app->migrator->rollback();
});
```
Setelah itu, untuk me-rollback, gunakan url
```
localhost/[yourapp]/public/index.php/migration/rollback
```

#### Cara lebih praktis? kayak Laravel gituloh, tinggal mainin terminal
Kalo yang 1 itu sedang saya buat. Jadi ditunggu aja yah :D


## More from official documentation
- Routing: [http://docs.slimframework.com/#Routing-Overview](http://docs.slimframework.com/#Routing-Overview)
- Rendering a view: [http://docs.slimframework.com/#Rendering](http://docs.slimframework.com/#Rendering)
- Twig for view: [http://twig.sensiolabs.org/](http://twig.sensiolabs.org/)
- Eloquent Model: [http://laravel.com/docs/eloquent](http://laravel.com/docs/eloquent)
- Validation: [http://laravel.com/docs/validation](http://laravel.com/docs/validation)
- Schema Builder: [http://laravel.com/docs/schema](http://laravel.com/docs/schema)
