<?php

use \Common\Util;

function is_post() {
	return REQUEST_METHOD === 'POST';
}

function parse_float($str) {
	$number = preg_replace('/[^0-9\.]/i', '', $str);
	return floatval($number);
}

function redirect($url) {
	Util::redirect($url);
}

function slugify($name, $lowercase = true, $skip_chars = '') {
	return Util::slugify($name, $lowercase, $skip_chars);
}

function options($options, &$exceptions) {
	return Util::getOptions($options, $exceptions);
}

function parse_name($name) {
	if (!$name) return false;

	$name = slugify($name, false, "'");

	$parts = explode('-', $name);
	$parts_count = count($parts);

	if ($parts_count === 1) return [$parts[0], ''];

	// last word is the last name
	$lastname = $parts[$parts_count - 1];

	// get the first elements as firstname
	unset($parts[$parts_count - 1]);
	$firstname = implode(' ', $parts);

	return [$firstname, $lastname];
}

function in_string($string, $subject) {
    return Util::inString($string, $subject);
}

function plog($msg = '', $newline = true, $options = [], $return = false) {
	$is_cli = Util::isCli();
    $is_ajax = Util::isAjax();
    $is_pjax = Util::isPjax();

    $is_html = !($is_cli || $is_ajax) || $is_pjax;

	$result = Util::debug($msg, array_merge(['newline' => $newline], $options), true);
	$result = $is_html ? '<div class="debug">'.$result.'</div>' : $result;

	if ($return) return $result;
	else echo $result;
}

function get($field, $data = null, $default = null, $possible_values = []) {
	return Util::get($field, $data, $default, $possible_values);
}

function br2nl($text) {
	return Util::br2nl($text);
}

function array_delete($array, $items) {
    return array_diff($array, is_array($items) ? $items : [$items]);
}

function dt_valid($date, $min_date = null, $max_date = null, $timezone = null) {
	$valid = false;

    $date = dt($date, \DateTime::ISO8601, $timezone);
    if (!$date) return false;
    if ($max_date) $valid = $date < dt($max_date, \DateTime::ISO8601, $timezone);
    if ($min_date) $valid = $date > dt($min_date, \DateTime::ISO8601, $timezone);

    return $valid;
}

function dt($date = 'now', $format = null, $timezone = null, $src_format = null) {
	if (!$format) $format = 'Y-m-d H:i:s';

    if ($date) {
        try {
            if ($src_format) $date = \Moment\Moment::createFromFormat($src_format, $date, $timezone) ?: $date;
            if ($date instanceof DateTime) {
            	$dt = $date;
            } else {
            	// Warning: specifying the timezone will change the output date
            	if (is_string($date)) {
            		$date = strtotime($date);
            		if ($date < 0) return null;

            		$date = '@'.$date;
            	}

            	$dt = new \Moment\Moment($date, $timezone);
            }

            return $dt->format($format);

        } catch (Exception $ex) {
            trigger_error($ex->getMessage());
        }
    }

    return null;
}

function token($length = 16) {
	return Util::token($length);
}

function uuid() {
	return Util::uuid();
}

function phone($input, $country_code = 1, $format = '+%1$s%2$s%3$s%4$s') {
	return Util::formatPhone($input, $country_code, $format);
}

function ssn($input) {
	return Util::formatSsn($input);
}

function escape($str, $nl2br = false) {
	return Util::escapeHtml($str, $nl2br);
}

function encrypt($data, $iv) {
	$iv = hash_hmac('sha256', $iv, ENCRYPTION_KEY);
	return Util::encrypt($data, ENCRYPTION_KEY, $iv);
}

function decrypt($data, $iv) {
	$iv = hash_hmac('sha256', $iv, ENCRYPTION_KEY);
	return Util::decrypt($data, ENCRYPTION_KEY, $iv);
}

?>