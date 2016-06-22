<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 06.06.16
 * Time: 10:24
 */

namespace User\MessagesBundle\Twig;

use Doctrine\ORM\EntityManager as Manager;

class UserMessageExtension extends \Twig_Extension
{
    /**
     * @var Manager
    */
    private $em;

    /**
     * variable init
     *
     * @param Manager $em
    */
    public function __construct(Manager $em)
    {
        $this->em = $em;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('notReadMessage', [$this, 'notReadMessageFilter']),
        );
    }

    public function notReadMessageFilter($id)
    {
        $count = $this->em->getRepository("UserMessagesBundle:Dialog")
            ->findOneByNotReadMessage($id);

        return $count;
    }

    public function getName()
    {
        return 'app_extension';
    }
}