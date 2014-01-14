/**
* Homepage Widget
*
* @author Michael Ochmann (INF | INF - SMS)
*/
$('document').ready(function() {
  setTimeout(HomepageScroll, 2000);
});


function HomepageScroll() {
    scrollAmount = $('#HomepagePanel').height() - $('#Homepage').height() + $('#Homepage > .widgetTitle').height();
    scrollHeight = scrollAmount;
    if ($('#Homepage').scrollTop() > 0)
      scrollHeight = -$('#HomepagePanel').scrollTop();
    scrollDuration = scrollAmount * 50;
  $('#Homepage').animate({scrollTop : scrollHeight}, scrollDuration, 'linear', function() {
    setTimeout(HomepageScroll, 2000);
  });
}