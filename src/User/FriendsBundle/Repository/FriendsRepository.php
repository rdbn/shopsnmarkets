<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FriendsRepository extends EntityRepository
{
    /**
     * Список друзей пользователей
     *
     * @param int $id
     * @param int $count
     *
     * @return array
     */
    public function findByFriends($id, $count)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT u.id, u.realname, u.path FROM UserFriendsBundle:Friends f
                LEFT JOIN f.friends u
                WHERE f.users = :id AND f.checkFriends = \'t\'
                GROUP BY u
            ')
            ->setParameter('id', $id)
            ->setFirstResult($count)
            ->setMaxResults(20);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Список заявок пользователя в друзья(от него)
     *
     * @param int $id
     * @param int $count
     *
     * @return array
     */
    public function findByMyApplication($id, $count)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT u.id, u.realname, u.path FROM UserFriendsBundle:Friends f
                LEFT JOIN f.friends u
                WHERE f.users = :id AND f.checkFriends = \'f\'
                GROUP BY u
            ')
            ->setParameter('id', $id)
            ->setFirstResult($count)
            ->setMaxResults(20);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Список заявок пользователя в друзья(к нему)
     *
     * @param int $id
     * @param int $count
     *
     * @return array
     */
    public function findByApplication($id, $count)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT u.id, u.realname, u.path FROM UserFriendsBundle:Friends f
                LEFT JOIN f.users u
                WHERE f.friends = :id AND f.checkFriends = \'f\'
                GROUP BY u
            ')
            ->setParameter('id', $id)
            ->setFirstResult($count)
            ->setMaxResults(20);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Список заявок пользователя в друзья(от него)
     *
     * @param int $id
     * @param int $count
     *
     * @return array
     */
    public function findByUserFriends($id, $count)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT fu.id, fu.realname, fu.path FROM UserUserBundle:Users u
                LEFT JOIN u.friends f
                LEFT JOIN f.friends fu
                WHERE u.id = :id AND f.checkFriends = \'t\'
                GROUP BY f
            ')
            ->setParameter('id', $id)
            ->setFirstResult($count)
            ->setMaxResults(20);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}