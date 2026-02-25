<?php

namespace API\Middlewares;

use Slim\Psr7\Response;

class RateLimiterMiddleware {
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    private function update_response($response, $remaining, $last_reset) {
        // store reate limit info
        return $response
            ->withHeader('X-RateLimit-Limit', API_RATE_LIMIT)
            ->withHeader('X-RateLimit-Remaining', max($remaining, 0))
            ->withHeader('X-RateLimit-Reset', $last_reset + 3600);
    }

    public function __invoke($request, $handler) {
        $client_ip = \Common\Util::getClientIp();
        $remaining = API_RATE_LIMIT;
        $last_reset = time();

        // get first request of the day
        $first_api_request = \Models\APIRequest::row("
            SELECT id, created_at
            FROM api_requests
            WHERE active = 1
                AND created_at >= CURDATE()
                AND ip = :ip
            LIMIT 1
        ", ['ip' => $client_ip]);

        if ($first_api_request) {
            $first_request_time = strtotime($first_api_request->created_at);

            // calculate last reset
            $ellapsed = time() - $first_request_time;
            $last_reset = time() - ($ellapsed % 3600);

            // get current requests
            $requests = \Models\Model::$db->row("
                SELECT count(*) AS total
                FROM api_requests
                WHERE active = 1
                    AND created_at > :last_reset
                    AND ip = :ip
            ", ['ip' => $client_ip, 'last_reset' => dt($last_reset)]);

            $remaining = API_RATE_LIMIT - $requests->total;
            if ($remaining <= 0) {
                $response = $this->update_response(new Response(), 0, $last_reset);
                return $this->container->get('formatter')->format($response, 'API rate limit exceeded', 429);
            }
        }

        $response = $handler->handle($request);
        return $this->update_response($response, $remaining, $last_reset);
    }
}