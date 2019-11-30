<?php
use lib\Sql;

class orderAllegroModel extends Database {

	public function getOrder() {

		$token = new Sql();
		$token = $token->select('Allen');
    	$token = $token[0]['TOKEN'];

    	$offersUrl = "https://api.allegro.pl.allegrosandbox.pl/order/checkout-forms?status=READY_FOR_PROCESSING";

    	$ch = curl_init($offersUrl);

    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, [
    		"Authorization: Bearer {$token}", 
    		"Accept: application/vnd.allegro.public.v1+json"
    	]);

    	$ordersResult = curl_exec($ch);
    	$resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    	curl_close($ch);

    	if($ordersResult === false || $resultCode !== 200) {

    		echo $ordersResult . '<br/>';
    		echo $resultCode . '<br/>';
            echo "Something went wrong";
    	}

    	$ordersList = json_decode($ordersResult, true);
    	
    	return $ordersList;
	}
}