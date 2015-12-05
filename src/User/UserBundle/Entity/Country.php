<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="country")
 */

Class Country
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $name;
    
    /**
     * @ORM\OneToMany(targetEntity="City", mappedBy="country")
     */
    protected $city;
    
    /**
     * Construct for class Contry
     */
    public function __construct()
    {
        $this->country = new ArrayCollection();
    }
    
    /**
     * toString for class Contry
     */
    public function __toString() {
        return $this->name;
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
     * @return Country
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
     * Add city
     *
     * @param \User\UserBundle\Entity\City $city
     * @return Country
     */
    public function addCity(\User\UserBundle\Entity\City $city)
    {
        $this->city[] = $city;
    
        return $this;
    }

    /**
     * Remove city
     *
     * @param \User\UserBundle\Entity\City $city
     */
    public function removeCity(\User\UserBundle\Entity\City $city)
    {
        $this->city->removeElement($city);
    }

    /**
     * Get city
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCity()
    {
        return $this->city;
    }
}