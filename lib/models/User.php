<?php

namespace Models;
use \Common\Util;

class User extends Model {

    const MAX_SUSPENSION_REPORTS = 5;

    const PASSWORD_VALIDATION_LENGTH = 'length';
    const PASSWORD_VALIDATION_NUMBER = 'number';
    const PASSWORD_VALIDATION_SYMBOL = 'symbol';
    const PASSWORD_VALIDATION_UPPERCASE = 'uppercase';

    const PASSWORD_MIN_LENGTH = 8;

    public static function validateUsername($username, &$message = '') {
        $message = 'The username is already taken';

        $user = self::withUsername($username) ? true : false;
        if (!$user) {
            $message = 'The username is not in use';
            return true;
        }

        return false;
    }

    public static function validateEmail($email, &$message = '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Email is not valid';
            return false;
        }

        $user = self::withEmail($email) ? true : false;
        if (!$user) {
            $message = 'The email is not in use';
            return true;
        }

        $message = 'The email is already taken';

        return false;
    }

    public function getOrganization() {
        return Organization::instance($this->organization_id);
    }

    public function verifyEmail($key) {
        $verification = $this->getVerification(Verification::TYPE_EMAIL);
        if ($verification && $verification->validate($this)) {

            $verified = $verification->verify($key);
            if ($verified) {
                $this->update('verified', 1);
                $verification->complete();

                // verify the current session
                if (\App\App::isAuthenticated()) {
                    $session = \App\App::getSession();
                    $session->setVerification($verification);
                }

                return true;
            }
        }

        return false;
    }

    public function verifyPhone($code) {
        $verification = $this->getVerification(Verification::TYPE_PHONE);
        if ($verification && $verification->validate($this)) {

            $verified = $verification->verify($code);
            if ($verified) {
                // update phone
                $this->update('phone', $verification->to);

                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has a valid phone
     * @return boolean Result
     */
    public function hasPhone() {
        return $this->phone ? true : false;
    }

    public function isVerified() {
        return $this->verified ? true : false;
    }

    public function getVerification($type_id) {
        return Verification::row("
            SELECT v.*
            FROM verifications v
            INNER JOIN verification_types t ON t.id = v.type_id AND t.active = 1
            WHERE user_id = :user_id
                AND v.active = 1
                AND v.type_id = :type_id
                AND v.completed_at IS NULL
                AND v.token IS NOT NULL
                AND NOW() < DATE_ADD(v.created_at, INTERVAL timeout SECOND)
            ORDER BY id DESC
            LIMIT 1
        ", [
            'user_id' => $this->id,
            'type_id' => $type_id
        ]);
    }

    public function sendPhoneVerification($phone, $method = Verification::METHOD_SMS) {
        $verfication = $this->createVerification(Verification::TYPE_PHONE, $phone, $method);
        $verfication->deliver();

        return $verfication;
    }

    public function sendEmailVerification() {
        if ($this->isVerified()) return true;

        // create a email verification request
        $verification = $this->createVerification(Verification::TYPE_EMAIL, $this->email, Verification::METHOD_EMAIL);
        $verification->deliver();

        return $verification;

        return false;
    }

    public function createVerification($type_id, $to, $method = Verification::METHOD_EMAIL) {
        // check for existing request
        $existing_request = $this->getVerification($type_id);
        if ($existing_request) {
            if ($existing_request->method !== $method) {
                $existing_request->fail('Method has changed');
            } else return $existing_request;
        }

        $data = [
            'user_id' => $this->id,
            'to' => $to,
            'method' => $method,
            'type' => $type_id
        ];

        $signature = base64_encode(json_encode($data));

        return Verification::insert([
            'user_id' => $this->id,
            'type_id' => $type_id,
            'message' => 'Verification created',
            'to' => $to,
            'token' => token(),
            'method' => $method,
            'signature' => $signature
        ]);
    }

    public function getName() {
        $parts = [$this->firstname, $this->lastname];
        return $this->firstname ? implode(' ', $parts) : $this->username;
    }

    public function makeSaltedPassword($password) {
        $salt = hash('sha256', $this->id.$this->email);;
        return $salt.':'.$password;
    }

    public static function getPasswordRequirements() {
        return [
            self::PASSWORD_VALIDATION_LENGTH => 'Must be at least '.self::PASSWORD_MIN_LENGTH.' characters',
            self::PASSWORD_VALIDATION_NUMBER => 'Must contain at least 1 number',
            self::PASSWORD_VALIDATION_SYMBOL => 'Must contain at least 1 symbol',
            self::PASSWORD_VALIDATION_UPPERCASE => 'Must contain at least 1 uppercase letter'
        ];;
    }

    public static function validatePassword($password, &$errors) {
        if (!$password) {
            $errors = ['Password cannot be empty.'];
            return false;
        }

        $errors = [];

        $validators = [
            self::PASSWORD_VALIDATION_LENGTH => function($password) {
                return strlen($password) >= self::PASSWORD_MIN_LENGTH;
            },
            self::PASSWORD_VALIDATION_NUMBER => function($password) {
                return preg_match('/\d+/', $password);
            },
            self::PASSWORD_VALIDATION_SYMBOL => function($password) {
                return preg_match('/[^\w]+/', $password);
            },
            self::PASSWORD_VALIDATION_UPPERCASE => function($password) {
                return preg_match('/[A-Z]+/', $password);
            }
        ];

        $requirements = self::getPasswordRequirements();

        foreach ($requirements as $requirement => $message) {
            $validator = $validators[$requirement] ?? false;
            if ($validator) {
                $valid = $validator($password);
                if (!$valid) $errors[] = $message;
            }
        }

        return $errors ? false : true;
    }

    public function setPassword($password) {
        $salted_password = $this->makeSaltedPassword($password);
        $hash = password_hash($salted_password, PASSWORD_BCRYPT, ['cost' => 11]);
        return $this->update('password', $hash);
    }

    public static function withEmail($email) {
        return self::instance('email', $email);
    }

    public static function withUsername($username) {
        return self::instance('username', $username);
    }

    public function verifyPassword($password) {
        if (!$this->password) throw new \Exception('User does not have a password');

        $salted_password = $this->makeSaltedPassword($password);

        if (password_verify($salted_password, $this->password)) {
            if (password_needs_rehash($this->password, PASSWORD_BCRYPT, ['cost' => 11])) {
                $new_salted_hash = password_hash($salted_password, PASSWORD_BCRYPT, ['cost' => 11]);
                $this->update('password', $new_salted_hash);
            }

            return true;
        } else return false;
    }

    public function createSession($platform) {
        return Session::create($this, $platform);
    }

    public function getAvatarUrl($size = 48) {
        if ($this->avatar_url) return $this->avatar_url;

        $gravatar = new \Common\Gravatar($this->email);
        $gravatar->setSize($size);
        return $gravatar->getUrl();
    }

    public function createAccessToken() {
        $token = sha1(token());

        return AccessToken::insert([
            'user_id' => $this->id,
            'token' => $token
        ]);
    }

    public function validateAccessToken($token) {
        $token = AccessToken::withToken($token);
        return $token && $token->user_id == $this->id;
    }

    public function validateSessionToken($token) {
        $session = Session::instance('token', $token);
        return $session && $session->user_id == $this->id;
    }

    public function notify($subject, $body) {
        if (!$this->email) return false;

        $mailer = new \Common\Mailer;

        $body = \Common\Mailer::formatBody($body, \Common\Mailer::TEMPLATE_DEFAULT);
        return $mailer->submit($this->email, $subject, $body);
    }

    public function createWebSession($platform, $remember = false) {
        $session = $this->createSession($platform);
        $session->setWebSession();

        // create cookie
        if ($remember) $session->setWebCookie();
        return $session;
    }

    public function get() {
        $data = $this->toArray(['id', 'firstname', 'lastname', 'username', 'email', 'created_at']);
        $data = Model::formatDates(array('created_at'), $data, \DateTime::ISO8601);

        $data['fullname'] = $this->getName();
        $data['avatar_url'] = $this->getAvatarUrl();

        $organization = $this->getOrganization();
        $data['organization'] = $organization ? $organization->name : null;

        return $data;
    }
}