<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 08.11.15
 * Time: 22:48
 */

namespace Shop\AddProductsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;

use Shop\AddProductsBundle\Form\DataTransformer\NameToTagsTransformer;

class HashTagsType extends AbstractType
{
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new NameToTagsTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected issue does not exist',
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'hashTags';
    }
}