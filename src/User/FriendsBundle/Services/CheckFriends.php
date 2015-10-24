<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Services;

use User\FriendsBundle\Entity\Friends;

use Doctrine\ORM\EntityManager;

class CheckFriends {
    
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function check($id, $userID) {
        if (gettype($id) == 'array' && settype($id['type'], 'integer') && settype($id['id'], 'integer')) {            
            $type = $this->em->getRepository('UserFriendsBundle:TypeFriends')
                    ->findOneById($id['type']);
            
            $this->setFriends($userID, $id, $type);
            $this->checkUpdate($id, $userID);
            
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    private function setFriends($userID, $id, $type) {
        $friends = new Friends();
        $friends->setId($id['id']);
        $friends->setUsers($userID);
        $friends->setTypeFriends($type);
        $friends->setCheckFriends('1');

        $add = $this->em;
        $add->persist($friends);
        $add->flush();
    }
    
    private function checkUpdate($id, $userID) {
        $query = $this->em->createQueryBuilder()
                ->update('UserFriendsBundle:Friends', 'f')
                ->set('f.check_friends', '1')
                ->where('f.id = :id')
                ->setParameter('id', $userID)
                ->andWhere('f.users = :id_user')
                ->setParameter('id_user', $id['id']);
        
        $query->getQuery()->execute();
    }
}
?>
