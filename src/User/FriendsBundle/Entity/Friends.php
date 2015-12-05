<?php

/* 
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
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\Users", inversedBy="friends")
     * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     */
    protected $users;
    
    /**
     * @ORM\ManyToOne(targetEntity="User\FriendsBundle\Entity\TypeFriends")
     * @ORM\JoinColumn(name="type_friends_id", referencedColumnName="id")
     */
    protected $type_friends;
    
    /**
     * @ORM\Column(name="check_fiends", type="boolean")
     */
    protected $check_friends;
    
    /**
     * Consrtuct for class Partners
     */
    public function __construct() {
        $this->users = new ArrayCollection();
        $this->check_partners = true;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Friends
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set check_friends
     *
     * @param boolean $checkFriends
     * @return Friends
     */
    public function setCheckFriends($checkFriends)
    {
        $this->check_friends = $checkFriends;
    
        return $this;
    }

    /**
     * Get check_friends
     *
     * @return boolean 
     */
    public function getCheckFriends()
    {
        return $this->check_friends;
    }

    /**
     * Set users
     *
     * @param \User\UserBundle\Entity\Users $users
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
     * Set type_friends
     *
     * @param \User\FriendsBundle\Entity\TypeFriends $typeFriends
     * @return Friends
     */
    public function setTypeFriends(\User\FriendsBundle\Entity\TypeFriends $typeFriends = null)
    {
        $this->type_friends = $typeFriends;
    
        return $this;
    }

    /**
     * Get type_friends
     *
     * @return \User\FriendsBundle\Entity\TypeFriends 
     */
    public function getTypeFriends()
    {
        return $this->type_friends;
    }
}