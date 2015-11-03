<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Services;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductImage
{    
    protected $formFactory, $form, $session, $value;

    public function __construct(FormFactoryInterface $formFactory, Session $session) {
        $this->session = $session;
        $this->formFactory = $formFactory;
    }
    
    public function form($type, $model) {
        $this->form = $this->formFactory->create($type, $model);
        
        return $this->form;
    }
    
    public function upload($request, $shopname) {
        $this->form->bind($request);
        
        if ($this->form->isValid()) {
            $this->value['size'] = $this->form->getData()->getFile()->getClientSize();
            $this->value['type'] = $this->form->getData()->getFile()->guessExtension();
            $this->value['name'] = $this->form->getData()->preUpload($shopname);
            
            if ($this->session->has('image_product')) {
                $value = $this->session->get('image_product');
                
                if (count($value) < 4) {
                    $this->form->getData()->upload($shopname);
                    
                    $value[count($value)] = '/'.$this->value['name'];

                    $this->session->set('image_product', $value);
                }
            } else {
                $this->form->getData()->upload($shopname);
                
                $value = array('/'.$this->value['name']);
                
                $this->session->set('image_product', $value);
            }

            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function getValue() {
        return array(
            'files' => array(array(
                'name' => $this->value['name'],
                'size' => $this->value['size'],
                'type' => $this->value['type'],
                'url' => 'http://ornest.com/'.$this->value['name'],
                'delete_url' => 'http://ornest.com/'.$this->value['name'],
                'delete_type' => 'DELETE'
            )),
        );
    }
}
?>
