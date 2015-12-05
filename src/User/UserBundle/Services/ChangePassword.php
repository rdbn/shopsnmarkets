<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Services;

use User\UserBundle\Services\hash.password;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class ChangePassword {
    
    protected $em, $formFactory, $model, $form, $hash.password;

    public function __construct(EntityManager $em, FormFactoryInterface $formFactory, hash.password $hash.password) {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->hash.password = $hash.password;
    }

    public function createForm($type, $user) {
        $this->model = $user;
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function changePassword($request) {
        $userPassword = $this->model->getPassword();

        $this->form->bind($request);

        if ($this->form->isValid()) {
            $oldPassword = $request->request->get('password');

            $oldPass = $this->hash.password->checkOldPassword($this->model, $userPassword, $oldPassword['old_password']);
            if ($oldPass) {
                $this->hash.password->password($this->model, $this->model->getPassword());
            }

            $newPassword = $this->em;
            $newPassword->flush();

            return true;
        } else {
            return false;
        }
    }
    
    public function getError() {
        $errors = array();
        
        foreach ($this->form->all() as $child) {
            if (!$child->isValid()) {
                $name = $child->getName();
                $error = $child->getErrors();
                
                $errors[$name] = $error['0']->getMessage();
            }
        }
        
        return $errors;
    }
}
?>
