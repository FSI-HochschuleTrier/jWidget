<!--
* Mensa Widget
*
* @author Michael Ochmann (INF | INF - SMS)
-->

<h2 class='widgetTitle'>Mensa</h2>
<?php

include_once("parseMensa.php");

$weekMenuContent = unserialize(parseMensa());
$dayOfWeekNames = Array("Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag");
$menuSectionsNames = Array("Stammessen", "Komponentenessen", "Eintopf / Sonstiges");

$dow = date("N") - 1;
echo "
 <ul class='MensaTableView' id='MensaPanel'>
";
for ($dayOfWeek = $dow; $dayOfWeek <= $dow; $dayOfWeek++) {
if ($dow < 5) {
//echo "     <li class='MensaGroupHeader'>".$dayOfWeekNames[$dayOfWeek]."</li>\n";
         for($menuSections = 0; $menuSections <= 2; $menuSections++) {
             echo "     <li>\n         <span class='MensaHeadline'>".$menuSectionsNames[$menuSections]."</span>\n";
if ($weekMenuContent[$dayOfWeek][$menuSections]) {
         foreach($weekMenuContent[$dayOfWeek][$menuSections] as $menu) {
         @$menu = eregi_replace("  ", " ", $menu);
         @$menu = eregi_replace("http://www.studiwerk.de/kiosk/grafik/icon_schwein.gif", "widgets/Mensa/icons/meat@24.png", $menu);
         @$menu = eregi_replace("http://www.studiwerk.de/kiosk/grafik/icon_pilz.gif", "widgets/Mensa/icons/vegetable@24.png", $menu);
         @$menu = eregi_replace("http://www.studiwerk.de/kiosk/grafik/icon_blume.gif", "widgets/Mensa/icons/vegan@24.png", $menu);
         @$menu = eregi_replace("http://www.studiwerk.de/kiosk/grafik/icon_rind.gif", "widgets/Mensa/icons/beef@24.png", $menu);
         @$menu = eregi_replace("http://www.studiwerk.de/kiosk/grafik/icon_huhn.gif", "widgets/Mensa/icons/chicken@24.png", $menu);
         @$menu = eregi_replace("http://www.studiwerk.de/kiosk/grafik/icon_wild.gif", "widgets/Mensa/icons/deer@24.png", $menu);
         @$menu = eregi_replace("http://www.studiwerk.de/kiosk/grafik/icon_fisch.gif", "widgets/Mensa/icons/fish@24.png", $menu);
         @$menu = nl2br($menu);
         echo "         <p>
            $menu
        </p>\n";
         }
}
 else {
       echo "         <p>-</p>\n";
      }
echo "    </li>\n";
         }
 }
 else {
   echo "<li style='color: white;'><img src='widgets/Mensa/MensaClosed.png' style='vertical-align: middle; margin-right: 15px;' />Mensa geschlossen</li>";
 }
}
echo "
</ul>
";

?>