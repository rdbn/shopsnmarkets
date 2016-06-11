<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MessagesRepository extends EntityRepository
{
    /**
     * Получаем последние сообщения пользователя
     *
     * @param int $id
     * @param int $count
     *
     * @return array
     */
    public function findByUsersMessages($id, $count)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT m, u FROM UserMessagesBundle:Messages m
                  LEFT JOIN m.users u
                WHERE m.dialog = :id
                ORDER BY m.id ASC
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
     * Получаем все сообщения которые не прочитаны
     *
     * @param int $usersFrom
     * @param int $usersTo
     * @param int $toUsers
     *
     * @return array
     */
    public function findByCheckMessages($usersFrom, $usersTo, $toUsers)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT m FROM UserMessagesBundle:Messages m
                  LEFT JOIN m.dialog d
                  LEFT JOIN m.users u
                WHERE 
                  d.users = :usersFrom
                  AND d.usersTo = :usersTo 
                  AND m.users = :toUsers 
                  AND m.flags = \'f\'
            ')
            ->setParameters([
                'usersFrom' => $usersFrom,
                'usersTo' => $usersTo,
                'toUsers' => $toUsers
            ]);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Получаем все сообщения которые не прочитаны
     *
     * @param array $id
     *
     * @return array
     */
    public function findByRemoveMessages(array $id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT m FROM UserMessagesBundle:Messages m WHERE m.id IN (:id)
            ')
            ->setParameter('id', $id);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}