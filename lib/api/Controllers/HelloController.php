<?php

namespace API\Controllers;
use Psr\Container\ContainerInterface;
use \Common\Util;

class HelloController {
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function helloWorld($request, $response, $args) {
        $user = \App\App::getAuthenticatedUser();

        // make use of data
        // $data = $request->getParsedBody();
        // $something = get('something', $data);

        $result = [
            'message' => 'Well, hello there',
            'user' => $user->get()
        ];

        return $this->container->get('formatter')->format($response, $result);
    }
}