<?php
require_once("classes/Mensen.php");
require_once("classes/Theken.php");

$when	= date("H") < 15 && date("m") <= 30 ? date("Ymd") : date("Ymd", strtotime("+1 day"));
$target	= date("H") < 15 && date("m") <= 30 ? "(heute)" : "(morgen)";

$theken	= json_decode(file_get_contents(urldecode("https://fsi.hochschule-trier.de/apis/mensa/?mensa=".Mensen::MENSA_SCHNEIDERSHOF."&date=$when")));
$names	= array(
	"theke-1"	=> "Stammessen",
	"theke-2"	=> "Komponentenessen",
	"theke-3"	=> "Kleine Karte"
);

function getName($key) {
	global $names;

	if (array_key_exists($key, $names))
		return $names[$key];
	else
		return "Sonstiges";
}

function price($value) {
	return number_format($value, 2, ",", ".")."&euro;";
}

echo "
 <h2 class='widgetTitle'>Mensa <span>$target</span></h2>
 <ul class='MensaTableView' id='MensaPanel'>
";

if (empty($theken)) {
	echo "<li style='color: white;'><img src='widgets/Mensa/MensaClosed.png' style='vertical-align: middle; margin-right: 15px;' />Mensa geschlossen</li>";
	exit;
}

foreach ($theken as $theke) {
	if (count($theke->meals) <= 0)
		continue;
	if ($theke->id != Theken::STAMMESSEN && $theke->id != Theken::KOMPONENTENESSEN && $theke->id != Theken::KLEINE_KARTE)
		continue;
	echo "     <li class='MensaMeal'>\n<span class='MensaHeadline'>".getName($theke->id)."</span>\n";
	foreach ($theke->meals as $meal) {
		if (preg_match("/Salatschale/", $meal->title) || $meal->price->studierende <= 1.0)
			continue;
		echo "<b class='MensaMealTitle'>$meal->title</b>";
		if (count($meal->sidedishes) > 0)
			echo "<i>".implode(" • ", $meal->sidedishes)."</i><br>";
		echo "<section><sup>Studierende:</sup>".price($meal->price->studierende)."</section>";
		echo "<section><sup>Bedienstete:</sup>".price($meal->price->bedienstete)."</section>";
		echo "<section><sup>Gäste:</sup>".price($meal->price->besucher)."</section>";
	}
	echo "</li>";
}