<?php 
namespace lib;

class View {

	public function view($filename, $data, $account) {

		require_once 'mvc/view/' . $filename . '/index.php';
	}
}