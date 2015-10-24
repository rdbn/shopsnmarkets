<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class AdvertisingShop
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\CreateBundle\Entity\Shops")
     * @ORM\JoinColumn(name="shops_id", referencedColumnName="id")
     */
    protected $shops;
    
    /**
     * @ORM\ManyToOne(targetEntity="Manager\AdvertisingBundle\Entity\Format")
     * @ORM\JoinColumn(name="format_id", referencedColumnName="id")
     */
    protected $format;
    
    /**
     * Set shops
     *
     * @param \Shop\CreateBundle\Entity\Shops $shops
     * @return AdvertisingShop
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
     * Set format
     *
     * @param \Manager\AdvertisingBundle\Entity\Format $format
     * @return AdvertisingShop
     */
    public function setFormat(\Manager\AdvertisingBundle\Entity\Format $format = null)
    {
        $this->format = $format;
    
        return $this;
    }

    /**
     * Get format
     *
     * @return \Manager\AdvertisingBundle\Entity\Format
     */
    public function getFormat()
    {
        return $this->format;
    }
}
?>