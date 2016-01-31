<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shop\ProductBundle\Repository\HashTagsRepository")
 * @ORM\Table(name="hash_tags")
 */

Class HashTags
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=45, unique=true)
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Shop\ProductBundle\Entity\Product", mappedBy="hashTags")
     */
    protected $product;

    /**
     * @ORM\ManyToMany(targetEntity="Shop\CreateBundle\Entity\Shops", mappedBy="shopTags")
     */
    protected $shop;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return HashTags
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add product
     *
     * @param \Shop\ProductBundle\Entity\Product $product
     *
     * @return HashTags
     */
    public function addProduct(\Shop\ProductBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \Shop\ProductBundle\Entity\Product $product
     */
    public function removeProduct(\Shop\ProductBundle\Entity\Product $product)
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
     * Add shop
     *
     * @param \Shop\CreateBundle\Entity\Shops $shop
     *
     * @return HashTags
     */
    public function addShop(\Shop\CreateBundle\Entity\Shops $shop)
    {
        $this->shop[] = $shop;

        return $this;
    }

    /**
     * Remove shop
     *
     * @param \Shop\CreateBundle\Entity\Shops $shop
     */
    public function removeShop(\Shop\CreateBundle\Entity\Shops $shop)
    {
        $this->shop->removeElement($shop);
    }

    /**
     * Get shop
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShop()
    {
        return $this->shop;
    }
}
