<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Services;

use Doctrine\ORM\EntityManager;

class DeleteFriends {
    
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function deleteFriends($userID, $id) {
        if (settype($id, 'integer')) {
            $this->delete($userID, $id);
            $this->delete($id, $userID);
            
            return true;
        } else {
            return false;
        }
    }
    
    private function delete($userID, $id) {
        $em = $this->em->createQueryBuilder();
            $query = $em->delete('UserFriendsBundle:Friends', 'f')
                    ->where('f.id = :id')
                    ->setParameter('id', $id)
                    ->andWhere('f.users = :id_users')
                    ->setParameter('id_users', $userID);

            $query->getQuery()->execute();
    }
}
?>
