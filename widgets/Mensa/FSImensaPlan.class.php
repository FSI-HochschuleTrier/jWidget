<?php

include("Mensen.php");
include ("Meal.php");
include("Theke.php");
include("Price.php");

class FSImensaPlan {
    private $date; // FORMAT: YYYYMMDD
    private static $url = "http://studiwerk.de/eo/cms?_bereich=artikel&_aktion=suche_rubrik&idrubrik=1031&_type=xml&_sprache=xml&_seitenlaenge=1000&datum1=";
    private $mensaPlanArray = Array();
    private $xmlSource;

  public function __construct($date = "") {
     $date = $date == "" ? date("Ymd") : $date;
     $this->date = $date;
     $this->buildMensaPlan();
  }

  private function buildMensaPlan() {
	  @$this->xmlSource = simplexml_load_file(FSImensaPlan::$url . $this->date);
	  $standorte = $this->xmlSource->artikel->content->calendarday->{'standort-liste'}->standort;
	  $schneidershof = null;
	  foreach ($standorte as $standort) {
		  if ($standort->attributes()["id"] != Mensen::MENSA_SCHNEIDERSHOF)
			  continue;
		  $schneidershof = $standort;

		  foreach ($schneidershof->{'theke-liste'}->theke as $theke) {
			  $obj = new Theke($theke);
			  array_push($this->mensaPlanArray, $obj);
		  }
	  }
  }

  public function getMensaPlanArray() { if (!empty($this->mensaPlanArray)) { return $this->mensaPlanArray; } else { return false; } }
}

?>