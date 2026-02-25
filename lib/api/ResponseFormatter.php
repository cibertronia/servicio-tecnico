<?php

namespace API;

class ResponseFormatter {
	private $container;

	public function __construct($container) {
		$this->container = $container;
	}

	public function format($response, $payload, $status_code = 200) {
		if (is_string($payload)) {
			$payload = [
				'message' => $payload,
				'status' => $status_code.' '.\Common\Util::getHttpStatus($status_code)
			];
		}

		$response->getBody()->write(json_encode($payload, __DEV__ ? JSON_PRETTY_PRINT : null));
		return $response
			->withHeader('Content-Type', 'application/json')
			->withStatus($status_code);
	}
}