<?php

namespace API;

class RateLimitMiddleware {
	private $_container;

    public function __construct(\Slim\App $api_app) {
        $this->_container = $api_app->getContainer();
    }

    public function __invoke($request, $response, $next) {
    	if ($this->_container->has('app')) {
    		$app = $this->_container->get('app');
	    	$access_token = \Models\AccessToken::with_token($this->_container->get('access_token'));

			// get first request of the day
			$first_api_request = \Models\APIRequest::query_row("
				SELECT id, created_at
				FROM api_requests
				WHERE active = 1
					AND created_at >= CURDATE()
					AND token_id = :token_id
				ORDER BY id
				LIMIT 1
			", ['token_id' => $access_token->id]);

			if ($first_api_request) {
				$first_request_time = strtotime($first_api_request->created_at);

				// calculate last reset
				$ellapsed = time() - $first_request_time;
				$remaining = $ellapsed % 3600;
				$last_reset = time() - $remaining;

				// get current requests
				$current_requests = \Models\Model::$db->query_row("
					SELECT count(*) AS total
					FROM api_requests
					WHERE active = 1
						AND created_at > :last_reset
						AND token_id = :token_id
					ORDER BY id
					LIMIT 1
				", ['token_id' => $access_token->id, 'last_reset' => dt($last_reset)]);

				$remaining = API_RATE_LIMIT - $current_requests->total;

				// store reate limit info
				$response = $response
					->withHeader('X-RateLimit-Limit', API_RATE_LIMIT)
					->withHeader('X-RateLimit-Remaining', max($remaining, 0))
					->withHeader('X-RateLimit-Reset', $last_reset + 3600);

				if ($remaining <= 0) {
					return $response->withJson([
						'message' => 'API rate limit exceeded',
						'documentation_url' => DOCS_URL.'/developer#rate-limiting'
					], 403, JSON_PRETTY_PRINT);
				}
			}
    	}

		return $next($request, $response);
    }

}