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
     * @param int $id
     *
     * @return array
     */
    public function findByCheckMessages($id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT m FROM UserMessagesBundle:Messages m
                  LEFT JOIN m.users u
                WHERE m.dialog = :id AND m.flags = \'f\'
            ')
            ->setParameter('id', $id);

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