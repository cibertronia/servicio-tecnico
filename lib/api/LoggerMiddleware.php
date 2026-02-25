<?php

namespace API;

class LoggerMiddleware {

    private $_container;

    public function __construct(\Slim\App $api_app) {
        $this->_container = $api_app->getContainer();
    }

    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {
    	if ($this->_container->has('app')) {
    		$app = $this->_container->get('app');
	    	$access_token = $this->_container->get('access_token');

	    	// Begin of time
			$start = microtime(true);
			// URL accessed
			$path = $request->getUri();
			// Call next middleware
			$response = $next($request, $response);
			// End of time
			$end = microtime(true);
			// Latency
			$latency = $end - $start;
			// Client IP address
			$client_ip = \Common\Util::get_client_ip();
			// Method access
			$method = $request->getMethod();

			\App\App::log_api($access_token, [
				'path' => $path,
				'latency' => $latency,
				'ip' =>  $client_ip,
				'method' => $method,
				'status' => $response->getStatusCode(),
				'body' => (string)$response->getBody(),
				'user_agent' => $request->getHeaderLine('User-Agent')
			]);
    	} else {
    		$response = $next($request, $response);
    	}

		return $response;
    }

}