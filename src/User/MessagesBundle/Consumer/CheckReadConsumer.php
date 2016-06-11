<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 07.06.16
 * Time: 23:33
 */

namespace User\MessagesBundle\Consumer;

use User\MessagesBundle\Entity\Messages;

use PhpAmqpLib\Message\AMQPMessage;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use User\MessagesBundle\Consumer\Handler\AbstractMessage;

class CheckReadConsumer extends AbstractMessage implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        echo $msg->body . PHP_EOL;
        $parameters = json_decode($msg->body, 1);

        preg_match('/username_(.*\d)/', $parameters['from'], $from);
        preg_match('/username_(.*\d)/', $parameters['to'], $to);

        $dialog = $this->em->getRepository("UserMessagesBundle:Dialog")
            ->findOneBy(['users' => $from[1], 'usersTo' => $to[1]]);

        $dialog->setFlags(true);

        $this->checkStatus($from[1], $to[1], $to[1]);
        $this->checkStatus($to[1], $from[1], $to[1]);
        
        $this->em->flush();
        if (!$parameters['isReadMessage']) {
            $this->sendCountNotReadMessage($to[1]);
        }

        return true;
    }

    /**
     * Обновляем статус прочитано или нет сообщение
     *
     * @param int $from
     * @param int $to
     * @param int $checkUser
    */
    private function checkStatus($from, $to, $checkUser)
    {
        $messages = $this->em->getRepository('UserMessagesBundle:Messages')
            ->findByCheckMessages($from, $to, $checkUser);

        foreach ($messages as $message) {
            /** @var Messages $message */
            $message->setFlags(true);
        }
    }
}