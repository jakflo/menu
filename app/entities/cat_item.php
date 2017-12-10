<?php



namespace app\entities;


class cat_item {
    public $id;
    public $name;
    public $parrent_id;
    
    public function __construct($id, $name, $parrent_id) {
        $this->id = $id;
        $this->name = $name;
        $this->parrent_id = $parrent_id;
    }
}
