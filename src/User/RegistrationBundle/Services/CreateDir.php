<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\RegistrationBundle\Services;

Class CreateDir {
    
    public function createDir($value) {
        if (gettype($value) == 'string') {
            
            mkdir($value, 0777, true);
            
            return TRUE;
        } else {
            return false;
        }
    }
    
    public function copy($oldName, $newName) {
        $dir = __DIR__.'/../../../../web/public/xml/Shops';
        
        if (is_dir($dir.'/'.$oldName)) {
            $file = scandir($dir.'/'.$oldName);
            unset($file['0']);
            unset($file['1']);
            
            foreach ($file as $name) {
                
            }
        }
    }

    public function remove($dir) {
        if (file_exists($dir)) {
            
        }
    }
    
    public function rename($oldName, $newName) {
        $dir = __DIR__.'/../../../../web/public/xml/Shops';
        
        if (file_exists($dir.'/'.$oldName)) {
            rename($dir.'/'.$oldName, $dir.'/'.$newName);
        }
    }
}
?>
