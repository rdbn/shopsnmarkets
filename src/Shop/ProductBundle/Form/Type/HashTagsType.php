<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 08.11.15
 * Time: 22:48
 */

namespace Shop\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;

use Shop\ProductBundle\Form\DataTransformer\NameToTagsTransformer;

class HashTagsType extends AbstractType
{
    /**
     * @var ObjectManager
    */
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new NameToTagsTransformer($this->om);
        $builder->addViewTransformer($transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'The selected issue does not exist',
        ]);
    }

    public function getParent()
    {
        return "text";
    }

    public function getName()
    {
        return 'tags';
    }
}