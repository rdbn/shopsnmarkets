<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Shop\CreateBundle\Entity\Shops;

class ShopsToNameTransformer implements DataTransformerInterface
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
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($shops)
    {
        if (null === $shops) {
            return "";
        }

        return $shops;
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $number
     *
     * @return Issue|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($unique_name)
    {
        if (!$unique_name) {
            return null;
        }

        $shops = $this->om->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(array('unique_name' => $unique_name));

        if (null === $shops) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $unique_name
            ));
        }

        return $shops;
    }
}
?>