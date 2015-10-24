<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Services;

use User\RegistrationBundle\Services\HashPassword;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class ChangePassword {
    
    protected $em, $formFactory, $model, $form, $hashPassword;

    public function __construct(EntityManager $em, FormFactoryInterface $formFactory, HashPassword $hashPassword) {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->hashPassword = $hashPassword;
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

            $oldPass = $this->hashPassword->checkOldPassword($this->model, $userPassword, $oldPassword['old_password']);
            if ($oldPass) {
                $this->hashPassword->password($this->model, $this->model->getPassword());
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
