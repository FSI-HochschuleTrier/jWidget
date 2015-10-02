<?php

class Price {
	private $studierende;
	private $bedienstete;
	private $besucher;

	public function __construct(SimpleXMLElement $prices) {
		$temp = array();
		foreach ($prices as $price)
			array_push($temp, (float) $price["data"]);
		sort($temp);
		$this->studierende	= $temp[0];
		$this->bedienstete	= $temp[1];
		$this->besucher		= $temp[2];
	}

	public function __get($var) {
		if (property_exists($this, $var))
			return number_format($this->$var, 2, ",", ".")."€";
		else
			return "null";
	}
} 