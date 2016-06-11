<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 01.06.16
 * Time: 0:02
 */
namespace User\MessagesBundle\Consumer\Handler;

use User\MessagesBundle\Entity\Dialog;
use User\MessagesBundle\Entity\Messages;

use Predis\Client;
use PhpAmqpLib\Message\AMQPMessage;
use Doctrine\ORM\EntityManager as Manager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;

abstract class AbstractMessage
{
    /**
     * @var Manager
     */
    protected $em;

    /**
     * @var Client
     */
    protected $redis;

    /**
     * init variable
     *
     * @param Manager $em
     * @param Client $redis
     */
    public function __construct(Manager $em, Client $redis)
    {
        $this->em = $em;
        $this->redis = $redis;
    }

    /**
     * Отправляем метку количества не прочитанных сообщений
     *
     * @param int $user
     *
     * @return integer
    */
    protected function sendCountNotReadMessage($user)
    {
        $notReadMessage = $this->em->getRepository("UserMessagesBundle:Dialog")
            ->findOneByNotReadMessage($user);

        if ($notReadMessage > 0) {
            $this->redis->publish('not-read', json_encode([
                'username' => 'username_' . $user,
                'count' => $notReadMessage,
            ]));
        }
    }
}