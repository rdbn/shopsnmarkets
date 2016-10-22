<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\MainBundle\Services;

use Shop\PartnersBundle\Services\Tools\AbstractSearch;

class Search extends AbstractSearch
{
    /**
     * Ищем в базе продукты
     *
     * @return array
     */
    private function find()
    {
        $repository = $this->em->getRepository('ShopProductBundle:Product');
        $select = $repository->createQueryBuilder('p')
            ->select('p.id, p.name, p.price, p.path');

        $query = $select->where($select->expr()->like('p.keywords', ':words'))
            ->setParameter('words', "%{$this->keywords}%")
            ->setFirstResult(0)
            ->setMaxResults(16)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Отдаем резльтаты поиска
     *
     * @return array
     */
    public function getResult()
    {
        $result = $this->find();
        if (count($result) > 0) {
            return $result;
        } else {
            return [];
        }
    }
}