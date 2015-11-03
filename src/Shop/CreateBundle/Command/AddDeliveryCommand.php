<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 25.10.15
 * Time: 13:47
 */

namespace Shop\CreateBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Shop\CreateBundle\Entity\Delivery;

class AddDeliveryCommand extends ContainerAwareCommand
{
    /**
     * @var array
    */
    private $deliveries = [
        ["name" => "Курьер", "img" => "public/images/delivery/courier.gif"],
        ["name" => "DHL", "img" => "public/images/delivery/dhl.gif"],
        ["name" => "EMS", "img" => "public/images/delivery/ems.gif"],
        ["name" => "Express Ru", "img" => "public/images/delivery/expressru.gif"],
        ["name" => "FedEx", "img" => "public/images/delivery/fedex.gif"],
        ["name" => "Гарантпост", "img" => "public/images/delivery/garantpost.gif"],
        ["name" => "iBox", "img" => "public/images/delivery/ibox.gif"],
        ["name" => "PONY EXPRESS", "img" => "public/images/delivery/ponyexpress.gif"],
        ["name" => "Почта России", "img" => "public/images/delivery/russianpost.gif"],
        ["name" => "Самовывоз", "img" => "public/images/delivery/self-delivery.gif"],
        ["name" => "СПСР-ЭКСПРЕСС", "img" => "public/images/delivery/spsr.gif"],
        ["name" => "UPS", "img" => "public/images/delivery/ups.gif"],
        ["name" => "USPS", "img" => "public/images/delivery/usps.gif"],
    ];

    protected function configure()
    {
        $this
            ->setName('add:delivery')
            ->setDescription('Добавляем способы доставки.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        foreach ($this->deliveries as $value) {
            $delivery = new Delivery();
            $delivery->setName($value["name"]);
            $delivery->setImage($value["img"]);

            $em->persist($delivery);
        }

        $em->flush();
    }
}