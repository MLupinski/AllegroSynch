<?php
class JsonGen {

	private $ean;
	private $id;
	private $price;
	private $quant;

	public function generateCode($id, $quant) {

		$this->id = $id;
		$this->quant = $quant;

		$data = 
		[
        	'modification' => 
        	[
            	'changeType' => 'FIXED',
                	'value' => (int)$quant,
            	],
            	'offerCriteria' => 
            	[
            		[
                		'offers' => 
                		[
                    		['id' => $id],
                		],
                		'type' => 'CONTAINS_OFFERS'
            		],
            	]
          	];
		
		return $data;
	}
}