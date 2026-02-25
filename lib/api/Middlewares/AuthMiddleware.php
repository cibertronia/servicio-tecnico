<?php

namespace API\Middlewares;

use Slim\Psr7\Response;

class AuthMiddleware {
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __invoke($request, $handler) {
        $path = $request->getUri()->getPath();
        $authorized = false;

        $exception = 'Not authorized';
        if ($request->hasHeader('Authorization')) {
            $authorization = $request->getHeader('Authorization');
            $auth_info = explode(' ', $authorization[0]);
            if (isset($auth_info[0]) && strtolower($auth_info[0]) === 'bearer') {

                $auth_token = $auth_info[1] ?? null;
                $session = \Models\Session::instance([
                    'token' => $auth_token,
                    'platform' => \App\App::PLATFORM_API
                ]);

                if ($session) {
                    $authorized = true;
                    \App\App::setSession($session);
                }
            }
        }

        if ($authorized) {
            $response = $handler->handle($request);
            return $response;
        } else {
            $response = new Response();
            return $this->container->get('formatter')->format($response, $exception, 401);
        }
    }
}