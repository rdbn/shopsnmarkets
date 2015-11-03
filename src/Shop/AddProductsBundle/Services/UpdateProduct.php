<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class UpdateProduct
{    
    protected $em, $formFactory, $form, $model;

    public function __construct(EntityManager $em, FormFactoryInterface $formFactory) {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }
    
    public function form($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $model);
        
        return $this->form;
    }
    
    public function addProduct($request, $shopname) {
        if ($request->getMethod('POST')) {
            $this->form->bind($request);
            
            if ($this->form->isValid()) { 
                $this->form->getData()->preUpload($shopname, $this->model);
                $this->form->getData()->upload($shopname, $this->model);

                $addProduct = $this->em;
                $addProduct->flush();
                
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}
?>
