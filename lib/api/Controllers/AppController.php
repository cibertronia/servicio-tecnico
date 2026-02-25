<?php

namespace API\Controllers;
use Psr\Container\ContainerInterface;
use \Common\Util;

class AppController {
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * Ping the api server (authenticated)
     */
    public function ping($request, $response, $args) {
        return $this->container->get('formatter')->format($response, 'pong');
    }

    /**
     * Authenticate a user given a username and password
     * @param string $username username
     * @param string $password password
     */
    public function authenticate($request, $response, $args) {
        $data = $request->getParsedBody();

        if (!Util::verifyFields(['username', 'password'], $data, $missing)) {
            throw new \Exception('Missing fields: '.Util::implodeAnd($missing));
        }

        $username = get('username', $data);
        $password = get('password', $data);

        $session = \App\App::apiAuth([
            'username' => $username,
            'password' => $password
        ]);

        return $this->container->get('formatter')->format($response, $session->get(), 201);
    }

    /**
     * Signup a user
     * @param string $firstname First Name
     * @param string $lastname Last Name
     * @param string $email Email Address
     * @param string $password Password
     */

    public function register($request, $response, $args) {
        $data = $request->getParsedBody();

        if (!Util::verifyFields(['email', 'firstname', 'lastname', 'password'], $data, $missing)) {
            throw new \Exception('Missing fields: '.Util::implodeAnd($missing));
        }

        $password = get('password', $data);
        $password_valid = \Models\User::validatePassword($password, $errors);
        if (!$password_valid) {
            throw new \Exception('Password requirements:'.EOL.implode(EOL, $errors));
        }

        $user = \App\App::addUser([
            'firstname' => get('firstname', $data),
            'lastname' => get('lastname', $data),
            'email' => get('email', $data),
            'password' => $password
        ]);

        if ($user) {
            $session = $user->createSession(\App\App::PLATFORM_API);
            $data = $user->get();
            $data['session'] = $session->get();

            return $this->container->get('formatter')->format($response, $data, 201);
        }

        throw new \Exception('Unable to register the user due to an unknown error. Please try again later.');
    }

    public function getUser($request, $response, $args) {
        $id = get('id', $args);
        $user = \Models\User::instance($id);
        if (!$user) throw new \Exception('User not found', 404);

        return $this->container->get('formatter')->format($response, $user->get());
    }

    public function getUsers($request, $response, $args) {
        $users = \App\App::getUsers();
        return $this->container->get('formatter')->format($response, $users);
    }
}