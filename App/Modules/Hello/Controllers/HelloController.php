<?php namespace App\Modules\Hello\Controllers;

class HelloController extends \BaseController {

	public function pageHello()
	{
		$data['title'] = "You've just begun";
		$this->app->render("@Hello/helloview.twig", $data);
	}

}