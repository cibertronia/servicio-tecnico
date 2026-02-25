<?php

namespace API;

class Logger extends \App\Logger {
	private $container;

	public function __construct($container) {
		$this->container = $container;

		$client_ip = \Common\Util::getClientIp();
		$channel = 'IP_'.slugify($client_ip);
		parent::__construct(APP_LOGS_PATH.'/api', $channel, false);

		$log = '['.$client_ip.']';
		if (__DEV__) $log .= ' DEV';
		if (__TEST__) $log .=' TEST';

		$this->debug($log);
	}
}