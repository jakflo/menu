<?php


namespace App\Model;

use app\entities\DBwrap;

class cats_admin {
    protected $DBwarp;
    
    public function __construct() {
        $this->DBwarp = new DBwrap;
    }
    
    public function add_sibb($cat_id, $name) {
        $this->DBwarp->sendSQL("select cat_parrent from cats where cat_id = ?;", array($cat_id));
        $parrent_id = $this->DBwarp->fetch()["cat_parrent"];
        $this->DBwarp->sendSQL("insert into cats (cat_name, cat_parrent) values (?, ?);", array($name, $parrent_id));
    }
    
    public function add_kid($cat_id, $name) {
        $this->DBwarp->sendSQL("insert into cats (cat_name, cat_parrent) values (?, ?);", array($name, $cat_id));
    }
    
    public function rename($cat_id, $name) {
        $this->DBwarp->sendSQL("update cats set cat_name = ? where cat_id = ?;", array($name, $cat_id));
    }
    
    public function delete($cat_id) {
        $this->DBwarp->sendSQL("delete from cats where cat_id = ?;", array($cat_id));
    }
}
