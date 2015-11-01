<?php

/*
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
     * @ORM\ManyToOne(targetEntity="User\RegistrationBundle\Entity\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;
    
    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $shopname;
    
    /**
     * @ORM\Column(type="string", length=45, unique=true)
     */
    protected $unique_name;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $keywords;
    
    /**
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $street;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $url;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $email;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $home_index;
    
    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    protected $phone;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $fax;
    
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
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    protected $path;
    
    /**
     * @ORM\ManyToMany(targetEntity="User\RegistrationBundle\Entity\Users", inversedBy="shop")
     * @ORM\JoinTable(name="shops_like")
     */
    protected $like_shop;
    
    /**
     * @ORM\ManyToMany(targetEntity="User\RegistrationBundle\Entity\Users", inversedBy="shopManager")
     * @ORM\JoinTable(name="manager_shops")
     * )
     */
    protected $manager;
    
    /**
     * @ORM\ManyToMany(targetEntity="User\RegistrationBundle\Entity\Users", inversedBy="shopUsers")
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
    protected $shops_delivery;

    /**
     * Consrtuct for class Shops
     */
    public function __construct() {
        $this->manager = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->partners = new ArrayCollection();
        $this->shops_delivery = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }
    
    /**
     * toString for class Contry
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
     * @return Shops
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

    protected function getUploadRootDir($nameShop)
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir($nameShop);
    }

    protected function getUploadDir($nameShop)
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.        
        return 'public/xml/Shops/'.$nameShop.'/logo';
    }
    
    public function preUpload($nameShop)
    {   
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->file->guessExtension();
            
            return $this->getUploadDir($nameShop).'/'.$this->path;
        }
    }
    
    public function upload($nameShop)
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
            $this->getUploadRootDir($nameShop),
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
     * Set shopname
     *
     * @param string $shopname
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
     * Set unique_name
     *
     * @param string $uniqueName
     * @return Shops
     */
    public function setUniqueName($uniqueName)
    {
        $this->unique_name = $uniqueName;
    
        return $this;
    }

    /**
     * Get unique_name
     *
     * @return string 
     */
    public function getUniqueName()
    {
        return $this->unique_name;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return Shops
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
     * Set rating
     *
     * @param integer $rating
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
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
     * Set street
     *
     * @param string $street
     * @return Shops
     */
    public function setStreet($street)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Shops
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set email
     *
     * @param string $email
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
     * Set home_index
     *
     * @param integer $homeIndex
     * @return Shops
     */
    public function setHomeIndex($homeIndex)
    {
        $this->home_index = $homeIndex;
    
        return $this;
    }

    /**
     * Get home_index
     *
     * @return integer 
     */
    public function getHomeIndex()
    {
        return $this->home_index;
    }

    /**
     * Set phone
     *
     * @param integer $phone
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
     * Set fax
     *
     * @param integer $fax
     * @return Shops
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return integer 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set path
     *
     * @param string $path
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
     * Set city
     *
     * @param \User\RegistrationBundle\Entity\City $city
     * @return Shops
     */
    public function setCity(\User\RegistrationBundle\Entity\City $city = null)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return \User\RegistrationBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add like_shop
     *
     * @param \User\RegistrationBundle\Entity\Users $likeShop
     * @return Shops
     */
    public function addLikeShop(\User\RegistrationBundle\Entity\Users $likeShop)
    {
        $this->like_shop[] = $likeShop;
    
        return $this;
    }

    /**
     * Remove like_shop
     *
     * @param \User\RegistrationBundle\Entity\Users $likeShop
     */
    public function removeLikeShop(\User\RegistrationBundle\Entity\Users $likeShop)
    {
        $this->like_shop->removeElement($likeShop);
    }

    /**
     * Get like_shop
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLikeShop()
    {
        return $this->like_shop;
    }

    /**
     * Add manager
     *
     * @param \User\RegistrationBundle\Entity\Users $manager
     * @return Shops
     */
    public function addManager(\User\RegistrationBundle\Entity\Users $manager)
    {
        $this->manager[] = $manager;
    
        return $this;
    }

    /**
     * Remove manager
     *
     * @param \User\RegistrationBundle\Entity\Users $manager
     */
    public function removeManager(\User\RegistrationBundle\Entity\Users $manager)
    {
        $this->manager->removeElement($manager);
    }

    /**
     * Get manager
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Add users
     *
     * @param \User\RegistrationBundle\Entity\Users $users
     * @return Shops
     */
    public function addUser(\User\RegistrationBundle\Entity\Users $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \User\RegistrationBundle\Entity\Users $users
     */
    public function removeUser(\User\RegistrationBundle\Entity\Users $users)
    {
        $this->users->removeElement($users);
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
     * Add partners
     *
     * @param \Manager\PartnersBundle\Entity\Partners $partners
     * @return Shops
     */
    public function addPartner(\Manager\PartnersBundle\Entity\Partners $partners)
    {
        $this->partners[] = $partners;
    
        return $this;
    }

    /**
     * Remove partners
     *
     * @param \Manager\PartnersBundle\Entity\Partners $partners
     */
    public function removePartner(\Manager\PartnersBundle\Entity\Partners $partners)
    {
        $this->partners->removeElement($partners);
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
     * Add shops_delivery
     *
     * @param \Shop\CreateBundle\Entity\ShopsDelivery $shopsDelivery
     * @return Shops
     */
    public function addShopsDelivery(\Shop\CreateBundle\Entity\ShopsDelivery $shopsDelivery)
    {
        $this->shops_delivery[] = $shopsDelivery;
    
        return $this;
    }

    /**
     * Remove shops_delivery
     *
     * @param \Shop\CreateBundle\Entity\ShopsDelivery $shopsDelivery
     */
    public function removeShopsDelivery(\Shop\CreateBundle\Entity\ShopsDelivery $shopsDelivery)
    {
        $this->shops_delivery->removeElement($shopsDelivery);
    }

    /**
     * Get shops_delivery
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShopsDelivery()
    {
        return $this->shops_delivery;
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
}
