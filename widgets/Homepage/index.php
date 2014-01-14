<!--
* Homepage Widget
*
* @author Michael Ochmann (INF | INF - SMS)
-->
<h2 class='widgetTitle'>Fachschafts Homepage &raquo; News</h2>
 <ul id='HomepagePanel' style='padding-top: 50px;'>
<?php

require_once("../../parseDOM.php");

/*$html = file_get_html("http://fsi.hochschule-trier.de/index.php?id=news");

foreach($html->find('.news-list-item') as $element) {
$datum = $element->find('span.news-list-date', 0)->plaintext;
$day = date("d", strtotime($datum));
$dateElse = date("F y", strtotime($datum));
@$element = eregi_replace("src=\"", "src=\"http://fsi.fh-trier.de/", $element);
@$element = eregi_replace("width=\"", "", $element);
@$element = eregi_replace("height=\"", "", $element);
echo "<li>$element<span class='HomepageNewsPostDatum'>$day<sup>$dateElse</sup></span></li>";
}     */

$input = file_get_contents("http://fsi.hochschule-trier.de/contao/news.php");

$news = json_decode($input);

foreach ($news as $post) {
  echo "
<li><h2>".$post[0]."</h2>".$post[2]."<span class='HomepageNewsPostDatum'>".date("d", $post[1])."<sup>".date("F y", $post[1])."</sup></span></li>
  ";
}

?>
</ul>