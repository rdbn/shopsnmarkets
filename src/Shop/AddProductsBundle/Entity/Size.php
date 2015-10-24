<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="size")
 */

Class Size
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\AddProductsBundle\Entity\TypeThing")
     * @ORM\JoinColumn(name="type_thing_id", referencedColumnName="id")
     */
    protected $type_thing;  
    
    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $value;
    
    /**
     * @ORM\ManyToMany(targetEntity="Shop\AddProductsBundle\Entity\Product", mappedBy="size")
     */
    protected $product;
    
    /**
     * @ORM\ManyToMany(targetEntity="Shop\OrderBundle\Entity\OrderItem", mappedBy="size")
     */
    protected $order;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->order = new ArrayCollection();
    }
    
    /**
     * toString
     */
    public function __toString() {
        return (string)  $this->value;
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
     * Set value
     *
     * @param string $value
     * @return Size
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set type_thing
     *
     * @param \Shop\AddProductsBundle\Entity\TypeThing $typeThing
     * @return Size
     */
    public function setTypeThing(\Shop\AddProductsBundle\Entity\TypeThing $typeThing = null)
    {
        $this->type_thing = $typeThing;
    
        return $this;
    }

    /**
     * Get type_thing
     *
     * @return \Shop\AddProductsBundle\Entity\TypeThing 
     */
    public function getTypeThing()
    {
        return $this->type_thing;
    }

    /**
     * Add product
     *
     * @param \Shop\AddProductsBundle\Entity\Product $product
     * @return Size
     */
    public function addProduct(\Shop\AddProductsBundle\Entity\Product $product)
    {
        $this->product[] = $product;
    
        return $this;
    }

    /**
     * Remove product
     *
     * @param \Shop\AddProductsBundle\Entity\Product $product
     */
    public function removeProduct(\Shop\AddProductsBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add order
     *
     * @param \Shop\OrderBundle\Entity\OrderItem $order
     * @return Size
     */
    public function addOrder(\Shop\OrderBundle\Entity\OrderItem $order)
    {
        $this->order[] = $order;
    
        return $this;
    }

    /**
     * Remove order
     *
     * @param \Shop\OrderBundle\Entity\OrderItem $order
     */
    public function removeOrder(\Shop\OrderBundle\Entity\OrderItem $order)
    {
        $this->order->removeElement($order);
    }

    /**
     * Get order
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrder()
    {
        return $this->order;
    }
}