<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadLogoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('file', 'file', array(
            'label' => 'Загрузить лого',
            'label_attr' => ['class' => 'btn btn-success'],
            'attr' => ["class" => "hide"],
            'data' => isset($options['data']) ? $options['data']->getFile() : NULL,
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\CreateBundle\Entity\Shops',
        ));
    }
    
    public function getName() 
    {
        return 'UploadLogoShop';
    }
}