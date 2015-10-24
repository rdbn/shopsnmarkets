<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shop\AddProductsBundle\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 */

Class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\AddProductsBundle\Entity\TypeThing", inversedBy="category")
     * @ORM\JoinColumn(name="type_thing_id", referencedColumnName="id")
     */
    protected $type_thing;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\AddProductsBundle\Entity\Floor")
     * @ORM\JoinColumn(name="floor_id", referencedColumnName="id")
     */
    protected $floor;
    
    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $name;
    
    /**
     * toString
     */
    public function __toString() {
        return (string)  $this->name;
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
     * @return Category
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
     * Set type_thing
     *
     * @param \Shop\AddProductsBundle\Entity\TypeThing $typeThing
     * @return Category
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
}