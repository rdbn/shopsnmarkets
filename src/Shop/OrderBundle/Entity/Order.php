<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\Column(name="is_create_order", type="boolean", options={"default" = FALSE})
     */
    protected $isCreateOrder;
    
    /** 
     * @ORM\Column(name="is_pay", type="boolean", options={"default" = FALSE})
     */
    protected $isPay;
    
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
        $this->isPay = false;
        $this->isCreateOrder = false;

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
     * Set isCreateOrder
     *
     * @param boolean $isCreateOrder
     *
     * @return Order
     */
    public function setIsCreateOrder($isCreateOrder)
    {
        $this->isCreateOrder = $isCreateOrder;

        return $this;
    }

    /**
     * Get isCreateOrder
     *
     * @return boolean
     */
    public function getIsCreateOrder()
    {
        return $this->isCreateOrder;
    }

    /**
     * Set isPay
     *
     * @param boolean $isPay
     *
     * @return Order
     */
    public function setIsPay($isPay)
    {
        $this->isPay = $isPay;

        return $this;
    }

    /**
     * Get isPay
     *
     * @return boolean
     */
    public function getIsPay()
    {
        return $this->isPay;
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
