<?php
/**
 * Bus widget
 * Version: 2.0.0
 *
 * @author Michael Ochmann (INF | INF - SMS)
 */

define("LIMIT_HST", 3);
define("LIMIT_BITBU", 11);

require_once("SWTParser.class.php");
require_once("Bus.class.php");

$hst    = new SWTParser("HST");
$bitbu  = new SWTParser("bitbu");
?>

<h2 class='widgetTitle'>Busverbindungen</h2>
    <table id='BusPanel' cellspacing='0'>
        <tr>
            <td colspan='3' class='BusHeadline'>Haltestelle Hochschule</td>
        </tr>
        <tr>
            <th>Abfahrt</th>
            <th>Linie</th>
            <th>Nach</th>
        </tr>
<?php
$i = 0;
foreach($hst->getBusses() as $bus) {
  echo "
 <tr>
     <td><b>".$bus->getLive()."</b></td>
     <td>$bus->route</td>
     <td>$bus->destination</td>
</tr>
  ";
  if (++$i == LIMIT_HST)
      break;
}
?>
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
<?php
$i = 0;
foreach($bitbu->getBusses() as $bus) {
  echo "
 <tr>
     <td><b>".$bus->getLive()."</b></td>
     <td>$bus->route</td>
     <td>$bus->destination</td>
</tr>
  ";
  if (++$i == LIMIT_BITBU)
      break;
}
?>
</table>