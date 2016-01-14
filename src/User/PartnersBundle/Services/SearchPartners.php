<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PartnersBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class SearchPartners {
    
    protected $em, $formFactory, $form, $model, $resualt;

    public function __construct(EntityManager $em, FormFactoryInterface $formFactory) {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }
    
    public function createForm($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }

    public function validSearch($data, $userID) {
        if (gettype($data) == 'array') {
            $this->form->bind($data);
            
            if ($this->form->isValid()) {
                $this->resualt = $this->validKeywords($data, $userID);
                
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function resualtSearch() {
        if ($this->resualt != null) {
            return $this->resualt;
        } else {
            return '';
        }
    }
    
    private function validKeywords($keywords, $userID) {    
        if ($keywords['keywords'] != '' || $keywords['city'] != '') {
            $qbDQL = $this->em->createQueryBuilder();
            $qbDQL->addSelect('p.id')
                    ->from('ManagerPartnersBundle:Partners', 'p')
                    ->innerJoin('p.shops', 'sp')
                    ->innerJoin('sp.manager', 'sm')
                    ->andWhere('sm.id = :id')
                    ->setParameter('id', $userID);

            $qb = $this->em->createQueryBuilder();
            $query = $qb->select('s.id, s.uniqueName, s.shopname, s.rating, s.path, '
                    . 'count(DISTINCT user) as users, count(DISTINCT shop_like) as likes')
                    ->from('ShopCreateBundle:Shops', 's')
                    ->leftJoin('s.manager', 'u')
                    ->leftJoin('s.like_shop', 'shop_like')
                    ->leftJoin('s.users', 'user')
                    ->andWhere('u.id <> :id')
                    ->setParameter('id', $userID);
            
            if ($keywords['keywords'] != '') {
                $lenghtString = substr($keywords['keywords'], 0, 255);
                $validString = preg_replace('/[^\w\x7F-\xFF\s]/', '', $lenghtString);
                $lenghtWords = trim(preg_replace('/\s(\S{1,2})\s/', ' ', preg_replace('/ +/', ' ', $validString)));
                $string = preg_replace('/ +/', ' ', $lenghtWords);

                $query = $query->andWhere($query->expr()->like('s.keywords', ':keywords'))
                    ->setParameter('keywords', '%'.$string.'%');
            }
            
            if ($keywords['city'] != '') {
                $query = $query->andWhere('s.city = :idCity')
                    ->setParameter('idCity', $keywords['city']);
            }
            
            $shops = $query->andWhere($qb->expr()->notIn('s.id', $qbDQL->getDQL()))
                    ->orderBy('s.createdAt', 'ASC')
                    ->groupBy('s')
                    ->setFirstResult('0')
                    ->setMaxResults('10')
                    ->getQuery()->getResult();

            return $shops;
        } else {
            return null;
        }
    }
}
?>
