<?php

namespace API;

class AuthMiddleware {

    private $_container;

    public function __construct(\Slim\App $api_app) {
        $this->_container = $api_app->getContainer();
    }

    public function __invoke($request, $response, $next) {
        $authorized = false;

        $exception = 'Not authorized';
        if ($request->hasHeader('Authorization')) {
            $authorization = $request->getHeader('Authorization');
            $auth_info = explode(' ', $authorization[0]);
            if (isset($auth_info[0]) && $auth_info[0] === 'Basic') {
                $auth_data = explode(':', base64_decode($auth_info[1]));

                if (isset($auth_data[0]) && isset($auth_data[1])) {
                    $username = $auth_data[0];
                    $access_token = $auth_data[1];

                    $authorized = $this->_authorize($username, $access_token);
                }
            }
        }

        if ($authorized) return $next($request, $response);
        else return $response->withJson(['message' => $exception], 403, JSON_PRETTY_PRINT);
    }

    private function _authorize($username, $access_token) {
        $user = \App\App::token_auth([
            'username' => $username,
            'access_token' => $access_token
        ]);

        if ($user) {
            $this->_container['user'] = $user;
            $this->_container['access_token'] = $access_token;

            return true;
        }

        return false;
    }
}