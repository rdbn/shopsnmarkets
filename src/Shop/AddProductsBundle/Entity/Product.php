<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shop\AddProductsBundle\Repository\ProductRepository")
 * @ORM\Table(name="product")
 */

Class Product
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
     * @ORM\ManyToOne(targetEntity="Shop\AddProductsBundle\Entity\Subcategory")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    protected $subcategory;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\AddProductsBundle\Entity\Floor")
     * @ORM\JoinColumn(name="floor_id", referencedColumnName="id")
     */
    protected $floor;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $keywords;
    
    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="float", scale=2)
     */
    protected $price;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $text;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;
    
    /**
     * @ORM\ManyToMany(targetEntity="User\RegistrationBundle\Entity\Users", inversedBy="product")
     * @ORM\JoinTable(name="product_like")
     */
    protected $like_product;
    
    /**
     * @ORM\ManyToMany(targetEntity="Shop\AddProductsBundle\Entity\Size", inversedBy="product")
     * @ORM\JoinTable(name="product_size")
     */
    protected $size;
    
    /**
     * @ORM\OneToMany(targetEntity="Shop\AddProductsBundle\Entity\ProductImage", mappedBy="product", cascade={"persist"})
     */
    protected $image;
    
    /**
     * Construct with Class Product
     */
    public function __construct() {
        $this->size = new ArrayCollection();
        $this->image = new ArrayCollection();
        $this->like_product = new ArrayCollection();
        $this->date = new \DateTime();
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
     * Set keywords
     *
     * @param string $keywords
     * @return Product
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    
        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
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
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Product
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Product
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Product
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set shops
     *
     * @param \Shop\CreateBundle\Entity\Shops $shops
     * @return Product
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
     * Set subcategory
     *
     * @param \Shop\AddProductsBundle\Entity\Subcategory $subcategory
     * @return Product
     */
    public function setSubcategory(\Shop\AddProductsBundle\Entity\Subcategory $subcategory = null)
    {
        $this->subcategory = $subcategory;
    
        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \Shop\AddProductsBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set floor
     *
     * @param \Shop\AddProductsBundle\Entity\Floor $floor
     * @return Product
     */
    public function setFloor(\Shop\AddProductsBundle\Entity\Floor $floor = null)
    {
        $this->floor = $floor;
    
        return $this;
    }

    /**
     * Get floor
     *
     * @return \Shop\AddProductsBundle\Entity\Floor 
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Add like_product
     *
     * @param \User\RegistrationBundle\Entity\Users $likeProduct
     * @return Product
     */
    public function addLikeProduct(\User\RegistrationBundle\Entity\Users $likeProduct)
    {
        $this->like_product[] = $likeProduct;
    
        return $this;
    }

    /**
     * Remove like_product
     *
     * @param \User\RegistrationBundle\Entity\Users $likeProduct
     */
    public function removeLikeProduct(\User\RegistrationBundle\Entity\Users $likeProduct)
    {
        $this->like_product->removeElement($likeProduct);
    }

    /**
     * Get like_product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLikeProduct()
    {
        return $this->like_product;
    }

    /**
     * Add size
     *
     * @param \Shop\AddProductsBundle\Entity\Size $size
     * @return Product
     */
    public function addSize(\Shop\AddProductsBundle\Entity\Size $size)
    {
        $this->size[] = $size;
    
        return $this;
    }

    /**
     * Remove size
     *
     * @param \Shop\AddProductsBundle\Entity\Size $size
     */
    public function removeSize(\Shop\AddProductsBundle\Entity\Size $size)
    {
        $this->size->removeElement($size);
    }

    /**
     * Get size
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Add image
     *
     * @param \Shop\AddProductsBundle\Entity\ProductImage $image
     * @return Product
     */
    public function addImage(\Shop\AddProductsBundle\Entity\ProductImage $image)
    {
        $this->image[] = $image;
    
        return $this;
    }

    /**
     * Remove image
     *
     * @param \Shop\AddProductsBundle\Entity\ProductImage $image
     */
    public function removeImage(\Shop\AddProductsBundle\Entity\ProductImage $image)
    {
        $this->image->removeElement($image);
    }

    /**
     * Get image
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImage()
    {
        return $this->image;
    }
}