![Slimmy (mini) Framework](https://dl.dropboxusercontent.com/u/102070675/slimmy-framework-logo%5B250x185%5D.png)

slimmy-framework
================

Mini (H)MVC framework based on [Slim micro framework](http://www.slimframework.com/ "Slim micro framework") combined with [illuminate/database Laravel](https://github.com/illuminate/database "Illuminate Database") for model and [Twig template engine](http://twig.sensiolabs.org/ "Twig Template Engine") for view.

It is just instant way to create Slim project with simple (H)MVC architecture.

## Features
- **powerful** Eloquent ORM for Models.
- **beautiful** Twig Template Engine for Views.
- **simple** Modular System.
- **great** Laravel Validator.

## Installation
First, make sure you have [composer](https://getcomposer.org) installed on your machine, and follow steps below:
- open terminal or cmd(in Windows)
- go to your based project directory(eg: htdocs in XAMPP, or www in WAMP) 
- run composer command below:

    `composer create-project slimmy/framework yourprojectdirname --prefer-dist`

After finish installation, open `localhost/yourprojectdirname/public` in your browser.

## Basic Guides

### Controller
Controller is a Class that grouping some actions/methods in your application, and these actions/methods can be called via Route. Controller files located in `app/controllers`.

For example, you want to create some actions to manage user
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

And you can call these actions in your route file by:
```php
// public/index.php

// call action UserController->pageManageUser 
// when user landing on [site]/index.php/user/manage
$app->get("/user/manage", "UserController:pageManageUsers");

// call action UserController->addUser 
// when user post something to [site]/index.php/user/manage
$app->post("/user/add", "UserController:addUser");
```

### Model
Models are PHP classes that are designed to simplify interact with your table in your database. Model files located in `app/models` directory. To make your model work, you must create at least one database connections on your `app/configs/database.php` file. 

For example, you have `users` table on your database, so the User model file might look like this: 
```php
<?php 
// app/models/User.php

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'users';

}
``` 
> this framework using Eloquent laravel for Model, so you can read full documentation about using Eloquent [here](http://laravel.com/docs/eloquent)

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
> For documentation about twig syntax, you can find it in official site twig [here](http://twig.sensiolabs.org/doc/templates.html)

## Working with module
Module basically is a directory that contain their own `controllers`, `models`, and `view` directories. 
Module used if you want to distribute tasks with your development team, crew A focused on module User, crew B focused on module Post, etc. And it can also simplify to migrate you part of your application to another application. 

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
```
// public/index.php

$app->get("/your-route", "@YourModuleName/YourModuleController:methodName");
```

## More from official documentation
- Routing: [http://docs.slimframework.com/#Routing-Overview](http://docs.slimframework.com/#Routing-Overview)
- Rendering a view: [http://docs.slimframework.com/#Rendering](http://docs.slimframework.com/#Rendering)
- Twig for view: [http://twig.sensiolabs.org/](http://twig.sensiolabs.org/)
- Eloquent Model: [http://laravel.com/docs/eloquent](http://laravel.com/docs/eloquent)
- Validation: [http://laravel.com/docs/validation](http://laravel.com/docs/validation)
