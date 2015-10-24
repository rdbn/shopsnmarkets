<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class PreviewUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $text_preview;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $text_main;
    
    /**
     * Set text_preview
     *
     * @param string $text_preview
     * @return PreviewUser
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
     * @return PreviewUser
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