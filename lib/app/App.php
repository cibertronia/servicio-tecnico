<?php

namespace App;
use \Common\Util;
use \Models\Model;

class App {
    private static $_session = null;

    const PLATFORM_WEB = 1;
    const PLATFORM_API = 2;

    const LOGIN_ERROR_INACTIVITY = 1;
    const LOGIN_ERROR_OAUTH = 2;

    const INACTIVITY_TIMEOUT = 0;
    const SOCKET_IO_PORT = 1990;

    public static function webLogout() {
        if (self::$_session) {
            self::$_session->destroy();
            self::$_session = null;
        }

        return true;
    }

    public static function getLoginException($code) {
        switch ($code) {
            case self::LOGIN_ERROR_INACTIVITY:
                $exception = 'You were inactive for more than 20 minutes. Please login again.';
                break;
            case self::LOGIN_ERROR_OAUTH:
                $exception = 'Unable to login you through our social login method. Please try again later.';
                break;
            default:
                $exception = 'Something went wrong. Please login again.';
        }

        return $exception;
    }

    /**
     * Authenticate the current page
     * @param  boolean $verify_session If the app should verify the session and the user itself. Set default to true if you already implemented the built-in verifications
     * @param  [type]  $login_page     The page it should redirect to if not authenticated
     */
    public static function authenticatePage($verify_session = true, $login_page = APP_URL.'/php_auth_login.php') {
        $r = urlencode(SERVER_REQUEST);
        $user = self::getAuthenticatedUser();
        if ($user) {
            // calculate inactivity
            $time = time();
            $active_at = strtotime(self::$_session->active_at);

            if (self::INACTIVITY_TIMEOUT && ($time - $active_at) >= self::INACTIVITY_TIMEOUT) {
                self::webLogout();

                if (Util::isAjax() || Util::isPjax()) {
                    Util::setStatus(401);
                    Util::setContentType('application/json');
                    echo json_encode(['message' => 'You were inactive for more than 20 minutes. Refresh the page and login again.']);
                    exit;
                } else {
                    redirect($login_page.'?r='.$r.'&error='.self::LOGIN_ERROR_INACTIVITY);
                }
            }

            if ($verify_session) {
                // check if account is verified
                /*
                if (!$user->isVerified()) {
                    if (Util::isAjax() || Util::isPjax()) {
                        Util::setStatus(401);
                        Util::setContentType('application/json');
                        echo json_encode(['message' => 'Your account is not verified.']);
                        exit;
                    } else {
                        redirect(APP_URL.'/account/gate?r='.$r);
                    }
                }
                */

                // should verify session (2FA)
                /*
                if (self::$_session->shouldVerify()) {
                    if (Util::isAjax() || Util::isPjax()) {
                        Util::setStatus(401);
                        Util::setContentType('application/json');
                        echo json_encode(['message' => 'Your active session requires verification.']);
                        exit;
                    } else {
                        redirect(APP_URL.'/auth/verify?r='.$r);
                    }
                }
                */
            }

            // set activity
            return self::$_session->ping();

        } else {
            if (Util::isAjax() || Util::isPjax()) {
                Util::setStatus(401);
                exit;
            } else {
                redirect($login_page.'?r='.$r);
            }
        }
    }

    public static function addOrganization($data) {
        return \Models\Organization::insert([
            'name' => get('name', $data),
            'email' => get('email', $data),
            'website' => get('website', $data),
            'about' => get('about', $data),
            'phone' => get('phone', $data)
        ]);
    }

