<?php

// 单例模式是设计模式中比较常见的一种设计模式，如常用到的数据库连接等

class DB
{
	private static $_instance;
	private static $_dbConnect;

	private $_dbConfig = [
		'host' => '127.0.0.1',
		'user' => 'root',
		'password' => 'root',
		'database' => 'test'
	];

	private function __construct(){}

	private function __clone(){}

	public static function getInstance()
	{
		if (!self::$_instance instanceof self) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function connect()
	{
		self::$_dbConnect = @mysql_connect($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password']);

		if (!self::$_dbConnect) {
			throw new Exception("Mysql connect error" . mysql_error());
		}

		mysql_query('SET NAMES UTF8');
		mysql_select_db($this->_dbConfig['database'], self::_dbConnect);
		return self::$_dbConnect;
	}
}

$db = DB::getInstance();

try {
	$db->connect();
} catch (\Exception $e) {
	// TODO
}