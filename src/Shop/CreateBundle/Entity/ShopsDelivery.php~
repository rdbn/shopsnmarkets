<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Shop\CreateBundle\Repository\ShopsDeliveryRepository")
 * @ORM\Table(name="shops_delivery")
 */

class ShopsDelivery
{     
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Shop\CreateBundle\Entity\Shops", inversedBy="shops_delivery")
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
     * @ORM\Column(name="price_duartion", type="float", scale=2)
     */
    protected $price_duration;
    
    /**
     * @ORM\Column(name="duration", type="string", length=255)
     */
    protected $duration;

    /**
     * Set price_duration
     *
     * @param float $priceDuration
     * @return ShopsDelivery
     */
    public function setPriceDuration($priceDuration)
    {
        $this->price_duration = $priceDuration;
    
        return $this;
    }

    /**
     * Get price_duration
     *
     * @return float 
     */
    public function getPriceDuration()
    {
        return $this->price_duration;
    }

    /**
     * Set duration
     *
     * @param string $duration
     * @return ShopsDelivery
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    
        return $this;
    }

    /**
     * Get duration
     *
     * @return string 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set shops
     *
     * @param \Shop\CreateBundle\Entity\Shops $shops
     * @return ShopsDelivery
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
     * @param \Shop\CreateBundle\Entity\Delivery $delivery
     * @return ShopsDelivery
     */
    public function setDelivery(\Shop\CreateBundle\Entity\Delivery $delivery = null)
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
