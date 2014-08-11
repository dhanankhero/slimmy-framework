![Slimmy (mini) Framework](https://dl.dropboxusercontent.com/u/102070675/slimmy-framework-logo%5B250x185%5D.png)

slimmy-framework
================

Slimmy (mini) framework adalah framework rakitan yang dibuat dengan dasar [Slim micro framework](http://www.slimframework.com/ "Slim micro framework")
yang dikombinasikan dengan [illuminate/database Laravel](https://github.com/illuminate/database "Illuminate Database") sebagai model
dan [Twig template engine](http://twig.sensiolabs.org/ "Twig Template Engine") for view.

Slimmy framework dibuat untuk mempermudah membuat Slim project dengan simpel arsitektur (H)MVC. 

> FYI: Slimmy ini anaknya dari Slim(inheritance Slim\Slim), jadi penggunaannya sama persis dengan Slim framework.
Framework ini hanya mengintegrasikan Illuminate/datase, Illuminate/Validation dan Twig kedalam simpel (H)MVC arsitekturnya.

## Fitur
- **powerful** Eloquent ORM for Models.
- **beautiful** Twig Template Engine for Views.
- **simple** Modular System.
- **great** Laravel Validator.

## Instalasi
Pertama-tama, pastikan kamu sudah menginstal [composer](https://getcomposer.org) di komputer kamu. 
 Setelah itu, ikuti langkah di bawah ini:
- buka terminal atau cmd(untuk pengguna Windows)
- masuk ke direktori dimana kamu mau menempatkan project kamu.
- ketik perintah composer dibawah ini:

    `composer create-project slimmy/framework yourprojectdirname --prefer-dist`

Setelah composer selesai menginstall dependency, buka `localhost/yourprojectdirname/public` di browser kamu.

## Petunjuk Dasar

### Controller
Controller adalah sebuah Class yang menyimpan aksi-aksi dari aplikasi anda, 
dimana aksi tersebut dapat dipanggil melalui sebuah Route. File controller terletak di `app/controllers`.

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

Setelah itu, kamu dapat menjalankan aksi tersebut melalui Route seperti dibawah ini
```php
// public/index.php

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
membuat setidaknya sebuah koneksi database di `app/config/database.php`.

Misalnya, kamu punya table `users` di database, maka User modelnya akan seperti ini: 
```php
<?php 
// app/models/User.php

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'users';

}
``` 
> framework ini menggunakan Eloquent Modelnya Laravel sebagai Model, jadi untuk dokumentasi selengkapnya tentang Eloquent, kamu bisa temukan [disini](http://laravel.com/docs/eloquent)

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
// public/index.php

// example rendering 'app/views/manage-users.twig' via Route Closure
$app->get("/users/manage", function() use ($app) {
    $data = array(
        // variables you want to creates in view
    );
    $app->render("manage-users.twig", $data);

});
```
> Untuk dokumentasi penggunaan twig, kamu dapat langsung lihat di official site twig [disini](http://twig.sensiolabs.org/doc/templates.html)

## Working with module
Module adalah sebuah direktori yang memiliki file `controllers`, `models`, dan `views`nya sendiri. 
Module digunakan jika kamu ingin berkolaborasi dengan tim pengembangan kamu, misalnya si A fokus mengerjakan bagian `User`, si B fokus mengerjakan bagian `Post`, dsb. Dan dia juga berguna untuk mempermudah dalam memindahkan bagian
aplikasi dari aplikasi slimmy yang 1 ke aplikasi slimmy yang lain.

> pada dasarnya, module terletak di `app/modules`.

### Struktur Direktori Module
Struktur direktori dari sebuah module, pada dasarnya adalah seperti ini
```
yourmodule
    |- controllers
    |   |- YourModuleController.php
    |
    |- models
    |   |- YourModuleModel.php
    |
    |- views
    |   |- your-module-view.twig
    |
    |- migrators
    |   |- YourModuleMigrator.php
```

### Memanggil Aksi di Controller yang terdapat pada Module
```php
// public/index.php

$app->get("/your-route", "@YourModuleName/YourModuleController:methodName");
```

### Merender View yang terdapat pada Module
Merender sebuah view di dalam module agak sedikit berbeda, karena view di dalam sebuah module juga memiliki [namespace](http://twig.sensiolabs.org/doc/api.html#built-in-loaders)nya sendiri. Format pemanggilan view di dalam module akan seperti ini `@[ModuleName]/[viewpath/viewname.twig]`. 

Contoh, jika kamu ingin merender `form-edit-user.twig` yang berada di dalam module `User`.
```php
$this->app->render("@User/form-edit-user.twig", $data);
```

## More from official documentation
- Routing: [http://docs.slimframework.com/#Routing-Overview](http://docs.slimframework.com/#Routing-Overview)
- Rendering a view: [http://docs.slimframework.com/#Rendering](http://docs.slimframework.com/#Rendering)
- Twig for view: [http://twig.sensiolabs.org/](http://twig.sensiolabs.org/)
- Eloquent Model: [http://laravel.com/docs/eloquent](http://laravel.com/docs/eloquent)
- Validation: [http://laravel.com/docs/validation](http://laravel.com/docs/validation)
