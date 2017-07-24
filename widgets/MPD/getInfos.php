<?php
/**
 *  * Created by PhpStorm.
 * User: Philipp Dippel Inf | DMS - M
 * For Project: jWidget
 * Date: 26.06.17
 * Copyright: Philipp Dippel
 */


require_once('MPC.php');

$mpc = new \massive_dynamic\mpc\MPC('polyhymnia.fsi.hochschule-trier.de');

$status = $mpc->status();
$current = $mpc->current();
unset($current->time);


echo json_encode((object) array_merge((array)$status, (array)$current));

