<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Services;

use Doctrine\ORM\EntityManager;

class ProductLike
{
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function addLike($id, $user) {
        $product = $this->em->getRepository('ShopAddProductsBundle:Product')
                ->findOneById($id);
        
        $addLike = $this->em;
        $addLike->persist($product->addLikeProduct($user));
        $addLike->flush();
    }
}
?>
