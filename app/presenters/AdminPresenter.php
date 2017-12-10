<?php

namespace App\Presenters;

use App\Model\cats_manager;
use Nette\Application\UI;
use Nette\Security\User;
use Nette\Security\SimpleAuthenticator;
use App\Model\cats_admin;
use App\Model\validate_payload;

class AdminPresenter extends HomepagePresenter{
    

    
    protected function createComponentLogoutForm(){
        $form = new UI\Form;
        $form->addSubmit('logout', 'Odhlásit se');
        $form->onSuccess[] = [$this, 'logoutFormSucceeded'];
        return $form;
    }
    
    public function logoutFormSucceeded(UI\Form $form, $values){
        $user = $this->getUser();
        $user->logout();
        $this->redirect("homepage");
    }
    
    public function handleEditCats($payload) {
        $this->check_if_logged();
        $payload = json_decode($payload);
        $valid = new validate_payload($payload->task, $payload->cat_id, $payload->name);
        if (!$valid->validate()){return;}
        $task = $valid->task;
        $cat_id = $valid->cat_id;
        $name = $valid->name;
        $cats_admin = new cats_admin;
        if ($task == "add_sibb"){$cats_admin->add_sibb($cat_id, $name);}
        if ($task == "add_kid"){$cats_admin->add_kid($cat_id, $name);}
        if ($task == "rename"){$cats_admin->rename($cat_id, $name);}
        if ($task == "delete"){$cats_admin->delete($cat_id);}
    }
}
