<?php
include_once 'lib/route.php';
include_once 'lib/controller.php';
include_once 'lib/view.php';
include_once 'lib/model.php';
include_once 'lib/database.php';
include_once 'lib/sql.php';
include_once 'lib/sqlAllegro.php';
include_once 'lib/sqlSystim.php';

class Index {

	public function __construct($url) {

		new Route($url);
	}
}

$url = isset($_GET['url']) ? $_GET['url'] : 'index';
new Index($url);