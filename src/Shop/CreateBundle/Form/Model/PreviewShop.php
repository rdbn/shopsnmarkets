<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Model;

use Doctrine\ORM\Mapping as ORM;

class PreviewShop
{   
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $shopname;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $text_preview;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $text_main;
    
    /**
     * Set shopname
     *
     * @param string $shopname
     * @return PreviewShop
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
     * Set text_preview
     *
     * @param string $text_preview
     * @return PreviewShop
     */
    public function setTextPreview($text_preview)
    {
        $this->text_preview = $text_preview;
    
        return $this;
    }

    /**
     * Get text_preview
     *
     * @return string 
     */
    public function getTextPreview()
    {
        return $this->text_preview;
    }
    
    /**
     * Set text_main
     *
     * @param string $text_main
     * @return PreviewShop
     */
    public function setTextMain($text_main)
    {
        $this->text_main = $text_main;
    
        return $this;
    }

    /**
     * Get text_main
     *
     * @return string 
     */
    public function getTextMain()
    {
        return $this->text_main;
    }
}
?>