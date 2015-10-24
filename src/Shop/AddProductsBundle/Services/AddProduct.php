<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Services;

use Shop\AddProductsBundle\Entity\ProductImage;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class AddProduct
{    
    protected $em, $formFactory, $form, $model, $session;

    public function __construct(EntityManager $em, FormFactoryInterface $formFactory, Session $session) {
        $this->em = $em;
        $this->session = $session;
        $this->formFactory = $formFactory;
    }
    
    public function form($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $model);
        
        return $this->form;
    }
    
    public function add($request) {
        if ($request->getMethod('POST')) {
            $this->form->bind($request);
            
            if ($this->form->isValid()) {
                $this->saveImage();
                
                $addProduct = $this->em;
                $addProduct->persist($this->model);
                $addProduct->flush();
                
                $this->session->clear();
                
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    private function saveImage() {
        if ($this->session->has('image_product')) {
            $images = $this->session->get('image_product');
            
            foreach ($images as $image) {
                $productImage = new ProductImage();
                $productImage->setProduct($this->model);
                $productImage->setPath($image);
                
                $this->model->addImage($productImage);
            }
        }
    }
}
?>