    public static function addUser($data, Organization $organization = null) {
        if (!Util::verifyFields(['firstname', 'lastname', 'email'], $data, $missing)) {
            throw new \Exception('Missing fields: '.Util::implodeAnd($missing));
        }

        $email = get('email', $data);
        $firstname = get('firstname', $data);
        $lastname = get('lastname', $data);

        $username = get('username', $data);
        $password = get('password', $data);
        if ($password) {
            $valid_password = \Models\User::validatePassword($password, $errors);
            if (!$valid_password) throw new \Exception('Password errors: '.Util::implodeAnd($errors));

        }

        $valid_username = \Models\User::validateUsername($username, $message);
        if (!$valid_username) throw new \Exception($message);

        $valid_email = \Models\User::validateEmail($email, $message);
        if (!$valid_email) throw new \Exception($message);

        // get location info
        try {
            $location = self::getLocationInfo();
            $country = self::getCountry(get('country', $location));
        } catch (\Exception $ex) {
            if (__DEV__) throw $ex;
        }

        if (!$location) throw new \Exception('Unable to get location information.');

        $user = \Models\User::insert([
            'username' => $username,
            'email' => $email,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'country' => $country->code,
            'timezone' => get('timezone', $location),
            'region' => get('region', $location)
        ]);

        if ($user) {
            if ($password) $user->setPassword($password);
            $user->sendEmailVerification();

            if ($organization) $organization->addUser($user);

            return $user;
        }

        throw new \Exception('Failed to create user account');
    }

    public static function isAuthenticated() {
        return self::$_session ? true : false;
    }

    public static function getSession() {
        return self::$_session;
    }

    public static function getAuthenticatedUser() {
        return self::isAuthenticated() ? self::$_session->getUser() : false;
    }

    public static function getLocationInfo($query = null) {
        if ($query) $ip = $query;
        else $ip = __LOCAL__ ? '' : Util::getClientIp();

        $content = file_get_contents('http://ip-api.com/json/'.$ip);
        $data = json_decode($content);
        if ($data && $data->status === 'success') {
            return [
                'country' => get('countryCode', $data),
                'timezone' => get('timezone', $data),
                'region' => get('region', $data),
                'timezone' => get('timezone', $data),
            ];
        }

        return null;
    }

    public static function logApi($data) {
        $session = self::getSession();

        return \Models\APIRequest::insert([
            'session_id' => $session ? $session->id : null,
            'path' => get('path', $data, '/'),
            'latency' => get('latency', $data, 0),
            'ip' => get('ip', $data) ?: Util::getClientIp(),
            'method' => get('method', $data),
            'status' => get('status', $data),
            'ua' => get('ua', $data),
            'request_body' => get('request_body', $data),
            'response_body' => get('response_body', $data)
        ]);
    }

    public static function getOauthConfig($provider) {
        return [
            //Location where to redirect users once they authenticate with a provider
            'callback' => APP_URL.'/auth/'.$provider,

            //Providers specifics
            'providers' => [
                'Facebook' => ['enabled' => true, 'keys' => [ 'id'  => OAUTH_FACEBOOK_ID, 'secret' => OAUTH_FACEBOOK_SECRET]],
                'Google' => ['enabled' => true, 'keys' => [ 'id'  => OAUTH_GOOGLE_ID, 'secret' => OAUTH_GOOGLE_SECRET]]
            ]
        ];
    }

    public static function socialAuth($provider, $profile, $access_token) {
        if (!($profile && $access_token)) {
            throw new \Exception('invalid oauth parameters');
        }

        $identifier = get('identifier', $profile);
        $email = get('email', $profile);

        $_SESSION[OAUTH_PROVIDER_SESSION_NAME] = $provider;

        // do whatever you like with the profile and email
        /*

        // verify if the user exists by email
        $user = \Models\User::withEmail($email);
        if ($user) {
            // update avatar
            $user->update([
                'avatar_url' => get('photoURL', $profile),
                'firstname' => get('firstName', $profile),
                'lastname' => get('lastName', $profile)
            ]);
        } else {
            // register this user automatically if it doesn't exist
            $user = self::addUser([
                'email' => $email,
                'firstname' => get('firstName', $profile),
                'lastname' => get('lastName', $profile),
                'avatar_url' => get('photoURL', $profile)
            ]);
        }

        */

        // for demo purposes, we're going to use the default user
        $user = \Models\User::instance(1);

        // create the web session
        return $user->createWebSession(self::PLATFORM_WEB, true);
    }

