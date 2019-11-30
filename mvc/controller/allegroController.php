<?php

class allegroController extends Controller {
	
	private $controller;
	private $data;

	function __construct() {
		
		$this->controller = new Controller();
		$data = $this->controller->run->model('allegro');
		$this->controller->render->view('allegro', $data, '');
	}
}