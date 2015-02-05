<!--
* Homepage Widget
*
* @author Michael Ochmann (INF | INF - SMS)
-->
<h2 class='widgetTitle'>Fachschafts Homepage &raquo; News</h2>
 <ul id='HomepagePanel'  class='bxslider'>
<?php

$monthArray = Array("Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");

function getJSONstream($url) {
    $str = file_get_contents($url);
    if ($str === FALSE) {
        throw new Exception("Die URL '$url' kann nicht aufgerufen werden!");
    } else {
        return $str;
    }
}


try {
  $input = getJSONstream("http://fsi.hochschule-trier.de/category/api/?key=4EFECF393331C8698DE1937378665");
} catch (Exception $e) {
    echo 'Fehler: ',  $e->getMessage(), "\n";
    $input = "[]";
}

$news = json_decode($input);

foreach ($news as $post) {
  $timestamp = $post->date;
  $title = $post->title;
  $excerpt = $post->content;
  $excerpt = @eregi_replace("\[nbsp\]", " ", $excerpt);
  $excerpt = @eregi_replace("\[&\]", "&amp;", $excerpt);
  $excerpt = nl2br($excerpt);
  echo "
<li><h2>$title</h2>$excerpt<span class='HomepageNewsPostDatum'>".date("d", $timestamp)."<sup>".
    $monthArray[date("n", $timestamp)-1]." ".date("Y", $timestamp)."</sup></span></li>
  ";
}

?>
</ul>
<script>
  $('#HomepagePanel').bxSlider({
           auto: true,
           adaptiveHeight: false,
           pause: 30000,
           speed: 1
  });
</script>