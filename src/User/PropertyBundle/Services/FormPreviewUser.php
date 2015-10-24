<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Services;

use User\PropertyBundle\Entity\PreviewUser;

use User\PropertyBundle\Services\SavePreviewXML;
use Symfony\Component\Form\FormFactoryInterface;

class FormPreviewUser {
    
    protected $formFactory, $form, $model, $saveXML;

    public function __construct(FormFactoryInterface $formFactory, SavePreviewXML $saveXML) {
        $this->formFactory = $formFactory;
        $this->saveXML = $saveXML;
    }

    public function createForm($type, $userID) {
        $this->model = new PreviewUser();
        $xml = $this->getXML($userID);
        
        if ($xml) {
            $this->model->setTextPreview(isset($xml['text_preview']) ? $xml['text_preview'] : '');
            $this->model->setTextMain(isset($xml['text_main']) ? $xml['text_main'] : '');
        }
        
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function add($request, $user) {
        if (gettype($request) == 'array') {
            $this->form->bind($request);
            
            if ($this->form->isValid()) {
                $this->saveXML->saveXML($this->form->getData(), $user);
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    private function getXML($userID) {
        $file = __DIR__.'/../../../../web/public/xml/Users/'.$userID.'/preview.xml';
        
        if (file_exists($file)) {
            $xml = simplexml_load_file($file);
            
            return (array)$xml;
        } else {
            return false;
        }
    }
}
?>
