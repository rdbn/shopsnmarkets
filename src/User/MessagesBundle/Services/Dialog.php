<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Services;

use Doctrine\ORM\EntityManager;

class Dialog
{
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function updateDialog($id) {
        $query = $this->em->createQueryBuilder()
                ->update('UserMessagesBundle:Dialog', 'd')
                ->set('d.flags', '2')
                ->where('d.id = :id')
                ->setParameter('id', $id);
        
        $query->getQuery()->execute();
    }
    
    public function deleteDialog($id) {
        $em = $this->em;
        $dialog = $em->getRepository('UserMessagesBundle:Dialog')
                ->findOneById($id);
        
        $messages = $em->getRepository('UserMessagesBundle:Messages')
                ->findOneByDialog($id);
        
        $em->remove($messages);
        $em->remove($dialog);
        $em->flush();
    }
    
    public function updateMessage($id, $flags) {
        $query = $this->em->createQueryBuilder()
                ->update('UserMessagesBundle:Messages', 'm')
                ->set('m.flags', $flags)
                ->where('m.id = :id')
                ->setParameter('id', $id);

        $query->getQuery()->execute();
    }
    
    public function deleteMessage($id) {
        $query = $this->em->createQueryBuilder()
                ->delete('UserMessagesBundle:Messages', 'm')
                ->where('m.id = :id')
                ->setParameter('id', $id);
        
        $query->getQuery()->execute();
    }
}
?>
