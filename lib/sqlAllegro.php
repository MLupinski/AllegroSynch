<?php
namespace lib;
require_once 'database.php';

class SqlAllegro {
	
	private $login;
	private $offerId;
	private $name;
	private $quant;
	private $ean;
	private $price;
	private $synchQuant;
	private $dateSynch;

	public function select() {

		$pdo = new \Database();

		$sfda = $pdo->pdo->prepare("SELECT * FROM allegro");
		$sfda->execute();

		$resultAllegro = $sfda->fetchAll();

		return $resultAllegro;
	}

	public function selectSynchCounter($login) {

		$this->login = $login;
		$pdo = new \Database();

		$sfda = $pdo->pdo->prepare("SELECT * FROM synchrocounter WHERE LOGIN = :login");
		$sfda->bindParam(':login', $login);
		$sfda->execute();

		$result = $sfda->fetchAll();

		return $result;
	}

	public function selectEan($ean) {

		$this->ean = $ean;
		$pdo = new \Database();

		$sfda = $pdo->pdo->prepare("SELECT * FROM allegro WHERE EAN = :ean");
		$sfda->bindParam(':ean', $ean);
		$sfda->execute();

		$resultAllegro = $sfda->fetchAll();

		return $resultAllegro;
	}

	public function insert($offerId, $name, $quant, $ean, $price) {

		$this->offerId = $offerId;
		$this->name = $name;
		$this->quant = $quant;
		$this->ean = $ean;
		$this->price = $price;

		$allegro = self::selectEan($ean);
		$allegroCount = count($allegro);
		$pdo = new \Database();

		if($allegroCount == 0) {

			$itdb = $pdo->pdo->prepare("INSERT INTO allegro (OFFER_ID, NAME, QUANT, EAN, PRICE) VALUES (:offerId, :name, :quant, :ean, :price)");
			$itdb->bindParam(':offerId', $offerId);
			$itdb->bindParam(':name', $name);
			$itdb->bindParam(':quant', $quant);
			$itdb->bindParam(':ean', $ean);
			$itdb->bindParam(':price', $price);
			$itdb->execute();
		} elseif ($allegroCount == 1) {

			self::update($offerId, $name, $quant, $ean, $price);
		}	
	}

	public function insertCounter($login, $synchQuant, $dateSynch) {

		$counter = self::selectSynchCounter($login);
		$counterCount = count($counter);

		$this->login = $login;
		$this->synchQuant = $synchQuant;
		$this->dateSynch = $dateSynch;
		$pdo = new \Database();

		if($counterCount == 0) {

			$itdb = $pdo->pdo->prepare("INSERT INTO synchrocounter (LOGIN, SynchQuant, DATE) VALUES (:login, :synchQuant, :dateSynch)");
			$itdb->bindParam(':login', $login);
			$itdb->bindParam(':synchQuant', $synchQuant);
			$itdb->bindParam(':dateSynch', $dateSynch);
			$itdb->execute();
		} elseif ($counterCount == 1) {

			$synchQuant += $counter[0]['SynchQuant'];
			self::updateCounter($login, $synchQuant, $dateSynch);
		}	
	}

	public function update($offerId, $name, $quant, $ean, $price) {

		$this->offerId = $offerId;
		$this->name = $name;
		$this->quant = $quant;
		$this->ean = $ean;
		$this->price = $price;
		$pdo = new \Database();

		$udba = $pdo->pdo->prepare("UPDATE allegro SET OFFER_ID = :offerId, NAME = :name, QUANT = :quant, EAN = :ean, PRICE = :price WHERE EAN = :whereEan");
		$udba->bindParam(':offerId', $offerId);
		$udba->bindParam(':name', $name);
		$udba->bindParam(':quant', $quant);
		$udba->bindParam(':ean', $ean);
		$udba->bindParam(':price', $price);
		$udba->bindParam(':whereEan', $ean);
		$udba->execute();
	}

	public function updateCounter($login, $synchQuant, $dateSynch) {

		$this->login = $login;
		$this->synchQuant = $synchQuant;
		$this->dateSynch = $dateSynch;
		$pdo = new \Database();

		$udba = $pdo->pdo->prepare("UPDATE synchrocounter SET SynchQuant = :synchQuant, DATE = :dateSynch WHERE LOGIN = :login");
		$udba->bindParam(':synchQuant', $synchQuant);
		$udba->bindParam(':dateSynch', $dateSynch);
		$udba->bindParam(':login', $login);
		$udba->execute();
	}

	public function selectAccount() {

		$pdo = new \Database();

		$sfda = $pdo->pdo->prepare("SELECT * FROM allegroAccount");
		$sfda->execute();

		$resultAcc = $sfda->fetchAll();

		return $resultAcc;
	}

	public function getOrder() {

		
	}
}