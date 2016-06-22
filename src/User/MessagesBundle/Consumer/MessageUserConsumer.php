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

use PhpAmqpLib\Message\AMQPMessage;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use User\MessagesBundle\Consumer\Handler\AbstractMessage;

class MessageUserConsumer extends AbstractMessage implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        echo $msg->body . PHP_EOL;
        $parameters = json_decode($msg->body, 1);
        $date = new \DateTime($parameters['date']);

        preg_match('/username_(.*\d)/', $parameters['from'], $from);
        preg_match('/username_(.*\d)/', $parameters['to'], $to);

        /** Message from */
        $this->addDialog($parameters['message'], $date, ['from' => $from[1], 'to' => $to[1]], true);
        /** Message to */
        $this->addDialog($parameters['message'], $date, ['from' => $to[1], 'to' => $from[1]], false);

        /** Save message */
        $this->em->flush();
        $this->sendCountNotReadMessage($to[1]);
        
        return true;
    }

    /**
     * Получаем объект диалога
     *
     * @param string $messageText
     * @param \DateTime $date
     * @param array $data
     * @param boolean $isFrom
     */
    private function addDialog($messageText, $date, array $data, $isFrom)
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
        }

        if ($isFrom) {
            $dialog->setFlags(true);
        } else {
            $dialog->setFlags(false);
        }

        $this->addMessage($dialog, $messageText, $date, $isFrom);
    }

    /**
     * Создаем сообщение
     *
     * @param Dialog $dialog
     * @param string $messageText
     * @param \DateTime $date
     * @param boolean $isFrom
     */
    private function addMessage(Dialog $dialog, $messageText, \DateTime $date, $isFrom)
    {
        $message = new Messages();
        $message->setDialog($dialog);
        $message->setText($messageText);
        $message->setCreatedAt($date);

        if ($isFrom) {
            $message->setUsers($dialog->getUsers());
        } else {
            $message->setUsers($dialog->getUsersTo());
        }

        $this->em->persist($message);
    }
}