<?php
class Location
{
	private $conn;
	private $table_name = "location";

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function save_location()
	{
		$query = "INSERT INTO ".$this->table_name." SET id=?, location=?, code=?, status=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->id);
		$ins->bindParam(2, $this->location);
		$ins->bindParam(3, $this->code);
		$ins->bindParam(4, $this->status);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function upd_location()
	{
		$query = "UPDATE ".$this->table_name." SET location=?, code=? WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->location);
		$upd->bindParam(2, $this->code);
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

	public function del_location()
	{
		$query = "UPDATE ".$this->table_name." SET status=? WHERE id=?";
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

	public function view_loc()
	{
		$query = "SELECT id, location, code, status FROM location WHERE status != 0 ORDER BY location ASC";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel=$this->conn->prepare($query);

		$sel->bindParam(1, $this->status);

		$sel->execute();
		return $sel;
	}

	public function view_loc_byID()
	{
		$query = "SELECT id, location, code, status FROM location WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel=$this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function get_loc_id()
	{
		$query = "SELECT max(id) + 1 as 'loc_id' FROM location";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
	}

	public function get_location_name()
	{
		$query = "SELECT id, location, code FROM location WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}
}
?>