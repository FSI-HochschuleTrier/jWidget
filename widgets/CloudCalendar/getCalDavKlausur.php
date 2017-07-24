<?php
/**
 *  * Created by PhpStorm.
 * User: Philipp Dippel Inf | DMS - M
 * For Project: jWidget
 * Date: 26.06.17
 * Copyright: Philipp Dippel
 */


require_once('CalDavClient.php');

$calDavClient = new \dippel_rocks\CalDavClient();

//echo json_encode($calDavClient->getInfos());
echo($calDavClient->getInfos('klausur'));