<?php
/**
 *  * Created by PhpStorm.
 * User: Philipp Dippel Inf | DMS - M
 * For Project: jWidget
 * Date: 15.06.17
 * Copyright: Philipp Dippel
 */


$action = "";


if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if ($action != "") {
    $output = "";

    if ($action == "getStatus") {
        $fp = fsockopen("polyhymnia.fsi.hochschule-trier.de", 6600, $errno, $errstr, 30);

        if ($fp) {

            $out = "status\n";
            $out .= "stats\n";
            $out .= "currentsong\n\n";
            fwrite($fp, $out);
            while (!feof($fp)) {

                $output = $output . fgets($fp, 128);
            }
            fclose($fp);
        }
    }

    if ($output != "") {
        $outArr = array();

        $posArtist = strpos($output, 'Artist:') + 8;
        $artist = substr($output, $posArtist, (strpos($output, PHP_EOL, $posArtist)) - $posArtist);

        $posPlayTime = strpos($output, 'time:') + 6;
        $playTime = substr($output, $posPlayTime, (strpos($output, PHP_EOL, $posPlayTime)) - $posPlayTime);

        $posTimeDot = strpos($playTime, ':');
        $alreadyPlayedTime = substr($playTime, 0, $posTimeDot);
        $duration = substr($playTime, $posTimeDot +1);


        $posTitle = strpos($output, 'Title:') + 7;
        $title = substr($output, $posTitle, (strpos($output, PHP_EOL, $posTitle)) - $posTitle);

        $posAlbum = strpos($output, 'Album:') + 7;
        $album = substr($output, $posAlbum, (strpos($output, PHP_EOL, $posAlbum)) - $posAlbum);

        $posDate = strpos($output, 'Date:') + 6;
        $date = substr($output, $posDate, (strpos($output, PHP_EOL, $posDate)) - $posDate);

        $outArr['artist'] = $artist;
        $outArr['title'] = $title;
        $outArr['album'] = $album;
        $outArr['date'] = $date;
        $outArr['time'] = $alreadyPlayedTime;
        $outArr['duration'] = $duration;
        $outArr['error'] = 'false';
        echo json_encode($outArr);

    } else {
        $errorArr = array();
        $errorArr['error'] = 'true';

        echo json_encode($errorArr);
    }


}
