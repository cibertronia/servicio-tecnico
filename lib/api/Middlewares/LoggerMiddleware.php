<?php

namespace API\Middlewares;

use Slim\Psr7\Response;

class LoggerMiddleware {
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __invoke($request, $handler) {
        $logger = $this->container->get('logger');

        $path = $request->getUri();
        $method = $request->getMethod();
        $client_ip = \Common\Util::getClientIp();

        $start = microtime(true);
        $response = $handler->handle($request);
        $end = microtime(true);

        $latency = round($end - $start, 4);
        $status_code = $response->getStatusCode();

        $api_request = \App\App::logApi([
            'path' => $path,
            'latency' => $latency,
            'ip' =>  $client_ip,
            'method' => $method,
            'status' => $status_code,
            'request_body' => json_encode($request->getParsedBody()) ?: (string)$request->getBody(),
            'response_body' => (string)$response->getBody(),
            'ua' => $request->getHeaderLine('User-Agent')
        ]);

        $request_id = $api_request->id;

        $logger->info('#'.$request_id.' '.$method.' '.$status_code.' '.$response->getReasonPhrase().' '.$latency.'s');
        return $response;
    }
}