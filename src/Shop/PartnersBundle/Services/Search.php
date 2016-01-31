<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\PartnersBundle\Services;

use Shop\PartnersBundle\Services\Tools\AbstractSearch;

class Search extends AbstractSearch
{
    public function getResult()
    {
        $result = $this->findShop();
        if (count($result) > 0) {
            return $result;
        } else {
            return [];
        }
    }
    
    private function findShop()
    {
        //if (!$this->keywords || !$this->cityId) return [];

        $qbDQL = $this->em->createQueryBuilder();
        $qbDQL->addSelect('pp.id')
            ->from('ShopPartnersBundle:Partners', 'p')
            ->innerJoin('p.partners', 'pp')
            ->innerJoin('p.shops', 'sp')
            ->innerJoin('sp.manager', 'sm')
            ->andWhere('sm.id = :id')
            ->setParameter('id', $this->id);

        $qb = $this->em->createQueryBuilder();
        $query = $qb
            ->select(
                's.id, s.uniqueName, s.shopname, s.rating, s.path, count(DISTINCT user) as users, count(DISTINCT shop_like) as likes'
            )
            ->from('ShopCreateBundle:Shops', 's')
            ->leftJoin('s.manager', 'u')
            ->leftJoin('s.likeShop', 'shop_like')
            ->leftJoin('s.users', 'user')
            ->andWhere('u.id <> :id')
            ->setParameter('id', $this->id);

        if ($this->keywords) {
            $lengthString = substr($this->keywords, 0, 255);
            $validString = preg_replace('/[^\w\x7F-\xFF\s]/', '', $lengthString);
            $lengthWords = trim(preg_replace('/\s(\S{1,2})\s/', ' ', preg_replace('/ +/', ' ', $validString)));
            $string = preg_replace('/ +/', ' ', $lengthWords);

            $query = $query->andWhere($query->expr()->like('s.keywords', ':keywords'))
                ->setParameter('keywords', '%'.$string.'%');
        }

        if ($this->cityId) {
            $query = $query->andWhere('s.city = :city')
                ->setParameter('city', $this->cityId);
        }

        $shops = $query->andWhere($qb->expr()->notIn('s.id', $qbDQL->getDQL()))
            ->orderBy('s.createdAt', 'ASC')
            ->groupBy('s')
            ->setFirstResult(0)
            ->setMaxResults(20)
            ->getQuery();

        return $shops->getResult();
    }
}