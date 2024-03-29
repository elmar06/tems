<?php
class Worker
{
	private $conn;
	private $table_name = 'worker';

	public $id;
	public $fullname;
	public $position;
	public $trade;
	public $project;
	public $status;

	public function __construct($db)
	{
		$this->conn = $db;
	}	

	public function save_worker()
	{
		$query = 'INSERT INTO '.$this->table_name.' SET worker_id=?, fullname=?, position=?, trade=?, project=?, status=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->worker_id);
		$ins->bindParam(2, $this->fullname);
		$ins->bindParam(3, $this->position);
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
		$query = 'UPDATE '.$this->table_name.' SET worker_id=?, fullname=?, position=?, trade=?, project=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->worker_id);
		$ins->bindParam(2, $this->fullname);
		$ins->bindParam(3, $this->position);
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
		$query = 'SELECT worker.id as "work-id", worker.fullname, worker.worker_id, worker.position, worker.trade as "trade_id", worker.project as "proj_id", department.id, department.department as "trade_name", location.id, location.location as "proj_name" FROM worker, department, location WHERE worker.trade = department.id AND worker.project = location.id AND worker.status != 0 ORDER BY worker.worker_id ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);
		
		$sel->execute();
		return $sel;
	}

	public function view_worker_by_id()
	{
		$query = 'SELECT worker.id as "work-id", worker.fullname, worker.worker_id, worker.position, worker.trade as "trade_id", worker.project as "proj_id", department.id, department.department as "trade_name", location.id, location.location as "proj_name" FROM worker, department, location WHERE worker.trade = department.id AND worker.project = location.id AND worker.status != 0 AND worker.worker_id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->worker_id);
		
		$sel->execute();
		return $sel;
	}

	public function view_worker_by_proj()
	{
		$query = 'SELECT worker.id as "work-id", worker.fullname, worker.worker_id, worker.position, worker.trade as "trade_id", worker.project as "proj_id", department.id, department.department as "trade_name", location.id, location.location as "proj_name" FROM worker, department, location WHERE worker.trade = department.id AND worker.project = location.id AND worker.status != 0 AND worker.project = ? ORDER BY worker.worker_id ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->project);
		
		$sel->execute();
		return $sel;
	}

	public function get_worker_data()
	{
		$query = 'SELECT worker.id as "work-id", worker.fullname, worker.worker_id, worker.position, worker.trade as "trade_id", worker.project as "proj_id", department.id, department.department as "trade_name", location.id, location.location as "proj_name" FROM worker, department, location WHERE worker.trade = department.id AND worker.project = location.id AND worker.status != 0 AND worker.id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function delete_worker()
	{
		$query = 'UPDATE '.$this->table_name.' SET status=0 WHERE id=?';
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
}
?>