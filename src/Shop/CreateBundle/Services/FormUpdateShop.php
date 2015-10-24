<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Services;

use User\RegistrationBundle\Services\CreateDir;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

Class FormUpdateShop {
    
    protected $em, $formFactory, $form, $model, $name, $dir;
    
    public function __construct(EntityManager $em, FormFactoryInterface $formFactory, CreateDir $dir) {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->dir = $dir;
    }
    
    public function createForm($type, $model) {
        
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function update($request, $nameShop) {
        if ($request->getMethod('POST')) {
            $this->name = $nameShop;
            $this->form->bind($request);
            $this->deleteAllSpace();
            
            if ($this->form->isValid() && $this->isName()) {
                $this->em->flush();
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function isName() {
        if ($this->name != $this->model->getUniqueName()) {
            $name = $this->em->getRepository('ShopCreateBundle:Shops')
                    ->findOneBy(array('unique_name' => $this->model->getUniqueName()));

            if ($name == null) {
                $this->dir->rename($this->name, $this->model->getUniqueName());
                
                return true;
            } else {
                return false;
            }
        } else {           
            return true;
        }
    }
    
    private function deleteAllSpace() {
        $name = $this->model->getUniqueName();
        
        $delete = str_replace(' ', '', $name);
        
        $this->model->setUniqueName($delete);
    }
}
?>
