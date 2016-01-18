<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Services;

use Doctrine\ORM\EntityManager as Manager;

class Search
{
    /**
     * @var Manager
    */
    private $em;

    /**
     * @var integer
    */
    private $id;

    /**
     * @var string
     */
    private $keywords;

    /**
     * Инициализируем переменные
     *
     * @param Manager $em
    */
    public function __construct(Manager $em)
    {
        $this->em = $em;
    }

    /**
     * Получаем id юзера
     *
     * @param int $id
     *
     * @return self
    */
    public function setUserId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Получаем слова для поиска
     *
     * @param string $keywords
     *
     * @return self
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

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

        /*if ($this->keywords['city']) {
            $query = $query->andWhere('u.city = :idCity')
                ->setParameter('idCity', $this->keywords['city']);
        }*/

        $users = $query->andWhere($qb->expr()->notIn('u.id', $qbDQL->getDQL()))
            ->setFirstResult('0')
            ->setMaxResults('20')
            ->getQuery();

        return $users->getResult();
    }
}