<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="User\MessagesBundle\Repository\MessagesRepository")
 * @ORM\Table(name="messages")
 */

class Messages
{   
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="User\MessagesBundle\Entity\Dialog", inversedBy="messages", cascade={"all"})
     * @ORM\JoinColumn(name="dialog_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $dialog;
    
    /**
     * @ORM\ManyToOne(targetEntity="User\RegistrationBundle\Entity\Users")
     * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     */
    protected $users;
    
    /**
     * @ORM\Column(name="text", type="text")
     */
    protected $text;
    
    /**
     * @ORM\Column(name="flags", type="boolean")
     */
    protected $flags;
    
    /**
     * @ORM\Column(type="datetime", name="created_at")
     *
     * @var DateTime $createdAt
     */
    protected $createdAt;
    
    /**
     * Consrtuct for class Messages
     */
    public function __construct() {
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
     * Set text
     *
     * @param string $text
     * @return Messages
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set flags
     *
     * @param boolean $flags
     * @return Messages
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
     * @return Messages
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
     * Set dialog
     *
     * @param \User\MessagesBundle\Entity\Dialog $dialog
     * @return Messages
     */
    public function setDialog(\User\MessagesBundle\Entity\Dialog $dialog = null)
    {
        $this->dialog = $dialog;
    
        return $this;
    }

    /**
     * Get dialog
     *
     * @return \User\MessagesBundle\Entity\Dialog 
     */
    public function getDialog()
    {
        return $this->dialog;
    }

    /**
     * Set users
     *
     * @param \User\RegistrationBundle\Entity\Users $users
     * @return Messages
     */
    public function setUsers(\User\RegistrationBundle\Entity\Users $users = null)
    {
        $this->users = $users;
    
        return $this;
    }

    /**
     * Get users
     *
     * @return \User\RegistrationBundle\Entity\Users 
     */
    public function getUsers()
    {
        return $this->users;
    }
}