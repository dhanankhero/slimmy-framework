<?php

// including vendor autoload file
require(__DIR__."/../vendor/autoload.php");

use Rakit\Slimmy\Slimmy;
use SlimFacades\Facade;

// load configurations
$configs = require(__DIR__."/configs/app.php");

// defining constants
define('APP_PATH', $configs['path.app']);
define('PUBLIC_PATH', $configs['path.public']);
define('BASE_URL', rtrim('http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']), '/'));

// initialize Slimmy App
$app = new Slimmy($configs);

$hooks = $app->config('hooks');
if(!empty($hooks)) {
	$hooks_dir = APP_PATH.'/hooks';
	foreach($hooks as $hookfile) {
		include($hooks_dir.'/'.$hookfile);
	}
}

// registering facades and aliasing classes
$facades = $app->config('aliases');
if(!empty($facades)) {
	Facade::setFacadeApplication($app);
	Facade::registerAliases($facades);
}

// registering required modules
$registered_modules = $app->config('modules');
if(!empty($registered_modules)) {
	foreach($registered_modules as $module_name) {
		$app->registerModule($module_name);
	}
}

// adding twig global variables
$app->view()->getTwig()->addGlobal('BASE_URL', BASE_URL);
$app->view()->getTwig()->addGlobal('APP_PATH', APP_PATH);
$app->view()->getTwig()->addGlobal('PUBLIC_PATH', PUBLIC_PATH);

return $app;