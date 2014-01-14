<!--
* AnalogUhr Widget
*
* @author Michael Ochmann (INF | INF - SMS)
-->
<div style='position: absolute;'>

<b class='digit'></b>
<sup class='date'></sup>
<?php
$wetter = simplexml_load_file("http://api.openweathermap.org/data/2.5/weather?q=Trier&mode=xml&lang=de");
$temperature = round( $wetter->temperature['value'] - 273.15);
$humidity = $wetter->humidity['value'];

echo "
 <p >
  <table class='weather'>
         <tr>
             <td valign='top'><img src='widgets/AnalogUhr/cloud.png' /></td>
             <td>
$temperature &deg;C<br>
$humidity %
            </td>
        </tr>
 </table>
</p>
";
?>

</div>
<img src='widgets/AnalogUhr/logo_fsi.png' alt='Fachschaft Informatik' class='AnalogUhrLogo' />
<canvas width='300' height='245' id='AnalogUhrCanvas' style='float: right; display: block;'></canvas>
<script type="text/javascript">
$('document').ready(function() {
  $('#AnalogUhrCanvas').width($('#AnalogUhr').width());
  $('#AnalogUhrCanvas').height($('#AnalogUhr').height());
  AnalogClock(document.getElementById('AnalogUhrCanvas'));
  $('.digit').css('font-size',($('#AnalogUhr').width()*0.3)+'px');
  $('.digit').css('width',$('#AnalogUhr').width() - 30 );
  $('.date').css('font-size',($('#AnalogUhr').width()*0.1)+'px');
});
</script>