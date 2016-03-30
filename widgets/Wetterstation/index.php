<!--
* Wetterstation Widget
*
* @author Michael Ochmann (INF | INF - SMS)
-->
<div style='position: absolute;'>
<b class='digit'></b>
<sup class='date'></sup>
<?php

require_once("key.php");

$wetter = @simplexml_load_file("http://api.openweathermap.org/data/2.5/weather?q=Trier&mode=xml&lang=de&APPID=".APIKEY);

@$temperature = round( $wetter->temperature['value'] - 273.15) != -273 ? round( $wetter->temperature['value'] - 273.15) : "N/A";
@$humidity = $wetter->humidity['value'];
@$weatherCode = (string) $wetter->weather['number'];
$weatherCode = substr($weatherCode, 0, 1);
$weatherSymbols[2] = "F";
$weatherSymbols[3] = "6";
$weatherSymbols[5] = "$";
$weatherSymbols[6] = "9";
$weatherSymbols[7] = "<";
$weatherSymbols[8] = "\"";
$weatherSymbols[9] = "X";

$temperature = $wetter ? $temperature." &deg;C" : "";
$humidity = $wetter ? $humidity." %" : "";
$error = $wetter ? "" : "<sup>Wetter ist zur Zeit nicht verf&uuml;gbar</sup>";
echo "
 <p >
  <table class='weather'>
         <tr>
             <td valign='top'><span class='WetterstationSymbol'>".@$weatherSymbols[$weatherCode]."</span></td>
             <td>
$error
$temperature<br />
$humidity
            </td>
        </tr>
 </table>
</p>
";
?>

</div>
<img src='widgets/Wetterstation/logo_fsi.png' alt='Fachschaft Informatik' class='WetterstationLogo' />
<script type="text/javascript">
$('document').ready(function() {
  WetterstationClock();

  $('.digit').css('font-size',($('#Wetterstation').width()*0.3)+'px');
  $('.digit').css('width',$('#Wetterstation').width() - 30 );
  $('.date').css('font-size',($('#Wetterstation').width()*0.1)+'px');
});
</script>