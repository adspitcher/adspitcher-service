<?php
/**
 * Class holding various required constants.
 * @author Rachna Khokhar
 *
 */
class App_Constant{
	
	//Text messages for json response framed.
	public static $TEXT_SUCCESS_RESPONSE = 'success';
	public static $TEXT_ERROR_RESPONSE = 'error';
	
	//Text messages send on success or error.
	public static $TEXT_LOGIN_SUCCESS_RESPONSE = 'login successfull';
	public static $TEXT_LOGIN_ERROR_RESPONSE = 'please provide valid credentials';
	public static $TEXT_NO_DATA_FOUND_RESPONSE = 'no data found';
	
	//Database details
	public static $DATABASE_HOST = 'localhost';
	public static $DATABASE_USER = 'root';
	public static $DATABASE_PASSWORD = 'tcs@1234';
	public static $DATABASE_DB = 'db_adspitcher';
	public static $DATABASE_PORT = 3306;
	//public static $DATABASE_SOCKET = 'socket val';
	
	//Exception Messages
	public static $ERROR_FAIL_DB_CONNECTION = 'Failed to connect to MYSQL. ';
	public static $ERROR_FAIL_DB_IMPROPER_CLIENT_REQUEST = 'Improper JSON request from client.';
}