<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\NewsBundle\Services;

class NewsXML {
    
    protected $doc;

    public function __construct() {
        $this->doc = new \DOMDocument('1.0', 'utf-8');
        $this->doc->formatOutput = true;
    }
    
    public function addInformation($data, $nameShop, $filename) {
        $arMas = array(
            'name' => $data->getName(),
            'text' => $data->getText(),
            'filename' => '/public/xml/Shops/'.$nameShop.'/news/'.$filename,
        );
        
        $news = $this->doc->createElement('news');
        $this->doc->appendChild($news);
        
        foreach ($arMas as $index => $value) {
            $name = $this->doc->createElement($index);
            $news->appendChild($name);

            $text = $this->doc->createTextNode($value);
            $name->appendChild($text);
        }
        
        $dir = __DIR__.'/../../../../web/public/xml/Shops/'.$nameShop.'/news'.$filename.'.xml';
        $this->doc->save($dir);
    }
}
?>