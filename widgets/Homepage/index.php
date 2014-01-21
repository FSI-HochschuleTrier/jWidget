<!--
* Homepage Widget
*
* @author Michael Ochmann (INF | INF - SMS)
-->
<h2 class='widgetTitle'>Fachschafts Homepage &raquo; News</h2>
 <ul id='HomepagePanel'  class='bxslider'>
<?php

$monthArray = Array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");

function getJSONstream($url) {
    $str = @file_get_contents($url);
    if ($str === FALSE) {
        throw new Exception("Die URL '$url' kann nicht aufgerufen werden!");
    } else {
        return $str;
    }
}

try {
  $input = getJSONstream("https://fsi.hochschule-trier.de/concon/news.php");
} catch (Exception $e) {
    echo 'Fehler: ',  $e->getMessage(), "\n";
    $input = "[]";
}

$news = json_decode($input);

foreach ($news as $post) {
  $timestamp = $post[1];
  $title = $post[0];
  $excerpt = $post[2];
  $excerpt = @eregi_replace("\[nbsp\]", " ", $excerpt);
  $excerpt = @eregi_replace("\[&\]", "&amp;", $excerpt);
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
           adaptiveHeight: true,
           pause: 30000
  });
</script>