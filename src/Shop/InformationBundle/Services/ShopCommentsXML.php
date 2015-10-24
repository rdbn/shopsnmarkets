<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Services;

class ShopCommentsXML {
    
    protected $doc;

    public function __construct() {
        $this->doc = new \DOMDocument('1.0', 'windows-1251');
        $this->doc->formatOutput = true;
    }

    public function saveXML($data) {
        $file = __DIR__.'/../../../../web/public/xml/Shops/'.$data->getShopname().'/comments/comments.xml';
        
        if (file_exists($file)) {
            $this->addComments($file, $data);
        } else {
            $this->createComments($data);
            
            $this->doc->save($file);
        }
    }
    
    private function arValue($data) {        
        $arValue = array(
            'user_img' => ($data->getUsers()->getPath() != '') ? $data->getUsers()->getPath() : '',
            'user_name' => $data->getUsers()->getRealname(),
            'text' => $data->getText(),
        );
        
        return $arValue;
    }

    private function createComments($data) {
        $root = $this->doc->createElement('comments');
        $this->doc->appendChild($root);
        
        $comment = $this->doc->createElement('comment');
        $root->appendChild($comment);

        foreach ($this->arValue($data) as $index => $value) {
            $name = $this->doc->createElement($index);
            $comment->appendChild($name);

            $text = $this->doc->createTextNode($value);
            $name->appendChild($text);
        }
    }
    
    private function addComments($file, $data) {
        $arValue = $this->arValue($data);
        $preview = simplexml_load_file($file);
        
        $comment = $preview->addChild('comment');
        $comment->addChild('user_img', $arValue['user_img']);
        $comment->addChild('user_name', $arValue['user_name']);
        $comment->addChild('text', $arValue['text']);
        
        $preview->asXML($file);
    }
}
?>
