<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class DialogRepository extends EntityRepository
{
    /**
     * Получаем последние диалоги пользователя
     *
     * @param int $id
     * @param int $count
     *
     * @return array
    */
    public function findByDialog($id, $count)
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());

        $rsm->addEntityResult("UserMessagesBundle:Dialog", "d");
        $rsm->addFieldResult("d", "id", "id");
        $rsm->addFieldResult("d", "flags", "flags");

        $rsm->addJoinedEntityResult("UserUserBundle:Users", "du", "d", "usersTo");
        $rsm->addFieldResult("du", "users_to_id", "id");
        $rsm->addFieldResult("du", "realname", "realname");
        $rsm->addFieldResult("du", "path", "path");

        $rsm->addJoinedEntityResult("UserMessagesBundle:Messages", "m", "d", "messages");
        $rsm->addFieldResult("m", "message_id", "id");
        $rsm->addFieldResult("m", "text", "text");

        $rsm->addJoinedEntityResult("UserUserBundle:Users", "u", "m", "users");
        $rsm->addFieldResult("u", "users_id", "id");
        $rsm->addFieldResult("u", "m_realname", "realname");
        $rsm->addFieldResult("u", "m_path", "path");

        $query = $this->getEntityManager()
            ->createNativeQuery('
                SELECT 
                  DISTINCT ON (d.id) d.id, 
                  d.flags,
                  du.id as users_to_id, 
                  du.realname, 
                  du.path,
                  m.id as message_id, 
                  m.text,
                  u.id as users_id, 
                  u.realname as m_realname, 
                  u.path as m_path
                FROM dialog d
                  LEFT JOIN users du ON d.users_to_id = du.id
                  LEFT JOIN messages m ON d.id = m.dialog_id
                  LEFT JOIN users u ON m.users_id = u.id
                WHERE d.users_id = ?
                GROUP BY d.id, d.flags, du.id, m.text, u.id, m.id
                LIMIT 20 OFFSET ?
            ', $rsm)
            ->setParameters([1 => $id, 2 => $count]);

        try {
            return $query->getArrayResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Получаем количество ане прочитанных сообщений
     *
     * @param int $id
     *
     * @return int
    */
    public function findOneByNotReadMessage($id)
    {
        $query = $this->getEntityManager()
            ->createQuery("
                SELECT count(d.id) as not_read FROM UserMessagesBundle:Dialog d
                WHERE d.users = :id AND d.flags = 'f'
            ")
            ->setParameter("id", $id);

        try {
            $result = $query->getArrayResult();

            return $result[0]["not_read"];
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}