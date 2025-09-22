<?php
class clsConnectionMain
{
	private $host = "192.168.2.2";
	private $dbname = "maindb";
	private $username = "admin";
	private $password = "admin";

	private $connMain;

	public function connectMain()
	{
		$this->connMain = null;

		try {
			$this->connMain = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
			$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $exception) {
			echo "Connection error: " . $exception->getMessage();
		}
		return $this->connMain;
	}
}
