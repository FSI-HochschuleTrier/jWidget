<?php

class Speiseplan {
	const URL = "http://studiwerk.de/eo/cms?_bereich=artikel&_aktion=suche_rubrik&idrubrik=1031&_type=xml&_sprache=xml&_seitenlaenge=1000&datum1=";
	private $date;
	private $mensa;
	private $xmlSource;
	private $theken = array();

	public function __construct($date = "", $mensa = Mensen::MENSA_SCHNEIDERSHOF) {
		spl_autoload_register("Speiseplan::autoload");
		$this->mensa 	= $mensa;
		$this->date		= $date == "" ? date("Ymd") : $date;
		if (!$this->xmlSource = simplexml_load_file(Speiseplan::URL.$this->date))
			throw new Exception("could not load mensa API");
		$this->buildTheken();
	}

	public static function autoload($classname) {
		if (file_exists("classes/$classname.php"))
			require_once("classes/$classname.php");
	}

	public function theken() {
		return $this->theken;
	}

	public function __get($var) {
		if (property_exists($this, $var))
			return $this->$var;
		else
			return "null";
	}

	private function buildTheken() {
		$standorte = $this->xmlSource->artikel->content->calendarday->{'standort-liste'}->standort;
		foreach ($standorte as $standort) {
			if ($standort->attributes()["id"] != $this->mensa)
				continue;
			$chosen = $standort;

			foreach ($chosen->{'theke-liste'}->theke as $theke) {
				if (!is_object($theke))
					continue;
				$obj = new Theke($theke);
				array_push($this->theken, $obj);
			}
		}
	}
} 