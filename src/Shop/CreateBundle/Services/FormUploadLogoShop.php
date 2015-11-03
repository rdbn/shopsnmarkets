<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Services;

use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityManager;

class FormUploadLogoShop 
{
    protected $em, $formFactory, $model, $form, $path;

    public function __construct(EntityManager $em, FormFactoryInterface $formFactory) {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }

    public function createForm($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function upload($request, $shopname) {
        if ($request->getMethod('POST')) {
            $this->form->bind($request);
        
            if ($this->form->isValid()) {
                $this->checkImage($shopname);
                $this->path = $this->form->getData()->preUpload($shopname);
                $this->form->getData()->upload($shopname);

                $addLogo = $this->em;
                $addLogo->persist($this->model->setPath($this->path));
                $addLogo->flush();

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function getPath() {
        return $this->path;
    }
    
    public function getErrors() {
        $arErrors =  array();
        
        foreach ($this->form->getErrors() as $key => $errors) {
            $arErrors[$key] = $errors->getMessage();
        }
        
        return $arErrors;
    }

    private function checkImage($shopname) {
        $dir = __DIR__.'/../../../../../Symfony/web/public/xml/Shops/'.$shopname.'/logo';
        
        $scandir = scandir($dir);
        unset($scandir['0']);
        unset($scandir['1']);
        
        if (isset($scandir['2'])) {
            unlink($dir.'/'.$scandir['2']);
        }
    }
}
?>
