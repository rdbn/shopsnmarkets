<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Services;

use Shop\InformationBundle\Services\ShopCommentsXML;

use Symfony\Component\Form\FormFactoryInterface;

class ShopComments {
    
    private $formFactory;
    private $form;
    private $model;
    private $saveXML;
    
    public function __construct(FormFactoryInterface $formFactory, ShopCommentsXML $saveXML) {
        $this->formFactory = $formFactory;
        $this->saveXML = $saveXML;
    }
    
    public function createForm($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function addComment($request) {
        if ($request != NULL) {
            $this->form->bind($request);
            
            if ($this->form->isValid()) {
                $this->saveXML->saveXML($this->model);
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function comments($shopname) {
        $dir = __DIR__.'/../../../../web/public/xml/Shops/'.$shopname.'/comments/comments.xml';
        
        $comments = '';
        if (file_exists($dir)) {
            $comments = simplexml_load_file($dir);
        }
        
        return $comments;
    }
    
    public function lastComments() {
        $arValue = array(
            'user_img' => ($this->model->getUsers()->getPath() != '') ? $this->model->getUsers()->getPath() : '',
            'user_name' => $this->model->getUsers()->getRealname(),
            'text' => $this->model->getText(),
        );
        
        return $arValue;
    }
}
?>
