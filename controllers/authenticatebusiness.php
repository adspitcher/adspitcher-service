<?php
/**
 * Login Controller to handle GET or POST Action for Login.
 * @author Rachna Khokhar
 *
 */
class AuthenticateBusiness_Controller {
	
	// Login Model Instance
	private $authenticateBusinessModel;
	
	/**
	 * Function to call to initialize login model.
	 */
	public function main() {
		$this->authenticateBusinessModel = new AuthenticateBusiness_Model();
	}
	
	/**
	 * Method to be called on GET request.
	 * 
	 * @param
	 *        	$request
	 */
	public function getAction($request) {
	}
	
	/**
	 * Method to be called on POST request.
	 * @param $request
	 * @return multitype:string
	 */
	public function postAction($request) {
		$userData = $this->authenticateBusinessModel->get_user ( $request->parameters );
		
		$data = $request->parameters;
		$requestUsername = $data ['username'];
		$requestPassword = $data ['password'];
		
		$responseUsername = $userData ['username'];
		$responsePassword = $userData ['password'];
		
		$finalResponse = array ();
		if (strcmp ( $requestPassword, $responsePassword ) == 0) {
			$finalResponse ['response'] = App_Constant::$TEXT_SUCCESS_RESPONSE;
			$finalResponse ['message'] = App_Constant::$TEXT_LOGIN_SUCCESS_RESPONSE;
		} else {
			$finalResponse ['response'] = App_Constant::$TEXT_ERROR_RESPONSE;
			$finalResponse ['message'] = App_Constant::$TEXT_LOGIN_ERROR_RESPONSE;
		}
		
		return $finalResponse;
	}
}