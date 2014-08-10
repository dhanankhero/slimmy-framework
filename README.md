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

    `composer create-project rakit/slimmy-framework yourprojectdirname --prefer-dist`

After finish installation, open `localhost/yourprojectdirname/public` in your browser.

## Documentation?
At this time, i have not write documentations. But, actually this framework is just a Slim framework that combining with some great features from another popular framework as i said in the description. So, for these documentation you can find at:
- Routing: [http://docs.slimframework.com/#Routing-Overview](http://docs.slimframework.com/#Routing-Overview)
- Rendering a view: [http://docs.slimframework.com/#Rendering](http://docs.slimframework.com/#Rendering)
- Twig for view: [http://twig.sensiolabs.org/](http://twig.sensiolabs.org/)
- Eloquent Model: [http://laravel.com/docs/eloquent](http://laravel.com/docs/eloquent)
- Validation: [http://laravel.com/docs/validation](http://laravel.com/docs/validation)
- For working with MVC or HMVC, you can learn from Hello Module.
