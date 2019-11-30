<?php
use lib\sqlAllegro;

class indexModel extends Database {

	private $config;

	function query() {

		$this->config = new Database();

		$sfdb = $this->config->pdo->prepare('SELECT * FROM systim');
		$sfdb->execute();

		$data = $sfdb->fetchAll();
		
		return (object) $data;
	}

	function selectAccount() {

		$sql = new SqlAllegro;
		$account = $sql->selectAccount();

		return (object) $account;
	}
}