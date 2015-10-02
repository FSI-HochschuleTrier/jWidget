<?php

class Theke {
	private $id;
	private $name;
	private $meals = array();

	public function __construct(SimpleXMLElement $theke) {
		$this->id	= (string) $theke->attributes()["id"];
		$this->name	= (string) $theke->label;
		foreach ($theke->{'mahlzeit-liste'}->mahlzeit as $mahlzeit) {
			$obj = new Meal($mahlzeit);
			array_push($this->meals, $obj);
		}
	}

	public function __get($var) {
		if (property_exists($this, $var))
			return $this->$var;
		else
			return "null";
	}
} 