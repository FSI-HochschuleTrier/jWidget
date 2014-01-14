<!--
* Bus Widget
*
* @author Michael Ochmann (INF | INF - SMS)
-->

<h2 class='widgetTitle'>Busverbindungen</h2>
<?php
require_once("parseSWT.class.php");

define("DISPLAY_LIMIT_HST", 3);
define("DISPLAY_LIMIT_BITBU", 13);

$fhBus = new parseSWT("HST");
$fhBusArray = $fhBus->toArray();
$bitBus = new parseSWT("bitbu");
$bitBusArray = $bitBus->toArray();

echo "
 <table id='BusPanel' cellspacing='0'>
        <tr>
            <td colspan='3' class='BusHeadline'>Haltestelle Hochschule</td>
       </tr>
        <tr>
            <th>Abfahrt</th>
            <th>Linie</th>
            <th>Nach</th>
       </tr>
";
$i = 0;
foreach($fhBusArray as $bus) {
  echo "
 <tr>
     <td><b>".$bus['arrival']."</b></td>
     <td>".$bus['route']."</td>
     <td>".$bus['destination']."</td>
</tr>
  ";
  if (++$i == DISPLAY_LIMIT_HST) break;
}
echo "
        <tr>
            <td colspan='3' style='border: none;'>&nbsp;</td>
       </tr>
        <tr>
            <td colspan='3' class='BusHeadline'>Haltestelle Bitburgerstra&szlig;e</td>
       </tr>
        <tr>
            <th>Abfahrt</th>
            <th>Linie</th>
            <th>Nach</th>
       </tr>
";
$i = 0;
foreach($bitBusArray as $bus) {
  echo "
 <tr>
     <td><b>".$bus['live']."</b></td>
     <td>".$bus['route']."</td>
     <td>".$bus['destination']."</td>
</tr>
  ";
  if (++$i == DISPLAY_LIMIT_BITBU) break;
}
echo "
</table>
";

?>