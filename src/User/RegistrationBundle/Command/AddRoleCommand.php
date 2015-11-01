<?php

/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 24.10.15
 * Time: 16:57
 */
namespace User\RegistrationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use User\RegistrationBundle\Entity\Roles;

class AddRoleCommand extends ContainerAwareCommand
{
    /**
     * @var array
    */
    private $roles = [
        "ROLE_ADMIN",
        "ROLE_USER",
        "ROLE_MANAGER",
    ];

    protected function configure()
    {
        $this
            ->setName('add:roles')
            ->setDescription('Добавляем роли');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        foreach ($this->roles as $name) {
            $role = new Roles();
            $role->setRole($name);
            $role->setName($name);

            $em->persist($role);
        }

        $em->flush();
    }
}