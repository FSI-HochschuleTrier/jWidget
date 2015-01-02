<?php

class Bus {
	public	$route;
	public	$destination;
	private $arrival;
	private $live;

	public function __construct($route, $destination, $arrival, $live) {
		$this->route		= (int)		$route;
		$this->destination	= (string)	$destination;
		$this->arrival		= (int)		$arrival;
		$this->live			= (int)		$live;
	}

	public function getArrival($format = "H:i") {
		return date($format, $this->arrival);
	}

	public function getLive($format = "H:i") {
		return date($format, $this->live);
	}

	static function busSort($a, $b) {
		return $a->live == $b->live ? 0 : ($a->live > $b->live) ? 1 : -1;
	}
}