    /**
     * API authenticate with api key & secret key
     * @param  array       $data   api key & secret key
     * @param  string|null &$exception error string
     * @return boolean              authenticated
     */
    public static function tokenAuth($data) {
        if (!Util::verifyFields(['username', 'access_token'], $data)) {
            throw new \Exception('Missing credentials');
        }

        $user = \Models\User::withUsername(get('username', $data));
        if ($user && $user->validateAccessToken(get('access_token', $data))) {
            return $user;
        }

        throw new \Exception('Invalid access token');
    }

    private static function _getUserWithPassword($data) {
        if (!Util::verifyFields(['username', 'password'], $data)) {
            throw new \Exception('Missing username or password fields');
        }

        $username = $data['username'];
        $password = $data['password'];

        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $user = \Models\User::withEmail($username);
        } else {
            $user = \Models\User::withUsername($username);
        }

        return $user && $user->verifyPassword($password) ? $user : false;
    }

    /**
     * API authenticate with username and password
     * @param  array       $data          username & password
     * @return boolean                     is authenticated
     */
    public static function apiAuth($data) {
        $user = self::_getUserWithPassword($data);
        if ($user) {
            $session = $user->createSession(self::PLATFORM_API);
            self::setSession($session);

            return $session;
        }

        throw new \Exception('Invalid username or password');
    }

    /**
     * Web authenticate with username and password
     * @param  array       $data          username & password
     * @return boolean                     is authenticated
     */
    public static function webAuth($data, $remember = true) {
        $user = self::_getUserWithPassword($data);
        if ($user) {
            $session = $user->createWebSession(self::PLATFORM_WEB, $remember);
            self::setSession($session);

            return $session;
        }

        throw new \Exception('Invalid username or password');
    }

    /**
     * Initialize web session ($_SESSION)
     * @return boolean is authenticated
     */
    public static function initWebSession() {
        $session = null;

        session_start();

        if (isset($_SESSION[AUTH_TOKEN_SESSION_NAME])) {
            $token = $_SESSION[AUTH_TOKEN_SESSION_NAME];
            $session = \Models\Session::withToken($token);
        } else if (isset($_COOKIE[AUTH_COOKIE_NAME])) {
            $cookie = $_COOKIE[AUTH_COOKIE_NAME];
            $session = \Models\Session::withCookie($cookie);
        }

        return self::setSession($session);
    }

    public static function setSession($session) {
        if ($session && $session->isValid()) {
            $session->touch();
            self::$_session = $session;

            return true;
        }

        return false;
    }

    public static function getCompany() {
        $data = [
            'name' => APP_OWNER_NAME,
            'phone' => APP_OWNER_PHONE,
            'fax' => APP_OWNER_FAX,
            'email' => APP_OWNER_EMAIL,
            'address' => APP_OWNER_ADDRESS,
            'logo' => APP_OWNER_LOGO
        ];

        return $data;
    }

    public static function error400($message = null) {
        self::includeError(400, $message);
    }

    public static function error404($message = null) {
        self::includeError(404, $message);
    }

    public static function error403($message = null) {
        self::includeError(403, $message);
    }

    public static function error401($message = null) {
        self::includeError(401, $message);
    }

    public static function includeError($code, $message = '') {
        if (!Util::isPjax() && !Util::isAjax()) {
            include_once self::getInclude('_'.$code);
        } else {
            Util::setStatus($code);
            if ($message) {
                Util::setContentType('application/json');
                echo json_encode(is_string($message) ? ['message' => $message] : $message);
            }
        }
    }

    public static function getInclude($path) {
        $path = in_string('.php', $path) ? $path : $path.'.php';
        $path = INCLUDES_PATH.'/'.$path;

        if (file_exists($path)) return $path;
        else return self::getInclude('_404');
    }

    public static function getUsers($filters = [], $binds = [], $get_count = false, $pagination = null) {
        $filters_str = \Models\Model::createFilter($filters, $binds);

        $query = "
            FROM users
            WHERE active = 1
                $filters_str
        ";

        if ($get_count) {
            $result = \Models\Model::$db->row("
                SELECT COUNT(id) AS total
                $query
            ", $binds);

            return $result ? $result->total : 0;
        }

        return \Models\User::select("
            SELECT users.*
            $query
            $pagination
        ", $binds);
    }
}