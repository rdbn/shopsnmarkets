<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

use Shop\ProductBundle\Entity\ProductImage;

/**
 * @ORM\Entity(repositoryClass="Shop\ProductBundle\Repository\ProductRepository")
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
     * @ORM\Column(type="float", scale=2)
     */
    protected $price;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $text;
    
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="Shop\ProductBundle\Entity\HashTags", inversedBy="product")
     * @ORM\JoinTable(name="product_tags")
     */
    protected $hashTags;
    
    /**
     * @ORM\ManyToMany(targetEntity="User\UserBundle\Entity\Users", inversedBy="product")
     * @ORM\JoinTable(name="product_like")
     */
    protected $likeProduct;
    
    /**
     * @ORM\OneToMany(targetEntity="Shop\ProductBundle\Entity\ProductImage", mappedBy="product", cascade={"persist"})
     */
    protected $image;

    /**
     * @var UploadedFile
    */
    protected $file;
    
    /**
     * Construct with Class Product
     */
    public function __construct() {
        $this->image = new ArrayCollection();
        $this->like_product = new ArrayCollection();
        $this->cacheTags = new ArrayCollection();

        $this->created_at = new \DateTime();
    }

    /**
     * Sets file.
     *
     * @param array $file
     *
     * @return Product
     */
    public function setFile(array $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PreFlush()
     */
    public function upload()
    {
        foreach($this->file as $uploadedFile) {
            $productImage = new ProductImage();
            $productImage->setFile($uploadedFile);
            $productImage->preUpload();
            $productImage->upload();

            $productImage->setProduct($this);
            $this->addImage($productImage);
        }
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
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
     * @param \Shop\ProductBundle\Entity\HashTags $hashTag
     *
     * @return Product
     */
    public function addHashTag(\Shop\ProductBundle\Entity\HashTags $hashTag)
    {
        $this->hashTags[] = $hashTag;

        return $this;
    }

    /**
     * Remove hashTag
     *
     * @param \Shop\ProductBundle\Entity\HashTags $hashTag
     */
    public function removeHashTag(\Shop\ProductBundle\Entity\HashTags $hashTag)
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
     * @param \User\UserBundle\Entity\Users $likeProduct
     *
     * @return Product
     */
    public function addLikeProduct(\User\UserBundle\Entity\Users $likeProduct)
    {
        $this->like_product[] = $likeProduct;

        return $this;
    }

    /**
     * Remove likeProduct
     *
     * @param \User\UserBundle\Entity\Users $likeProduct
     */
    public function removeLikeProduct(\User\UserBundle\Entity\Users $likeProduct)
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
     * @param \Shop\ProductBundle\Entity\ProductImage $image
     *
     * @return Product
     */
    public function addImage(\Shop\ProductBundle\Entity\ProductImage $image)
    {
        $this->image[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Shop\ProductBundle\Entity\ProductImage $image
     */
    public function removeImage(\Shop\ProductBundle\Entity\ProductImage $image)
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