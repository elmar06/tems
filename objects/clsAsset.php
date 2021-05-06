<?php
class Asset
{
	private $conn;
	private $table_name = "asset";

	public $id;
	public $description;
	public $specs;
	public $projects;
	public $category;
	public $code;
	public $trade;
	public $brand;
	public $barcode;
	public $quantity;
	public $price;
	public $date_warranty;
	public $serial;
	public $model;
	public $asset_condition;
	public $assign;
	public $date_transfer;
	public $image;
	public $notes;
	public $status;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function save_asset()
	{
		$query = "INSERT INTO " .$this->table_name. " SET description=?, specs=?, project=?, category=?, code=?, trade=?, brand=?, barcode=?, quantity=?, price=?, date_warranty=?, serial=?, model=?, tool_condition=?, assign=?, date_transfer=?, notes=?, status=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->description);
		$ins->bindParam(2, $this->specs);
		$ins->bindParam(3, $this->project);
		$ins->bindParam(4, $this->category);
		$ins->bindParam(5, $this->code);
		$ins->bindParam(6, $this->trade);
		$ins->bindParam(7, $this->brand);
		$ins->bindParam(8, $this->barcode);
		$ins->bindParam(9, $this->quantity);
		$ins->bindParam(10, $this->price);
		$ins->bindParam(11, $this->date_warranty);
		$ins->bindParam(12, $this->serial);
		$ins->bindParam(13, $this->model);
		$ins->bindParam(14, $this->tool_condition);
		$ins->bindParam(15, $this->assign);
		$ins->bindParam(16, $this->date_transfer);
		$ins->bindParam(17, $this->notes);
		$ins->bindParam(18, $this->status);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function update_asset()
	{
		$query = "UPDATE " .$this->table_name. " SET description=?, specs=?, project=?, category=?, code=?, trade=?, brand=?, barcode=?, quantity=?, price=?, date_warranty=?, serial=?, model=?, tool_condition=?, assign=?, date_transfer=?, notes=? WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->description);
		$upd->bindParam(2, $this->specs);
		$upd->bindParam(3, $this->project);
		$upd->bindParam(4, $this->category);
		$upd->bindParam(5, $this->code);
		$upd->bindParam(6, $this->trade);
		$upd->bindParam(7, $this->brand);
		$upd->bindParam(8, $this->barcode);
		$upd->bindParam(9, $this->quantity);
		$upd->bindParam(10, $this->price);
		$upd->bindParam(11, $this->date_warranty);
		$upd->bindParam(12, $this->serial);
		$upd->bindParam(13, $this->model);
		$upd->bindParam(14, $this->tool_condition);
		$upd->bindParam(15, $this->assign);
		$upd->bindParam(16, $this->date_transfer);
		$upd->bindParam(17, $this->notes);
		$upd->bindParam(18, $this->id);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function delete_asset()
	{
		$query = "UPDATE asset SET status = ? WHERE id = ?";
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

	public function view_asset()
	{
		$query = "SELECT asset.id as 'asset_id', asset.description, asset.specs, asset.status, asset.category, asset.code, asset.trade, asset.brand, asset.assign, asset.tool_condition, type.id as 'cat_id', type.type as 'cat_name', type.description as 'cat_desc', location.id, location.location as 'loc_name', department.id, department.department as 'dept_name' FROM asset, type, location, department, personnel WHERE asset.category = type.id AND asset.project = location.id AND asset.trade = department.id AND asset.assign = personnel.id AND asset.status != 0 AND asset.project = ? ORDER BY asset.code DESC";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->project);

		$sel->execute();
		return $sel;
	}

	public function get_asset_byID()
	{
		$query = "SELECT asset.id as 'asset_id', asset.description, asset.specs, asset.project, asset.category, asset.code, asset.trade, asset.brand, asset.barcode, asset.quantity, asset.price, asset.date_warranty, asset.serial, asset.model, asset.tool_condition, asset.assign, asset.date_transfer, asset.image, asset.notes, type.id as 'cat_id', type.type as 'cat_name', type.description as 'cat_desc', location.id, location.location as 'loc_name', department.id, department.department as 'dept_name', personnel.id, CONCAT(personnel.firstname, ' ', personnel.lastname) as 'fullname' FROM asset, type, location, department, personnel WHERE asset.category = type.id AND asset.project = location.id AND asset.trade = department.id AND asset.assign = personnel.id AND asset.id = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function transfer_asset()
	{
		$query = "UPDATE ".$this->table_name." SET assign=?, date_transfer=?, project=? WHERE id=?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->assign);
		$upd->bindParam(2, $this->date_transfer);
		$upd->bindParam(3, $this->project);
		$upd->bindParam(4, $this->id);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_asset_byPerson()
	{
		$query = "SELECT asset.id as 'asset_id', asset.description, asset.specs, asset.project, asset.category, asset.code, asset.trade, asset.brand, asset.barcode, asset.quantity, asset.price, asset.date_warranty, asset.serial, asset.model, asset.tool_condition, asset.assign, asset.date_transfer, asset.image, asset.notes, type.id as 'cat_id', type.type as 'cat_name', type.description as 'cat_desc', location.id, location.location as 'loc_name', department.id, department.department as 'dept_name', personnel.id, CONCAT(personnel.firstname, ' ', personnel.lastname) as 'fullname' FROM asset, type, location, department, personnel WHERE asset.category = type.id AND asset.project = location.id AND asset.trade = department.id AND asset.assign = personnel.id AND asset.assign = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->assign);

		$sel->execute();
		return $sel;
	}

	public function get_asset_byProj()
	{
		$query = "SELECT asset.id as 'asset_id', asset.description, asset.specs, asset.project, asset.category, asset.code, asset.trade, asset.brand, asset.barcode, asset.quantity, asset.price, asset.date_warranty, asset.serial, asset.model, asset.tool_condition, asset.assign, asset.date_transfer, asset.image, asset.notes, type.id as 'cat_id', type.type as 'cat_name', type.description as 'cat_desc', location.id, location.location as 'loc_name', department.id, department.department as 'dept_name', personnel.id, CONCAT(personnel.firstname, ' ', personnel.lastname) as 'fullname' FROM asset, type, location, department, personnel WHERE asset.category = type.id AND asset.project = location.id AND asset.trade = department.id AND asset.assign = personnel.id AND asset.project = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->project);

		$sel->execute();
		return $sel;
	}

	public function get_asset_byType()
	{
		$query = "SELECT asset.id as 'asset_id', asset.description, asset.specs, asset.project, asset.category, asset.code, asset.trade, asset.brand, asset.barcode, asset.quantity, asset.price, asset.date_warranty, asset.serial, asset.model, asset.tool_condition, asset.assign, asset.date_transfer, asset.image, asset.notes, type.id as 'cat_id', type.type as 'cat_name', type.description as 'cat_desc', location.id, location.location as 'loc_name', department.id, department.department as 'dept_name', personnel.id, CONCAT(personnel.firstname, ' ', personnel.lastname) as 'fullname' FROM asset, type, location, department, personnel WHERE asset.category = type.id AND asset.project = location.id AND asset.trade = department.id AND asset.assign = personnel.id AND asset.category = ?";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->category);

		$sel->execute();
		return $sel;
	}

	public function get_asset_id()
  	{
	  	$query = "SELECT max(id) + 1 as 'asset_id' FROM asset";
	  	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	  	$sel = $this->conn->prepare($query);

	  	$sel->execute();
	  	return $sel;
  	}

  	public function get_last_id()
  	{
	  	$query = "SELECT max(id) as 'asset_id' FROM asset";
	  	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	  	$sel = $this->conn->prepare($query);

	  	$sel->execute();
	  	return $sel;
  	}

  	public function check_image_exist()
  	{
  		$query = "SELECT * FROM asset WHERE image = ?";
  		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  		$sel = $this->conn->prepare($query);

  		$sel->bindParam(1, $this->image);

  		$sel->execute();
  		return $sel;
  	}

  	public function insert_image()
  	{
  		$query = "UPDATE ".$this->table_name." SET image=? WHERE id=?";
  		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  		$upd = $this->conn->prepare($query);

  		$upd->bindParam(1, $this->image);
  		$upd->bindParam(2, $this->id);

  		if($upd->execute())
  		{
  			return true;
  		}
  		else
  		{
  			return false;
  		}
  	}

  	public function view_asset_by_user()
	{
		$query = "SELECT asset.id as 'asset_id', asset.barcode, asset.description, asset.type_id, type.id, type.type as 'asset_type', type.created_by, asset.location_id, location.id, location.location as 'asset_loc', asset.manufacturer, asset.brand, asset.model, asset.price, asset.quantity, asset.date_warranty, asset.serial, asset.price, asset.quantity, asset.asset_status, asset.date_transfer, asset.asset_condition, asset.assign, asset.asset_status, asset.dept_id, asset.notes, asset.image, personnel.id as 'person_id', personnel.firstname, personnel.lastname, personnel.contact_num, department.id, department.department FROM asset, type, location, personnel, department WHERE asset.type_id=type.id AND asset.assign=personnel.id AND asset.location_id=location.id AND asset.dept_id=department.id AND asset.status != 0 AND type.created_by = ? ORDER BY asset.id DESC";
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->created_by);

		$sel->execute();
		return $sel;
	}

	public function upd_tool_stat()
	{
		$query = 'UPDATE '.$this->table_name.' SET status=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->status);
		$upd->bindParam(2, $this->id);

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