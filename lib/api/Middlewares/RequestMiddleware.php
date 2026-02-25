<?php

namespace API\Middlewares;

use Slim\Psr7\Response;

class RequestMiddleware {
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __invoke($request, $handler) {
        // user-agent is required
        if (!$request->hasHeader('User-Agent')) {
            $response = new Response();
            return $this->container->get('formatter')->format($response, 'Please make sure your request has a User-Agent header', 403);
        }

        $method = $request->getMethod();
        $content_type = $request->getHeaderLine('Content-Type');

        // Samples:
        // curl -d '{"username":"YOUR_USERNAME","password":"YOUR_PASSWORD"}'  http://localhost/public/api/v1/authenticate -i -k
        // curl -X POST -F 'username=YOUR_USERNAME' -F 'password=YOUR_PASSWORD'  http://localhost/public/api/v1/authenticate -i -k

        // assume that POST requests aside multipart/form-data are in JSON format
        if (in_array($method, ['POST', 'PUT']) && !strstr($content_type, 'multipart/form-data')) {
            $contents = json_decode($request->getBody(), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $request = $request->withParsedBody($contents);
            }
        }

        return $handler->handle($request);
    }
}