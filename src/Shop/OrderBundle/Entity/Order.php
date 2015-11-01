<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;

/**
 * @ORM\Entity(repositoryClass="Shop\OrderBundle\Repository\OrderRepository")
 * @ORM\Table(name="`order`")
 */

class Order
{   
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /** 
     * @ORM\Column(name="order_number", type="string", length=45)
     */
    protected $order_number;

    /**
     * @ORM\Column(name="amount", type="decimal", precision=6, scale=2, nullable=true)
     */
    protected $amount;
    
    /** 
     * @ORM\Column(name="check_pay", type="boolean") 
     */
    protected $check_pay;
    
    /**
     * @ORM\Column(name="createdAt", type="datetime")
     */
    protected $createdAt;
    
    /**
     * @ORM\OneToOne(targetEntity="Shop\OrderBundle\Entity\Address", mappedBy="order", cascade={"persist"})
     */
    protected $address;
    
    /**
     * @ORM\OneToMany(targetEntity="Shop\OrderBundle\Entity\OrderDelivery", mappedBy="order", cascade={"persist"})
     */
    protected $delivery;
    
    /**
     * @ORM\ManyToMany(targetEntity="User\RegistrationBundle\Entity\Users", inversedBy="order")
     * @ORM\JoinColumn(name="order_user")
     */
    protected $users;
    
    /*
     * constructor
     */
    public function __construct($amount, $orderNumber)
    {
        $this->amount = $amount;
        $this->order_number = $orderNumber;
        $this->check_pay = false;
        $this->createdAt = new \DateTime();
        $this->users = new ArrayCollection();
        $this->delivery = new ArrayCollection();
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
     * Set order_number
     *
     * @param string $orderNumber
     * @return Order
     */
    public function setOrderNumber($orderNumber)
    {
        $this->order_number = $orderNumber;
    
        return $this;
    }

    /**
     * Get order_number
     *
     * @return string 
     */
    public function getOrderNumber()
    {
        return $this->order_number;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return Order
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set check_pay
     *
     * @param boolean $checkPay
     * @return Order
     */
    public function setCheckPay($checkPay)
    {
        $this->check_pay = $checkPay;
    
        return $this;
    }

    /**
     * Get check_pay
     *
     * @return boolean 
     */
    public function getCheckPay()
    {
        return $this->check_pay;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Order
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
     * Set address
     *
     * @param \Shop\OrderBundle\Entity\Address $address
     * @return Order
     */
    public function setAddress(\Shop\OrderBundle\Entity\Address $address = null)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return \Shop\OrderBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add users
     *
     * @param \User\RegistrationBundle\Entity\Users $users
     * @return Order
     */
    public function addUser(\User\RegistrationBundle\Entity\Users $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \User\RegistrationBundle\Entity\Users $users
     */
    public function removeUser(\User\RegistrationBundle\Entity\Users $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add delivery
     *
     * @param \Shop\OrderBundle\Entity\OrderDelivery $delivery
     * @return Order
     */
    public function addDelivery(\Shop\OrderBundle\Entity\OrderDelivery $delivery)
    {
        $this->delivery[] = $delivery;
    
        return $this;
    }

    /**
     * Remove delivery
     *
     * @param \Shop\OrderBundle\Entity\OrderDelivery $delivery
     */
    public function removeDelivery(\Shop\OrderBundle\Entity\OrderDelivery $delivery)
    {
        $this->delivery->removeElement($delivery);
    }

    /**
     * Get delivery
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDelivery()
    {
        return $this->delivery;
    }
}