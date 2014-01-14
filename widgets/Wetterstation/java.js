/**
* Wetterstation Widget
*
* @author Michael Ochmann (INF | INF - SMS)
*/

function WetterstationClock(){
  // Neues Datumsobjekt
  var objDate = new Date();
  var intSek = objDate.getSeconds();     // Sekunden 0..59
  var intMin = objDate.getMinutes();     // Minuten 0..59
  var intHours = objDate.getHours()%12;  // Stunden 0..11

  intHours = objDate.getHours();
  digitHours = intHours < 10 ? "0" + intHours : intHours;
  digitMin = intMin < 10 ? "0" + intMin : intMin;
  $('.digit').html(digitHours + ":" + digitMin);

  digitMonths = Array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
  $('.date').html(objDate.getDate() + ". " + digitMonths[objDate.getMonth()] + " " + objDate.getFullYear());
  hTimer = window.setTimeout(WetterstationClock, 5000);
}