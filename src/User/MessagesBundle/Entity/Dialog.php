<?php

/*
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
     * @ORM\ManyToOne(targetEntity="User\RegistrationBundle\Entity\Users")
     * @ORM\JoinColumn(name="send_id", referencedColumnName="id")
     */
    protected $send;
    
    /**
     * @ORM\ManyToOne(targetEntity="User\RegistrationBundle\Entity\Users")
     * @ORM\JoinColumn(name="take_id", referencedColumnName="id")
     */
    protected $take;
    
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
     * @ORM\OneToMany(targetEntity="User\MessagesBundle\Entity\Messages", mappedBy="dialog", cascade={"all"})
     */
    protected $messages;
    
    /**
     * Consrtuct for class Messages
     */
    public function __construct() {
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
     * Set send
     *
     * @param \User\RegistrationBundle\Entity\Users $send
     * @return Dialog
     */
    public function setSend(\User\RegistrationBundle\Entity\Users $send = null)
    {
        $this->send = $send;
    
        return $this;
    }

    /**
     * Get send
     *
     * @return \User\RegistrationBundle\Entity\Users 
     */
    public function getSend()
    {
        return $this->send;
    }

    /**
     * Set take
     *
     * @param \User\RegistrationBundle\Entity\Users $take
     * @return Dialog
     */
    public function setTake(\User\RegistrationBundle\Entity\Users $take = null)
    {
        $this->take = $take;
    
        return $this;
    }

    /**
     * Get take
     *
     * @return \User\RegistrationBundle\Entity\Users 
     */
    public function getTake()
    {
        return $this->take;
    }

    /**
     * Add messages
     *
     * @param \User\MessagesBundle\Entity\Messages $messages
     * @return Dialog
     */
    public function addMessage(\User\MessagesBundle\Entity\Messages $messages)
    {
        $this->messages[] = $messages;
    
        return $this;
    }

    /**
     * Remove messages
     *
     * @param \User\MessagesBundle\Entity\Messages $messages
     */
    public function removeMessage(\User\MessagesBundle\Entity\Messages $messages)
    {
        $this->messages->removeElement($messages);
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