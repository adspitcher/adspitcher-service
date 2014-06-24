<?php
/**
 * The MySQL Improved driver extends the Database_Library to provide
 * interaction with a MySQL database
 */
class MysqlImproved_Driver extends Database_Library {
	/**
	 * Connection holds MySQLi resource
	 */
	private $connection;
	
	/**
	 * Query to perform
	 */
	private $query;
	
	/**
	 * Result holds data retrieved from server
	 */
	private $result;
	
	/**
	 * Create new connection to database
	 */
	public function connect() {
		// connection parameters
		$host = App_Constant::$DATABASE_HOST;
		$user = App_Constant::$DATABASE_USER;
		$password = App_Constant::$DATABASE_PASSWORD;
		$database = App_Constant::$DATABASE_DB;
		$port = App_Constant::$DATABASE_PORT;
		// $socket = App_Constant::$DATABASE_SOCKET;
		
		// create new connection with specified database details.
		try {
			$this->connection = mysqli_connect ( $host, $user, $password, $database, $port );
		} catch ( Exception $e ) {
			throw new Exception ( App_Constant::$ERROR_FAIL_DB_CONNECTION . mysqli_connect_error () );
		}
		
		/*
		 * if (mysqli_connect_errno()) { throw new Exception(App_Constant::$ERROR_FAIL_DB_CONNECTION . mysqli_connect_error()); }
		 */
	}
	
	/**
	 * Break connection to database
	 */
	public function disconnect() {
		// clean up connection!
		$this->connection->close ();
		
		return TRUE;
	}
	
	/**
	 * Prepare query to execute
	 *
	 * @param
	 *        	$query
	 */
	public function prepare($query) {
		// store query in query variable
		$this->query = $query;
		
		return TRUE;
	}
	
	/**
	 * Execute a prepared query
	 */
	public function query() {
		if (isset ( $this->query )) {
			// execute prepared query and store in result variable
			$this->result = mysqli_query ( $this->connection, $this->query );
			return TRUE;
		}
		
		return FALSE;
	}
	
	/**
	 * Fetch a row from the query result
	 *
	 * @param
	 *        	$type
	 */
	public function fetch($type = 'object') {
		if (isset ( $this->result )) {
			switch ($type) {
				case 'array' :
					
					// fetch a row as array
					$datarows = array ();
					while ( $row = mysqli_fetch_array ( $this->result ) ) {
						$datarows [] = $row;
					}
					break;
				
				case 'assoc' :
					$datarows = array ();
					while ( $row = mysqli_fetch_assoc ( $this->result ) ) {
						$datarows [] = $row;
					}
					break;
				
				case 'object' :
				
				// fall through...
				
				default :
					// fetch a row as object
					$row = mysqli_fetch_object ( $this->result );
					break;
			}
			
			return $datarows;
		}
		
		return FALSE;
	}
	
	/**
	 * Method to fetch single object from database
	 * @param string $type
	 * @return unknown|boolean
	 */
	public function fetchSingleObj($type = 'object') {
		if (isset ( $this->result )) {
			switch ($type) {
				case 'array' :
					
					// fetch a row as array
					$row = $this->result->fetch_array ();
					break;
				
				case 'assoc' :
					$row = mysqli_fetch_assoc ( $this->result );
					break;
				
				case 'object' :
				
				// fall through...
				
				default :
					// fetch a row as object
					// $row = $this->result->fetch_object();
					$row = mysqli_fetch_object ( $this->result );
					break;
			}
			
			return $row;
		}
		return FALSE;
	}
	
	/**
	 * Sanitize data to be used in a query
	 *
	 * @param
	 *        	$data
	 */
	public function escape($data) {
		return $this->connection->real_escape_string ( $data );
	}
}