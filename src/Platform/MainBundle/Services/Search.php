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
            ->setParameter('words', '%'.$this->getKeywords().'%')
            ->setFirstResult(0)
            ->setMaxResults(16)
            ->getQuery();

        return $query->getResult();
    }
    
    private function getKeywords()
    {
        $lengthString = substr($this->keywords, 0, 255);
        $validString = preg_replace('/[^\w\x7F-\xFF\s]/', '', $lengthString);
        $lengthWords = trim(preg_replace('/\s(\S{1,2})\s/', ' ', preg_replace('/ +/', ' ', $validString)));
        $string = preg_replace('/ +/', ' ', $lengthWords);
        
        return $string;
    }
}