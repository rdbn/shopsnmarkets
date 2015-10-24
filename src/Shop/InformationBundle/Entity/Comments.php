<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Comments
{    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User\RegistrationBundle\Entity\Users")
     * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     */
    protected $users;
    
    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $shopname;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $text;
    
    /**
     * Set shopname
     *
     * @param string $shopname
     * @return Comments
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
     * Set text
     *
     * @param string $text
     * @return Comments
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get $text
     *
     * @return text 
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * Set users
     *
     * @param \User\RegistrationBundle\Entity\Users $users
     * @return Comments
     */
    public function setUsers(\User\RegistrationBundle\Entity\Users $users = null)
    {
        $this->users = $users;
    
        return $this;
    }

    /**
     * Get users
     *
     * @return \User\RegistrationBundle\Entity\Users 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
?>