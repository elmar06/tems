<?php
class TransferRecord
{
	private $conn;
	private $table_name = "transfer";

	public $id;
	public $project;
	public $tool_id;
	public $tool_code;
	public $tool_desc;
	public $borrow_code;
	public $borrow_name;
	public $date_borrow;
	public $returned_by;
	public $date_return;
	public $add_by;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function save_transfer_record()
	{
		$query = "INSERT INTO ".$this->table_name." SET transfer_id=?, to_id=?, from_id=?, asset_id=?, quantity=?, price=?, reason=?, transfer_date=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->transfer_id);
		$ins->bindParam(2, $this->to_id);
		$ins->bindParam(3, $this->from_id);
		$ins->bindParam(4, $this->asset_id);
		$ins->bindParam(5, $this->quantity);
		$ins->bindParam(6, $this->price);
		$ins->bindParam(7, $this->reason);
		$ins->bindParam(8, $this->transfer_date);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_records()
	{
		$query = "SELECT id, transfer_id, to_id, from_id, asset_id, quantity, price, reason, transfer_date FROM transfer WHERE asset_id = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->asset_id);

		$sel->execute();
		return $sel;
	}

	public function get_last_transfer_id()
	{
		$query = "SELECT max(transfer_id + 1) as 'transfer_id' FROM transfer";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
	} 

	public function get_records_report($from, $to, $project, $add_by)
	{
		$query = 'SELECT records.project, records.tool_id, records.tool_code, records.tool_desc, records.borrow_code, records.borrow_name, records.date_borrow, records.returned_by, records.date_return, records.add_by, records.status, location.location as "project", CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM records, location, users WHERE records.project=location.id AND records.add_by=users.id AND (records.date_borrow BETWEEN ? AND ? AND records.project=? AND records.add_by=?) ORDER BY records.date_borrow DESC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $project, $add_by));
		return $sel;
	}
}
?>