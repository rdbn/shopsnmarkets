<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Form\Type;

use Shop\AddProductsBundle\Form\DataTransformer\TypeThingToIdTransformer;

use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TypeThingType extends AbstractType {
    
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
    
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $transfomer = new TypeThingToIdTransformer($this->om);
        $builder->addModelTransformer($transfomer);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected issue does not exist',
        ));
    }
    
    public function getParent()
    {
        return 'hidden';
    }
    
    public function getName() 
    {
        return 'typeThing';
    }
}
?>
