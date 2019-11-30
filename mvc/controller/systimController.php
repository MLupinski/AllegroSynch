<?php
ob_start();
class systimController extends Controller {
	
	private $controller;

	function __construct() {
		
		$this->controller = new Controller();
		$data = $this->controller->run->model('systim');
		header('Location: index');
	}
}
ob_end_flush();