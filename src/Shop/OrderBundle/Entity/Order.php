<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="Shop\OrderBundle\Entity\Address", inversedBy="order")
     * @ORM\JoinColumn(name="address_id", nullable=true)
     */
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\Users", inversedBy="order")
     * @ORM\JoinColumn(name="users_id", nullable=true)
     */
    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="Shop\CreateBundle\Entity\Shops", inversedBy="order")
     * @ORM\JoinColumn(name="shops_id", nullable=true)
     */
    protected $shops;

    /**
     * @ORM\ManyToOne(targetEntity="Shop\CreateBundle\Entity\ShopsDelivery", inversedBy="order")
     * @ORM\JoinColumn(name="delivery_id", nullable=true)
     */
    protected $delivery;

    /**
     * @ORM\Column(name="amount", type="decimal", precision=6, scale=2, nullable=true)
     */
    protected $amount;
    
    /** 
     * @ORM\Column(name="check_pay", type="boolean")
     */
    protected $checkPay;
    
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Shop\OrderBundle\Entity\OrderItem", mappedBy="order", cascade={"persist"})
     */
    protected $orderItem;
    
    /**
     * constructor
     */
    public function __construct()
    {
        $this->amount = 100;
        $this->checkPay = false;

        $this->createdAt = new \DateTime();
        $this->orderItem = new ArrayCollection();
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
     * Set amount
     *
     * @param string $amount
     *
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
     * Set checkPay
     *
     * @param boolean $checkPay
     *
     * @return Order
     */
    public function setCheckPay($checkPay)
    {
        $this->checkPay = $checkPay;

        return $this;
    }

    /**
     * Get checkPay
     *
     * @return boolean
     */
    public function getCheckPay()
    {
        return $this->checkPay;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
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
     *
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
     * Set users
     *
     * @param \User\UserBundle\Entity\Users $users
     *
     * @return Order
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
     * Set shops
     *
     * @param \Shop\CreateBundle\Entity\Shops $shops
     *
     * @return Order
     */
    public function setShops(\Shop\CreateBundle\Entity\Shops $shops = null)
    {
        $this->shops = $shops;

        return $this;
    }

    /**
     * Get shops
     *
     * @return \Shop\CreateBundle\Entity\Shops
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * Set delivery
     *
     * @param \Shop\CreateBundle\Entity\ShopsDelivery $delivery
     *
     * @return Order
     */
    public function setDelivery(\Shop\CreateBundle\Entity\ShopsDelivery $delivery = null)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery
     *
     * @return \Shop\CreateBundle\Entity\ShopsDelivery
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Add orderItem
     *
     * @param \Shop\OrderBundle\Entity\OrderItem $orderItem
     *
     * @return Order
     */
    public function addOrderItem(\Shop\OrderBundle\Entity\OrderItem $orderItem)
    {
        $this->orderItem[] = $orderItem;

        return $this;
    }

    /**
     * Remove orderItem
     *
     * @param \Shop\OrderBundle\Entity\OrderItem $orderItem
     */
    public function removeOrderItem(\Shop\OrderBundle\Entity\OrderItem $orderItem)
    {
        $this->orderItem->removeElement($orderItem);
    }

    /**
     * Get orderItem
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderItem()
    {
        return $this->orderItem;
    }
}
