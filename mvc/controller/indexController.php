<?php

class indexController extends Controller {
	
	private $controller;
	private $data;

	function __construct() {
		
		$this->controller = new Controller();
		$data = $this->controller->run->model('index')->query();
		$account = $this->controller->run->model('index')->selectAccount();
		$this->controller->render->view('index', $data, $account);
	}
}