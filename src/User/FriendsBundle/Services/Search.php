<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Services;

use Shop\PartnersBundle\Services\Tools\AbstractSearch;

class Search extends AbstractSearch
{
    /**
     * Отдаем резльтаты поиска
     *
     * @return array
    */
    public function getResult()
    {
        $result = $this->findUser();
        if (count($result) > 0) {
            return $result;
        } else {
            return [];
        }
    }

    /**
     * Осуществляем посиск пользователей
     *
     * @return array
    */
    private function findUser()
    {
        if (!$this->keywords) return [];

        $qbDQL = $this->em->createQueryBuilder();
        $qbDQL->addSelect('fu.id')
            ->from('UserFriendsBundle:Friends', 'f')
            ->leftJoin('f.friends', 'fu')
            ->leftJoin('f.users', 'uf')
            ->where('uf.id = :id')
            ->setParameter('id', $this->id);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('u.id, u.realname, u.path')
            ->from('UserUserBundle:Users', 'u')
            ->where('u.id <> :id')
            ->setParameter('id', $this->id);

        if ($this->keywords) {
            $lengthString = substr($this->keywords, 0, 255);
            $validString = preg_replace('/[^\w\x7F-\xFF\s]/', '', $lengthString);
            $lengthWords = trim(preg_replace('/\s(\S{1,2})\s/', ' ', preg_replace('/ +/', ' ', $validString)));
            $string = preg_replace('/ +/', ' ', $lengthWords);

            $query = $query->andWhere($query->expr()->like('u.realname', ':name'))
                ->setParameter('name', '%'.$string.'%');
        }

        if ($this->cityId) {
            $query = $query->andWhere('u.city = :idCity')
                ->setParameter('idCity', $this->cityId);
        }

        $users = $query->andWhere($qb->expr()->notIn('u.id', $qbDQL->getDQL()))
            ->setFirstResult('0')
            ->setMaxResults('10')
            ->getQuery();

        return $users->getResult();
    }
}