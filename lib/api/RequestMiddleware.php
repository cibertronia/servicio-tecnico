<?php

namespace API;

class RequestMiddleware {

	public function __invoke($request, $response, $next) {
		// user-agent is required
		if (!$request->hasHeader('User-Agent')) {
		    return $response->withJson([
		    	'message' => 'Please make sure your request has a User-Agent header',
		    	'documentation_url' => DOCS_URL.'/developer#user-agent-required'
		    ], 403, JSON_PRETTY_PRINT);
		}

		$mediaType = $request->getMediaType();
		if ($mediaType !== 'application/json') {
			// modify the body to json
			$body = $request->getBody();
			$request = $request->withParsedBody(json_decode($body));
		}

		return $next($request, $response);
	}
}