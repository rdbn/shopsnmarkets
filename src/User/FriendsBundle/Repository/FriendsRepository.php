<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FriendsRepository extends EntityRepository
{
    public function findAllMyApplication($id) {
        return $this->getEntityManager()
                ->createQuery(
                    'SELECT u.id, u.realname, u.path FROM UserFriendsBundle:Friends f
                    LEFT JOIN UserUserBundle:Users u WITH u.id = f.id
                    WHERE f.users = :id AND f.check_friends = 0
                    GROUP BY u'
                )->setParameter('id', $id)
                ->getResult();
    }
    
    public function findAllApplication($id) {
        return $this->getEntityManager()
                ->createQuery(
                    'SELECT u.id, u.realname, u.path FROM UserFriendsBundle:Friends f
                    LEFT JOIN UserUserBundle:Users u WITH u.id = f.users
                    WHERE f.id = :id AND f.check_friends = 0
                    GROUP BY u'
                )->setParameter('id', $id)
                ->getResult();
    }
    
    public function findAllFriends($id) {
        return $this->getEntityManager()
                ->createQuery(
                    'SELECT u.id, u.realname, u.path FROM UserFriendsBundle:Friends f
                    LEFT JOIN UserUserBundle:Users u WITH u.id = f.id
                    WHERE f.users = :id AND f.check_friends = 1
                    GROUP BY u'
                )->setParameter('id', $id)
                ->getResult();
    }
    
    public function checkFriends($value) {
        $query = $this->getEntityManager()
                ->createQuery(
                    'SELECT f.id FROM UserFriendsBundle:Friends f
                    WHERE f.id = :id AND f.users = :user'
                )->setParameters($value)
                ->getResult();
        
        if (null == $query) {
            return true;
        } else {
            return false;
        }
        
    }
}
?>
