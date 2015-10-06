/**
* Mensa Widget
*
* @author Michael Ochmann (INF | INF - SMS)
*/
$('document').ready(function() {
  setTimeout(MensaScroll, 2000);
});


function MensaScroll() {
    scrollAmount = $('#MensaPanel').height() - $('#Mensa').height() + $('#Mensa > .widgetTitle').height();
    scrollHeight = scrollAmount;
    if ($('#Mensa').scrollTop() > 0)
      scrollHeight = -$('#MensaPanel').scrollTop();
    scrollDuration = scrollAmount * 60;
  $('#Mensa').animate({scrollTop : scrollHeight},scrollDuration, 'linear', function() {
    setTimeout(MensaScroll, 2000);
  });
}