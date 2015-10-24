<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Search\ShopBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class SearchShopProduct {
    
    protected $em, $formFactory, $model, $form;
    
    public function __construct(EntityManager $em, FormFactoryInterface $formFactory) {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }
    
    public function createForm($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function getResult($request) {
        if (gettype($request) == 'array') {
            $this->form->bind($request);
            
            if ($this->form->isValid()) {
                return $this->getQuery();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    private function getQuery() {
        if ($this->form->getData()->getKeywords() != '') {
            $repository = $this->em->getRepository('ShopAddProductsBundle:Product');
            $select = $repository->createQueryBuilder('p')
                    ->select('p.id, p.name, p.price, p.path, f.id as floor, c.id as category, sub.id as subcategory')
                    ->innerJoin('p.shops', 's')
                    ->innerJoin('p.floor', 'f')
                    ->innerJoin('p.subcategory', 'sub')
                    ->innerJoin('sub.category', 'c')
                    ->where('s.id = :id')
                    ->setParameter('id', $this->model->getShops()->getId());
            
            $query = $select->andWhere($select->expr()->like('p.keywords', ':words'))
                    ->setParameter('words', '%'.$this->isValidKeyvords().'%')
                    ->setFirstResult('0')
                    ->setMaxResults('18');
            
            $result = $query->getQuery()->getResult();
            
            return $result;
        } else {
            return false;
        }
    }
    
    private function isValidKeyvords() {
        $lenghtString = substr($this->model->getKeywords(), 0, 255);
        $validString = preg_replace('/[^\w\x7F-\xFF\s]/', '', $lenghtString);
        $lenghtWords = trim(preg_replace('/\s(\S{1,2})\s/', ' ', preg_replace('/ +/', ' ', $validString)));
        $string = preg_replace('/ +/', ' ', $lenghtWords);
        
        return $string;
    }
}

