<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class CreateAdvertisingShop {
    
    public $filename = array();
    protected $em, $formFactory, $form, $model;

    public function __construct(EntityManager $em, FormFactoryInterface $formFactory) {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }
    
    public function createForm($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function add($request) {
        if ($request->getMethod('POST')) {
            $this->form->bind($this->getRequest($request));
            
            if ($this->form->isValid()) {
                $this->upload($request);
                
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    private function getRequest($request) {
        $arValue = $request->request->get('Advertising');
        unset($arValue['adFormat']);
        unset($arValue['date_start']);
        unset($arValue['date_end']);
        unset($arValue['file']);
        
        return $arValue;
    }
    
    private function upload($request) {
        $files = $request->files->get('Advertising');
        $shopname = $this->model->getShops()->getUniqueName();
        
        $this->filename['shop'] = $this->model->getShops()->getShopname();
        $this->filename['unique_name'] = $this->model->getShops()->getUniqueName();
        $this->filename['format'] = $this->model->getFormat()->getId();
        
        if ($this->filename['format'] == '1') {
            $format = 'slider';
        } else {
            $format = 'side_of';
        }
        
        $dir = __DIR__.'/../../../../web/public/xml/Shops/'.$shopname.'/advertising/'.$format;
        
        foreach ($files['file'] as $index => $file) {
            $type = $file->guessExtension();
            if ($type == 'jpg' || 'jpeg' || 'gif' || 'png') {
                $this->filename['image'][$index] = sha1(uniqid(mt_rand(), true)).'.'.$type;
                $file->move($dir, $this->filename['image'][$index]);
            }
        }
    }
}
?>
