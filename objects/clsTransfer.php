<?php
class TransferRecord
{
	private $conn;
	private $table_name = "transfer";

	public $id;
	public $transfer_id;
	public $to_id;
	public $from_id;
	public $asset_id;
	public $quantity;
	public $price;
	public $reason;
	public $transfer_date;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function save_transfer_record()
	{
		$query = "INSERT INTO ".$this->table_name." SET transfer_id=?, to_id=?, from_id=?, asset_id=?, quantity=?, price=?, reason=?, cur_proj=?, new_proj=?, transfer_date=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->transfer_id);
		$ins->bindParam(2, $this->to_id);
		$ins->bindParam(3, $this->from_id);
		$ins->bindParam(4, $this->asset_id);
		$ins->bindParam(5, $this->quantity);
		$ins->bindParam(6, $this->price);
		$ins->bindParam(7, $this->reason);
		$ins->bindParam(8, $this->cur_proj);
		$ins->bindParam(9, $this->new_proj);
		$ins->bindParam(10, $this->transfer_date);

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
}
?>