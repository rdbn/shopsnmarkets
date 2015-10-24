<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Services;

use User\FriendsBundle\Entity\Friends;

use Doctrine\ORM\EntityManager;

class AddFriends {
    
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function add($id, $user) {
        if (settype($id, 'integer')) {
            $typeFriends = $this->em->getRepository('UserFriendsBundle:TypeFriends')
                    ->findOneById('1');
            
            $usersFriends = new Friends();
            $usersFriends->setId($id);
            $usersFriends->setUsers($user);
            $usersFriends->setTypeFriends($typeFriends);
            $usersFriends->setCheckFriends('0');

            $addFriends = $this->em;
            $addFriends->persist($usersFriends);
            $addFriends->flush();

            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>
