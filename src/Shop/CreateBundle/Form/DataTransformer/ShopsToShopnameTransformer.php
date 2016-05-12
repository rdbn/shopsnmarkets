<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

use Shop\CreateBundle\Entity\Shops;

class ShopsToShopnameTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param Shops $shop
     * @return string
     */
    public function transform($shop)
    {
        if (!$shop) return null;

        return $shop->getShopname();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param string $shopname
     *
     * @return Shops
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($shopname)
    {
        if (!$shopname) return null;

        $shop = $this->om->getRepository('ShopCreateBundle:Shops')
            ->findOneBy(["shopname" => $shopname]);
        
        if (null === $shop) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $shopname
            ));
        }
        
        return $shop;
    }
}