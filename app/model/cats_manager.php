<?php

namespace App\Model;

use app\entities\DBwrap;
use app\entities\cat_item;

class cats_manager {
    protected $DBwarp;
    
    public function __construct() {
        $this->DBwarp = new DBwrap;
    }

    public function get_cats() {
        $cats = array();
        
        $this->DBwarp->sendSQL("select * from cats", array());
        while ($row = $this->DBwarp->fetch()){
            $cats[] = new cat_item($row["cat_id"], $row["cat_name"], $row["cat_parrent"]);
        }
        return $cats;
    }
    
    public function get_cats_with_kids(){
        $result = array();
        $this->DBwarp->sendSQL("select distinct cat_parrent from cats;", array());
        while ($row = $this->DBwarp->fetch()){
            if ($row["cat_parrent"] == null){continue;}
            $result[] = $row["cat_parrent"];
        }
        return $result;
    }
}



