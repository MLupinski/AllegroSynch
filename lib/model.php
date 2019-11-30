<?php
namespace lib;

class Model {

	function model($filename) {

		require_once 'mvc/model/' . $filename . 'Model.php';

		$object = $filename . 'Model';

		return new $object();
	}
}