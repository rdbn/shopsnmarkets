<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\RegistrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="city")
 */

Class City
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="city")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $country;
    
    /**
     * @ORM\Column(type="string", length=45, unique=true)
     */
    protected $name;

    /**
     * toString for class City
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
     * @return City
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
     * Set country
     *
     * @param \User\RegistrationBundle\Entity\Country $country
     * @return City
     */
    public function setCountry(\User\RegistrationBundle\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \User\RegistrationBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}