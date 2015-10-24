<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\PartnersBundle\Services;

use Doctrine\ORM\EntityManager;

class DeletePartners {
    
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function deletePartners($id) {
        if (settype($id['shop'], 'integer') && settype($id['partners'], 'integer')) {
            $this->delete($id['shop'], $id['partners']);
            $this->delete($id['partners'], $id['shop']);
            
            return true;
        } else {
            return false;
        }
    }
    
    private function delete($shop, $id) {
        $em = $this->em->createQueryBuilder();
            $query = $em->delete('ManagerPartnersBundle:Partners', 'p')
                    ->where('p.id = :partners')
                    ->setParameter('partners', $id)
                    ->andWhere('p.shops = :shop')
                    ->setParameter('shop', $shop);

            $query->getQuery()->execute();
    }
}
?>
