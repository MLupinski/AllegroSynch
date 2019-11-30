<?php
namespace lib;
require_once 'database.php';

class SqlSystim {
	
	private $offerId;
	private $name;
	private $quant;
	private $ean;
	private $price;

	public function select() {

		$pdo = new \Database();

		$sfds = $pdo->pdo->prepare("SELECT * FROM systim");
		$sfds->execute();

		$resultSystim = $sfds->fetchAll();

		return $resultSystim;
	}

	public function selectEan($ean) {

		$this->ean = $ean;
		$pdo = new \Database();

		$sfda = $pdo->pdo->prepare("SELECT * FROM systim WHERE EAN = :ean");
		$sfda->bindParam(':ean', $ean);
		$sfda->execute();

		$resultSystim = $sfda->fetchAll();

		return $resultSystim;
	}
	
	public function insert($name, $ean, $quant) {

		$this->name = $name;
		$this->quant = $quant;
		$this->ean = $ean;

		$systim = self::selectEan($ean);
		$systimCount = count($systim);
		$pdo = new \Database();

		if($systimCount == 0) {

			$itdb = $pdo->pdo->prepare("INSERT INTO systim (NAME, EAN, QUANT) VALUES (:name, :ean, :quant)");
			$itdb->bindParam(':name', $name);
			$itdb->bindParam(':ean', $ean);
			$itdb->bindParam(':quant', $quant);
			$itdb->execute();
		} elseif ($systimCount == 1) {

			self::update($name, $ean, $quant);
		}	
	}

	public function update($name, $ean, $quant) {

		$this->name = $name;
		$this->ean = $ean;
		$this->quant = $quant;
		$pdo = new \Database();

		$udbs = $pdo->pdo->prepare("UPDATE systim SET NAME = :name, EAN = :ean, QUANT = :quant WHERE EAN = :whereEan");
		$udbs->bindParam(':name', $name);
		$udbs->bindParam(':ean', $ean);
		$udbs->bindParam(':quant', $quant);
		$udbs->bindParam(':whereEan', $ean);
		$udbs->execute();
	}
}