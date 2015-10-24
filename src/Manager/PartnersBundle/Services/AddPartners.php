<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\PartnersBundle\Services;

use Manager\PartnersBundle\Entity\Partners;

use Doctrine\ORM\EntityManager;

class AddPartners {
    
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function add($data) {
        if (gettype($data) == 'array') {
            if (settype($data['shop'], 'integer') && settype($data['partners'], 'integer')) {
                $shop = $this->em->getRepository('ShopCreateBundle:Shops')
                        ->findOneById($data['shop']);
                
                $partners = new Partners();
                $partners->setId($data['partners']);
                $partners->setShops($shop);
                $partners->setCheckPartners(false);
                
                $addPartners = $this->em;
                $addPartners->persist($partners);
                $addPartners->persist($shop);
                $addPartners->flush();
                
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
