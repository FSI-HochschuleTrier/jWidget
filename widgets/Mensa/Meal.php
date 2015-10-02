<?php

class Meal {
	private $title;
	private $price;
	private $sidedishes = array();

	public function __construct(SimpleXMLElement $meal) {
		$this->title	= (string) $meal->beschreibung;
		$this->price	= new Price($meal->price);

		$this->addDish($meal->vorspeise);
		$this->addDish($meal->beilage1);
		$this->addDish($meal->beilage2);
		$this->addDish($meal->nachspeise);
	}

	public function __get($var) {
		if (property_exists($this, $var))
			return $this->$var;
		else
			return "null";
	}

	private function addDish(SimpleXMLElement $dish) {
		$content = $dish->{'mahlzeitkomponenten-list'}->{'mahlzeitkomponenten-item'}->data->title;
		if (!empty($content) && $content != "")
			array_push($this->sidedishes, (string) $content);
	}
} 