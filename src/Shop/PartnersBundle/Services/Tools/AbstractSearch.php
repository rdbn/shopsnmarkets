<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 21.01.16
 * Time: 22:25
 */

namespace Shop\PartnersBundle\Services\Tools;

use User\UserBundle\Entity\City;
use Shop\PartnersBundle\Services\Tools\InterfaceSearch as Search;

use Doctrine\ORM\EntityManager as Manager;

abstract class AbstractSearch implements Search
{
    /**
     * @var Manager
     */
    protected $em;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $cityId;

    /**
     * @var string
     */
    protected $keywords;

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
     * Получаем id города
     *
     * @param City $city
     *
     * @return self
     */
    public function setCityId($city)
    {
        if ($city) {
            $this->cityId = $city->getId();
        }

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
    abstract public function getResult();
}