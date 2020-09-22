<?php
class Worker
{
	private $conn;
	private $table_name = 'worker';

	public $id;
	public $fullname;
	public $address;
	public $trade;
	public $project;
	public $status;

	public function __construct($db)
	{
		$this->conn = $db;
	}	

	public function save_worker()
	{
		$query = 'INSERT INTO '.$this->table_name.' SET worker_id=?, fullname=?, address=?, trade=?, project=?, status=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->worker_id);
		$ins->bindParam(2, $this->fullname);
		$ins->bindParam(3, $this->address);
		$ins->bindParam(4, $this->trade);
		$ins->bindParam(5, $this->project);
		$ins->bindParam(6, $this->status);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function update_worker()
	{
		$query = 'UPDATE '.$this->table_name.' SET worker_id=?, fullname=?, address=?, trade=?, project=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->worker_id);
		$ins->bindParam(2, $this->fullname);
		$ins->bindParam(3, $this->address);
		$ins->bindParam(4, $this->trade);
		$ins->bindParam(5, $this->project);
		$ins->bindParam(6, $this->id);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function view_worker()
	{
		$query = 'SELECT worker.id as "work-id", worker.fullname, worker.worker_id, worker.address, worker.trade as "trade_id", worker.project as "proj_id", department.id, department.department as "trade_name", location.id, location.location as "proj_name" FROM worker, department, location WHERE worker.trade = department.id AND worker.project = location.id AND worker.status != 0 ORDER BY fullname ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
	}

	public function get_worker_data()
	{
		$query = 'SELECT worker.id as "work-id", worker.fullname, worker.worker_id, worker.address, worker.trade as "trade_id", worker.project as "proj_id", department.id, department.department as "trade_name", location.id, location.location as "proj_name" FROM worker, department, location WHERE worker.trade = department.id AND worker.project = location.id AND worker.status != 0 AND worker.id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}
}
?>