![Slimmy (mini) Framework](https://dl.dropboxusercontent.com/u/102070675/slimmy-framework-logo%5B250x185%5D.png)

slimmy-framework
================

Slimmy (mini) framework adalah framework rakitan yang dibuat dengan dasar [Slim micro framework](http://www.slimframework.com/ "Slim micro framework")
yang dikombinasikan dengan [illuminate/database Laravel](https://github.com/illuminate/database "Illuminate Database") sebagai model
dan [Twig template engine](http://twig.sensiolabs.org/ "Twig Template Engine") for view.

Slimmy framework dibuat untuk mempermudah membuat Slim project dengan simpel arsitektur (H)MVC.

## Fitur
- **powerful** Eloquent ORM for Models.
- **beautiful** Twig Template Engine for Views.
- **simple** Modular System.
- **great** Laravel Validator.

## Instalasi
Pertama-tama, pastikan anda sudah menginstal [composer](https://getcomposer.org) di komputer anda. 
 Setelah itu, ikutin langkah di bawah ini:
- buka terminal atau cmd(untuk pengguna Windows)
- masuk ke direktori dimana kamu mau menempatkan project kamu.
- ketik perintah composer dibawah ini:

    `composer create-project slimmy/framework yourprojectdirname --prefer-dist`

Setelah composer selesai menginstall dependency, buka `localhost/yourprojectdirname/public` di browser anda.

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

Setelah itu, anda dapat menjalankan aksi tersebut melalui Route seperti dibawah ini
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
View basically is a file that contain HTML, css or js code that rendered to browser as a web page. View files by default is located on `app/views` directory. This framework use twig as View, so you should use `.twig` as extension.

Rendering a view in controller
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

Rendering a view by Closure in Route
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
> For documentation about twig syntax, you can find it in twig official site [here](http://twig.sensiolabs.org/doc/templates.html)

## Working with module
Module basically is a directory that contain their own `controllers`, `models`, and `views` files. 
Module used if you want to distribute tasks with your development team, crew A focused on module User, crew B focused on module Post, etc. And it can also simplify to migrate a part of your slimmy application to another slimmy application. 

> by default modules are located on `app/modules`.

### Module Directory Structure
Basically, module structure might look like this
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

### Call Module Controller action/method from Route
```php
// public/index.php

$app->get("/your-route", "@YourModuleName/YourModuleController:methodName");
```

### Rendering Module View
Rendering module view is little bit different, because view in the module have it's own [namespace](http://twig.sensiolabs.org/doc/api.html#built-in-loaders). So, you should call these views in format `@[ModuleName]/[viewpath/viewname.twig]`. 

For example, if you want render `form-edit-user.twig` in `User` module.
```php
$this->app->render("@User/form-edit-user.twig", $data);
```

## More from official documentation
- Routing: [http://docs.slimframework.com/#Routing-Overview](http://docs.slimframework.com/#Routing-Overview)
- Rendering a view: [http://docs.slimframework.com/#Rendering](http://docs.slimframework.com/#Rendering)
- Twig for view: [http://twig.sensiolabs.org/](http://twig.sensiolabs.org/)
- Eloquent Model: [http://laravel.com/docs/eloquent](http://laravel.com/docs/eloquent)
- Validation: [http://laravel.com/docs/validation](http://laravel.com/docs/validation)
