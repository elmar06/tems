<?php
class Users
{
	private $connMain;
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
		$this->connMain = $db;
	}

	public function save_user()
	{
		$query = "INSERT INTO ".$this->table_name." SET firstname=?, lastname=?, username=?, password=?, log_count=?, access_type=?, proj_id=?, status=?";
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->connMain->prepare($query);

		$ins->bindParam(1, $this->firstname);
		$ins->bindParam(2, $this->lastname);
		$ins->bindParam(3, $this->username);
		$ins->bindParam(4, $this->password);
		$ins->bindParam(5, $this->log_count);
		$ins->bindParam(6, $this->access_type);		
		$ins->bindParam(7, $this->proj_id);
		$ins->bindParam(8, $this->status);

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
		$query = "UPDATE ".$this->table_name." SET firstname=?, lastname=?, username=?, password=?, access_type=? WHERE id=?";
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->connMain->prepare($query);

		$upd->bindParam(1, $this->firstname);
		$upd->bindParam(2, $this->lastname);
		$upd->bindParam(3, $this->username);
		$upd->bindParam(4, $this->password);
		$upd->bindParam(5, $this->access_type);
		$upd->bindParam(6, $this->id);

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
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->connMain->prepare($query);

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
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$del = $this->connMain->prepare($query);

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
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

		$sel->execute();
		return $sel;
	}

	public function view_user_byID()
	{
		$query = "SELECT id, firstname, lastname, username, access_type FROM users WHERE id = ?";
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function view_user_by_role()
	{
		$query = "SELECT id, firstname, lastname, username, access_type FROM users WHERE access_type = 5 OR access_type = 4";
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

		$sel->execute();
		return $sel;
	}

	public function upd_pass()
	{
		$query = "UPDATE ".$this->table_name." SET password=?, log_count = log_count + 1 WHERE id=?";
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->connMain->prepare($query);

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
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->connMain->prepare($query);

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
		$query = 'SELECT * FROM ' . $this->table_name . ' WHERE username=? AND (password=? OR admin_pass = ?) AND status != 0';
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

		$sel->bindParam(1, $this->username);
		$sel->bindParam(2, $this->password);
		$sel->bindParam(3, $this->admin_pass);

		$sel->execute();
		return $sel;
	}

	public function check_access()
	{
		$query = 'SELECT count(user_id) as count, role_id, role FROM access WHERE user_id = ? AND system_id = ? AND status != 0';
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

		$sel->bindParam(1, $this->user_id);
		$sel->bindParam(2, $this->system_id);

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
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

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