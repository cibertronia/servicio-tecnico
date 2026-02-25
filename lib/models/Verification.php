<?php

namespace Models;
use \Common\Mailer;

class Verification extends Model {

	const TYPE_PASSWORD_RESET = 1;
	const TYPE_EMAIL = 2;
	const TYPE_PHONE = 3;
	const TYPE_2FA = 4;

	const METHOD_SMS = 'sms';
	const METHOD_CALL = 'call';
	const METHOD_EMAIL = 'email';

	public function fail($message) {
		$this->update('message', $message);
		return $this->delete();
	}

	public function complete($message = 'Verification completed') {
		return $this->update([
			'message' => $message,
			'completed_at' => dt('now')
		]);
	}

	public function isCompleted() {
		return $this->completed_at ? true : false;
	}

	public function isExpired() {
		$type = self::$db->row("
			SELECT *
			FROM verification_types
			WHERE active = 1
				AND id = :type_id
		", ['type_id' => $this->type_id]);

		$timeout = strtotime($this->created_at) + $type->timeout;
		return time() >= $timeout;
	}

	public function isValid() {
		return !$this->isExpired() && !$this->completed_at;
	}

	public function getUser() {
		return User::instance($this->user_id);
	}

	public function deliverPhoneVerification() {
		if (!(TWILIO_ACCOUNT_SID && TWILIO_AUTH_TOKEN)) throw new \Exception('Twilio Verify API is not configured');
		$twilio = new \Twilio\Rest\Client(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);

		$verification = $twilio->verify->v2->services(TWILIO_VERIFY_SERVICE_ID)
           ->verifications
           ->create($this->to, $this->method);

		if ($verification) {
			$this->update('code', $verification->sid);
			return true;
		}

		throw new \Exception('Failed to initiate verification');
	}

	public function deliver2faVerification() {
		if ($this->method === self::METHOD_EMAIL) {
			$user = $this->getUser();
			$code = random_int(100000, 999999);

	        $mailer = new Mailer;
	        $message = Mailer::formatBody([
	        	'code' => $code,
	        	'name' => $user->firstname
	        ], Mailer::TEMPLATE_2FA_CODE);

	        $result = $mailer->submit($this->to, '['.APP_TITLE.'] 2FA Verification Code', $message);
	        if ($result) {

	        	// we hash the stored code instead
	        	$hash_code = hash_hmac('sha256', $code, $this->token);
	        	$this->update('code', $hash_code);
	        	return true;
	        }

		} else {
			if (!(TWILIO_ACCOUNT_SID && TWILIO_AUTH_TOKEN)) throw new \Exception('Twilio Verify API is not configured');
			$twilio = new \Twilio\Rest\Client(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);

			$verification = $twilio->verify->v2->services(TWILIO_2FA_SERVICE_ID)
	           ->verifications
	           ->create($this->to, $this->method);

			if ($verification) {
				$this->update('code', $verification->sid);
				return true;
			}
		}

		throw new \Exception('Failed to initiate verification');
	}

	public function deliverEmailVerification() {
		$user = $this->getUser();

		$code = token();
		$key = hash_hmac('sha256', $code, $this->token);

		$verify_url = APP_URL.'/php_security_email_verify.php?action=validate&key='.$key.'&email='.urlencode($this->to);
        $mailer = new Mailer;
        $message = Mailer::formatBody([
            'url' => $verify_url,
            'name' => $user->firstname
        ], Mailer::TEMPLATE_VERIFY_EMAIL);

        $result = $mailer->submit($this->to, '['.APP_TITLE.'] Verify Your Account', $message);
        if ($result) {
        	$this->update('code', $code);
        	return true;
        }

        throw new \Exception('Failed to send email');
	}

	public function deliver() {
		try {
			switch ($this->type_id) {
				case self::TYPE_EMAIL:
					return $this->deliverEmailVerification();
					break;

				case self::TYPE_PHONE:
					return $this->deliverPhoneVerification();
					break;

				case self::TYPE_2FA:
					return $this->deliver2faVerification();
					break;

				default:
					throw new \Exception('Request is not supported.');
					break;
			}

		} catch (\Exception $ex) {
			$this->fail($ex->getMessage());
			if (__DEV__ || __TEST__) throw $ex;
			throw new \Exception('Failed to deliver verification request.');
		}
	}

	public function verify($input) {
		try {
			switch ($this->type_id) {
				case self::TYPE_EMAIL:
					$verified = hash_hmac('sha256', $this->code, $this->token) === $input;
					if ($verified) return $this->complete();

					break;

				case self::TYPE_PHONE:
				case self::TYPE_2FA:

		            	if ($this->method === self::METHOD_EMAIL) {
							$verified = $this->code === hash_hmac('sha256', $input, $this->token);
							if ($verified) return $this->complete();

						} else {
							if (!(TWILIO_ACCOUNT_SID && TWILIO_AUTH_TOKEN)) throw new \Exception('Twilio Verify API is not configured');
							$twilio = new \Twilio\Rest\Client(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);

		            		$twilio_service_id = $this->type_id == self::TYPE_PHONE ? TWILIO_VERIFY_SERVICE_ID : TWILIO_2FA_SERVICE_ID;
			                $verification_check = $twilio->verify->v2->services($twilio_service_id)
			                    ->verificationChecks
			                    ->create($input, ['verificationSid' => $this->code]);

			                if ($verification_check && $verification_check->status === 'approved') {
			                    return $this->complete();
			                }
						}

					break;

				default:
					throw new \Exception('Invalid verification type');
			}

			throw new \Exception('Verification code is incorrect');

		} catch (\Throwable $ex) {
            if (__DEV__) throw $ex;
            throw new \Exception('Verification code is incorrect');
        }
	}

	public function validate($user) {
		if ($this->isValid()) {
			$this_user = $this->getUser();
			$data = json_decode(base64_decode($this->signature));
			if ($data && $this_user->id == $user->id) {
				$verified = $data->user_id == $user->id &&
					$data->to == $this->to &&
					$data->type == $this->type_id &&
					$data->method == $this->method;

				if ($verified) return true;
				else throw new \Exception('Unable to validate the request.');
			} else throw new \Exception('The verification request contains invalid data.');
		} else throw new \Exception('The verification request is no longer valid');
	}

    public function get() {
        $data = $this->toArray(['id', 'name', 'created_at']);
        $data = Model::formatDates(['created_at'], $data, \DateTime::ISO8601);

        return $data;
    }
}