<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 25.10.15
 * Time: 13:47
 */

namespace Manager\AdvertisingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Manager\AdvertisingBundle\Entity\AdvertisingWatch;
use Manager\AdvertisingBundle\Entity\AdvertisingDuration;

class AddTimeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('add:time')
            ->setDescription('Добавляем время показа для рекламы.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        $watch = [];
        for ($i = 0; $i <= 23; $i++) {
            $watch[$i] = 'c '.$i.':00';
        }

        foreach ($watch as $value) {
            $delivery = new AdvertisingWatch();
            $delivery->setName($value);

            $em->persist($delivery);
        }

        $duration = [];
        for ($i = 1; $i <= 24; $i++) {
            $duration[$i] = $i.' (в часах)';
        }

        foreach ($duration as $value) {
            $delivery = new AdvertisingDuration();
            $delivery->setName($value);

            $em->persist($delivery);
        }

        $em->flush();
    }
}