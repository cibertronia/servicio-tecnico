<?php
// Suppress deprecated warnings from 3rd party libraries (Moment.php) on PHP 8+
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
require_once ROOT_PATH.'/vendor/autoload.php';
/*$dirs = ['tmp', 'cache', 'logs', 'archive'];
foreach ($dirs as $dir) {
	$path = ROOT_PATH.'/'.$dir;
	if (!file_exists($path)) {
    mkdir($path, 0777, true);
    chmod($path, 0775);
	}
}*/
$dotenv = Dotenv\Dotenv::create(ROOT_PATH, '.env');
$dotenv->load();
// global functions
require_once ROOT_PATH.'/config.php';
require_once ROOT_PATH.'/lib/func.php';
// Cache
\Common\Cache::setKey(ENCRYPTION_KEY);
// Moment
\Moment\Moment::setDefaultTimezone(date_default_timezone_get());