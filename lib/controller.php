<?php 
use lib\View;
use lib\Model;

class Controller {

	protected $render;
	protected $run;

	public function __construct() {

		$this->render = new View();
		$this->run = new Model();
	}
}