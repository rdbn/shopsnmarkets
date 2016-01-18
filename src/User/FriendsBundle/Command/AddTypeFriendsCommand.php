<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 25.10.15
 * Time: 13:47
 */

namespace User\FriendsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use User\FriendsBundle\Entity\TypeFriends;

class AddTypeFriendsCommand extends ContainerAwareCommand
{
    /**
     * @var array
    */
    private $type = [
        "Лучший друг",
        "Товарищ",
        "Приятель",
        "Коллега",
        "Партнер",
    ];

    protected function configure()
    {
        $this
            ->setName('add:type:friends')
            ->setDescription('Добавляем типы дружбы.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        foreach ($this->type as $value) {
            $delivery = new TypeFriends();
            $delivery->setName($value);

            $em->persist($delivery);
        }

        $em->flush();
    }
}