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

use Shop\CreateBundle\Entity\Delivery;

class DeliveryToIdTransformer implements DataTransformerInterface
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
     * @param  Delivery $delivery
     * @return string
     */
    public function transform($delivery)
    {
        if (!$delivery) return null;

        return $delivery->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $id
     *
     * @return Delivery|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) return null;

        $delivery = $this->om->getRepository('ShopCreateBundle:Delivery')
                ->findOneById($id);
        
        if (null === $delivery) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $id
            ));
        }
        
        return $delivery;
    }
}