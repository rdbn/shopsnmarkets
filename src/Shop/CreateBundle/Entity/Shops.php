<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Shop\CreateBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shop\CreateBundle\Repository\ShopsRepository")
 * @ORM\Table(name="shops")
 */

Class Shops
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\Users", inversedBy="shopManager")
     * @ORM\JoinColumn(name="manager_id", referencedColumnName="id")
     * )
     */
    protected $manager;
    
    /**
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;
    
    /**
     * @ORM\Column(name="shopname", type="string", length=45)
     */
    protected $shopname;
    
    /**
     * @ORM\Column(name="unique_name", type="string", length=45, unique=true)
     */
    protected $uniqueName;
    
    /**
     * @ORM\Column(name="rating", type="integer")
     */
    protected $rating;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;
    
    /**
     * @ORM\Column(type="datetime", name="created_at")
     *
     * @var \DateTime $createdAt
     */
    protected $createdAt;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $email;
    
    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    protected $phone;
    
    /**
     * @Assert\Image(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     maxSizeMessage = "Максимальный вес картинки 1MB.",
     *     mimeTypesMessage = "Только таких типов ихображений можно загрузитью"
     * )
     *
     * @var UploadedFile
     */
    protected $file;
    
    /**
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    protected $path;
    
    /**
     * @ORM\ManyToMany(targetEntity="User\UserBundle\Entity\Users", inversedBy="shop")
     * @ORM\JoinTable(name="shops_like")
     */
    protected $likeShop;

    /**
     * @ORM\ManyToMany(targetEntity="Shop\CreateBundle\Entity\Keywords", inversedBy="shop")
     * @ORM\JoinTable(name="keywords_shop")
     */
    protected $keywords;
    
    /**
     * @ORM\ManyToMany(targetEntity="User\UserBundle\Entity\Users", inversedBy="shopUsers")
     * @ORM\JoinTable(name="users_shops")
     */
    protected $users;
    
    /**
     * @ORM\OneToMany(targetEntity="Manager\PartnersBundle\Entity\Partners", mappedBy="shops")
     */
    protected $partners;
    
    /**
     * @ORM\OneToMany(targetEntity="Shop\CreateBundle\Entity\ShopsDelivery", mappedBy="shops")
     */
    protected $shopsDelivery;

    /**
     * @ORM\OneToMany(targetEntity="User\AdvertisingBundle\Entity\AdvertisingShop", mappedBy="shops")
     */
    protected $advertisingShop;

    /**
     * Construct for class Shops
     */
    public function __construct()
    {
        $this->rating = 0;

        $this->manager = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->partners = new ArrayCollection();
        $this->shops_delivery = new ArrayCollection();
        $this->advertising_shop = new ArrayCollection();

        $this->createdAt = new \DateTime();
    }
    
    /**
     * toString for class Country
     */
    public function __toString() {
        return $this->shopname;
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
        $dir = __DIR__.'/../../../../web/'.$this->getUploadDir();
        if (!file_exists($dir)) {
            mkdir($dir, 0775);
        }

        return $dir;
    }

    protected function getUploadDir()
    {
        return 'public/images/logo';
    }
    
    public function preUpload()
    {   
        if (null !== $this->file) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->file->guessExtension();

            return $this->getUploadDir().'/'.$this->path;
        }
    }
    
    public function upload()
    {
        if (null === $this->file) return;

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        $this->path = $this->getUploadDir()."/".$this->path;
        $this->file = null;
    }
    
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();

        if ($file) unlink($file);
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
     * Set shopname
     *
     * @param string $shopname
     *
     * @return Shops
     */
    public function setShopname($shopname)
    {
        $this->shopname = $shopname;

        return $this;
    }

    /**
     * Get shopname
     *
     * @return string
     */
    public function getShopname()
    {
        return $this->shopname;
    }

    /**
     * Set uniqueName
     *
     * @param string $uniqueName
     *
     * @return Shops
     */
    public function setUniqueName($uniqueName)
    {
        $this->uniqueName = $uniqueName;

        return $this;
    }

    /**
     * Get uniqueName
     *
     * @return string
     */
    public function getUniqueName()
    {
        return $this->uniqueName;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return Shops
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Shops
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Shops
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Shops
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Shops
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Shops
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
     * Set manager
     *
     * @param \User\UserBundle\Entity\Users $manager
     *
     * @return Shops
     */
    public function setManager(\User\UserBundle\Entity\Users $manager = null)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return \User\UserBundle\Entity\Users
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set city
     *
     * @param \User\UserBundle\Entity\City $city
     *
     * @return Shops
     */
    public function setCity(\User\UserBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \User\UserBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add likeShop
     *
     * @param \User\UserBundle\Entity\Users $likeShop
     *
     * @return Shops
     */
    public function addLikeShop(\User\UserBundle\Entity\Users $likeShop)
    {
        $this->likeShop[] = $likeShop;

        return $this;
    }

    /**
     * Remove likeShop
     *
     * @param \User\UserBundle\Entity\Users $likeShop
     */
    public function removeLikeShop(\User\UserBundle\Entity\Users $likeShop)
    {
        $this->likeShop->removeElement($likeShop);
    }

    /**
     * Get likeShop
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikeShop()
    {
        return $this->likeShop;
    }

    /**
     * Add keyword
     *
     * @param \Shop\CreateBundle\Entity\Keywords $keyword
     *
     * @return Shops
     */
    public function addKeyword(\Shop\CreateBundle\Entity\Keywords $keyword)
    {
        $this->keywords[] = $keyword;

        return $this;
    }

    /**
     * Remove keyword
     *
     * @param \Shop\CreateBundle\Entity\Keywords $keyword
     */
    public function removeKeyword(\Shop\CreateBundle\Entity\Keywords $keyword)
    {
        $this->keywords->removeElement($keyword);
    }

    /**
     * Get keywords
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Add user
     *
     * @param \User\UserBundle\Entity\Users $user
     *
     * @return Shops
     */
    public function addUser(\User\UserBundle\Entity\Users $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \User\UserBundle\Entity\Users $user
     */
    public function removeUser(\User\UserBundle\Entity\Users $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add partner
     *
     * @param \Manager\PartnersBundle\Entity\Partners $partner
     *
     * @return Shops
     */
    public function addPartner(\Manager\PartnersBundle\Entity\Partners $partner)
    {
        $this->partners[] = $partner;

        return $this;
    }

    /**
     * Remove partner
     *
     * @param \Manager\PartnersBundle\Entity\Partners $partner
     */
    public function removePartner(\Manager\PartnersBundle\Entity\Partners $partner)
    {
        $this->partners->removeElement($partner);
    }

    /**
     * Get partners
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartners()
    {
        return $this->partners;
    }

    /**
     * Add shopsDelivery
     *
     * @param \Shop\CreateBundle\Entity\ShopsDelivery $shopsDelivery
     *
     * @return Shops
     */
    public function addShopsDelivery(\Shop\CreateBundle\Entity\ShopsDelivery $shopsDelivery)
    {
        $this->shopsDelivery[] = $shopsDelivery;

        return $this;
    }

    /**
     * Remove shopsDelivery
     *
     * @param \Shop\CreateBundle\Entity\ShopsDelivery $shopsDelivery
     */
    public function removeShopsDelivery(\Shop\CreateBundle\Entity\ShopsDelivery $shopsDelivery)
    {
        $this->shopsDelivery->removeElement($shopsDelivery);
    }

    /**
     * Get shopsDelivery
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShopsDelivery()
    {
        return $this->shopsDelivery;
    }

    /**
     * Add advertisingShop
     *
     * @param \User\AdvertisingBundle\Entity\AdvertisingShop $advertisingShop
     *
     * @return Shops
     */
    public function addAdvertisingShop(\User\AdvertisingBundle\Entity\AdvertisingShop $advertisingShop)
    {
        $this->advertisingShop[] = $advertisingShop;

        return $this;
    }

    /**
     * Remove advertisingShop
     *
     * @param \User\AdvertisingBundle\Entity\AdvertisingShop $advertisingShop
     */
    public function removeAdvertisingShop(\User\AdvertisingBundle\Entity\AdvertisingShop $advertisingShop)
    {
        $this->advertisingShop->removeElement($advertisingShop);
    }

    /**
     * Get advertisingShop
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdvertisingShop()
    {
        return $this->advertisingShop;
    }
}