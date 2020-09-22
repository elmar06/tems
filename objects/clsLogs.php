<?php
class Logs
{
	private $conn;
	private $table_name = 'logs';

	public $id;
	public $loc_id;//project/building
	public $type_id;//category
	public $series_no;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function check_if_exist()
	{
		$query = 'SELECT COUNT(*) FROM logs WHERE loc_id = ? AND type_id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->loc_id);
		$sel->bindParam(2, $this->type_id);

		$sel->execute();
		return $sel;
	}

	public function save_logs()
	{
		$query = 'INSERT INTO '.$this->table_name.' SET loc_id=?, type_id=?, series_no=?, status=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->loc_id);
		$ins->bindParam(2, $this->type_id);
		$ins->bindParam(3, $this->series_no);
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

	public function update_logs()
	{
		$query = 'UPDATE '.$this->table_name.' SET series_no = series_no + 1 WHERE loc_id = ? AND type_id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->loc_id);
		$upd->bindParam(2, $this->type_id);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_series()
	{
		$query = 'SELECT max(series_no) + 1 as "series_no" FROM logs WHERE loc_id=? AND type_id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->loc_id);
		$sel->bindParam(2, $this->type_id);

		$sel->execute();
		return $sel;
	}
}
?>