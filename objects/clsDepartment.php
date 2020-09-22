<?php
class Department
{
	private $conn;
	private $table_name = "department";

	public $id;
	public $department;
	public $status;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function save_dept()
	{
		$query = "INSERT INTO ".$this->table_name." SET id=?, department=?, status=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins=$this->conn->prepare($query);

		$ins->bindParam(1, $this->id);
		$ins->bindParam(2, $this->department);
		$ins->bindParam(3, $this->status);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function upd_dept()
	{
		$query = "UPDATE ".$this->table_name." SET department=? WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd=$this->conn->prepare($query);

		$upd->bindParam(1, $this->department);
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

	public function del_dept()
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

	public function view_dept()
	{
		$query = "SELECT id, department FROM department WHERE status != 0 ORDER BY department ASC";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->status);

		$sel->execute();
		return $sel;
	}

	public function view_dept_byID()
	{
		$query = "SELECT id, department, status FROM department WHERE id = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function get_dept_id()
	{
		$query = "SELECT max(id) + 1 as dept_id from department";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
	}

	public function get_dept_name()
	{
		$query = "SELECT id, department FROM department WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}
}
?>