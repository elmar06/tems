<?php
class clsConnection
{
	private $host = "localhost";
	private $dbname = "toolsdb";
	private $username = "root";
	private $password = "";

	private $conn;

	public function connect()
	{
		$this->conn = null;

		try
		{
			$this->conn = new PDO("mysql:host=" . $this->host. ";dbname=" . $this->dbname, $this->username, $this->password);
		}
		catch(PDOException $exception)
		{
			echo "Connection error: ". $exception->getMessage();
		}

		return $this->conn;
	}

	public function disconnect()
	{
		$this->conn=null;
		return $this->conn;
	}
}
?>