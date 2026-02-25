<?php

namespace Models;

class AccessToken extends Model {
	public static function withToken($token) {
		return parent::instance('token', $token);
	}
}

?>