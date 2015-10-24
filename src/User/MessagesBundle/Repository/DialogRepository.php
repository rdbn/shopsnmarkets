<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DialogRepository extends EntityRepository
{
    public function findBySend($value, $flags = null) {
        $repository = $this->getEntityManager()->getRepository('UserMessagesBundle:Dialog');
        $query = $repository->createQueryBuilder('d')
                ->select('send.id, send.realname, send.path, d.id as dialog, m.text, m.flags')
                ->innerJoin('d.messages', 'm')
                ->innerJoin('d.send', 'send')
                ->where('d.take = :id')
                ->setParameter('id', $value);
        
        if ($flags == '0') {
            $query = $query->andWhere('d.flags = 0');
        } 
        if ($flags == '2') {
            $query = $query->andWhere('d.flags = 2');
        }
        if ($flags == null) {
            $query = $query->andWhere('d.flags <> 2');
        }
        
        $query = $query->groupBy('send')
                ->orderBy('m.createdAt', 'DESC');
        
        $user = $query->getQuery()->getResult();
        
        return $user;
    }
    
    public function findByTake($value, $flags = null) {
        $repository = $this->getEntityManager()->getRepository('UserMessagesBundle:Dialog');
        $query = $repository->createQueryBuilder('d')
                ->select('take.id, take.realname, take.path, d.id as dialog, m.text, m.flags')
                ->innerJoin('d.messages', 'm')
                ->innerJoin('d.take', 'take')
                ->where('d.send = :id')
                ->setParameter('id', $value);
        
        if ($flags == '0') {
            $query = $query->andWhere('d.flags = 0');
        } 
        if ($flags == '2') {
            $query = $query->andWhere('d.flags = 2');
        }
        if ($flags == null) {
            $query = $query->andWhere('d.flags <> 2');
        }
        
        $query = $query->groupBy('take')
                ->orderBy('m.createdAt', 'ASC');
        
        $user = $query->getQuery()->getResult();
        
        return $user;
    }
}
?>