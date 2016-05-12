<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shop\OrderBundle\Repository\AddressRepository")
 * @ORM\Table(name="address")
 */

class Address
{   
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;
    
    /**
     * @ORM\Column(name="realname", type="string", length=255)
     */
    protected $realname;

    /**
     * @ORM\Column(name="email", type="string", length=60)
     */
    protected $email;
    
    /**
     * @ORM\Column(name="street", type="string", length=45)
     */
    protected $street;
    
    /**
     * @ORM\Column(name="home_index", type="integer")
     */
    protected $home_index;
    
    /**
     * @ORM\Column(name="phone", type="bigint")
     */
    protected $phone;
    
    /**
     * @ORM\Column(name="skype", type="string", length=45, nullable=true)
     */
    protected $skype;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Shop\OrderBundle\Entity\Order", mappedBy="address", cascade={"persist"})
     */
    protected $order;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();

        $this->order = new ArrayCollection();
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
     * Set realname
     *
     * @param string $realname
     *
     * @return Address
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;

        return $this;
    }

    /**
     * Get realname
     *
     * @return string
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Address
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
     * Set street
     *
     * @param string $street
     *
     * @return Address
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
     * Set homeIndex
     *
     * @param integer $homeIndex
     *
     * @return Address
     */
    public function setHomeIndex($homeIndex)
    {
        $this->home_index = $homeIndex;

        return $this;
    }

    /**
     * Get homeIndex
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
     *
     * @return Address
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
     * Set skype
     *
     * @param string $skype
     *
     * @return Address
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Address
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
     * Set city
     *
     * @param \User\UserBundle\Entity\City $city
     *
     * @return Address
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
     * Add order
     *
     * @param \Shop\OrderBundle\Entity\Order $order
     *
     * @return Address
     */
    public function addOrder(\Shop\OrderBundle\Entity\Order $order)
    {
        $this->order[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \Shop\OrderBundle\Entity\Order $order
     */
    public function removeOrder(\Shop\OrderBundle\Entity\Order $order)
    {
        $this->order->removeElement($order);
    }

    /**
     * Get order
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrder()
    {
        return $this->order;
    }
}
