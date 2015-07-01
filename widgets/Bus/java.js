/**
* Bus Widget
*
* @author Michael Ochmann (INF | INF - SMS)
*/
$('document').ready(function() {
  setTimeout(BusScroll, 2000);
});


function BusScroll() {
    scrollAmount = $('#BusPanel').outerHeight() - $('#Bus').height() + $('#Bus > .widgetTitle').height();
    scrollHeight = scrollAmount;
    if ($('#Bus').scrollTop() > 0)
      scrollHeight = -$('#BusPanel').scrollTop();
    scrollDuration = scrollAmount * 20;
  $('#Bus').animate({scrollTop : scrollHeight}, scrollDuration, 'linear', function() {
    setTimeout(BusScroll, 1000);
  });
}