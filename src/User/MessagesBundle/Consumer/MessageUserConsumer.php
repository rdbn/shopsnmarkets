<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 01.06.16
 * Time: 0:02
 */
namespace User\MessagesBundle\Consumer;

use User\MessagesBundle\Entity\Dialog;
use User\MessagesBundle\Entity\Messages;

use Predis\Client;
use PhpAmqpLib\Message\AMQPMessage;
use Doctrine\ORM\EntityManager as Manager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;

class MessageUserConsumer implements ConsumerInterface
{
    /**
     * @var Manager
     */
    private $em;

    /**
     * @var Client
     */
    private $redis;

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

    public function execute(AMQPMessage $msg)
    {
        echo $msg->body . PHP_EOL;
        $parameters = json_decode($msg->body, 1);
        $date = new \DateTime($parameters['date']);

        preg_match('/username_(.*\d)/', $parameters['from'], $from);
        preg_match('/username_(.*\d)/', $parameters['to'], $to);

        /** Message from */
        $this->addDialog($parameters['message'], $date, ['from' => $from[1], 'to' => $to[1]]);
        /** Message to */
        $this->addDialog($parameters['message'], $date, ['from' => $to[1], 'to' => $from[1]]);

        /** Save message */
        $this->em->flush();


        $this->redis->publish('not-read', json_encode([
            'username' => 'username_'.$parameters['to'],
        ]));

        return true;
    }

    /**
     * Получаем объект диалога
     *
     * @param string $messageText
     * @param \DateTime $date
     * @param array $data
     */
    private function addDialog($messageText, $date, array $data)
    {
        $dialog = $this->em->getRepository("UserMessagesBundle:Dialog")
            ->findOneBy(['users' => $data['from'], 'usersTo' => $data['to']]);

        if (!$dialog) {
            $usersFrom = $this->em->getRepository("UserUserBundle:Users")
                ->findOneBy(['id' => $data['from']]);

            $usersTo = $this->em->getRepository("UserUserBundle:Users")
                ->findOneBy(['id' => $data['to']]);

            $dialog = new Dialog();
            $dialog->setUsers($usersFrom);
            $dialog->setUsersTo($usersTo);

            $this->em->persist($dialog);
        } else {
            $dialog->setFlags(false);
        }

        $this->addMessage($dialog, $messageText, $date);
    }

    /**
     * Создаем сообщение
     *
     * @param Dialog $dialog
     * @param string $messageText
     * @param \DateTime $date
     */
    private function addMessage(Dialog $dialog, $messageText, \DateTime $date)
    {
        $message = new Messages();
        $message->setDialog($dialog);
        $message->setUsers($dialog->getUsers());
        $message->setText($messageText);
        $message->setCreatedAt($date);

        $this->em->persist($message);
    }
}