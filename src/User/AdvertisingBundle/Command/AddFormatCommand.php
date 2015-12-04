<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 25.10.15
 * Time: 13:47
 */

namespace User\AdvertisingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use User\AdvertisingBundle\Entity\AdvertisingFormat;

class AddFormatCommand extends ContainerAwareCommand
{
    /**
     * @var array
    */
    private $deliveries = [
        "Реклама на слайдере",
        "Реклама с боку",
    ];

    protected function configure()
    {
        $this
            ->setName('add:format')
            ->setDescription('Добавляем способы место для рекламы.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        foreach ($this->deliveries as $value) {
            $delivery = new AdvertisingFormat();
            $delivery->setName($value);

            $em->persist($delivery);
        }

        $em->flush();
    }
}