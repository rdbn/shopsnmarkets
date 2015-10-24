<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\PartnersBundle\Services;

use Manager\PartnersBundle\Entity\Partners;

use Doctrine\ORM\EntityManager;

class CheckPartners {
    
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function check($id) {
        if (settype($id['shop'], 'integer') && settype($id['partners'], 'integer')) {            
            $shop = $this->em->getRepository('ShopCreateBundle:Shops')
                    ->findOneById($id['shop']);
            
            $partners = new Partners();
            $partners->setShops($shop);
            $partners->setId($id['partners']);
            $partners->setCheckPartners('1');
            
            $check = $this->em;
            $check->persist($partners);
            $check->flush();
            
            $query = $this->em->createQueryBuilder()
                    ->update('ManagerPartnersBundle:Partners', 'p')
                    ->set('p.check_partners', '1')
                    ->where('p.id = :shop')
                    ->andWhere('p.shops = :partners')
                    ->setParameters($id)
                    ->getQuery();
            
            $query->execute();
            
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>
