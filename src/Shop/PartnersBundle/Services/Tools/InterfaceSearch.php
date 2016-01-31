<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 21.01.16
 * Time: 22:25
 */

namespace Shop\PartnersBundle\Services\Tools;

use User\UserBundle\Entity\City;
use Doctrine\ORM\EntityManager as Manager;

interface InterfaceSearch
{
    /**
     * Инициализируем переменные
     *
     * @param Manager $em
     */
    public function __construct(Manager $em);

    /**
     * Получаем id города
     *
     * @param City $city
     *
     * @return self
     */
    public function setCityId($city);

    /**
     * Получаем слова для поиска
     *
     * @param string $keywords
     *
     * @return self
     */
    public function setKeywords($keywords);

    /**
     * Отдаем резльтаты поиска
     *
     * @return array
     */
    public function getResult();
}