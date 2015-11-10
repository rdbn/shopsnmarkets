<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

use Shop\ProductBundle\Entity\HashTags;

class NameToTagsTransformer implements DataTransformerInterface
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
     * @param  issue|null $tags
     * @return string
     */
    public function transform($tags)
    {
        if (null === $tags) {
            return "";
        }

        return $tags;
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param string $tags
     *
     * @return Issue|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($tags)
    {
        if (!$tags) {
            return null;
        }

        $tags = str_replace(" ", "", $tags);
        $hashTags = $this->om->getRepository('ShopProductBundle:HashTags')
                ->findByNameTags(explode(",", $tags));

        if (null === $hashTags) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $tags
            ));
        }

        return $hashTags;
    }
}
?>