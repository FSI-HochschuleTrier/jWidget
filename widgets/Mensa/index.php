<?php
require_once("classes/Mensen.php");
require_once("classes/Speiseplan.php");

$speiseplan = new Speiseplan();
$test = $speiseplan->theken();

echo "
 <h2 class='widgetTitle'>Mensa $target</h2>
 <ul class='MensaTableView' id='MensaPanel'>
";

foreach ($speiseplan->theken() as $theke) {
	if (count($theke->meals) <= 0)
		continue;
	echo "     <li class='MensaMeal'>\n<span class='MensaHeadline'>".$theke->name."</span>\n";
	foreach ($theke->meals as $meal) {
		echo "<b class='MensaMealTitle'>$meal->title</b>";
		if (count($meal->sidedishes) > 0)
			echo "<i>".implode(" • ", $meal->sidedishes)."</i><br>";
		echo "<section><sup>Studierende:</sup>".$meal->price->studierende."</section>";
		echo "<section><sup>Bedienstete:</sup>".$meal->price->bedienstete."</section>";
		echo "<section><sup>Gäste:</sup>".$meal->price->besucher."</section>";
	}
	echo "</li>";
}