<?php
class ToolKeeper
{
	private $conn;
	private $table_name = 'records';

	public $id;
	public $tool_code;
	public $borrower_code;
	public $date_borrow;
	public $date_return;
	public $status;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function get_tool_detail()
	{
		$query = 'SELECT * FROM asset WHERE code = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$get = $this->conn->prepare($query);

		$get->bindParam(1, $this->code);

		$get->execute();
		return $get;
	}

	public function get_worker_detail()
	{
		$query = 'SELECT worker.fullname, department.department as "trade" FROM worker, department WHERE worker.trade=department.id AND worker_id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$get = $this->conn->prepare($query);

		$get->bindParam(1, $this->worker_id);

		$get->execute();
		return $get;
	}

	public function borrow_tool()
	{
		$query = 'INSERT INTO '.$this->table_name.' SET tool_id=?, tool_code=?, tool_desc=?, borrow_code=?, borrow_name=?, date_borrow=?, status=2';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->tool_id);
		$ins->bindParam(2, $this->tool_code);
		$ins->bindParam(3, $this->tool_desc);
		$ins->bindParam(4, $this->borrow_code);
		$ins->bindParam(5, $this->borrow_name);
		$ins->bindParam(6, $this->date_borrow);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function return_tool()
	{
		$query = 'UPDATE '.$this->table_name.' SET returned_by=?, date_return=?, status=1 WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->returned_by);
		$upd->bindParam(2, $this->date_return);
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

	public function check_record()
	{
		$query = 'SELECT * FROM '.$this->table_name.' WHERE tool_id=? AND tool_code=? AND date_return is null';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->tool_id);
		$sel->bindParam(2, $this->tool_code);

		$sel->execute();
		return $sel;
	}

	public function view_records()
	{
		$query = 'SELECT * FROM '.$this->table_name.' WHERE status != 0 ORDER BY date_borrow DESC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
	}
}
?>