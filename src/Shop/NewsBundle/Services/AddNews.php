<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\NewsBundle\Services;

use Shop\NewsBundle\Services\NewsXML;

use Symfony\Component\Form\FormFactoryInterface;

class AddNews {
    
    protected $formFactory;
    protected $newsXML;
    protected $form;
    protected $model;

    public function __construct(FormFactoryInterface $formFactory, NewsXML $newsXML) {
        $this->newsXML = $newsXML;
        $this->formFactory = $formFactory;
    }
    
    public function createForm($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function addInformation($request, $shopname) {
        if ($request->getMethod('POST')) {
            $this->form->bind($request);
            
            if ($this->form->isValid()) {
                $filename = $this->form->getData()->preUpload();
                $this->form->getData()->upload();
                $this->newsXML->addInformation($this->model, $shopname, $filename);
                
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