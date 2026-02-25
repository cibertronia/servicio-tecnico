<?php
chdir(__DIR__);
require_once 'const.php';
// initialize composer
$autoload_file = ROOT_PATH.'/vendor/autoload.php';
if (!file_exists($autoload_file)) {
	include_once APP_PATH.'_install.php';
	exit;
}
require_once ROOT_PATH.'/root.php';
require_once ROOT_PATH.'/debug.php';
// check folder permissions
if (!is_writable(ROOT_PATH)) {
	include_once APP_PATH.'/_permissions.php';
	exit;
}
require_once APP_PATH.'/init.ui.php';