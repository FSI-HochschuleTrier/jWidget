<?php


require_once('../../parseDOM.php');


function parseMensa() {
$karte = Array();

$html = file_get_html('https://studip.hochschule-trier.de/plugins.php/mensaplugin/show');

foreach($html->find('.menu-inhalt') as $element) {
$tag = Array();
        foreach($element->find('.menu-inhalt-zeile-text') as $tagtext) {
       if(!empty($tagtext->plaintext)) {array_push($tag, $tagtext);}
    }
if (!empty($tag)) {array_push($karte, $tag);}
}


$menu = Array();
$menu[0][0] = $karte[1];
$menu[0][1] = $karte[2];
$menu[0][2] = $karte[3];

$menu[1][0] = $karte[5];
$menu[1][1] = $karte[6];
$menu[1][2] = $karte[7];

$menu[2][0] = $karte[9];
$menu[2][1] = $karte[10];
$menu[2][2] = $karte[11];

$menu[3][0] = $karte[13];
$menu[3][1] = $karte[14];
$menu[3][2] = $karte[15];

$menu[4][0] = $karte[17];
$menu[4][1] = $karte[18];
$menu[4][2] = $karte[19];


return $menuArray = serialize($menu);
}

?>