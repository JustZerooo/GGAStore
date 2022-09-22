<?php

/**
 * @author gwork
 */

use GWork\System\Exceptions\GWorkException;

define('HIDE_COPYRIGHT', true);

if(phpversion() < '7.0.0') {
	return error('Supports only on PHP >= 7');
} else if(!defined('PDO::ATTR_DRIVER_NAME')) {
	return error('PDO is not installed.');
}

function error($string) {
	echo '<span style="font-family: arial;font-size:13px;">' . $string . '</span>';
}

try {
	require_once __DIR__ . '/GWork/GWork.php';
} catch(GWorkException $ex) {
	echo $ex->getMessage();
} catch(Exception $ex) {
	echo $ex->getMessage();
}
