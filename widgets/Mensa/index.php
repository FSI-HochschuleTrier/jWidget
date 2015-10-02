<!--
* Mensa Widget
*
* @author Michael Ochmann (INF | INF - SMS)
-->

<?php
require_once("FSImensaPlan.class.php");

$mensaPlan = new FSImensaPlan();
$mensaPlanTomorrow = new FSImensaPlan(date("Ym").date("d") + 1);

$mensaPlanTag = $mensaPlanTomorrow->getMensaPlanArray() != false && date("H") >= 15 ? $mensaPlanTomorrow->getMensaPlanArray() : $mensaPlan->getMensaPlanArray();
$menuSectionsNames = Array("theke-1" => "Stammessen", "theke-2" => "Komponentenessen", "eintopf" => "Eintopf / Sonstiges");

if (@$_GET['json'] == true) {
         $json = strip_tags(json_encode($mensaPlan->getMensaPlanArray()));
         $out = preg_replace("/\[[A-Z]\]/", " ", $json);
         echo $out;
         exit;
   }

$target = $mensaPlanTomorrow->getMensaPlanArray() != false && date("H") >= 15 ? "<span>(morgen)</span>" : "<span>(heute)</span>";
//print_r($mensaPlanTag);
if ($mensaPlanTag === false) { $target = ""; }
echo "
 <h2 class='widgetTitle'>Mensa $target</h2>
 <ul class='MensaTableView' id='MensaPanel'>
";

if ($mensaPlanTag === false) {
   echo "<li style='color: white;'><img src='widgets/Mensa/MensaClosed.png' style='vertical-align: middle; margin-right: 15px;' />Mensa geschlossen</li>";
}
else {
  foreach($mensaPlanTag as $theke) {
	  $head = array_key_exists($theke->id, $menuSectionsNames) ? $menuSectionsNames[$theke->id] : "Eintopf";
     echo "     <li>\n         <span class='MensaHeadline'>".$head."</span>\n";

     foreach ($theke->meals as $menu) {
        echo "<b>$menu->title</b><br />";
		 if (count($menu->sidedishes) > 0)
		 	echo "<i style='font-size: normal;'>".implode(" • ", $menu->sidedishes)."</i><br>";
		 echo "<section style='display: inline-block; color: white; line-height: 1.0em; margin-right: 15px;'><sup style='display: block;'>Studierende:</sup>".$menu->price->studierende."</section>";
		 echo "<section style='display: inline-block; color: white; line-height: 1.0em; margin-right: 15px;'><sup style='display: block;'>Bedienstete:</sup>".$menu->price->bedienstete."</section>";
		 echo "<section style='display: inline-block; color: white; line-height: 1.0em; margin-right: 15px;'><sup style='display: block;'>Gäste:</sup>".$menu->price->besucher."</section>";
	 	echo "<br><br>";
	 }
  }
}

echo "
</ul>
";


function insertIcons($row) {
    $replaceArray = Array('/\[S\]/', '/\[R\]/', '/\[F\]/', '/\[G\]/', '/\[V\]/', '/\[B\]/', '/\[W\]/', '/\[H\]/', "/\[M\]/", "/\[A\]/");
    $patternArray = Array('meat', 'beef', 'fish', 'chicken', 'vegetable', 'vegan', 'deer', 'chicken', 'lactose', 'alcohol');
  for ($i = 0; $i < count($patternArray); $i++) {
         $patternArray[$i] = "<img src='widgets/Mensa/icons/".$patternArray[$i]."@24.png' alt='".$patternArray[$i]."' />";
  }
    $out = preg_replace($replaceArray, $patternArray, $row);

  return $out;
}
?>