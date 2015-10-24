<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Search\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class SearchUsers {
    
    protected $em;
    protected $formFactory;
    protected $form;
    protected $model;
    protected $resualt;

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
        if ($this->resualt != '') {
            return $this->resualt;
        } else {
            return '';
        }
    }
    
    private function validKeywords($keywords, $userID) {
        if ($keywords['keywords'] != '' || $keywords['city'] != '') {
            $qbDQL = $this->em->createQueryBuilder();
            $qbDQL->addSelect('f.id')
                    ->from('UserFriendsBundle:Friends', 'f')
                    ->innerJoin('f.users', 'uf')
                    ->where('uf.id = :id')
                    ->setParameter('id', $userID);

            $qb = $this->em->createQueryBuilder();
            $query = $qb->select('u.id, u.realname, u.path')
                    ->from('UserRegistrationBundle:Users', 'u')
                    ->where('u.id <> :id')
                    ->setParameter('id', $userID);

            if ($keywords['keywords'] != '') {
                $lenghtString = substr($keywords['keywords'], 0, 255);
                $validString = preg_replace('/[^\w\x7F-\xFF\s]/', '', $lenghtString);
                $lenghtWords = trim(preg_replace('/\s(\S{1,2})\s/', ' ', preg_replace('/ +/', ' ', $validString)));
                $string = preg_replace('/ +/', ' ', $lenghtWords);

                $query = $query->andWhere($query->expr()->like('u.realname', ':name'))
                        ->setParameter('name', '%'.$string.'%');
            }
            if ($keywords['city'] != '') {
                $query = $query->andWhere('u.city = :idCity')
                        ->setParameter('idCity', $keywords['city']);
            }
            $shops = $query->andWhere($qb->expr()->notIn('u.id', $qbDQL->getDQL()))
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
