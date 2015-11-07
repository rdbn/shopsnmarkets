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
     * @ORM\Column(type="string", length=45)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="float", scale=2)
     */
    protected $price;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $text;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\ManyToMany(targetEntity="Shop\AddProductsBundle\Entity\HashTags", inversedBy="product")
     * @ORM\JoinTable(name="product_tags")
     */
    protected $hashTags;
    
    /**
     * @ORM\ManyToMany(targetEntity="User\RegistrationBundle\Entity\Users", inversedBy="product")
     * @ORM\JoinTable(name="product_like")
     */
    protected $like_product;
    
    /**
     * @ORM\OneToMany(targetEntity="Shop\AddProductsBundle\Entity\ProductImage", mappedBy="product", cascade={"persist"})
     */
    protected $image;
    
    /**
     * Construct with Class Product
     */
    public function __construct() {
        $this->image = new ArrayCollection();
        $this->like_product = new ArrayCollection();
        $this->cacheTags = new ArrayCollection();

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
     * Set name
     *
     * @param string $name
     *
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
     *
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
     * Set text
     *
     * @param string $text
     *
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
     *
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
     *
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
     * Add hashTag
     *
     * @param \Shop\AddProductsBundle\Entity\HashTags $hashTag
     *
     * @return Product
     */
    public function addHashTag(\Shop\AddProductsBundle\Entity\HashTags $hashTag)
    {
        $this->hashTags[] = $hashTag;

        return $this;
    }

    /**
     * Remove hashTag
     *
     * @param \Shop\AddProductsBundle\Entity\HashTags $hashTag
     */
    public function removeHashTag(\Shop\AddProductsBundle\Entity\HashTags $hashTag)
    {
        $this->hashTags->removeElement($hashTag);
    }

    /**
     * Get hashTags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHashTags()
    {
        return $this->hashTags;
    }

    /**
     * Add likeProduct
     *
     * @param \User\RegistrationBundle\Entity\Users $likeProduct
     *
     * @return Product
     */
    public function addLikeProduct(\User\RegistrationBundle\Entity\Users $likeProduct)
    {
        $this->like_product[] = $likeProduct;

        return $this;
    }

    /**
     * Remove likeProduct
     *
     * @param \User\RegistrationBundle\Entity\Users $likeProduct
     */
    public function removeLikeProduct(\User\RegistrationBundle\Entity\Users $likeProduct)
    {
        $this->like_product->removeElement($likeProduct);
    }

    /**
     * Get likeProduct
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikeProduct()
    {
        return $this->like_product;
    }

    /**
     * Add image
     *
     * @param \Shop\AddProductsBundle\Entity\ProductImage $image
     *
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
