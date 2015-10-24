<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Services;

use User\RegistrationBundle\Services\CreateDir;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

Class FormCreateShop {
    
    protected $em, $formFactory, $form, $model, $dir;

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

    public function addShop($request, $user) {
        if ($request->getMethod('POST')) {
            $this->form->bind($request);
            
            if ($this->form->isValid() && $this->isName()) {
                $this->deleteAllSpace();
                $this->model->addManager($user);
                
                $this->em->persist($this->model);
                $this->em->flush();
                
                $this->createDir();
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function shopName() {
        return $this->model->getUniqueName();
    }
    
    public function isName() {
        $name = $this->em->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(array('unique_name' => $this->model->getUniqueName()));
        
        if ($name == null) {
            return true;
        } else {
            return false;
        }
    }
    
    private function createDir() {
        $dir = __DIR__.'/../../../../../Symfony/web/public/xml/Shops';
        $this->dir->createDir($dir.'/'.$this->model->getUniqueName().'/advertising');
        $this->dir->createDir($dir.'/'.$this->model->getUniqueName().'/advertising/slider');
        $this->dir->createDir($dir.'/'.$this->model->getUniqueName().'/advertising/side_of');
        $this->dir->createDir($dir.'/'.$this->model->getUniqueName().'/checkout');
        $this->dir->createDir($dir.'/'.$this->model->getUniqueName().'/comments');
        $this->dir->createDir($dir.'/'.$this->model->getUniqueName().'/product');
        $this->dir->createDir($dir.'/'.$this->model->getUniqueName().'/logo');
    }

    private function deleteAllSpace() {
        $name = $this->model->getUniqueName();
        
        $delete = str_replace(' ', '', $name);
        
        $this->model->setUniqueName($delete);
    }
}
?>
