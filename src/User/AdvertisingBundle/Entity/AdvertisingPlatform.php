<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\AdvertisingBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="User\AdvertisingBundle\Repository\AdvertisingPlatformRepository")
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
     * @ORM\ManyToOne(targetEntity="User\AdvertisingBundle\Entity\AdvertisingFormat")
     * @ORM\JoinColumn(name="format_id", referencedColumnName="id")
     */
    protected $format;

    /**
     * @ORM\Column(name="date_start", type="datetime")
     */
    protected $date_start;

    /**
     * @ORM\Column(name="date_end", type="datetime")
     */
    protected $date_end;

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
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return AdvertisingPlatform
     */
    public function setDateStart($dateStart)
    {
        $this->date_start = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return AdvertisingPlatform
     */
    public function setDateEnd($dateEnd)
    {
        $this->date_end = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->date_end;
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
     * @param \User\AdvertisingBundle\Entity\AdvertisingFormat $format
     *
     * @return AdvertisingPlatform
     */
    public function setFormat(\User\AdvertisingBundle\Entity\AdvertisingFormat $format = null)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return \User\AdvertisingBundle\Entity\AdvertisingFormat
     */
    public function getFormat()
    {
        return $this->format;
    }
}
