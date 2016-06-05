<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="User\MessagesBundle\Repository\DialogRepository")
 * @ORM\Table(name="dialog")
 */

class Dialog
{   
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\Users")
     * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     */
    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\Users")
     * @ORM\JoinColumn(name="users_to_id", referencedColumnName="id")
     */
    protected $usersTo;
    
    /**
     * @ORM\Column(name="flags", type="boolean")
     */
    protected $flags;
    
    /**
     * @ORM\Column(type="datetime", name="created_at")
     *
     * @var \DateTime $createdAt
     */
    protected $createdAt;
    
    /**
     * @ORM\OneToMany(targetEntity="User\MessagesBundle\Entity\Messages", mappedBy="dialog", cascade={"all"})
     */
    protected $messages;
    
    /**
     * Construct for class Messages
     */
    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->flags = false;
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
     * Set flags
     *
     * @param boolean $flags
     *
     * @return Dialog
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Get flags
     *
     * @return boolean
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Dialog
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set users
     *
     * @param \User\UserBundle\Entity\Users $users
     *
     * @return Dialog
     */
    public function setUsers(\User\UserBundle\Entity\Users $users = null)
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
     * Set usersTo
     *
     * @param \User\UserBundle\Entity\Users $usersTo
     *
     * @return Dialog
     */
    public function setUsersTo(\User\UserBundle\Entity\Users $usersTo = null)
    {
        $this->usersTo = $usersTo;

        return $this;
    }

    /**
     * Get usersTo
     *
     * @return \User\UserBundle\Entity\Users
     */
    public function getUsersTo()
    {
        return $this->usersTo;
    }

    /**
     * Add message
     *
     * @param \User\MessagesBundle\Entity\Messages $message
     *
     * @return Dialog
     */
    public function addMessage(\User\MessagesBundle\Entity\Messages $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \User\MessagesBundle\Entity\Messages $message
     */
    public function removeMessage(\User\MessagesBundle\Entity\Messages $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
