<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Manager\AdvertisingBundle\Repository\AdvertisingPlatformRepository")
 * @ORM\Table(name="advertising_platform")
 */
class AdvertisingPlatform
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
     * @ORM\ManyToOne(targetEntity="Manager\AdvertisingBundle\Entity\AdvertisingFormat")
     * @ORM\JoinColumn(name="format_id", referencedColumnName="id")
     */
    protected $format;

    /**
     * @ORM\ManyToOne(targetEntity="Manager\AdvertisingBundle\Entity\AdvertisingWatch")
     * @ORM\JoinColumn(name="date_start_id", referencedColumnName="id")
     */
    protected $watch;

    /**
     * @ORM\ManyToOne(targetEntity="Manager\AdvertisingBundle\Entity\AdvertisingDuration")
     * @ORM\JoinColumn(name="date_end_id", referencedColumnName="id")
     */
    protected $duration;

    /**
     * @var UploadedFile
     *
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
     * @return UploadedFile
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
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return '/public/images/advertising';
    }

    public function preUpload()
    {
        if (null !== $this->file) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $this->getUploadDir().'/'.$filename.'.'.$this->file->guessExtension();

            return $this->path;
        }
    }

    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

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
     *
     * @return AdvertisingPlatform
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
     * Set shops
     *
     * @param \Shop\CreateBundle\Entity\Shops $shops
     *
     * @return AdvertisingPlatform
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
     * @param \Manager\AdvertisingBundle\Entity\AdvertisingFormat $format
     *
     * @return AdvertisingPlatform
     */
    public function setFormat(\Manager\AdvertisingBundle\Entity\AdvertisingFormat $format = null)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return \Manager\AdvertisingBundle\Entity\AdvertisingFormat
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set watch
     *
     * @param \Manager\AdvertisingBundle\Entity\AdvertisingWatch $watch
     *
     * @return AdvertisingPlatform
     */
    public function setWatch(\Manager\AdvertisingBundle\Entity\AdvertisingWatch $watch = null)
    {
        $this->watch = $watch;

        return $this;
    }

    /**
     * Get watch
     *
     * @return \Manager\AdvertisingBundle\Entity\AdvertisingWatch
     */
    public function getWatch()
    {
        return $this->watch;
    }

    /**
     * Set duration
     *
     * @param \Manager\AdvertisingBundle\Entity\AdvertisingDuration $duration
     *
     * @return AdvertisingPlatform
     */
    public function setDuration(\Manager\AdvertisingBundle\Entity\AdvertisingDuration $duration = null)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \Manager\AdvertisingBundle\Entity\AdvertisingDuration
     */
    public function getDuration()
    {
        return $this->duration;
    }
}
