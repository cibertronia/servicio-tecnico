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
// check folder permissions - only check temp/ folder (writable needed for sessions/cache)
// ROOT_PATH check removed: in cPanel/VPS environments the root may not be writable by web user
$_temp_path = ROOT_PATH.'/temp';
if (!is_dir($_temp_path)) {
	@mkdir($_temp_path, 0775, true);
}
if (!is_writable($_temp_path)) {
	@chmod($_temp_path, 0775);
	// If still not writable after attempt, show error page
	if (!is_writable($_temp_path)) {
		include_once APP_PATH.'/_permissions.php';
		exit;
	}
}
require_once APP_PATH.'/init.ui.php';