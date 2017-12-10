<?php

namespace App\Presenters;

use App\Model\cats_manager;
use Nette\Application\UI;
use Nette\Security\User;
use Nette\Security\SimpleAuthenticator;



class HomepagePresenter extends UI\Presenter{
    
    
    protected function createComponentLoginForm(){
        $form = new UI\Form;
        $form->addText('name', 'Jméno:');
        $form->addPassword('pass', 'Heslo:');
        $form->addSubmit('login', 'Přihlásit se');
        $form->onSuccess[] = [$this, 'registrationFormSucceeded'];
        return $form;
    }
    
    public function registrationFormSucceeded(UI\Form $form, $values){
        $user = $this->getUser();
        $authenticator = new SimpleAuthenticator([
            'admin' => 'admin']);
        $user->setAuthenticator($authenticator);
        try {
            $user->login($values["name"], $values["pass"]);
            $this->redirect("admin");
        } catch (\Nette\Security\AuthenticationException $e) {
            $this->flashMessage('Uživatelské jméno nebo heslo je nesprávné', 'warning');
        }
    }
    
    protected function check_if_logged(){
        $user = $this->getUser();
        if ($user->isLoggedIn()){
            if($user->id == "admin"){
                return;
            }
        }
        $this->redirect("homepage");
    }

        public function renderDefault(){
        if ($_SERVER['REQUEST_URI'] == "/homepage/admin"){
            $this->check_if_logged();
        }
        $cat_fetcher = new cats_manager;
        $cats = $cat_fetcher->get_cats();
        $cats_with_kids = $cat_fetcher->get_cats_with_kids();
        $this->template->cats = json_encode($cats);
        $this->template->cats_with_kids = json_encode($cats_with_kids);
    }
}
