<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Services;

class SavePreviewXML {
    
    protected $doc;

    public function __construct() {
        $this->doc = new \DOMDocument('1.0', 'windows-1251');
        $this->doc->formatOutput = true;
    }

    public function saveXML($data, $userID) {
        $file = __DIR__.'/../../../../web/public/xml/Users/'.$userID.'/preview.xml';
        
        if (file_exists($file)) {
            $this->update($data, $file);
        } else {
            $this->create($data, $file);
        }
    }
    
    private function update($data, $file) {
        $preview = simplexml_load_file($file);
        
        $preview->text_preview = $data->getTextPreview();
        $preview->text_main = $data->getTextMain();

        $preview->asXML($file);
    }
    
    private function create($data, $file) {
        $arValue = array(
            'text_preview' => $data->getTextPreview(),
            'text_main' => $data->getTextMain(),
        );

        $root = $this->doc->createElement('userInformation');
        $this->doc->appendChild($root);

        foreach ($arValue as $index => $value) {
            $name = $this->doc->createElement($index);
            $root->appendChild($name);

            $text = $this->doc->createTextNode($value);
            $name->appendChild($text);
        }

        $this->doc->save($file);
    }
}
?>
