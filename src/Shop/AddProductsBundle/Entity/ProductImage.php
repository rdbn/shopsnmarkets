<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="product_image")
 */

Class ProductImage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\AddProductsBundle\Entity\Product", inversedBy="image", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
    
    /**
     * @ORM\Column(name="path", type="string", length=255)
     */
    protected $path;
    
    /**
     * @Assert\Image(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     maxSizeMessage = "Максимальный вес картинки 1MB.",
     *     mimeTypesMessage = "Только таких типов ихображений можно загрузитью"
     * )
     */
    protected $file;
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return ProductImage
     */
    public function getFile()
    {
        return $this->file;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir($shopName)
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir($shopName);
    }

    protected function getUploadDir($shopName)
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.           
        return 'public/xml/Shops/'.$shopName.'/product';
    }
    
    public function preUpload($shopName)
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->path = $this->getUploadDir($shopName).'/'.uniqid().'.'.$this->file->guessExtension();
            
            return $this->path;
        }
    }
    
    public function upload($shopName)
    {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir($shopName),
            $this->path
        );

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
    
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
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
     * Set path
     *
     * @param string $path
     * @return ProductImage
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
     * Set product
     *
     * @param \Shop\AddProductsBundle\Entity\Product $product
     * @return ProductImage
     */
    public function setProduct(\Shop\AddProductsBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Shop\AddProductsBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}