<?php
/**
 * Created by PhpStorm.
 * User: Philipp
 * Date: 13.06.17
 * Time: 23:31
 */
require_once("key.php");

$curl = curl_init();
$headers = [
    'PRIVATE-TOKEN: ' .APIKEY,
];

curl_setopt($curl, CURLOPT_URL, "https://gitlab.fsi.hochschule-trier.de/api/v3/projects/399/issues?state=opened&per_page=50");
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$outPutOpen = curl_exec($curl);
curl_close($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://gitlab.fsi.hochschule-trier.de/api/v3/projects/399/issues?state=closed&per_page=10");
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$outPutClosed = curl_exec($curl);
curl_close($curl);

file_put_contents("test.txt", $outPutClosed);

//file_put_contents("issues_resolve_examples.json", $outPut); //get an example of retrieved data

echo '
    
    <div id = "main" >
    <div class="listBox" id = "boxAlle" >
        <div class="title" >Alle</div >
        <ul id="listAlle"></ul>
    </div>
    <div class="listBox" id = "boxSprecher" >
        <div class="title" > Sprecher</div >
        <ul id="listSprecher"></ul>
    </div >
    <div class="listBox" id = "boxKasse" >
        <div class="title" > Kasse</div >
        <ul id="listKasse"></ul>
    </div >
    <div class="listBox" id = "boxAdmin" >
        <div class="title" > Admin</div >
        <ul id="listAdmin"></ul>
    </div >
    <div class="listBox" id = "boxWebmaster" >
        <div class="title" > Webmaster</div >
        <ul id="listWeb"></ul>
    </div >
    <div class="listBox" id = "boxEvents" >
        <div class="title" > Events</div >
        <ul id="listEvents"></ul>
    </div >
    <div class="listBox" id = "boxRaumwart" >
        <div class="title" > Raumwart</div >
        <ul id="listRaumwart"></ul>
    </div >
    <div class="listBox" id = "boxClosed" >
        <div class="title" > Closed</div >
        <ul id="listClosed"></ul>
    </div >
</div >


<script type = "text/javascript" >

        evaluateData('.$outPutOpen.','.$outPutClosed.');

</script >';
?>