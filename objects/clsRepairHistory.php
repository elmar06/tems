<?php
class RepairHistory
{
    private $conn;
    private $table_name = 'repair';

    public $id;
    public $asset_id;
    public $date_repair;
    public $date_returned;
    public $remarks;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function save_repair_history()
    {
        $query = 'INSERT INTO '.$this->table_name.' SET asset_id=?, date_repair=?, datre_returned=?, remarks=?, status=1';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $ins = $this->conn->prepare($query);

        $ins->bindParam(1, $this->asset_id);
        $ins->bindParam(2, $this->date_repair);
        $ins->bindParam(3, $this->date_returned);
        $ins->bindParam(4, $this->remarks);

        if($ins->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function upd_repair_history()
    {
        $query = 'UPDATE '.$this->table_name.' SET date_returned=?, remarks=? WHERE id = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->date_returned);
        $upd->bindParam(2, $this->remarks);
        $upd->bindParam(3, $this->id);

        if($upd->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function view_repair_history()
    {
        $query = 'SELECT asset.id, asset.code, asset.description, asset.project, location.location, repair.asset_id, repair.date_repair, date_returned, repair.remarks FROM asset, repair, location WHERE asset.id = repair.asset_id AND asset.project = location.id ORDER BY asset.id desc';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute();
        return $sel;
    }
}
?>