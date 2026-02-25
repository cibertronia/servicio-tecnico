<?php
define('__DEV__', getenv('ENVIRONMENT') === 'dev');
define('__TEST__', getenv('ENVIRONMENT') === 'test');
define('__LOCAL__', getenv('LOCAL_DEV') === 'true');
define('API_RATE_LIMIT', (int)getenv('API_RATE_LIMIT'));

// database data source
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_PORT', getenv('DB_PORT'));

// security
define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY'));

// email
define('APP_EMAIL_HOST', getenv('APP_EMAIL_HOST'));
define('APP_EMAIL_PORT', getenv('APP_EMAIL_PORT'));
define('APP_EMAIL_USER', getenv('APP_EMAIL_USER'));
define('APP_EMAIL_PASSWORD', getenv('APP_EMAIL_PASSWORD'));
define('APP_EMAIL_SECURE', getenv('APP_EMAIL_SECURE'));
define('APP_EMAIL_MAILER', getenv('APP_EMAIL_MAILER'));
define('APP_EMAIL', getenv('APP_EMAIL'));

define('APP_ALERTS_EMAIL', getenv('APP_ALERTS_EMAIL'));

// app info
define('APP_TITLE', getenv('APP_TITLE'));
define('APP_DESCRIPTION', getenv('APP_DESCRIPTION'));
define('APP_ABOUT', getenv('APP_ABOUT'));

define('APP_THEME', getenv('APP_THEME'));

define('APP_OWNER_NAME', getenv('APP_OWNER_NAME'));
define('APP_OWNER_ADDRESS', getenv('APP_OWNER_ADDRESS'));
define('APP_OWNER_URL', getenv('APP_OWNER_URL'));
define('APP_OWNER_EMAIL', getenv('APP_OWNER_EMAIL'));
define('APP_OWNER_PHONE', getenv('APP_OWNER_PHONE'));

// get app version
$composer_json = json_decode(file_get_contents(ROOT_PATH.'/composer.json'));
define('APP_VERSION', $composer_json ? $composer_json->version : 1);

// Twilio
define('TWILIO_ACCOUNT_SID', getenv('TWILIO_ACCOUNT_SID'));
define('TWILIO_AUTH_TOKEN', getenv('TWILIO_AUTH_TOKEN'));
define('TWILIO_VERIFY_SERVICE_ID', getenv('TWILIO_VERIFY_SERVICE_ID'));
define('TWILIO_2FA_SERVICE_ID', getenv('TWILIO_2FA_SERVICE_ID'));

define('GOOGLE_API_KEY', getenv('GOOGLE_API_KEY'));
define('GOOGLE_MAPS_JS_URL', 'https://maps.googleapis.com/maps/api/js?key='.GOOGLE_API_KEY.'&libraries=visualization&libraries=geometry');
define('GOOGLE_ANALYTICS_ID', getenv('GOOGLE_ANALYTICS_ID'));

define('OAUTH_FACEBOOK_ID', getenv('OAUTH_FACEBOOK_ID'));
define('OAUTH_FACEBOOK_SECRET', getenv('OAUTH_FACEBOOK_SECRET'));

define('OAUTH_GOOGLE_ID', getenv('OAUTH_GOOGLE_ID'));
define('OAUTH_GOOGLE_SECRET', getenv('OAUTH_GOOGLE_SECRET'));

define('AUTH_COOKIE_NAME', getenv('AUTH_COOKIE_NAME'));
define('AUTH_TOKEN_SESSION_NAME', getenv('AUTH_TOKEN_SESSION_NAME'));
define('CSRF_SESSION_NAME', getenv('CSRF_SESSION_NAME'));
define('OAUTH_PROVIDER_SESSION_NAME', getenv('OAUTH_PROVIDER_SESSION_NAME'));