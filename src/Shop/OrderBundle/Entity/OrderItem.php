<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_item")
 */

class OrderItem 
{  
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\OrderBundle\Entity\Order", cascade={"persist"})
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\CreateBundle\Entity\Shops")
     * @ORM\JoinColumn(name="shops_id", referencedColumnName="id")
     */
    protected $shops;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\AddProductsBundle\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    
    /**
     * @ORM\ManyToMany(targetEntity="Shop\AddProductsBundle\Entity\Size", inversedBy="order")
     * @ORM\JoinColumn(name="order_size")
     */
    protected $size;
    
    /*
     * constructor
     */
    public function __construct()
    {
        $this->size = new ArrayCollection();
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
     * Set order
     *
     * @param \Shop\OrderBundle\Entity\Order $order
     * @return OrderItem
     */
    public function setOrder(\Shop\OrderBundle\Entity\Order $order = null)
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
     * @return OrderItem
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
     * Set product
     *
     * @param \Shop\AddProductsBundle\Entity\Product $product
     * @return OrderItem
     */
    public function setProduct(\Shop\AddProductsBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Shop\AddProductsBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add size
     *
     * @param \Shop\AddProductsBundle\Entity\Size $size
     * @return OrderItem
     */
    public function addSize(\Shop\AddProductsBundle\Entity\Size $size)
    {
        $this->size[] = $size;
    
        return $this;
    }

    /**
     * Remove size
     *
     * @param \Shop\AddProductsBundle\Entity\Size $size
     */
    public function removeSize(\Shop\AddProductsBundle\Entity\Size $size)
    {
        $this->size->removeElement($size);
    }

    /**
     * Get size
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSize()
    {
        return $this->size;
    }
}