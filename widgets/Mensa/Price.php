<?php

class Price {
	private $studierende;
	private $bedienstete;
	private $besucher;

	public function __construct(SimpleXMLElement $prices) {
		$temp = array();
		foreach ($prices as $price)
			array_push($temp, $price["data"]);
		sort($temp);
		$this->studierende	= (float) $temp[0];
		$this->bedienstete	= (float) $temp[1];
		$this->besucher		= (float) $temp[2];
	}

	public function __get($var) {
		if (property_exists($this, $var))
			return number_format($this->$var, 2, ",", ".")."€";
		else
			return "null";
	}
} 