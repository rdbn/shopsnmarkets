<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Services;

use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityManager;

class FormUserInformation {
    
    protected $em, $formFactory, $form, $model, $email, $isMail;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em) {
        $this->formFactory = $formFactory;
        $this->em = $em;
    }

    public function createForm($type, $user) {
        $this->model = $user;
        $this->email = $user->getEmail();
        
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function add($request) {
        $this->form->bind($request);
        
        $this->isMail = $this->isMail();
        if ($this->form->isValid() && $this->isMail) {
            $add = $this->em;
            $add->flush();

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
        
        if (!$this->isMail) {
            $errors['email_check'] =  'Email: '.$this->model->getEmail().' уже занят!';
        }
        
        return $errors;
    }

    private function isMail() {
        $email = $this->em->getRepository('UserRegistrationBundle:Users')
                ->findOneByEmail($this->email);
        
        if (null == $email) {
            return true;
        } else {
            if ($this->email == $this->model->getEmail() || $this->email == '') {
                return true;
            } else {
                return false;
            }
        }
    }
}
?>
