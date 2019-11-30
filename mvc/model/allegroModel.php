<?php
use lib\Sql;
use lib\SqlAllegro;
use lib\SqlSystim;
include 'lib/jsonGen.php';

class allegroModel {

	private $code;
	private $token;
	private $offersList;
	private $sql;
    
    public function __construct() {

        $code = $_GET['code'];
        
        $authUrl = "https://allegro.pl.allegrosandbox.pl/auth/oauth/"
                        . "token?grant_type=authorization_code&code=".$code.""
                . "&redirect_uri=http://mojaapka.pl/Allegro";
        $clientSecret = "***";
        $clientId = "***";

    	$ch = curl_init($authUrl);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    	curl_setopt($ch, CURLOPT_USERNAME, $clientId);
    	curl_setopt($ch, CURLOPT_PASSWORD, $clientSecret);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    	$tokenResult = curl_exec($ch);
    	$resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    	curl_close($ch);

    	if($tokenResult === false || $resultCode !== 200) {

            echo "Something went wrong";
    	}

    	$tokenObject = json_decode($tokenResult);
        $token = $tokenObject->access_token;
        $expire = time() + ($tokenObject->expires_in);
        $expire = date('d-m-Y H:i', $expire);
        $refresh = $tokenObject->refresh_token;
        
        $sql = new Sql();
        $sql->insert('Allen', $token, $expire, $refresh);

    	self::getAllOffers($tokenObject);
    }
    
    public function getAllOffers($token) {

    	$this->token = $token;

    	$token = $token->access_token;

    	$offersUrl = "https://api.allegro.pl.allegrosandbox.pl/sale/offers?publication.status=ACTIVE";

    	$ch = curl_init($offersUrl);

    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, [
    		"Authorization: Bearer {$token}", 
    		"Accept: application/vnd.allegro.public.v1+json"
    	]);

    	$offersResult = curl_exec($ch);
    	$resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    	curl_close($ch);

    	if($offersResult === false || $resultCode !== 200) {

    		echo $offersResult . '<br/>';
    		echo $resultCode . '<br/>';
            echo "Something went wrong";
    	}

    	$offersList = json_decode($offersResult);

    	self::getOffer($token, $offersList);
    }

    public function getOffer($token, $offersList) {

    	$this->token = $token;
    	$this->offersList = $offersList;

    	$id = "";

    	foreach ($offersList->offers as $offer) {
    		$id = $offer->id;

    		$offerUrl = "https://api.allegro.pl.allegrosandbox.pl/sale/offers/{$id}";

	    	$ch = curl_init($offerUrl);

	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    	curl_setopt($ch, CURLOPT_HTTPHEADER, [
	    		"Authorization: Bearer {$token}", 
	    		"Accept: application/vnd.allegro.public.v1+json"
	    	]);

	    	$offerResult = curl_exec($ch);
	    	$resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    	curl_close($ch);

	    	if($offerResult === false || $resultCode !== 200) {

	    		echo $offerResult . '<br/>';
	    		echo $resultCode . '<br/>';
	            echo "Something went wrong";
	    	}

	    	$offer = json_decode($offerResult);

            if($offer->ean != null) {
                $sqlAllegro = new SqlAllegro();
                $sqlAllegro->insert($offer->id, $offer->name, $offer->stock->available, $offer->ean, $offer->sellingMode->price->amount);   
            }
    	}
    	self::synchroAllegro($token);	
    }

    public function synchroAllegro($token) {

    	$sqlAllegro = new SqlAllegro();
        $sqlSystim = new SqlSystim();
    	$json = '';
    	$i = 1;

    	$dataAllegro = $sqlAllegro->select();
    	$dataSystim = $sqlSystim->select();
        $counter = $sqlAllegro->selectSynchCounter('Allen');
        $counterCount = count($counter);

    	foreach ($dataAllegro as $data) {

    		for($j = 0; $j < count($dataSystim); $j++) {

    			if($data['EAN'] == $dataSystim[$j]['EAN']) {

    				$headers = [
    					'Accept: application/vnd.allegro.public.v1+json',
            			'Content-Type: application/vnd.allegro.public.v1+json',
            			'Authorization: Bearer '.$token.''
    				];
    				$genJson = new JsonGen();
					$jsonData = json_encode($genJson->generateCode($data['OFFER_ID'], $dataSystim[$j]['QUANT'])); 

			    	$random = rand(1, 999999999);
			    	$commandId = '9b84e1bc-5341-45e7-837e-'. $random;

			    	$offerUrl = "https://api.allegro.pl.allegrosandbox.pl/sale/offer-quantity-change-commands/" . $commandId;

				    $ch = curl_init($offerUrl);

				    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);// nie weryfikuj certyfikatów
        			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// nie weryfikuj certyfikatów
        			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

				    $offerResult = curl_exec($ch);
				    $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				    curl_close($ch);

				    if($offerResult === false || $resultCode !== 201) {

				    	echo $offerResult . '<br/>';
				    	echo $resultCode . '<br/>';
				        echo "Something went wrong";
				    }
                    $i++;
    			}
    		}	
    	}
            $dateSynch = date('d-m-Y H:i:s');
            $sqlAllegro->insertCounter('Allen', $i, $dateSynch);
    }
}