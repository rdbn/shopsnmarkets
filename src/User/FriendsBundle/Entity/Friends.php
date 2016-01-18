<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity(repositoryClass="User\FriendsBundle\Repository\FriendsRepository")
 * @ORM\Table(name="friends")
 */
class Friends
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\Users", inversedBy="usersFriends")
     * @ORM\JoinColumn(name="friends_id", referencedColumnName="id")
     */
    protected $friends;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\Users", inversedBy="friends")
     * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     */
    protected $users;
    
    /**
     * @ORM\ManyToOne(targetEntity="User\FriendsBundle\Entity\TypeFriends")
     * @ORM\JoinColumn(name="type_friends_id", referencedColumnName="id", nullable=true)
     */
    protected $typeFriends;
    
    /**
     * @ORM\Column(name="check_fiends", type="boolean")
     */
    protected $checkFriends;
    
    /**
     * Construct for class Friends
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->checkFriends = false;
    }

    /**
     * Set checkFriends
     *
     * @param boolean $checkFriends
     *
     * @return Friends
     */
    public function setCheckFriends($checkFriends)
    {
        $this->checkFriends = $checkFriends;

        return $this;
    }

    /**
     * Get checkFriends
     *
     * @return boolean
     */
    public function getCheckFriends()
    {
        return $this->checkFriends;
    }

    /**
     * Set friends
     *
     * @param \User\UserBundle\Entity\Users $friends
     *
     * @return Friends
     */
    public function setFriends(\User\UserBundle\Entity\Users $friends)
    {
        $this->friends = $friends;

        return $this;
    }

    /**
     * Get friends
     *
     * @return \User\UserBundle\Entity\Users
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Set users
     *
     * @param \User\UserBundle\Entity\Users $users
     *
     * @return Friends
     */
    public function setUsers(\User\UserBundle\Entity\Users $users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \User\UserBundle\Entity\Users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set typeFriends
     *
     * @param \User\FriendsBundle\Entity\TypeFriends $typeFriends
     *
     * @return Friends
     */
    public function setTypeFriends(\User\FriendsBundle\Entity\TypeFriends $typeFriends = null)
    {
        $this->typeFriends = $typeFriends;

        return $this;
    }

    /**
     * Get typeFriends
     *
     * @return \User\FriendsBundle\Entity\TypeFriends
     */
    public function getTypeFriends()
    {
        return $this->typeFriends;
    }
}
