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
$menuSectionsNames = Array("stammessen" => "Stammessen", "komponentenessen" => "Komponentenessen", "eintopf" => "Eintopf / Sonstiges");

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
  foreach($mensaPlanTag as $category => $inhalt) {
     echo "     <li>\n         <span class='MensaHeadline'>".$menuSectionsNames[$category]."</span>\n";
     foreach ($inhalt as $row) {
        echo insertIcons($row)."<br />";
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