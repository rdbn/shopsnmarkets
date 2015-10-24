<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\PartnersBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity(repositoryClass="Manager\PartnersBundle\Repository\PartnersRepository")
 * @ORM\Table(name="partners")
 */
class Partners
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Shop\CreateBundle\Entity\Shops", inversedBy="partners")
     * @ORM\JoinColumn(name="shops_id", referencedColumnName="id")
     */
    protected $shops;
    
    /**
     * @ORM\Column(name="check_partners", type="boolean")
     */
    protected $check_partners;
    
    /**
     * Consrtuct for class Partners
     */
    public function __construct() {
        $this->shops = new ArrayCollection();
        $this->check_partners = true;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Partners
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
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
     * Set check_partners
     *
     * @param boolean $checkPartners
     * @return Partners
     */
    public function setCheckPartners($checkPartners)
    {
        $this->check_partners = $checkPartners;
    
        return $this;
    }

    /**
     * Get check_partners
     *
     * @return boolean 
     */
    public function getCheckPartners()
    {
        return $this->check_partners;
    }

    /**
     * Set shops
     *
     * @param \Shop\CreateBundle\Entity\Shops $shops
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