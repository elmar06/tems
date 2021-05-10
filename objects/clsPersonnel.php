<?php
class Personnel
{
	private $connn;
	private $table_name = "personnel";

	public $id;
	public $dept_id;
	public $location_id;
	public $emp_no;
	public $firstname;
	public $lastname;
	public $contact_num;
	public $status;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function save_person()
	{
		$query = "INSERT INTO ".$this->table_name." SET id=?, emp_no=?, firstname=?, lastname=?, contact_num=?, project=?, status=1";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins=$this->conn->prepare($query);

		$ins->bindParam(1, $this->id);
		$ins->bindParam(2, $this->emp_no);
		$ins->bindParam(3, $this->firstname);
		$ins->bindParam(4, $this->lastname);
		$ins->bindParam(5, $this->contact_num);
		$ins->bindParam(6, $this->project);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function upd_person()
	{
		$query = "UPDATE ".$this->table_name." SET emp_no=?, firstname=?, lastname=?, contact_num=?, project=? WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->emp_no);
		$upd->bindParam(2, $this->firstname);
		$upd->bindParam(3, $this->lastname);
		$upd->bindParam(4, $this->contact_num);
		$upd->bindParam(5, $this->project);
		$upd->bindParam(6, $this->id);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function del_person()
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

	public function view_person()
	{
		$query = "SELECT personnel.id as 'person_id', personnel.firstname, personnel.lastname, personnel.emp_no, CONCAT(firstname, ' ', lastname) as 'fullname', contact_num as 'contact', location.location as 'project' FROM personnel, location WHERE personnel.status != 0 AND personnel.project = location.id ORDER BY personnel.firstname ASC";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
	}

	public function view_person_by_proj()
	{
		$query = "SELECT personnel.id as 'person_id', personnel.firstname, personnel.lastname, personnel.emp_no, CONCAT(firstname, ' ', lastname) as 'fullname', contact_num as 'contact', location.location as 'project' FROM personnel, location WHERE personnel.status != 0 AND personnel.project = location.id AND personnel.project = ? ORDER BY personnel.firstname ASC";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->project);

		$sel->execute();
		return $sel;
	}

	public function view_person_byID()
	{
		$query = "SELECT personnel.id, personnel.emp_no, personnel.firstname, personnel.lastname, personnel.contact_num, personnel.project, location.id as 'proj_id', location.location FROM personnel, location WHERE personnel.project=location.id AND personnel.id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function get_person_id()
	{
		$query = "SELECT max(id) + 1 as 'person_id' FROM personnel";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
	}

	public function get_person_name()
	{
		$query = "SELECT id, firstname, lastname FROM personnel WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}
}
?>