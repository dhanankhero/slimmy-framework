<?php

return array(

	// app path
	'path.app' => dirname(__DIR__),

	// public path for html, css, image and js files
	'path.public' => dirname(dirname(__DIR__))."/public",

	// path for view files (from app.path)
	'view.directory' => 'Views',

	// module paths
	'module.path' => dirname(__DIR__)."/Modules",

	// base namespace for module
	'module.namespace' => 'App\Modules',

	// auto register module 
	// if it set true, your app will automatically registering a module 
	// when you create a route that calling a method from module controller
	'module.auto_register' => true,

	// list required modules to load
	// in many case, you don't need to register
	// your modules here if you enable auto register module
	'modules' => array(
		// in example, if you want to register module Foo, Bar and Baz, 
		// just add their name in array like code below
		// 'Foo', 'Bar', 'Baz'
	),

	// facades and aliases
	'aliases' => array(
		'App'      => 'SlimFacades\App',
	    'Config'   => 'SlimFacades\Config',
	    'Input'    => 'SlimFacades\Input',
	    'Request'  => 'SlimFacades\Request',
	    'Response' => 'SlimFacades\Response',
	    'Route'    => 'SlimFacades\Route',
	    'View'     => 'SlimFacades\View',
	),

	'hooks' => require(__DIR__.'/hooks.php'),

	'database.default_connection' => 'default',
	'database.connections' => require(__DIR__.'/database.php'),

	'migration.table' => 'migrations',
	'migration.directory' => 'Migrations',
	'migration.enabled' => true,

);