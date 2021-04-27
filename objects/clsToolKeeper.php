<?php
class ToolKeeper
{
	private $conn;
	private $table_name = 'borrow_log';

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
		$query = 'INSERT INTO '.$this->table_name.' SET tool_code=?, borrower_code=?, date_borrow=?, status=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->tool_code);
		$ins->bindParam(2, $this->borrower_code);
		$ins->bindParam(3, $this->date_borrow);
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

	public function return_tool()
	{
		$query = 'UPDATE '.$this->table_name.' SET status = ? WHERE tool_code = ? AND borrower_code = ? AND date_borrow = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->status);
		$upd->bindParam(2, $this->tool_code);
		$upd->bindParam(3, $this->borrower_code);
		$upd->bindParam(4, $this->date_borrow);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}	
}
?>