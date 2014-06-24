<?php

/**
 * Net Request Utility to handle both POST and GET Http requests.
 * @author Rachna Khokhar
 *
 */
class Netrequest_Utility {
	
	// URL Elements
	public $url_elements;
	// Request Method POST or GET
	public $request_method;
	// Parameters send along with the request
	public $parameters;
	
	/**
	 * Construct the NetRequest Utility Object
	 */
	public function __construct() {
		$this->request_method = $_SERVER ['REQUEST_METHOD'];
		$this->url_elements = explode ( '/', $_SERVER ['PATH_INFO'] );
		$this->parseIncomingParams ();
		// Initialise json as default format
		$this->format = 'json';
		if (isset ( $this->parameters ['format'] )) {
			$this->format = $this->parameters ['format'];
		}
	}
	
	/**
	 * Method to parse the parameters of GET Request or Fetch POST data
	 */
	private function parseIncomingParams() {
		$parameters = array ();
		
		// First of all, pull the GET vars
		if (isset ( $_SERVER ['QUERY_STRING'] )) {
			parse_str ( $_SERVER ['QUERY_STRING'], $parameters );
		}
		
		// Now how about PUT/POST bodies? These override what we got from GET
		$body = file_get_contents ( "php://input" );
		$content_type = false;
		if (isset ( $_SERVER ['CONTENT_TYPE'] )) {
			$content_type = $_SERVER ['CONTENT_TYPE'];
		}
		switch ($content_type) {
			case "application/json" :
				{
					try {
						$body_params = json_decode ( $body );
						if ($body_params) {
							foreach ( $body_params as $param_name => $param_value ) {
								$parameters [$param_name] = $param_value;
							}
						}
						$this->format = "json";
					} catch (Exception $exception) {
						$errorResponse = array();
						$errorResponse['response'] = App_Constant::$TEXT_ERROR_RESPONSE;
						$errorResponse['message'] = App_Constant::$ERROR_FAIL_DB_IMPROPER_CLIENT_REQUEST;
						return $errorResponse;
					}
					
				}
				break;
			default :
				// we could parse other supported formats here
				break;
		}
		$this->parameters = $parameters;
	}
}