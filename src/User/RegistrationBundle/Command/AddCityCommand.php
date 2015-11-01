<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 25.10.15
 * Time: 13:47
 */

namespace User\RegistrationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use User\RegistrationBundle\Entity\Country;
use User\RegistrationBundle\Entity\City;

class AddCityCommand extends ContainerAwareCommand
{
    /**
     * @var array
    */
    private $citys = [
        "Алушта",
        "Анапа",
        "Астрахань",
        "Белгород",
        "Булгар",
        "Великий Новгород",
        "Великий Устюг",
        "Владивосток",
        "Владимир",
        "Волгоград",
        "Вологда",
        "Воронеж",
        "Геленджик",
        "Гурзуф",
        "Евпатория",
        "Екатеринбург",
        "Елец",
        "Ессентуки",
        "Задонск",
        "Иркутск",
        "Казань",
        "Калининград",
        "Керчь",
        "Кижи",
        "Кисловодск",
        "Кострома",
        "Курган",
        "Липецк",
        "Минеральные Воды",
        "Москва",
        "Нижний Новгород",
        "Новосибирск",
        "Орел",
        "Переславль-Залесский",
        "Пермь",
        "Петрозаводск",
        "Плёс",
        "Псков",
        "Пятигорск",
        "Ростов Великий",
        "Рыбинск",
        "Рязань",
        "Самара",
        "Санкт-Петербург",
        "Саратов",
        "Севастополь",
        "Сергиев Посад",
        "Смоленск",
        "Сочи",
        "Суздаль",
        "Тюмень",
        "Углич",
        "Ульяновск",
        "Феодосия",
        "Ялта",
        "Ярославль",
    ];

    protected function configure()
    {
        $this
            ->setName('add:city')
            ->setDescription('Добавляем города');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        $country = new Country();
        $country->setName("Россия");

        $em->persist($country);
        $em->flush();

        foreach ($this->citys as $name) {
            $role = new City();
            $role->setCountry($country);
            $role->setName($name);

            $em->persist($role);
        }

        $em->flush();
    }
}