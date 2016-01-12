<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PartnersBundle\Services;

use User\PartnersBundle\Entity\Partners;

use Doctrine\ORM\EntityUser;

class CheckPartners {
    
    protected $em;

    public function __construct(EntityUser $em) {
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
                    ->update('UserPartnersBundle:Partners', 'p')
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
