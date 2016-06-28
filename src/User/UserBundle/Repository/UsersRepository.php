<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 27.06.16
 * Time: 23:28
 */

namespace User\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use User\UserBundle\Entity\Users;

class UsersRepository extends EntityRepository
{
    /**
     * find user vk or instagram
     *
     * @param int $id
     *
     * @return Users
    */
    public function findOneByOAuthUser($id)
    {
        $query = $this->getEntityManager()
            ->createQuery("
                SELECT u FROM UserUserBundle:Users u 
                WHERE u.vkontakteId = :id OR u.instagramId = :id
            ")
            ->setParameter("id", $id);

        try {
            return $query->getSingleResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}