<?php

class FSImensaPlan {
    private $date; // FORMAT: YYYYMMDD
    private static $url = "http://studiwerk.de/cgi-bin/cms?_SID=NEW&_bereich=system&_aktion=export_speiseplan&datum=";
    private $mensaPlanArray = Array();
    private $xmlSource;

  public function __construct($date = "") {
     $date = $date == "" ? date("Ymd") : $date;
     $this->date = $date;
     $this->buildMensaPlan();
  }

  private function buildMensaPlan() {
     @$this->xmlSource = simplexml_load_file(FSImensaPlan::$url . $this->date);

         if ($this->xmlSource != false) {
      foreach ($this->xmlSource->{'mensa-7'}->children() as $menuTitle => $menu) {
               if (preg_match("/menue*/", $menuTitle)) {
                       switch($menuTitle) {
                         case "menue-1":
                           $category = "stammessen";
                           break;
                         case "menue-2":
                           $category = "komponentenessen";
                           break;
                         case "menue-3":
                           $category = "eintopf";
                       }
                       $rows = Array();
                       foreach($menu->children() as $menuZeile) {

                       if ($menuZeile->text != "")
                               array_push($rows, (string) ($menuZeile->text) );
                       }
                       $this->mensaPlanArray[$category] = $rows;
               }
      }
         }
  }

  public function getMensaPlanArray() { if (!empty($this->mensaPlanArray)) { return $this->mensaPlanArray; } else { return false; } }
}

?>