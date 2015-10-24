<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Services;

use Shop\CreateBundle\Services\SavePreviewShopXML;
use Symfony\Component\Form\FormFactoryInterface;

class FormPreviewShop 
{
    protected $formFactory, $model, $form, $saveXML;

    public function __construct(FormFactoryInterface $formFactory, SavePreviewShopXML $saveXML) {
        $this->formFactory = $formFactory;
        $this->saveXML = $saveXML;
    }

    public function createForm($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function addInformation($request) {
        if (gettype($request) == 'array') {
            $this->form->bind($request);
            
            if ($this->form->isValid()) {
                $this->saveXML->saveXML($this->form->getData());
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>
