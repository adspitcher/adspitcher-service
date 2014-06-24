<?php
/**
 * Model to request SQL Database for Login query.
 * @author Rachna Khokhar
 *
 */
class AuthenticateUser_Model{

	/**
	 * Holds instance of database connection
	 */
	private $db;

	/**
	 * Construct
	 */
	public function __construct()
	{
		$this->db = new MysqlImproved_Driver;
	}

	/**
	 * Method to get user details from database.
	 * @param $data
	 * @return response from mysql
	 */
	public function get_user($data)
	{ 
		//username password from server request
		$username = $data['username'];
		$password = $data['password'];

		//connect to database
		$status = $this->db->connect();

		//sanitize data
		$username = $this->db->escape($username);

		//prepare query
		$this->db->prepare
		(
				"
				SELECT
				`col_username`,
				`col_userpassword`
				FROM
				`tb_user_authenticate_credentials`
				WHERE
				`col_username` = '$username'
				;
				"
		);

		//execute query
		$this->db->query();

		//fetch user details
		$user = $this->db->fetchSingleObj('assoc');

		//disconnect database connection
		$this->db->disconnect();

		return $user;
	}

}