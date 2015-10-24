<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Manager\AdvertisingBundle\Repository\AdvertisingRepository")
 * @ORM\Table(name="advertising")
 */

class Advertising
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
     * @ORM\ManyToOne(targetEntity="Manager\AdvertisingBundle\Entity\Format")
     * @ORM\JoinColumn(name="format_id", referencedColumnName="id")
     */
    protected $format;
    
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
     * @ORM\Column(name="path", type="string", length=255)
     */
    protected $path;
    
    /**
     * @ORM\Column(type="datetime", name="date_start")
     *
     * @var DateTime $date_start
     */
    protected $date_start;
    
    /**
     * @ORM\Column(type="datetime", name="date_end")
     *
     * @var DateTime $date_end
     */
    protected $date_end;
    
    /**
     * Consrtuct for class Advertising
     */
    public function __construct() {
        $this->date_start = new \DateTime();
        $this->date_end = new \DateTime();
    }
    
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
     * @return Advertising
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

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.        
        return '/public/xml/Shops/Advertising';
    }
    
    public function preUpload()
    {   
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $this->getUploadDir().'/'.$filename.'.'.$this->file->guessExtension();
            
            return $this->path;
        }
    }
    
    public function upload()
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
            $this->getUploadRootDir(),
            $this->path
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

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
     * Set date_start
     *
     * @param \DateTime $dateStart
     * @return Advertising
     */
    public function setDateStart($dateStart)
    {
        $this->date_start = $dateStart;
    
        return $this;
    }

    /**
     * Get date_start
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * Set date_end
     *
     * @param \DateTime $dateEnd
     * @return Advertising
     */
    public function setDateEnd($dateEnd)
    {
        $this->date_end = $dateEnd;
    
        return $this;
    }

    /**
     * Get date_end
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * Set shops
     *
     * @param \Shop\CreateBundle\Entity\Shops $shops
     * @return Advertising
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
     * Set format
     *
     * @param \Manager\AdvertisingBundle\Entity\Format $format
     * @return Advertising
     */
    public function setFormat(\Manager\AdvertisingBundle\Entity\Format $format = null)
    {
        $this->format = $format;
    
        return $this;
    }

    /**
     * Get format
     *
     * @return \Manager\AdvertisingBundle\Entity\Format 
     */
    public function getFormat()
    {
        return $this->format;
    }
}