<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="type_thing")
 */

Class TypeThing
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
     * @ORM\OneToMany(targetEntity="Shop\AddProductsBundle\Entity\Category", mappedBy="type_thing")
     */
    private $category;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->category = new ArrayCollection();
    }
    
    /**
     * toString
     */
    public function __toString() {
        return (string)  $this->id;
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
     * @return TypeThing
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
     * Add category
     *
     * @param \Shop\AddProductsBundle\Entity\Category $category
     * @return TypeThing
     */
    public function addCategory(\Shop\AddProductsBundle\Entity\Category $category)
    {
        $this->category[] = $category;
    
        return $this;
    }

    /**
     * Remove category
     *
     * @param \Shop\AddProductsBundle\Entity\Category $category
     */
    public function removeCategory(\Shop\AddProductsBundle\Entity\Category $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
    }
}