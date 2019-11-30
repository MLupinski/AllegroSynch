<?php
namespace lib;
require_once 'database.php';

class Sql {

	private $login;
	private $token; 
	private $expire; 
	private $refresh;

	public function select($login) {

		$this->login = $login;
		$pdo = new \Database();

		$sfda = $pdo->pdo->prepare("SELECT * FROM tokenallegro WHERE LOGIN = :login");
		$sfda->bindParam(':login', $login);
		$sfda->execute();
		$result = $sfda->fetchAll();

		return $result;
	}

	public function insert($login, $token, $expire, $refresh) {

		$this->login = $login;
		$this->token = $token;
		$this->expire = $expire;
		$this->refresh = $refresh;
		$pdo = new \Database();

		$result = self::select($login);
		$resultCount = count($result);

		if($resultCount > 0) {

			self::update($login, $token, $expire, $refresh);
		} else {

			$itdb = $pdo->pdo->prepare("INSERT INTO tokenallegro (LOGIN, TOKEN, EXPIRE_TIME, REFRESH) VALUES (:login, :token, :expire, :refresh)");
			$itdb->bindParam(':login', $login);
			$itdb->bindParam(':token', $token);
			$itdb->bindParam(':expire', $expire);
			$itdb->bindParam(':refresh', $refresh);
			$itdb->execute();
		}
	}

	public function update($login, $token, $expire, $refresh) {

		$this->login = $login;
		$this->token = $token;
		$this->expire = $expire;
		$this->refresh = $refresh;
		$pdo = new \Database();

		$udba = $pdo->pdo->prepare("UPDATE tokenallegro SET LOGIN = :login, TOKEN = :token, EXPIRE_TIME = :expire, REFRESH = :refresh WHERE LOGIN = :whereLogin");
		$udba->bindParam(':login', $login);
		$udba->bindParam(':token', $token);
		$udba->bindParam(':expire', $expire);
		$udba->bindParam(':refresh', $refresh);
		$udba->bindParam(':whereLogin', $login);
		$udba->execute();
	}
}