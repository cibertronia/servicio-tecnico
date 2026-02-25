<?php

namespace Models;

use \Common\Util;
use \Twilio\Rest\Client as TClient;

class Session extends Model {

	public function touch() {
		return $this->update('updated_at', dt('now'));
	}

	public static function withToken($token) {
		return parent::instance('token', $token);
	}

	public static function withCookie($value) {
		if ($value) {
			$value = explode('|', $value);
			if (count($value) === 2 && ((int)$value[0] === 0 || (int)$value[0] > time())) {
				$cookie_data = explode('.', trim(decrypt($value[1], $value[0])));
		        if (isset($cookie_data[0]) && isset($cookie_data[1])) {
		        	$token = $cookie_data[0];
		            $session_id = $cookie_data[1];

		            $session = parent::instance($session_id);
		            if ($session && $token === $session->cookie_token) return $session;
		        }
			}
		}

        return false;
	}

	public static function destroyCookie() {
		if (isset($_COOKIE[AUTH_COOKIE_NAME])) {
            setcookie(AUTH_COOKIE_NAME, null, time() -1, '/', '', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on', true);
            unset($_COOKIE[AUTH_COOKIE_NAME]);
        }
	}

	private static function _getHashedUa() {
		$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
		return hash('sha256', $ua);
	}

	public static function create(User $user, $platform = \App\App::PLATFORM_WEB) {
		$detect = new \Mobile_Detect;

		$token = hash('sha256', token());
		$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';

		return self::insert([
			'user_id' => $user->id,
			'token' => $token,
			'ip' => Util::getClientIp(),
			'platform' => $platform,
			'ua' => $ua,
			'ua_hash' => self::_getHashedUa(),
			'is_mobile' => $detect->isMobile() ? 1 : 0,
			'is_tablet' => $detect->isTablet() ? 1 : 0
		]);
	}

	public function sendVerification($method) {
		if ($this->verified) throw new \Exception('This session is already verified');

		$user = $this->getUser();

		// check if verified in order to use a verified email
		if (!$user->isVerified()) throw new \Exception('User account is not verified');

		// use phone by default
		if ($method === Verification::METHOD_EMAIL) {
			$to = $user->email;
		} else {
			if (!$user->hasPhone()) throw new \Exception('User does not have a phone to verify. Use email instead.');
			$to = $user->phone;
		}

		$verification = $user->createVerification(Verification::TYPE_2FA, $to, $method);
		$verification->deliver();

		return $verification;
	}

	public function verify2faCode($code) {
		$user = $this->getUser();
		$verification = $user->getVerification(Verification::TYPE_2FA);
        if ($verification && $verification->validate($user)) {
            $verified = $verification->verify($code);
            if ($verified) {
                $this->setVerification($verification);
                return true;
            }
        }

        return false;
    }

	/**
	 * Update the verified status of the session
	 * @param bool $verified [description]
	 */
	public function setVerification(Verification $verification) {
		return $this->update([
			'verified' => $verification->isCompleted() ? 1 : 0,
			'verification_id' => $verification->id
		]);
	}

	public function shouldVerify() {
		if ($this->verified) return false;

		$known_session = self::row("
			SELECT id, verification_id
			FROM sessions s
			WHERE active = 1
				AND verified = 1
				AND ip = :ip
				AND ua_hash = :ua_hash
				AND id != :session_id -- not this session
		", [
			'ip' => Util::getClientIp(),
			'ua_hash' => self::_getHashedUa(),
			'session_id' => $this->id
		]);

		if ($known_session) {
			$this->update([
				'verified' => 1,
				'verification_id' => $known_session->verification_id
			]);

			return false;
		}

		return true;
	}

	public function isValid() {
		// check user
		$user = $this->getUser();
		if (!$user) return false;

		// other validations like timeout
		// ...

		return true;
	}

	public function getUser() {
		return User::instance($this->user_id);
	}

	// https://stackoverflow.com/questions/244882/what-is-the-best-way-to-implement-remember-me-for-a-website
	public function setWebCookie() {
		$token = token();
		$result = $this->update('cookie_token', $token);
		if ($result) {
			$cookie = $token.'.'.$this->id;

			$cookie_data = $expires.'|'.encrypt($cookie, $expires);
        	setcookie(AUTH_COOKIE_NAME, $cookie_data, $expires, '/', '', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on', true);

        	return true;
		} else return false;
	}

	public function setWebSession() {
		if ($this->platform == \App\App::PLATFORM_WEB) {
			$_SESSION[AUTH_TOKEN_SESSION_NAME] = $this->token;
		}

		return true;
	}

	public function ping() {
		return $this->update('active_at', dt('now'));
	}

	public function destroy() {
		if ($this->platform == \App\App::PLATFORM_WEB) {

			if (isset($_SESSION[OAUTH_PROVIDER_SESSION_NAME])) {
	            $config = \App\App::getOauthConfig($_SESSION[OAUTH_PROVIDER_SESSION_NAME]);
	            $hybridauth = new \Hybridauth\Hybridauth($config);
	            $hybridauth->disconnectAllAdapters();
	        }

			self::destroyCookie();

            session_unset();
            session_destroy();
		}
	}

	public function get() {
        $data = $this->toArray(['id', 'token', 'created_at']);
        $data = Model::formatDates(['created_at'], $data, \DateTime::ISO8601);

        return $data;
    }
}

?>