<?php 
class Route {

	public function __construct($url) {

		$url = rtrim($url, '/');
		$url = explode('/', $url);
		$url[0] = strtolower($url[0]);

		$controller = $url[0] . 'Controller';
		
		require_once 'mvc/controller/' . $controller . '.php';

		new $controller();
	}
}