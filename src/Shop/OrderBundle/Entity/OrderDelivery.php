<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_delivery")
 */

class OrderDelivery
{      
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Shop\OrderBundle\Entity\Order", inversedBy="delivery")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Shop\CreateBundle\Entity\Shops")
     * @ORM\JoinColumn(name="shops_id", referencedColumnName="id")
     */
    protected $shops;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Shop\CreateBundle\Entity\Delivery")
     * @ORM\JoinColumn(name="delivery_id", referencedColumnName="id")
     */
    protected $delivery;

    /**
     * Set order
     *
     * @param \Shop\OrderBundle\Entity\Order $order
     * @return OrderDelivery
     */
    public function setOrder(\Shop\OrderBundle\Entity\Order $order)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return \Shop\OrderBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set shops
     *
     * @param \Shop\CreateBundle\Entity\Shops $shops
     * @return OrderDelivery
     */
    public function setShops(\Shop\CreateBundle\Entity\Shops $shops)
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
     * @param \Shop\CreateBundle\Entity\Delivery $delivery
     * @return OrderDelivery
     */
    public function setDelivery(\Shop\CreateBundle\Entity\Delivery $delivery)
    {
        $this->delivery = $delivery;
    
        return $this;
    }

    /**
     * Get delivery
     *
     * @return \Shop\CreateBundle\Entity\Delivery 
     */
    public function getDelivery()
    {
        return $this->delivery;
    }
}