<?php
class Department
{
	private $connMain;
	private $table_name = "departments";

	public $id;
	public $dept_code;
	public $dept_nmae;
	public $status;

	public function __construct($db)
	{
		$this->connMain = $db;
	}

	public function view_dept()
	{
		$query = "SELECT id, dept_code, dept_name FROM departments WHERE status != 0 ORDER BY dept_name ASC";
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

		$sel->bindParam(1, $this->status);

		$sel->execute();
		return $sel;
	}

	public function get_dept_name()
	{
		$query = "SELECT id, dept_code, dept_name FROM departments WHERE id=?";
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function view_trade()
	{
		$query = "SELECT * FROM trades WHERE status != 0";
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

		$sel->execute();
		return $sel;
	}
}
?>