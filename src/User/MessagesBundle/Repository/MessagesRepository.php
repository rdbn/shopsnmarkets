<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MessagesRepository extends EntityRepository
{
    public function findByMessages($value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT u.id, u.realname, u.path, m.id as message, m.text, m.flags, m.createdAt 
                    FROM UserMessagesBundle:Messages m
                    LEFT JOIN m.users u
                    WHERE m.dialog = :id AND m.flags <> 2 AND m.flags <> 3
                    GROUP BY m
                ')->setParameter('id', $value)
                ->getResult();
    }
    
    public function findByMessagesFlags($value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT u.id, u.realname, u.path, m.id as message, m.text, m.flags, m.createdAt 
                    FROM UserMessagesBundle:Messages m
                    LEFT JOIN m.users u
                    WHERE m.dialog = :id AND m.flags = :flags
                    GROUP BY m
                ')->setParameters($value)
                ->getResult();
    }
}
?>