<?php
class Records
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

	public function get_records()
	{
		$query = "SELECT id, transfer_id, to_id, from_id, asset_id, quantity, price, reason, transfer_date FROM transfer WHERE asset_id = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->asset_id);

		$sel->execute();
		return $sel;
	}

	public function view_transfer_records()
	{
		$query = 'SELECT * FROM transfer ORDER BY id DESC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
	}

	public function get_records_report_byDate($from, $to)
	{
		$query = 'SELECT transfer.asset_id, asset.code, asset.description, CONCAT(from1.firstname, " ", from1.lastname) as "from", CONCAT(to1.firstname, " ", to1.lastname) as "to", loc1.location as "cur-location", loc2.location as "new-location", transfer.reason, transfer.transfer_date 
		FROM transfer
		INNER JOIN asset ON transfer.asset_id = asset.id
		INNER JOIN personnel as from1 ON transfer.from_id = from1.id
		INNER JOIN personnel as to1 ON transfer.to_id = to1.id
		INNER JOIN location as loc1 ON transfer.cur_proj = loc1.id
		INNER JOIN location as loc2 ON transfer.new_proj = loc2.id
		WHERE transfer.transfer_date BETWEEN ? AND ?
		ORDER BY transfer.transfer_date DESC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to));
		return $sel;
	}

}
?>