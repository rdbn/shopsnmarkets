<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Services;

class SavePreviewShopXML {
    
    protected $doc;

    public function __construct() {
        $this->doc = new \DOMDocument('1.0', 'windows-1251');
        $this->doc->formatOutput = true;
    }

    public function saveXML($data) {
        $file = __DIR__.'/../../../../../Symfony/web/public/xml/Shops/'.$data->getShopname().'/preview.xml';
        
        if (file_exists($file)) {
            $this->update($file, $data);
        } else {
            $this->create($file, $data);
        }
    }
    
    private function getArray($data) {
        return array(
                'text_preview' => $data->getTextPreview(),
                'text_main' => $data->getTextMain(),
            );
    }
    
    private function create($file, $data) {
        $root = $this->doc->createElement('userInformation');
        $this->doc->appendChild($root);

        foreach ($this->getArray($data) as $index => $value) {
            $name = $this->doc->createElement($index);
            $root->appendChild($name);

            $text = $this->doc->createTextNode($value);
            $name->appendChild($text);
        }
        
        $this->doc->save($file);
    }
    
    private function update($file, $data) {
        $preview = simplexml_load_file($file);
        
        $preview->text_preview = $data->getTextPreview();
        $preview->text_main = $data->getTextMain();
        
        $preview->asXML($file);
    }
}
?>
