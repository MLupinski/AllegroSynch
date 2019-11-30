<?php
use lib\sqlSystim;

class systimModel extends Database {

	private $config;

	function __construct() {

		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://allen.systim.pl/jsonAPI.php');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 
            'act=login'
            . '&login=***'
            . '&pass=***'
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $res = json_decode($result, true);

        curl_close($curl);

        self::getMagazineInfo($res['result']['token']);
	}

	function getMagazineInfo($token) {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://allen.systim.pl/jsonAPI.php');
        curl_setopt($curl, CURLOPT_POST, true); //sposób przesyłania - (true metoda POST)
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'act=listPQuantities'.
                   '&token= '.$token.
                   '&id_magazynu = 3'); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $wynik = curl_exec($curl);
        curl_close($curl);
        $dane = json_decode($wynik,true);
        
        foreach ($dane['result'] as $systim) {
            
            if($systim['kod_kreskowy'] != null && $systim['ilosc'] != null) {

                $sqlSystim = new SqlSystim;
                $name = $systim['nazwa_produktu'];
                $ean = $systim['kod_kreskowy'];
                $quant = $systim['ilosc'];

                $sqlSystim->insert($name, $ean, $quant);
            }
        }
	}
}