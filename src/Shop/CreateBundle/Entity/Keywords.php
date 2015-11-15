<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="keywords")
 */

class Keywords
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
     * @ORM\ManyToMany(targetEntity="Shop\CreateBundle\Entity\Shops", mappedBy="keywords")
     */
    protected $shop;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shop = new ArrayCollection();
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
     * @return Keywords
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
     * Add shop
     *
     * @param \Shop\CreateBundle\Entity\Shops $shop
     *
     * @return Keywords
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
