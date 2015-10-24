<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\ProductsBundle\Services;

use Doctrine\ORM\EntityManager;

class Pagination 
{
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function pagination() {
        
    }
}
?>
