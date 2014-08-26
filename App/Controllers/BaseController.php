<?php

use Rakit\Slimmy\Slimmy;

abstract class BaseController {

	protected $app = null;

	public function __construct()
	{
		$this->app = Slimmy::getInstance();
	}

	protected function renderJSON(array $data, $status = 200)
	{
		$json = json_encode($data);
		$this->app->response->headers->set("Content-Type", "application/json");
		$this->app->halt($status, $json);
	}

	protected function getModuleName()
	{
		$called_class = get_called_class();
		$module_namespace = $this->app->config('app.module.namespace');

		$module_name = str_replace($module_namespace, "", $called_class);

		return array_shift(explode('\\', ltrim($module_name,'\\')));
	}

}