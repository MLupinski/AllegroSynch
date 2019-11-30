<?php
class Database {

	public $pdo;

	function __construct() {

		$host = 'localhost';
		$dbname ='synch';
		$username = 'root';
		$password = '';
		$charset = 'utf8';
		$pdo = '';

		try {

			$this->pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset, $username, $password);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e) {

			echo '<p>Jeden z naszych szpiegów donosi, że wystąpił problem.';
		}
	}
}