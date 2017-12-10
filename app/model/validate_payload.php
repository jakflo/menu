<?php


namespace App\Model;


class validate_payload {
    
    public $task;
    public $cat_id;
    public $name;
    
    public function __construct($task, $cat_id, $name) {
        $this->task = $task;
        $this->cat_id = $cat_id;
        $this->name = $name;
    }
    
    protected function clean_text($text) {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        return $text;
    }
    
    public function validate(){
        $task = $this->task;
        if ($task != "add_sibb" && $task != "add_kid" && $task != "rename" && $task != "delete"){
            return false;
        }
        $this->cat_id = $this->clean_text($this->cat_id);
        $this->name = $this->clean_text($this->name);
        if ($task == "add_sibb" || $task == "add_kid" || $task == "rename"){
            if ($this->name == ""){return false;}
        }
        return filter_var($this->cat_id, FILTER_VALIDATE_INT);
    }

}
