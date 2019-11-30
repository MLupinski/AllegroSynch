<?php

class orderAllegroController extends Controller {
	
	private $controller;
	private $data;

	function __construct() {
		
		$this->controller = new Controller();
		$data = $this->controller->run->model('orderAllegro')->getOrder();
		$account = $this->controller->run->model('index')->selectAccount();
		$this->controller->render->view('orderAllegro', $data, $account);
	}
}