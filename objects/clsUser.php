<?php
class Users
{
	private $conn;
	private $table_name = "users";

	public $id;
	public $firstname;
	public $lastname;
	public $username;
	public $password;
	public $log_count;
	public $status;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function save_user()
	{
		$query = "INSERT INTO ".$this->table_name." SET firstname=?, lastname=?, username=?, password=?, log_count=?, access_type=?, access_cat=?, proj_id=?, status=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->firstname);
		$ins->bindParam(2, $this->lastname);
		$ins->bindParam(3, $this->username);
		$ins->bindParam(4, $this->password);
		$ins->bindParam(5, $this->log_count);
		$ins->bindParam(6, $this->access_type);		
		$ins->bindParam(7, $this->access_cat);
		$ins->bindParam(8, $this->proj_id);
		$ins->bindParam(9, $this->status);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function upd_user()
	{
		$query = "UPDATE ".$this->table_name." SET firstname=?, lastname=?, username=?, password=?, access_type=?, access_cat=? WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->firstname);
		$upd->bindParam(2, $this->lastname);
		$upd->bindParam(3, $this->username);
		$upd->bindParam(4, $this->password);
		$upd->bindParam(5, $this->access_type);
		$upd->bindParam(6, $this->access_cat);
		$upd->bindParam(7, $this->id);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function upd_user_detail()
	{
		$query = "UPDATE ".$this->table_name." SET firstname=?, lastname=?, username=?, access_type=? WHERE id = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->firstname);
		$upd->bindParam(2, $this->lastname);
		$upd->bindParam(3, $this->username);
		$upd->bindParam(4, $this->access_type);
		$upd->bindParam(5, $this->id);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function del_user()
	{
		$query = "UPDATE ".$this->table_name." SET status = ? WHERE id = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$del = $this->conn->prepare($query);

		$del->bindParam(1, $this->status);
		$del->bindParam(2, $this->id);

		if($del->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function view_user()
	{
		$query = "SELECT id, firstname, lastname, username, access_type FROM users WHERE status != 0 ORDER BY access_type ASC";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
	}

	public function view_user_byID()
	{
		$query = "SELECT id, firstname, lastname, username, access_type FROM users WHERE id = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function upd_pass()
	{
		$query = "UPDATE ".$this->table_name." SET password=?, log_count = log_count + 1 WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->password);
		$upd->bindParam(2, $this->id);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function upd_pass_later()
	{
		$query = "UPDATE ".$this->table_name." SET log_count = log_count + 1 WHERE id = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->id);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function login()
	{
		$query = "SELECT users.id , CONCAT(users.firstname, ' ', users.lastname) AS fullname, users.firstname, users.lastname, users.username, users.log_count, users.access_type, users.proj_id, location.location as 'proj_loc', users.status FROM users, location WHERE users.username = ?  AND users.password = ? AND users.proj_id = location.id AND users.status != ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel=$this->conn->prepare($query);

		$sel->bindParam(1, $this->username);
		$sel->bindParam(2, $this->password);
		$sel->bindParam(3, $this->status);

		$sel->execute();
		return $sel;	
	}

	public function logout()
	{
		session_start();
		if(session_destroy())
		{
			return true;
			unset($_SESSION['username']);
		}
		else
		{
			return false;
		}
	}

	public function get_access()
	{
		$query = "SELECT id, access_type, log_count FROM ".$this->table_name." WHERE username=? and status !=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->username);
		$sel->bindParam(2, $this->status);

		$sel->execute();
		return $sel;
	}

	public function isloggedin()
	{
		session_start();
		if(isset($_SESSION['username']))
		{
			return true;
		}
	}
}
?>