<?php
class Type
{
	private $conn;
	private $table_name = "type";

	public $id;
	public $type;
	public $status;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function save_type()
	{
		$query = "INSERT INTO " .$this->table_name. " SET id=?, type=?, description=?, series_no=?, status=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins=$this->conn->prepare($query);

		$ins->bindParam(1, $this->id);
		$ins->bindParam(2, $this->type);
		$ins->bindParam(3, $this->description);
		$ins->bindParam(4, $this->series_no);
		$ins->bindParam(5, $this->status);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function upd_type()
	{
		$query = "UPDATE " .$this->table_name. " SET type=?, description=? WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd=$this->conn->prepare($query);

		$upd->bindParam(1, $this->type);
		$upd->bindParam(2, $this->description);
		$upd->bindParam(3, $this->id);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function upd_series_no()
	{
		$query = "UPDATE " .$this->table_name. " SET series_no = series_no + 1 WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd=$this->conn->prepare($query);

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

	public function delete_type()
	{
		$query = "UPDATE " .$this->table_name. " SET status=? WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$del=$this->conn->prepare($query);

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

	public function view_type()
	{
		$query = "SELECT id, type_id, type, description, status FROM type WHERE type.status != 0 ORDER BY type.type ASC";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel=$this->conn->prepare($query);

		$sel->bindParam(1, $this->status);

		$sel->execute();
		return $sel;
	}

	public function view_type_by_user()
	{
		$query = "SELECT id, type, created_by, status FROM type WHERE status != 0 AND created_by = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel=$this->conn->prepare($query);

		$sel->bindParam(1, $this->created_by);

		$sel->execute();
		return $sel;
	}

	public function view_type_byid()
	{
		$query = "SELECT id, type, description FROM type WHERE id = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel=$this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function get_type_id()
  	{
	  	$query = "SELECT max(id) + 1 as 'type_id' FROM type";
	  	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	  	$sel = $this->conn->prepare($query);

	  	$sel->execute();
	  	return $sel;
  	}

  	public function get_type_name()
	{
		$query = "SELECT id, type FROM type WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function get_series()
	{
		$query = 'SELECT max(series_no) + 1 as "series_no" FROM type WHERE status != 0 AND type_id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}
}

?>