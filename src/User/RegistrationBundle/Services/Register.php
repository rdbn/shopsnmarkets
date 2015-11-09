<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\RegistrationBundle\Services;

use User\RegistrationBundle\Services\CreateDir;
use User\RegistrationBundle\Services\HashPassword;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class Register {
    
    protected $em, $formFactory, $hashPassword, $model, $createDir;

    public function __construct(EntityManager $em, FormFactoryInterface $formFactory, HashPassword $hashPassword, CreateDir $createDir) {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->hashPassword  = $hashPassword;
        $this->createDir = $createDir;
    }
    
    public function createForm($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $model);
        
        return $this->form;
    }
    
    public function addUser($request) {
        if ($request->getMethod('POST')) {
            $this->model->setSalt(md5(time()));
            $this->form->bind($request);
            
            if ($this->form->isValid() && $this->isEmail()) {
                $this->model->setUsername($this->form->getData()->getEmail());
                $this->hashPassword->password($this->model, $this->model->getPassword());
                $this->addRoleUser();
                
                $addUser = $this->em;
                $addUser->persist($this->model);
                $addUser->flush();

                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function isEmail() {
        $email = $this->em->getRepository('UserRegistrationBundle:Users')
                ->findOneByEmail($this->model->getEmail());
        
        if ($email == NULL) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    private function addRoleUser() {
        $role = $this->em->getRepository('UserRegistrationBundle:Roles')
                ->findOneByRole('ROLE_MANAGER');

        $this->model->addRole($role);
    }
}

?>
