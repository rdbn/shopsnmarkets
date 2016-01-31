<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\PartnersBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity(repositoryClass="Shop\PartnersBundle\Repository\PartnersRepository")
 * @ORM\Table(name="partners")
 */
class Partners
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Shop\CreateBundle\Entity\Shops", inversedBy="shopPartners")
     * @ORM\JoinColumn(name="partners_id", referencedColumnName="id")
     */
    protected $partners;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Shop\CreateBundle\Entity\Shops", inversedBy="partners")
     * @ORM\JoinColumn(name="shops_id", referencedColumnName="id")
     */
    protected $shops;
    
    /**
     * @ORM\Column(name="check_partners", type="boolean")
     */
    protected $checkPartners;
    
    /**
     * Construct for class Partners
     */
    public function __construct()
    {
        $this->shops = new ArrayCollection();
        $this->checkPartners = false;
    }

    /**
     * Set checkPartners
     *
     * @param boolean $checkPartners
     *
     * @return Partners
     */
    public function setCheckPartners($checkPartners)
    {
        $this->checkPartners = $checkPartners;

        return $this;
    }

    /**
     * Get checkPartners
     *
     * @return boolean
     */
    public function getCheckPartners()
    {
        return $this->checkPartners;
    }

    /**
     * Set partners
     *
     * @param \Shop\CreateBundle\Entity\Shops $partners
     *
     * @return Partners
     */
    public function setPartners(\Shop\CreateBundle\Entity\Shops $partners)
    {
        $this->partners = $partners;

        return $this;
    }

    /**
     * Get partners
     *
     * @return \Shop\CreateBundle\Entity\Shops
     */
    public function getPartners()
    {
        return $this->partners;
    }

    /**
     * Set shops
     *
     * @param \Shop\CreateBundle\Entity\Shops $shops
     *
     * @return Partners
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
}